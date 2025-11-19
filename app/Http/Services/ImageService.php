<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ImageService
{


    public function ImageUploaderwithvariable(Request $request, $model, string $storagePath = 'images/users', $variable = 'image')
    {
        if ($request->hasFile($variable)) {
            $imageFile = $request->file($variable);

            // Generate unique filename
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $imageFile->getClientOriginalExtension();
            $filename = $originalName . '_' . uniqid() . '.' . $extension;

            // Move the file to public path
            $imageFile->move(public_path($storagePath), $filename);
            $fullImagePath = url('/') . '/' . $storagePath . '/' . $filename;

            // Handle based on type: model or relation
            if ($model instanceof \Illuminate\Database\Eloquent\Relations\HasMany) {
                // Add new image record in related table
                $model->create(['image' => $fullImagePath]);
            } else {
                // Handle single image column
                $columnName = $variable;

                // Delete old image if exists
                $old_image = $model->{$columnName};
                if ($old_image) {
                    $old_image_name = basename(parse_url($old_image, PHP_URL_PATH));
                    $file_path = public_path($storagePath . '/' . $old_image_name);
                    if (File::exists($file_path)) {
                        File::delete($file_path);
                    }
                }

                // Update image column
                $model->{$columnName} = $fullImagePath;
                $model->save();
            }
        } else {
            return 'file not found';
        }
    }


    public function ImageUploader($image, $model, string $storagePath = 'images/users', string $columnName = 'image')
    {
        // إذا كانت الصورة نص (رابط URL جاهز)
        if (is_string($image)) {
            $model->{$columnName} = $image;
            $model->save();
            return $image;
        }

        // التأكد أن الملف كائن UploadedFile صالح
        if (!($image instanceof \Illuminate\Http\UploadedFile) || !$image->isValid()) {
            throw new \Exception('Invalid image file.');
        }

        // إنشاء اسم ملف فريد
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $filename = $originalName . '_' . uniqid() . '.' . $extension;

        // إنشاء المجلد إن لم يكن موجوداً
        $destinationPath = public_path($storagePath);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // نقل الصورة
        $image->move($destinationPath, $filename);
        $fullImagePath = url($storagePath . '/' . $filename);

        // حذف الصورة القديمة إن وُجدت
        $oldImage = $model->{$columnName};
        if ($oldImage) {
            $oldImageName = basename(parse_url($oldImage, PHP_URL_PATH));
            $filePath = public_path($storagePath . '/' . $oldImageName);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // تحديث الموديل بالرابط الجديد
        $model->{$columnName} = $fullImagePath;
        $model->save();

        return $fullImagePath;
    }


    public function MultiImageUploaderwithvariable(Request $request, $model, string $storagePath = 'images/projects', string $variable = 'images')
    {
        if ($request->has($variable)) {
            $images = $request->input($variable, []);
            $files = $request->file($variable, []);

            // دمج النصوص والملفات في مصفوفة واحدة للحلقة
            $allImages = [];

            // إضافة النصوص أولاً (URLs أو مسارات موجودة)
            foreach ($images as $img) {
                if (is_string($img) && !empty($img)) {
                    $allImages[] = $img;
                }
            }

            // إضافة الملفات الجديدة
            foreach ($files as $imageFile) {
                if (!$imageFile->isValid()) continue;

                $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $imageFile->getClientOriginalExtension();
                $filename = $originalName . '_' . uniqid() . '.' . $extension;

                $imageFile->move(public_path($storagePath), $filename);
                $fullImagePath = url('/') . '/' . $storagePath . '/' . $filename;

                $allImages[] = $fullImagePath;

                // ربط الصورة بالموديل
                if (method_exists($model, 'images')) {
                    $model->images()->create([
                        'image_path' => $fullImagePath,
                    ]);
                } else if ($model instanceof \Illuminate\Database\Eloquent\Relations\HasMany) {
                    $model->create(['image_path' => $fullImagePath]);
                }
            }

            // إرجاع جميع الصور (URLs + المرفوع حديثاً)
            return $allImages;
        }

        return [];
    }





    public function deleteOldImage($model, $storagePath)
    {
        if ($model) {
            $old_image = $model->image;
            $old_icon = $model->icon;

            if ($old_icon) {
                $oldIconName = basename(parse_url($old_icon, PHP_URL_PATH));
                $filePath = public_path($storagePath . '/' . $oldIconName);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
            if ($old_image) {
                // استخراج اسم الصورة من الرابط
                $oldImageName = basename(parse_url($old_image, PHP_URL_PATH));
                // تحديد المسار الفعلي للصورة في الخادم
                $filePath = public_path($storagePath . '/' . $oldImageName);

                // التحقق إذا كانت الصورة موجودة ثم حذفها
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
        }
    }



    public function uploadChatAttachment(UploadedFile $file, $model, string $storagePath = 'attachments/messages', string $variable = 'attachment'): ?string
    {
        // حذف المرفق القديم إن وجد
        $old_file = $model->{$variable};
        if ($old_file) {
            $old_file_name = basename(parse_url($old_file, PHP_URL_PATH));
            $file_path = public_path($storagePath . '/' . $old_file_name);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
        }

        // اسم جديد للملف
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = $originalName . '_' . uniqid() . '.' . $extension;

        // حفظ الملف
        $file->move(public_path($storagePath), $filename);

        // حفظ الرابط في قاعدة البيانات
        $model->{$variable} = url('/') . '/' . $storagePath . '/' . $filename;
        $model->save();

        return $model->{$variable};
    }



    public function deleteChatAttachment($model, string $variable = 'attachment'): bool
    {
        if ($model->{$variable}) {
            // -------------------------
            // استخراج اسم الملف من الرابط المخزن
            // -------------------------
            $fileName = basename(parse_url($model->{$variable}, PHP_URL_PATH));
            $filePath = public_path('attachments/messages/' . $fileName); // تحديث المسار حسب الحاجة

            // -------------------------
            // حذف الملف من التخزين
            // -------------------------
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            // -------------------------
            // إزالة الرابط من قاعدة البيانات
            // -------------------------
            $model->{$variable} = null;
            $model->save();

            return true; // تم الحذف بنجاح
        }

        return false; // لا يوجد مرفق للحذف
    }
}
