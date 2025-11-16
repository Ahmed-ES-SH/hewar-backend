<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
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
            $query = $request->input('query');

            // إذا لم يتم إدخال كلمة بحث
            if (!$query) {
                $Categories = ProjectCategory::orderBy('created_at', 'desc')->paginate(30);

                if ($Categories->total() === 0) {
                    return $this->noContentResponse();
                }

                return $this->paginationResponse($Categories, 200);
            }

            // ✅ Normalize Arabic letters
            $normalizedQuery = TextNormalizer::normalizeArabic($query);

            // ✅ SQL replace chain to normalize Arabic columns
            $normalizedSql = TextNormalizer::sqlNormalizeColumn('title_ar');

            // ✅ تنفيذ البحث
            $results = ProjectCategory::where(function ($q) use ($normalizedQuery, $normalizedSql) {
                $q->whereRaw("$normalizedSql LIKE ?", ["%$normalizedQuery%"])
                    ->orWhere('title_en', 'LIKE', "%$normalizedQuery%");
            })
                ->orderBy('created_at', 'desc')
                ->paginate(30);

            if ($results->total() === 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($results, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            if (!$query) {
                return $this->errorResponse([
                    'message' => 'يرجى إدخال كلمة البحث.',
                ], 422);
            }

            // ✅ Normalize Arabic letters
            $normalizedQuery = TextNormalizer::normalizeArabic($query);

            // ✅ SQL replace chain to normalize Arabic columns
            $normalizedSql = TextNormalizer::sqlNormalizeColumn('title_ar');
            // ✅ Execute manual query without Scout
            $results = ProjectCategory::where(function ($q) use ($normalizedQuery, $normalizedSql) {
                $q->whereRaw("$normalizedSql LIKE ?", ["%$normalizedQuery%"])
                    ->orWhere('title_en', 'LIKE', "%$normalizedQuery%");
            })->paginate(30);

            return $this->paginationResponse($results, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function AllArabicCategories()
    {
        try {
            $Categories = ProjectCategory::orderBy('created_at', 'desc')->select('id', 'title_ar', 'icon_name', 'bg_color')->get();
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
            $Categories = ProjectCategory::orderBy('created_at', 'desc')->where('is_active', true)->get();
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
            $category = new ProjectCategory();
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
    public function show(ProjectCategory $projectCategory)
    {
        try {
            return $this->successResponse($projectCategory, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, ProjectCategory $projectCategory)
    {
        try {
            $data = $request->validated();
            $projectCategory->update($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $projectCategory, 'images/projectCategories', 'image');
            }
            return $this->successResponse($projectCategory->fresh(), 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCategory $projectCategory)
    {
        try {
            if ($projectCategory->image) {
                $this->imageservice->deleteOldImage($projectCategory, 'images/projectCategories');
            }

            $projectCategory->delete();

            return $this->successResponse($projectCategory, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
