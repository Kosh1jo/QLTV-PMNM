@extends('admin.main')
@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-6 ">
            <div class="dataTables_length bs-select" id="dtBasicExample_length ">
                <form method="GET" action="/admin/danhmuc/list" id="form-pageSize">
                <label class="m-2" style="text-align: left;font-weight: 400;padding-top: 0.5rem;padding-bottom: 0.5rem;">Show
                    <input value="{{$pagesize}}" style="width: auto;" id="page_size" name="page_size" aria-controls="dtBasicExample" class="custom-select custom-select-sm form-control form-control-sm">
                     entries</label>
                </form>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 ">
            <form action="" method="get">
                <div class="d-flex m-2">
                    <div class="col-6">
                        <input value="{{request()->input('keywords') ? :''}}" type="search" class="form-control" name="keywords" id="" placeholder="Từ khóa tìm kiếm...">
                    </div>
                    <div class="col-3">
                        <select class="form-control" name="searchType">
                            <option value="0" {{request()->input('searchType')==0 ? 'selected':''}}>----Type----</option>
                            <option value="1" {{request()->input('searchType')==1 ? 'selected':''}}>Mã danh mục</option>
                            <option value="2" {{request()->input('searchType')==2 ? 'selected':''}}>Tên danh mục</option>
                            <option value="3" {{request()->input('searchType')==3 ? 'selected':''}}>Vị trí</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>STT</th>
            <th>Mã danh mục</th>
            <th>Tên danh mục</th>
            <th>Mô tả</th>
            <th>Vị trí</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($danhmucs))
        @foreach($danhmucs as $key => $danhmuc)
            <tr>
                <td>{{$danhmucs->currentPage()*$pagesize-$pagesize+$key+1}}</td>
                <td>{{$danhmuc->MaDM}}</td>
                <td>{{$danhmuc->TenDM}}</td>
                <td>{!! $danhmuc->MoTa !!}</td>
                <td>{{$danhmuc->Vitri}}</td>
                <td><a class=" btn btn-primary mr-3" href="/admin/danhmuc/edit/{{$danhmuc->id}}"><i class="fa fa-edit "></i></a>
                    <a class="btn btn-danger" href="#" onclick="Delete({{$danhmuc->id}},'/admin/danhmuc/delete')"><i class = "fa fa-trash"></i></a>
                </td>
            </tr
        @endforeach
        @else
            <h5 class="mt-3 text-center text-body-secondary ">Không tìm thấy danh mục bạn yêu cầu</h5>
        @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info m-2" id="example2_info" role="status" aria-live="polite">
                Showing {{$danhmucs->currentPage()*$pagesize-$pagesize+1}} to {{$danhmucs->currentPage()*$pagesize-$pagesize+$danhmucs->count()}} of {{$danhmucs->total()}} entries
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                {{ $danhmucs->links() }}
            </div>
        </div>
    </div>

@endsection
