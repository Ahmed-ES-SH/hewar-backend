<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    use ApiResponse;
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }



    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'query' => 'nullable|string|max:255',
                'status' => 'nullable|in:draft,under_review,published,scheduled,rejected,archived',
                'categories' => 'nullable|string', // CSV IDs
            ]);

            $articles = Article::with(['category', 'tags', 'author'])
                ->filter($request->only(['query', 'status', 'categories']))
                ->orderBy('order', 'asc')
                ->paginate(12);

            if ($articles->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($articles);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function approved(Request $request)
    {
        try {
            $request->validate([
                'query' => 'nullable|string|max:255',
                'categories' => 'nullable|string',
                'status' => 'nullable|in:draft,under_review,published,scheduled,rejected,archived',
            ]);

            $articles = Article::with(['category', 'tags', 'author'])
                ->where('status', 'published')
                ->filter($request->only(['query', 'status', 'categories']))
                ->orderBy('order', 'desc')
                ->paginate(12);

            if ($articles->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($articles);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $order = Article::max('order') ?? 0;
            if (!$request->filled('order')) {
                $data['order'] = $order + 1;
            }
            $article = Article::create($data);

            if ($request->hasFile('image')) {
                $this->imageService->ImageUploaderwithvariable($request, $article, 'images/articles', 'image');
            }

            if ($request->has('tags')) {
                $article->tags()->sync($request->tags);
            }

            $article->load('category', 'tags', 'author');

            DB::commit();

            return $this->successResponse($article, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        try {
            return $this->successResponse($article->load('category', 'tags', 'author'), 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $article->update($data);

            if ($request->hasFile('image')) {
                $this->imageService->ImageUploaderwithvariable($request, $article, 'images/articles', 'image');
            }

            if ($request->has('tags')) {
                $article->tags()->sync($request->tags);
            }

            $article->load('category', 'tags', 'author');

            DB::commit();

            return $this->successResponse($article, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try {
            $this->imageService->deleteOldImage($article, 'images/articles');

            // ✅ حذف المشروع نفسه
            $article->delete();

            return $this->successResponse(['message' => 'تم حذف المشروع بنجاح'], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
