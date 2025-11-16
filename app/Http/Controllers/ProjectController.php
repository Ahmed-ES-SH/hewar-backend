<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\Project;
use App\Models\ProjectImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
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
                'status' => 'nullable|in:draft,pending,approved,in_progress,completed,rejected,canceled',
                'categories' => 'nullable|string', // CSV IDs
            ]);

            $projects = Project::with(['images', 'category'])
                ->filter($request->only(['query', 'status', 'categories']))
                ->orderBy('order', 'asc')
                ->paginate(12);

            if ($projects->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($projects);
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
                'is_urgent' => 'nullable|boolean',
                'limit' => 'nullable|integer',
            ]);

            if ($request->limit) {
                 $projects = Project::with(['images', 'category'])
                ->where('status', 'approved') // ✅ تقييد بالمشاريع الموافق عليها فقط
                ->filter($request->only(['query', 'categories', 'is_urgent']))
                ->orderBy('order', 'asc')
                ->limit($request->limit);
                ->get();

                return $tihs->successResponse($projects, 200);
            }

            $projects = Project::with(['images', 'category'])
                ->where('status', 'approved') // ✅ تقييد بالمشاريع الموافق عليها فقط
                ->filter($request->only(['query', 'categories', 'is_urgent']))
                ->orderBy('order', 'asc')
                ->paginate(12);

            if ($projects->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($projects);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $order = Project::max('order') ?? 0;
            if (!$request->filled('order')) {
                $data['order'] = $order + 1;
            }

            $project = Project::create($data);

            if ($request->has('image')) {
                $this->imageService->ImageUploaderwithvariable($request, $project, 'images/projects', 'image');
            }

            if ($request->hasFile('images')) {
                $this->imageService->MultiImageUploaderwithvariable(
                    $request,
                    $project,
                    'images/projects/gallery',
                    'images'
                );
            }

            DB::commit();

            $project->load('images:id,image_path', 'category:id,title_ar,icon_name,bg_color');

            return $this->successResponse($project, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        try {
            if (is_string($project->location)) {
                $project->location = json_decode($project->location);
            }

            if (is_string($project->metadata)) {
                $project->metadata = json_decode($project->metadata);
            }


            return $this->successResponse($project->load('images:id,project_id,image_path', 'category'), 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    public function update(UpdateProjectRequest $request, Project $project)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            // ✅ تحديث بيانات المشروع الأساسية
            $project->update($data);

            /** ✅ تحديث الصورة الرئيسية */
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة (باستخدام خدمتك)
                $this->imageService->deleteOldImage($project, 'images/projects');

                // رفع الصورة الجديدة
                $this->imageService->ImageUploaderwithvariable(
                    $request,
                    $project,
                    'images/projects',
                    'image'
                );
            }

            /** ✅ تحديث صور المعرض (في حالة إرسال صور جديدة) */

            if ($request->hasFile('images')) {
                $this->imageService->MultiImageUploaderwithvariable(
                    $request,
                    $project,
                    'images/projects/gallery',
                    'images'
                );
            }


            if ($request->filled('deletedImages')) {
                $deletedImages = $request->deletedImages;

                if (is_array($deletedImages)) {
                    foreach ($deletedImages as $imageId) {

                        // البحث عن الصورة في قاعدة البيانات
                        $oldImage = ProjectImage::find($imageId);

                        // استخراج اسم الصورة من الرابط
                        $oldImageName = basename(parse_url($oldImage->image_path, PHP_URL_PATH));
                        $filePath = public_path('images/projects/gallery/' . $oldImageName);

                        // التحقق من وجود الصورة وحذفها فعليًا
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        } else {
                            Log::warning("⚠️ لم يتم العثور على الملف في المسار: {$filePath}");
                        }

                        // حذف السجل من قاعدة البيانات
                        $oldImage->delete();
                    }
                }
            }

            DB::commit();

            if (is_string($project->location)) {
                $project->location = json_decode($project->location);
            }

            if (is_string($project->metadata)) {
                $project->metadata = json_decode($project->metadata);
            }

            return $this->successResponse(
                $project->load('images:id,project_id,image_path', 'category:id,title_ar,icon_name,bg_color'),
                200
            );
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        DB::beginTransaction();

        try {
            // ✅ حذف الصورة الرئيسية + الأيقونة (إن وجدت)
            $this->imageService->deleteOldImage($project, 'images/projects');

            // ✅ حذف الصور التابعة (من العلاقة images)
            if ($project->images && $project->images->count() > 0) {
                foreach ($project->images as $img) {
                    $this->imageService->deleteOldImage($img, 'images/projects/gallery');
                    $img->delete();
                }
            }

            // ✅ حذف المشروع نفسه
            $project->delete();

            DB::commit();

            return $this->successResponse(['message' => 'تم حذف المشروع بنجاح'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
