@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">ADD A PRODUCT</h6>
                    <form action="{{ route('create_product') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input class="form-control" type="text" name="name" id="name">
                                    @error('name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <br>

                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Ảnh đại diện</label>
                                    <input class="form-control" type="file" name="thumbnail" id="thumbnail">
                                    @error('thumbnail')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="price">Giá</label>
                                    <input class="form-control" type="text" name="price" id="price">
                                    @error('price')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="description">Mô tả sản phẩm</label>
                                    <textarea name="description" class="form-control" id="intro" cols="30" rows="10"></textarea>
                                    @error('description')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>


                        <div class="form-group">
                            <label for="detail">Chi tiết sản phẩm</label>
                            <textarea name="detail" class="form-control main_content" id="intro" cols="50" rows="10"></textarea>
                            @error('detail')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="cat_id">Danh mục</label>
                            <select class="form-control" id="cat_id" name="cat_id">
                                <option>Chọn danh mục</option>
                                @foreach ($list_cats as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('cat_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="brand_id">Thương hiệu</label>
                            <select class="form-control" id="brand_id" name="brand_id">
                                <option>Chọn hãng</option>
                                @foreach ($list_brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="quantity">Số lượng</label>
                            <input class="form-control" type="text" name="quantity" id="quantity">
                            @error('quantity')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>

                        <input type="submit" class="btn btn-primary" value="Thêm mới">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
