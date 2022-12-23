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
                @if (session('status-danger'))
                    <div class="alert alert-danger">
                        {{ session('status-danger') }}
                    </div>
                @endif
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">CHANGE PASSWORD</h6>
                    <form action="{{ url('admin/user/reset', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="bg-light rounded h-100 p-4">
                            <form action="{{ route('reset', $user->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Name: <b>{{ $user->name }}</b></label>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input class="form-control" type="password" name="password" id="password">
                                    @error('password')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="password_confirmation">Password Confirmed</label>
                                    <input class="form-control" type="password" name="password_confirmation"
                                        id="password_confirmation">
                                    @error('password')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <br>
                                <input type="submit" class="btn btn-primary" name="btn-update" value="Change Password">
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
