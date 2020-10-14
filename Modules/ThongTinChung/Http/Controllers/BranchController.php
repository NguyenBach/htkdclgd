<?php

namespace Modules\ThongTinChung\Http\Controllers;

use App\Http\Controllers\Controller;
use Cocur\Slugify\Slugify;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\ThongTinChung\Entities\Branch;
use Modules\ThongTinChung\Http\Requests\BranchRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BranchController extends Controller
{
    private $branch = null;

    public function __construct(Branch $model)
    {
        $this->branch = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($year)
    {
        $this->authorize('index', Branch::class);
        $user = Auth::user();

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $branches = $this->branch->where('university_id', $universityId)
            ->where('year', $year)
            ->get();
        $result = [
            'success' => true,
            'message' => 'Lấy thông tin thành công',
            'data' => [
                'branches' => $branches
            ]
        ];
        return response()->json($result, 200);
    }

    public function copy($year)
    {
        $copyYear = Input::get('copy_year');
        $this->authorize('index', Branch::class);
        $user = Auth::user();
        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }
        $faculty = Branch::where('university_id', $universityId)
            ->where('year', $copyYear)
            ->get();

        $faculty->map(function ($item) use ($year) {
            $newData = $item->replicate();
            $newData->year = $year;
            $newData->save();
        });
        $result = [
            'success' => true,
            'message' => 'Sao chép danh sách thành công',
        ];
        return response()->json($result, 200);
    }


    /**
     * Store a newly created resource in storage.
     * @param BranchRequest $request
     * @throws AuthorizationException
     */
    public function store($year, BranchRequest $request)
    {
        $this->authorize('store', Branch::class);
        $user = Auth::user();

        $universityId = $user->university_id;
        if (!$universityId) {
            $universityId = Input::get('university_id');
            if (!$universityId) {
                throw new NotFoundHttpException('Không có trường đại học');
            }
        }

        $data = $request->validated();
        if (!isset($data['number_researcher'])) {
            $data['number_researcher'] = 0;
        }

        if (!isset($data['number_officer'])) {
            $data['number_officer'] = 0;
        }
        $data['university_id'] = $universityId;
        $data['year'] = $year;
        $slugify = new Slugify();
        $data['slug'] = $slugify->slugify($data['name']);

        $checkExist = $this->branch->where('university_id', $universityId)
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
        $this->authorize('update', $branch);
        $user = Auth::user();
        $data = $request->validated();

        $slugify = new Slugify();
        $data['slug'] = $slugify->slugify($data['name']);

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
        $this->authorize('update', $branch);
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
