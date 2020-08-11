<?php

namespace Modules\ThongTinChung\Http\Controllers;

use App\Http\Controllers\Controller;
use Cocur\Slugify\Slugify;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\ThongTinChung\Entities\Branch;
use Modules\ThongTinChung\Http\Requests\BranchRequest;

class BranchController extends Controller
{
    private $branch = null;

    public function __construct(Branch $model)
    {
        $this->branch = $model;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('branch', Branch::class);
        $user = Auth::user();
        $branches = $this->branch->where('university_id', $user->university_id)->get();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'branches' => $branches
            ]
        ];
        return response()->json($result, 200);
    }


    /**
     * Store a newly created resource in storage.
     * @param BranchRequest $request
     * @throws AuthorizationException
     * @return Response
     */
    public function store(BranchRequest $request)
    {
        $this->authorize('branch', Branch::class);
        $user = Auth::user();
        $data = $request->validated();
        if (!isset($data['number_researcher'])) {
            $data['number_researcher'] = 0;
        }

        if (!isset($data['number_officer'])) {
            $data['number_officer'] = 0;
        }
        $data['university_id'] = $user->university_id;
        $slugify = new Slugify();
        $data['slug'] = $slugify->slugify($data['name']);

        $checkExist = $this->branch->where('university_id', $user->university_id)
            ->where('slug', $data['slug'])->first();
        if (!is_null($checkExist)) {
            $result = [
                'success' => false,
                'message' => 'Đơn vị này đã tồn tại',
            ];
            return response()->json($result, 400);
        }

        $branch = $this->branch->create($data);
        if ($branch) {
            $result = [
                'success' => true,
                'message' => 'Tạo đơn vị thành công',
                'data' => [
                    'branch' => $branch
                ]
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Tạo đơn vị thất bại',
            ];
            return response()->json($result, 500);
        }
    }

    /**
     * Show the specified resource.
     * @param Branch $id
     * @return Response
     */
    public function show(Branch $id)
    {
        $result = [
            'success' => true,
            'message' => 'Lấy đơn vị thành công',
            'data' => [
                'branch' => $id
            ]
        ];
        return response()->json($result, 200);
    }

    /**
     * Update the specified resource in storage.
     * @param BranchRequest $request
     * @param Branch $branch
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Branch $branch, BranchRequest $request)
    {
        $this->authorize('branch_update', $branch);
        $user = Auth::user();
        $data = $request->validated();

       /** if (!isset($data['number_researcher'])) {
            $data['number_researcher'] = $branch->number_researcher;
        }

        if (!isset($data['number_officer'])) {
            $data['number_officer'] = $branch->number_officer;
        }**/

        $slugify = new Slugify();
        $data['slug'] = $slugify->slugify($data['name']);
        //$data['university_id'] = $user->university_id;

       // $checkExist = $this->branch->where('university_id', $user->university_id)
       //     ->where('slug', $data['slug'])->first();

     //   if (!is_null($checkExist) && $data['slug'] != $branch->slug) {
     //       $result = [
    //            'success' => false,
     //           'message' => 'Đơn vị này đã tồn tại',
    //        ];
   //         return response()->json($result, 400);
    //    }

        $success = $branch->update($data);

        if ($success) {
            $result = [
                'success' => true,
                'message' => 'Tạo đơn vị thành công',
                'data' => [
                    'branch' => $branch
                ]
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Tạo đơn vị thất bại',
            ];
            return response()->json($result, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Branch $branch
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Branch $branch)
    {
        //
        $this->authorize('branch_update', $branch);
        $success = $branch->delete();
        if ($success) {
            $result = [
                'success' => true,
                'message' => 'Xóa đơn vị thành công',
            ];
            return response()->json($result, 200);
        } else {
            $result = [
                'success' => false,
                'message' => 'Xóa Đơn vị thất bại ',
            ];
            return response()->json($result, 500);
        }
    }
}
