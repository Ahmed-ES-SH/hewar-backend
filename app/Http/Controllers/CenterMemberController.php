<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCenterMemberRequest;
use App\Http\Requests\UpdateCenterMemberRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\CenterMember;
use Exception;
use Illuminate\Http\Request;

class CenterMemberController extends Controller
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
            $members = CenterMember::orderBy('sort', 'asc')->paginate(12);

            if ($members->total() == 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($members, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function activeMembers(Request $request)
    {
        try {

            $request->validate([
                'limit' => 'nullable|integer'
            ]);

            $limit = $request->limit;

            if ($limit) {
                $members = CenterMember::orderBy('sort', 'asc')->where('is_active', 1)->limit($limit)->get();
                return $this->successResponse($members, 200);
            }

            $members = CenterMember::orderBy('sort', 'asc')->where('is_active', 1)->paginate(12);

            if ($members->total() == 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($members, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCenterMemberRequest $request)
    {
        try {
            $data = $request->validated();
            $member = CenterMember::create($data);

            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $member, 'images/members', 'image');
            }

            return $this->successResponse($member, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CenterMember $centerMember)
    {
        try {
            return $this->successResponse($centerMember, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCenterMemberRequest $request, CenterMember $centerMember)
    {
        try {
            $data = $request->validated();
            $centerMember->update($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $centerMember, 'images/members', 'image');
            }
            $centerMember->refresh();

            return $this->successResponse($centerMember, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CenterMember $centerMember)
    {
        try {
            if (!empty($centerMember->image)) {
                $this->imageservice->deleteOldImage($centerMember, 'images/members');
            }

            $centerMember->delete();

            return $this->successResponse($centerMember, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
