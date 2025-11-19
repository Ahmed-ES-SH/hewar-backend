<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Mail\VerifyEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use ApiResponse;

    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }



    public function index() // admin Route
    {
        try {
            $users = User::orderBy('created_at', 'desc')
                ->select('id', 'name', 'image', 'email',  'phone', 'role', 'created_at')
                ->paginate(30);

            if ($users->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($users, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    public function usersWithSelectedData(Request $request)
    {
        try {
            // التحقق من الإدخال
            $validatedData = $request->validate([
                'query' => 'nullable|string|max:255'
            ]);

            $query = $validatedData['query'] ?? null;

            // Base query
            $usersQuery = User::select('id', 'name', 'email', 'image');

            if ($query) {
                // ✅ Normalize the search term
                $normalizedQuery = TextNormalizer::normalizeArabic($query);

                // ✅ SQL string to normalize Arabic letters in the database fields
                $normalizedName = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";
                $normalizedEmail = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(email, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";
                $normalizedPhone = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";
                $normalizedCountry = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(country, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";

                $usersQuery->where(function ($q) use ($normalizedQuery, $normalizedName, $normalizedEmail, $normalizedPhone, $normalizedCountry) {
                    $q->whereRaw("$normalizedName LIKE ?", ["%$normalizedQuery%"])
                        ->orWhereRaw("$normalizedEmail LIKE ?", ["%$normalizedQuery%"])
                        ->orWhereRaw("$normalizedPhone LIKE ?", ["%$normalizedQuery%"])
                        ->orWhereRaw("$normalizedCountry LIKE ?", ["%$normalizedQuery%"]);
                });
            }

            // ✅ Paginate results
            $users = $usersQuery->paginate(20);

            if ($users->total() === 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($users, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }





    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();

            // تشفير كلمة المرور إن وجدت
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->filled('id_number')) {
                $data['id_number'] = Hash::make($request->id_number);
            }

            // إنشاء المستخدم وملء البيانات
            $user = User::create($data);

            // معالجة الصورة إذا تم رفعها`
            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $user, 'images/users', 'image');
            }

            return $this->successResponse($user, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    public function show($id)
    {
        try {
            $user = User::findOrFail($id);

            return $this->successResponse($user, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $user = User::findOrFail($id);

            // تحديث كلمة المرور بعد التحقق من وجودها
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // تحديث البيانات
            $user->update($data);

            // تحديث الصورة إذا تم رفع صورة جديدة
            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $user, 'images/users', 'image');
            }

            return $this->successResponse($user->fresh(), 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    public function destroy($id) // admin route
    {
        try {
            $user = User::findOrFail($id);

            // حذف الصورة إذا وُجدت
            if (!empty($user->image)) {
                $this->imageservice->deleteOldImage($user, 'images/users');
            }

            $user->delete();

            return $this->successResponse(['name', $user->name], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    public function searchForUsers(Request $request) // admin Route
    {
        try {
            // التحقق من الإدخال
            $validatedData = $request->validate([
                'query' => 'required|string|max:255'
            ]);
            $query = $validatedData['query'];

            // ✅ Normalize the search term
            $normalizedQuery = TextNormalizer::normalizeArabic($query);

            // ✅ SQL string to normalize Arabic letters in the database fields
            $normalizedName = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";
            $normalizedEmail = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(email, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";
            $normalizedPhone = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";
            $normalizedCountry = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(country, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";

            // ✅ Execute the search query
            $users = User::where(function ($q) use ($normalizedQuery, $normalizedName, $normalizedEmail, $normalizedPhone, $normalizedCountry) {
                $q->whereRaw("$normalizedName LIKE ?", ["%$normalizedQuery%"])
                    ->orWhereRaw("$normalizedEmail LIKE ?", ["%$normalizedQuery%"])
                    ->orWhereRaw("$normalizedPhone LIKE ?", ["%$normalizedQuery%"])
                    ->orWhereRaw("$normalizedCountry LIKE ?", ["%$normalizedQuery%"]);
            })->paginate(30);

            // التأكد من وجود نتائج
            if ($users->total() === 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($users, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    public function getUsersIds() // admin Route
    {
        try {
            // استخدام cursor() لتحميل البيانات بشكل تدريجي
            $usersIds = User::cursor()->pluck('id')->toArray();

            // التحقق من وجود بيانات
            if (empty($usersIds)) {
                return $this->noContentResponse();
            }

            return $this->successResponse(array_values($usersIds), 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
