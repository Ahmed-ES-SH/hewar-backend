<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class NewsController extends Controller
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

            $articles = News::with(['category', 'tags', 'author'])
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

            $articles = News::with(['category', 'tags', 'author'])
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

            $order = News::max('order') ?? 0;
            $data['order'] = $order + 1;
            $news = News::create($data);

            if ($request->hasFile('image')) {
                $this->imageService->ImageUploaderwithvariable($request, $news, 'images/news', 'image');
            }

            if ($request->has('tags')) {
                $news->tags()->sync($request->tags);
            }

            $news->load('category', 'tags', 'author');

            DB::commit();

            return $this->successResponse($news, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        try {
            return $this->successResponse($news->load('category', 'tags', 'author'), 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $news->update($data);

            if ($request->hasFile('image')) {
                $this->imageService->ImageUploaderwithvariable($request, $news, 'images/news', 'image');
            }

            if ($request->has('tags')) {
                $news->tags()->sync($request->tags);
            }

            $news->load('category', 'tags', 'author');

            DB::commit();

            return $this->successResponse($news, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        try {
            $this->imageService->deleteOldImage($news, 'images/news');

            // ✅ حذف المشروع نفسه
            $news->delete();

            return $this->successResponse(['message' => 'تم حذف المشروع بنجاح'], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
