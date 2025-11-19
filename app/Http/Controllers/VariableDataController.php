<?php

namespace App\Http\Controllers;

use App\Http\Resources\AboutSectionResource;
use App\Http\Resources\CharityServicesResource;
use App\Http\Resources\FaqSectionResource;
use App\Http\Resources\HelpSectionResource;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\VariableData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class VariableDataController extends Controller
{
    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }




    public function getVariablesData(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|exists:variable_data,id',
                'limit' => 'nullable|integer',
            ]);

            $id = $request->id;
            $limit = $request->limit ?? 30;


            $model = VariableData::findOrFail($id);

            $result = [];

            // نتحقق من الأعمدة من column_1 حتى column_$limit
            for ($i = 1; $i <= $limit; $i++) {
                $columnName = 'column_' . $i;

                if (!isset($model->$columnName)) {
                    // إذا العمود غير موجود في الموديل
                    continue;
                }

                $value = $model->$columnName;

                // إذا كان النص عبارة عن JSON صالح، نقوم بتحويله إلى مصفوفة
                if (is_string($value) && $this->isJson($value)) {
                    $value = json_decode($value, true);
                }

                $result[$columnName] = $value;
            }

            return $this->successResponse($result, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    public function updateVariablesData(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:variable_data,id',
                'limit' => 'nullable|integer|min:1|max:30',
            ]);

            $limit = $request->limit ?? 30;
            $model = VariableData::findOrFail($request->id);

            $updateData = [];

            for ($i = 1; $i <= $limit; $i++) {
                $col = 'column_' . $i;

                // ============================
                // 🔥 1) معالجة رفع الصور
                // ============================
                if ($request->hasFile($col)) {
                    $storagePath = "";
                    $imageFile = $request->file($col);

                    // اسم فريد للملف
                    $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = strtolower($imageFile->getClientOriginalExtension());
                    $filename = $originalName . '_' . uniqid() . '.' . $extension;

                    // تحديد نوع الملف
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                    $videoExtensions = ['mp4', 'mov', 'avi', 'mkv', 'wmv'];

                    if (in_array($extension, $imageExtensions)) {
                        $storagePath = 'images/variablesData';
                    } elseif (in_array($extension, $videoExtensions)) {
                        $storagePath = 'videos/variablesData';
                    } else {
                        return 'File type not supported';
                    }

                    $imageFile->move(public_path($storagePath), $filename);

                    // لينك قابل للاستخدام في الواجهة
                    $fullImagePath = url('/') . '/' . $storagePath . '/' . $filename;

                    // حذف الصورة القديمة إن وجدت
                    $old_image = $model->$col;
                    if ($old_image) {
                        $old_image_name = basename(parse_url($old_image, PHP_URL_PATH));
                        $old_path = public_path("$storagePath/$old_image_name");
                        if (File::exists($old_path)) {
                            File::delete($old_path);
                        }
                    }

                    // تخزين المسار النهائي
                    $updateData[$col] = $fullImagePath;

                    continue; // انتقل للعمود التالي
                }

                // ==================================
                // 🔥 2) تخزين القيم النصية كما هي
                // ==================================
                if ($request->has($col)) {
                    $updateData[$col] = $request->$col;
                }
            }

            // تطبيق التحديث
            $model->update($updateData);

            return $this->successResponse($updateData, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    public function getALlDataForHomePage()
    {
        try {
            $data = [
                'charity_services' => new CharityServicesResource(
                    VariableData::select('column_1', 'column_2')->find(1)
                ),

                'about_section' => new AboutSectionResource(
                    VariableData::select('column_1', 'column_2', 'column_3', 'column_4', 'column_5')->find(2)
                ),

                'help_section' => new HelpSectionResource(
                    VariableData::select('column_1', 'column_2', 'column_3', 'column_4')->find(3)
                ),

                'faq_section' => new FaqSectionResource(
                    VariableData::select('column_1', 'column_2', 'column_3', 'column_4', 'column_5')->find(4)
                ),
            ];

            return $this->successResponse($data, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }






    public function getCharityServices()
    {
        try {
            $model = VariableData::findOrFail(1);
            $services = json_decode($model->column_1 ?? '[]', true);
            $mainTitles = json_decode($model->column_2 ?? '[]', true);
            $data = [
                'services' => $services,
                'texts' => $mainTitles
            ];
            return $this->successResponse($data, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function updateCharityServices(Request $request)
    {
        try {
            $validated = $request->validate([
                'services' => 'required',
                'texts' => 'required',
            ]);


            $model = VariableData::findOrFail(1);
            $model->update([
                'column_1' => $validated['services'],
                'column_2' => $validated['texts'],
            ]);
            return $this->successResponse($model, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
