<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Login Page" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .toggle-password {
            cursor: pointer;
            user-select: none;
            padding: 0 10px;
            font-size: 18px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container-xxl">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow rounded-3">
                    <div class="card-body p-0 bg-dark rounded-top text-center">
                        <div class="p-4">
                            <a href="#" class="logo logo-admin">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo"
                                    class="auth-logo">
                            </a>
                            <h4 class="mt-3 mb-1 fw-semibold text-white">Welcome Back</h4>
                            <p class="text-muted mb-0">Sign in to continue</p>
                        </div>
                    </div>
                    <div class="card-body p-4">

                        <!-- ✅ Single Form -->
                        <form id="loginForm" method="post" action="{{ url('admin/login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter password">
                                    <span class="input-group-text toggle-password" onclick="togglePassword('password', this)">🙈</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <a href="auth-recover-pw.html" class="text-muted small">Forgot password?</a>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary" type="submit">Log In <i
                                        class="fas fa-sign-in-alt ms-1"></i></button>
                            </div>
                        </form>

                        <!-- Messages -->
                        <div id="loginmessage" class="mt-3 text-center"></div>

                        <div class="text-center mt-4">
                            <p class="text-muted">Don't have an account?
                                <a href="auth-register.html" class="text-primary ms-1">Register</a>
                            </p>
                            <h6 class="px-3 d-inline-block">Or Login With</h6>
                        </div>
                        <div class="d-flex justify-content-center gap-2 mt-2">
                            <a href="#"
                                class="d-flex justify-content-center align-items-center thumb-md bg-primary-subtle text-primary rounded-circle">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#"
                                class="d-flex justify-content-center align-items-center thumb-md bg-info-subtle text-info rounded-circle">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#"
                                class="d-flex justify-content-center align-items-center thumb-md bg-danger-subtle text-danger rounded-circle">
                                <i class="fab fa-google"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- <script>const api_url = "{{ config('app.api_url') }}";</script>
    <script src="{{ asset('api-js/login.js') }}"></script> -->
</body>
</html>
