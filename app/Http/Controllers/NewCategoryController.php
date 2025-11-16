<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\NewCategory;
use Illuminate\Http\Request;

class NewCategoryController extends Controller
{
    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $filters = $request->only(['query']);

            $categories = NewCategory::filter($filters)
                ->latest()
                ->paginate(30);

            if ($categories->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }





    public function search(Request $request)
    {
        try {
            $request->validate([
                'query' => 'required|string|max:255',
            ]);

            $filters = $request->only(['query']);

            $results = NewCategory::filter($filters)
                ->latest()
                ->paginate(30);

            if ($results->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($results, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    public function AllArabicCategories()
    {
        try {
            $Categories = NewCategory::orderBy('created_at', 'desc')->select('id', 'title_ar', 'icon_name', 'bg_color')->get();
            if ($Categories->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->successResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function AllCategories()
    {
        try {
            $Categories = NewCategory::orderBy('created_at', 'desc')->get();
            if ($Categories->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->successResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategory $request)
    {
        try {
            $data = $request->validated();
            $category = new NewCategory();
            $category->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $category, 'images/projectCategories', 'image');
            }
            $category->save();
            return $this->successResponse($category, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NewCategory $newsCategory)
    {
        try {
            return $this->successResponse($newsCategory, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, NewCategory $newsCategory)
    {
        try {
            $data = $request->validated();
            $newsCategory->update($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $newsCategory, 'images/projectCategories', 'image');
            }
            return $this->successResponse($newsCategory->fresh(), 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewCategory $newsCategory)
    {
        try {
            if ($newsCategory->image) {
                $this->imageservice->deleteOldImage($newsCategory, 'images/projectCategories');
            }

            $newsCategory->delete();

            return $this->successResponse($newsCategory, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
