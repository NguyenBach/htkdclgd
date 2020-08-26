<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 05/08/2019
 * Time: 23:13
 */

namespace Modules\CoSoVatChat\Http\Controllers;


use App\Http\Controllers\Controller;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\Auth;
use Modules\CoSoVatChat\Entities\TrangThietBi;
use Modules\CoSoVatChat\Http\Requests\TrangThietBiRequest;

class TrangThietBiController extends Controller
{
    public function list()
    {
        $this->authorize('index', TrangThietBi::class);
        $trangThietBi = TrangThietBi::all();
        $result = [
            'success' => true,
            'message' => "Lấy danh sách trang thiết bị thành công",
            'data' => [
                'trang_thiet_bi' => $trangThietBi
            ]
        ];
        return \response()->json($result);
    }

    public function show(TrangThietBi $trangThietBi)
    {
        $result = [
            'success' => true,
            'message' => "Lấy trang thiết bị thành công",
            'data' => [
                'trang_thiet_bi' => $trangThietBi
            ]
        ];
        return \response()->json($result);
    }

    public function create(TrangThietBiRequest $request)
    {
        $this->authorize('create', TrangThietBi::class);
        $user = Auth::user();
        $data = $request->validated();
        $data['created_by'] = $user->id;
        $data['slug'] = (new Slugify())->slugify($data['name']);
        $trangThietBi = TrangThietBi::create($data);
        $result = [
            'success' => true,
            'message' => "Thêm trang thiết bị thành công",
            'data' => [
                'trang_thiet_bi' => $trangThietBi
            ]
        ];
        return \response()->json($result);
    }

    public function update(TrangThietBi $trangThietBi, TrangThietBiRequest $request)
    {
        $this->authorize('update', $trangThietBi);
        $user = Auth::user();
        $data = $request->validated();
        $data['created_by'] = $user->id;
        $data['slug'] = (new Slugify())->slugify($data['name']);
        $trangThietBi->update($data);
        $trangThietBi->refresh();
        $result = [
            'success' => true,
            'message' => "Thêm trang thiết bị thành công",
            'data' => [
                'trang_thiet_bi' => $trangThietBi
            ]
        ];
        return \response()->json($result);
    }

    public function delete(TrangThietBi $trangThietBi)
    {
        $this->authorize('update', $trangThietBi);
        $trangThietBi->delete();
        $result = [
            'success' => true,
            'message' => "Xóa trang thiết bị thành công",
        ];
        return \response()->json($result);
    }
}
