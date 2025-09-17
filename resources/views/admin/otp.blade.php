@include('partials.toasts')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify OTP</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-box {
      background: rgba(255, 255, 255, 0.15);
      padding: 30px;
      border-radius: 15px;
      backdrop-filter: blur(12px);
      box-shadow: 0px 8px 32px rgba(0, 0, 0, 0.2);
      width: 350px;
      text-align: center;
    }
    .form-box h2 { color: #fff; margin-bottom: 20px; }
    input {
      width: 100%;
      padding: 14px;
      margin: 10px 0;
      border-radius: 10px;
      border: none;
      outline: none;
      font-size: 16px;
    }
    button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #4a90e2, #357ABD);
      border: none;
      border-radius: 10px;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
    }
    .message { margin-top: 10px; font-size: 14px; }
    .success { color: green; }
    .error { color: red; }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Verify OTP</h2>

    <form id="otpForm" method="post" action="{{ url('admin/verify-otp') }}">
      @csrf
      <input id="email" name="email" readonly style="background:#f8f9fa;" type="hidden" value="{{ @$user }}">
      <input type="text" id="otp" name="otp" placeholder="Enter 6-digit OTP">
      <button type="submit">Verify OTP</button>
    </form>
    <div id="otpMessage" class="message"></div>
  </div>
</body>
</html>
