@extends('layouts.admin')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card-header bg-light font-weight-bold d-flex justify-content-between align-items-start">
                        <h6 class="mb-4">LIST ADMIN</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    <th scope="col">#</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Created Date</th>
                                    <th scope="col">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->total() != 0)
                                    @php
                                        $t = 0;
                                    @endphp
                                    @foreach ($users as $user)
                                        @php
                                            $t++;
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="list_check[]" value="{{ $user->id }}">
                                            </td>
                                            <th scope="row">{{ $t }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role_name }}</td>
                                            <td>{{  \Carbon\Carbon::parse($user->created_at )->format('j F, Y') }}</td>
                                            <td>
                                                <a href="{{ route('edit_user', $user->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                @if (session('admin_id') != $user->id)
                                                    <a href="{{ route('delete_admin', $user->id) }}"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này')"
                                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                        itle="Delete"><i
                                                            class="fa fa-trash"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="bg-white">Không tìm thấy bản ghi nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->
@endsection
