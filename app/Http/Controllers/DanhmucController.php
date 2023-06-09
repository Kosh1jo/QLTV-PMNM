<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDanhMucRequest;
use App\Http\Service\DanhMucService;
use App\Models\Danhmuc;
use Illuminate\Http\Request;

class DanhmucController extends Controller
{
    //
    protected $danhmucService;
    public function __construct(DanhMucService $danhMucService)
    {
        $this->danhmucService  = $danhMucService;
    }

    public function create(){
        return view('admin.danhmuc.add',[
           'title'=>'Thêm mới danh mục'
        ]);
    }
    public function store(CreateDanhMucRequest $request){
      //xử lý thêm mới danh mục
        //dd($request->input());
        $result = $this->danhmucService->create($request);
        return redirect()->back();
    }
    public function list(Request $request){
        $keywords = $request->input('keywords');
        $searchType = $request->input('searchType');
        $pageSize = $request->input('page_size',2);
        return view('admin.danhmuc.list',[
            'title'=>'Danh sách danh mục',
            'danhmucs'=>$this->danhmucService->getAll($keywords,$searchType,$pageSize),
            'pagesize'=>$pageSize

        ]);
    }
    public function edit(Danhmuc $danhmuc){
        return view('admin.danhmuc.edit',[
           'title'=>'Sửa thông tin danh mục',
           'danhmuc'=>$danhmuc
        ]);
    }
    public function postEdit(Danhmuc $danhmuc,CreateDanhMucRequest $request){
        $result = $this->danhmucService->edit($request,$danhmuc);
        return redirect()->back();
    }
    public function delete(Request $request){
        $result = $this->danhmucService->delete($request);
        if($result){
            return response()->json([
                'error'=>'false',
                'message'=>'Xóa danh mục thành công'
            ]);
        }
        return response()->json([
            'error'=>'true'
        ]);
    }
}
