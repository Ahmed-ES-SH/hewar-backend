<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCenterBranchRequest;
use App\Http\Requests\UpdateCenterBranchRequest;
use App\Http\Traits\ApiResponse;
use App\Models\CenterBranch;
use Exception;
use Illuminate\Http\Request;

class CenterBranchController extends Controller
{

    use ApiResponse;


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = CenterBranch::latest()->get();
            return $this->successResponse($data, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCenterBranchRequest $request)
    {
        try {
            $data = CenterBranch::create($request->validated());
            return $this->successResponse($data, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CenterBranch $centerBranch)
    {
        try {
            return $this->successResponse($centerBranch, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCenterBranchRequest $request, CenterBranch $centerBranch)
    {
        try {
            $data = $request->validated();
            $centerBranch->update($data);
            return $this->successResponse($centerBranch, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CenterBranch $centerBranch)
    {
        try {
            $centerBranch->delete();

            return $this->successResponse(['message' => 'Deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
