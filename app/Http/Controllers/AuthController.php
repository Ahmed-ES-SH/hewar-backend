<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{

    use ApiResponse;





    public function login(Request $request)
    {
        try {
            // Basic validation
            $validation = Validator::make($request->all(), [
                'login' => 'required|string',
                'password' => 'required|string'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'errors' => $validation->errors()
                ], 422);
            }

            $loginInput = $request->input('login');
            $password = $request->input('password');

            $account = null; // can be User or Organization

            // If email: try user first, then organization
            if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
                $account = User::where('email', $loginInput)->first();
            }
            // If phone format: try user first, then organization
            elseif (preg_match('/^\+?[0-9]{8,15}$/', $loginInput)) {
                $account = User::where('phone', $loginInput)->first();
            } else {
                return response()->json([
                    'message' => 'Invalid login format'
                ], 422);
            }

            // Not found
            if (!$account) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // Check password
            if (!Hash::check($password, $account->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // Ensure model supports token creation (HasApiTokens)
            if (!method_exists($account, 'createToken')) {
                return response()->json([
                    'message' => 'API tokens not enabled on the model. Add Laravel\Sanctum\HasApiTokens trait to the model.'
                ], 500);
            }

            // Create token
            $tokenResult = $account->createToken('auth_token');
            $plainToken = $tokenResult->plainTextToken;


            $account->save();

            // Hide sensitive fields
            if (method_exists($account, 'makeHidden')) {
                $account->makeHidden(['password', 'remember_token']);
            }

            return response()->json([
                'message' => ' login successful',
                'data' => $account,
                'token' => $plainToken,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }



    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            $user->currentAccessToken()->delete();
            $user->save();
            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    public function getCurrentUser(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            return response()->json([
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
