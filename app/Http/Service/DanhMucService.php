<?php

namespace App\Http\Service;

use App\Models\Danhmuc;
use http\Env\Request;
use PHPUnit\Exception;
use DB;

class DanhMucService
{
    public function create($request){
        try {
            Danhmuc::create([
                'TenDM'=>(string)$request->input('TenDM'),
                'MaDM'=>(string)$request->input('MaDM'),
                'MoTa'=>(string)$request->input('MoTa'),
                'Vitri'=>(string)$request->input('ViTri')
            ]);
            Session()->flash('success','Thêm mới danh mục thành công');
        }
        catch (Exception $ex){
            Session()->flash('error',$ex->getMessage());
            return false;
        }
        return true;
    }
    public function  getAll($request){
        $keywords = $request->input('keywords');
        $searchType = $request->input('$searchType');
        $pageSize = $request->input('page_size',2);
        return Danhmuc::paginate($pageSize)->withQueryString();
    }
    public function edit($request,$danhmuc){
        try {
                $danhmuc->MaDM = $request->input('MaDM');
                $danhmuc->TenDM = $request->input('TenDM');
                $danhmuc->MoTa = $request->input('MoTa');
                $danhmuc->Vitri = $request->input('ViTri');
                $danhmuc->save();
                Session()->flash('success','Sửa thông tin danh mục thành công');
        }
        catch (Exception $ex){
            Session()->flash('error',$ex->getMessage());
            return false;
        }
        return true;
    }
    public function delete($request){
        $danhmuc = Danhmuc::where('id',$request->input('id'))->first();
        if($danhmuc){
            return $danhmuc->delete();
        }
    }
}
