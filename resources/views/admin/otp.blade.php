@include('partials.toasts')

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
<body>
  <div class="form-box">
    <h2>Verify OTP</h2>

    <form id="otpForm" method="post" action="{{ route('admin.verifyOtp') }}">
      @csrf
      <input id="email" name="email" readonly style="background:#f8f9fa;" type="hidden" value="{{ @$user }}">
      <input type="text" id="otp" name="otp" placeholder="Enter 6-digit OTP">
      <button type="submit">Verify OTP</button>
    </form>
    <div id="otpMessage" class="message"></div>
  </div>
</body>
</html>