@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-light text-dark font-weight-bold">
                        Add a Product Brand
                    </div>
                    <div class="card-body">
                        <form action="{{ route('create_product_brand') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Brand Name</label>
                                <input class="form-control" type="text" name="name" id="name">
                            </div>
                            <br>

                            <input type="submit" class="btn btn-primary" value="Add a Brand" name="submit">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-8">
                <div class="card">
                    <div class="card-header bg-light text-dark font-weight-bold">
                        Product Brand
                    </div>
                    <div class="card-body">
                        <table class="table bg-light">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($product_brands))
                                    @php
                                        $t = 0;
                                    @endphp
                                    @foreach ($product_brands as $product_brand)
                                        @php
                                            $t++;
                                            $font = $product_brand->status == 'Active' ? 'text-success' : 'text-danger';
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $t }}</th>
                                            <td>{{ $product_brand->name }}</td>
                                            <td class="{{ $font }}">{{ $product_brand->status }}</td>
                                            <td>
                                                <a href="{{ route('update_product_brand', $product_brand->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_product_brand', $product_brand->id) }}"
                                                    onclick="return confirm('Are you sure to delete this item?')"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="bg-white">Not found any brands!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $product_brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->
@endsection
