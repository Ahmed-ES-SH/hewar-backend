<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSocialAccountsRequest;
use App\Http\Traits\ApiResponse;
use App\Models\SocialAccount;
use Exception;
use Illuminate\Http\Request;

class SocialAccountController extends Controller
{
    use ApiResponse;


    public function getAccounts()
    {
        try {
            $accounts = SocialAccount::findOrFail(1);
            return $this->successResponse($accounts, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    public function update(UpdateSocialAccountsRequest $request)
    {
        try {
            $data = $request->validated();
            $accounts = SocialAccount::findOrFail(1);
            $accounts->update($data);
            return $this->successResponse($accounts, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function getHeaderData()
    {
        try {
            $data = SocialAccount::select('id', 'gmail_account', 'whatsapp_number', 'location')->findOrFail(1);
            return $this->successResponse($data, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
