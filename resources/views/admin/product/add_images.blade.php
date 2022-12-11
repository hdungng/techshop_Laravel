@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">ADD PRODUCT'S IMAGES</h6>
                    <form action="{{ route('create_image_product', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control" type="text" name="id" id="id"
                                    value="{{ $product->id }}" readonly hidden>
                                <div class="form-group">
                                    <label class="form-label">{{ $product->name }}</label>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="url" class="form-label">Images URL</label>
                                    <input class="form-control" type="file" id="url" name="url[]" multiple>
                                    @error('url')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('url.*')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <br>

                                <input type="submit" class="btn btn-primary" value="Add images">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
