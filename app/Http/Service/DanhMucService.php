<?php

namespace App\Http\Service;

use App\Models\Danhmuc;
use http\Env\Request;
use mysql_xdevapi\Session;
use PHPUnit\Exception;
use DB;
use function PHPUnit\Framework\isEmpty;

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
    public function  getAll($keywords,$searchType,$pageSize){
        $query = Danhmuc::query();
        if ($keywords && $searchType) {
            switch ($searchType){
                case 0:
                    $query->where(function ($subQuery) use ($keywords) {
                        $subQuery->where('MaDM', 'like', '%' . $keywords . '%')
                            ->orWhere('TenDM', 'like', '%' . $keywords . '%')
                            ->orWhere('Vitri', 'like', '%' . $keywords . '%');
                    });
                    break;
                case 1:
                    $query->where('MaDM', 'like', '%' . $keywords . '%');
                   break;
                case 2:
                    $query->where('TenDM', 'like', '%' . $keywords . '%');
                    break;
                case 3:
                    $query->where('Vitri', 'like', '%' . $keywords . '%');
                    break;
            }
        }
        $danhmucs = $query->paginate($pageSize)->withQueryString();
        return $danhmucs;
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
