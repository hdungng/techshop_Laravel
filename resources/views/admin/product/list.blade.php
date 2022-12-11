@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">LIST PRODUCT</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Thumbnail</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$products->isEmpty())
                                    @php
                                        $t = 0;
                                    @endphp
                                    @foreach ($products as $product)
                                        @php
                                            $t++;
                                            $font = $product->status == 'Active' ? 'text-success' : 'text-danger';
                                        @endphp
                                        <tr class="">
                                            <td>{{ $t }}</td>
                                            <td><img src="{{ url($product->thumbnail) }}" alt=""
                                                    style="width: 70px; height: 70px"></td>
                                            <td><a
                                                    href="{{ route('update_product', $product->id) }}">{{ $product->name }}</a>
                                            </td>
                                            <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                            <td>{{ $product->cat_name }}</td>
                                            <td><span class="{{ $font }}">{{ $product->status }}</span></td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>
                                                <a href="{{ route('update_image_product', $product->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-file-image"></i></a>
                                                <a href="{{ route('delete_product', $product->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này')"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Delete"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="bg-white">No Product displayed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->
@endsection
