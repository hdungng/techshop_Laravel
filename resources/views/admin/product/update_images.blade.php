@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">EDIT PRODUCT'S IMAGES</h6>
                    <form action="{{ route('store_image_product', $images->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control" type="text" name="product_id" id="product_id"
                                    value="{{ $images->product_id }}" readonly hidden>
                                <div class="form-group">
                                    <label class="form-label">{{ $images->name }}</label>
                                </div>
                                @php
                                    $images_list = explode('|', $images->url);
                                @endphp
                                <div class="form-group">
                                    @foreach ($images_list as $image)
                                        <img src="{{ url($image) }}" style="height: 100px; width: 150px" alt="">
                                    @endforeach
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="url" class="form-label">Images</label>
                                    <input class="form-control" type="file" id="url" name="url[]" multiple>
                                    @error('url')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('url.*')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <br>

                                <div class="form-group">
                                    <label for="role">Status</label>
                                    {{ Form::select('status', ['Pending' => 'Pending', 'Active' => 'Active'], $images->status, ['class' => 'form-control']) }}
                                    @error('status')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <br>

                                <input type="submit" class="btn btn-primary" value="Update">
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
