@extends('layouts.customer')

@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">ĐỔI MẬT KHẨU</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="{{route('home_page')}}">Trang chủ</a></li>
                        <li><a href="{{ route('profile', $profile->id) }}">Thông tin</a></li>
                        <li class="active">Đổi mật khẩu</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
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
                        <form action="{{ route('reset', $profile->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <h5>Name: {{ $profile->name }}</h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="password">Mật khẩu mới</label>
                                <input class="form-control" type="password" name="password" id="password">
                                @error('password')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="password_confirmation">Xác nhận mật khẩu</label>
                                <input class="form-control" type="password" name="password_confirmation"
                                    id="password_confirmation">
                                @error('password')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <br>
                            <input type="submit" class="btn btn-danger" name="btn-update" value="Đổi mật khẩu">
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@endsection
