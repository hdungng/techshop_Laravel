@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                @if (session('status-danger'))
                    <div class="alert alert-danger">
                        {{ session('status-danger') }}
                    </div>
                @endif
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">EDIT A PRODUCT</h6>
                    <form action="{{ route('edit_product', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control" type="text" name="id" id="id"
                                    value="{{ $product->id }}" readonly hidden>

                                <br>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="name" id="name"
                                        value="{{ $product->name }}">
                                    @error('name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <br>

                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail</label>
                                    <br>
                                    <img style="width: 300px; height: 300px;" src="{{ url($product->thumbnail) }}"
                                        alt="">
                                    <br>
                                    <br>
                                    <input class="form-control" type="file" name="thumbnail" id="thumbnail"
                                        value="{{ $product->thumbnail }}">
                                    @error('thumbnail')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input class="form-control" type="text" name="price" id="price"
                                        value="{{ $product->price }}">
                                    @error('price')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="col-6">
                                <br>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="intro" cols="30" rows="10">{{ $product->description }}</textarea>
                                    @error('description')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="detail">Detail</label>
                            <textarea name="detail" class="form-control main_content" id="intro" cols="50" rows="10">{!! $product->detail !!}</textarea>
                            @error('detail')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="cat_id">Category</label>
                            <select name="cat_id" id="cat_id" class='form-control'>
                                @foreach ($list_cats as $cat)
                                    @if ($cat->id == $product->cat_id)
                                        <option value="{{ $product->cat_id }}" selected>{{ $cat->name }}</option>
                                    @else
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('cat_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="brand_id">Brand</label>
                            <select name="brand_id" id="brand_id" class='form-control'>
                                @foreach ($list_brands as $brand)
                                    @if ($brand->id == $product->brand_id)
                                        <option value="{{ $product->brand_id }}" selected>{{ $brand->name }}</option>
                                    @else
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('brand_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input class="form-control" type="text" name="quantity" id="quantity"
                                value="{{ $product->quantity }}">
                            @error('quantity')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="role">Status</label>
                            {{ Form::select('status', ['Pending' => 'Pending', 'Active' => 'Active'], $product->status, ['class' => 'form-control']) }}
                            @error('status')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Cập nhật">

                        {{-- <a href="{{ route('add_image_product', $product->id) }}">Add product's images</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
