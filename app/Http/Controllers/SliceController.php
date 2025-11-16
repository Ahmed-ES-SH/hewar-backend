<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSliceRequest;
use App\Http\Requests\UpdateSliceRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\Slice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliceController extends Controller
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
    public function index()
    {
        try {
            $slices = Slice::orderBy('created_at', 'desc')->get();

            if ($slices->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->successResponse($slices, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliceRequest $request)
    {
        try {
            $data = $request->validated();
            $slice = Slice::create($data);
            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $slice, 'images/slices', 'image');
            }

            if ($request->hasFile('video_path')) {
                $this->imageservice->ImageUploaderwithvariable($request, $slice, 'videos/slices', 'video_path');
            }

            return $this->successResponse($slice, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slice $slice)
    {
        try {
            return $this->successResponse($slice, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliceRequest $request, Slice $slice)
    {
        try {
            $data = $request->validated();
            $slice->update($data);

            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $slice, 'images/slices', 'image');
            }

            if ($request->hasFile('video_path')) {
                $this->imageservice->ImageUploaderwithvariable($request, $slice, 'videos/slices', 'video_path');
            }

            return $this->successResponse($slice, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slice $slice)
    {
        try {
            if ($slice->image) {
                $this->imageservice->deleteOldImage($slice, 'images/slices');
            }


            if ($slice->video_path) {
                $old_video = $slice->video_path;
                if ($old_video) {
                    // استخراج اسم الصورة من الرابط
                    $oldImageName = basename(parse_url($old_video, PHP_URL_PATH));
                    // تحديد المسار الفعلي للصورة في الخادم
                    $filePath = public_path('videos/slices' . '/' . $oldImageName);

                    // التحقق إذا كانت الصورة موجودة ثم حذفها
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }

            $slice->delete();
            return $this->successResponse($slice, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
