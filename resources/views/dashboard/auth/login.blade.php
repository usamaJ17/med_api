@extends('dashboard.layouts.auth')

@section('title')
    Deluxe hospital - Login
@endsection

@section('content')
    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">

            <div class="col-12">
                <div class="row justify-content-center g-0">
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="bg-white rounded10 shadow-lg">
                            <div class="content-top-agile p-20 pb-0">
                                <h2 class="text-primary">Let's Get Started</h2>
                                <p class="mb-0">Sign in to continue to Deluxe Hospital.</p>
                            </div>
                            <div class="p-40">
                                <form action="{{ route('login') }}" method="post">
                                    {{-- Add validation error messages --}}

                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    @csrf
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                            <input type="email" name="email" class="form-control ps-15 bg-transparent"
                                                placeholder="Email" value="{{ old('email') }}">
                                        </div>
                                        @if ($errors->has('email'))
                                            <div class="text-danger">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                            <input type="password" name="password" class="form-control ps-15 bg-transparent"
                                                placeholder="Password">
                                        </div>
                                        @if ($errors->has('password'))
                                            <div class="text-danger">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="checkbox">
                                                <input type="checkbox" id="basic_checkbox_1" name="remember">
                                                <label for="basic_checkbox_1">Remember Me</label>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-6">
                                            <div class="fog-pwd text-end">
                                                <a href="javascript:void(0)" class="hover-warning"><i
                                                        class="ion ion-locked"></i> Forgot pwd?</a><br>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-danger mt-10">SIGN IN</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>

                                {{-- <div class="text-center">
									<p class="mt-15 mb-0">Don't have an account? <a href="auth_register.html" class="text-warning ms-5">Sign Up</a></p>
								</div>	 --}}
                            </div>
                        </div>
                        <div class="text-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
