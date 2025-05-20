<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #ffffff;
    }

    .wave {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden;
    }

    .wave::before, .wave::after {
      content: "";
      position: absolute;
      border-radius: 50%;
      background-color: #86cdff;
      z-index: -2;
    }

    .wave::before {
      width: 600px;
      height: 600px;
      top: -200px;
      left: -300px;
    }

    .wave::after {
      width: 600px;
      height: 600px;
      bottom: -200px;
      right: -300px;
      background-color: #86cdff;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }

    .logo {
        position: absolute;
      top: 20px;
      left: 40px;
      font-size: 28px;
      font-weight: bold;
      color: #2148d4;
    }

    .logo span {
      color: gold;
    }

    .form-box {
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 30px rgba(0,0,0,0.05);
      text-align: center;
      min-width: 350px;
    }

    .form-box h2 {
        margin-top : 0;
      margin-bottom: 35px;
      color: #222;
      font-size: 28px;
      font-weight: bold;
      text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
    }

    .input-group {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      border: 1px solid #222;
      border-radius: 6px;
      overflow: hidden;
      background: #fff;
    }

    .input-group i {
      padding: 10px;
      background: #fff;
      color: #000;
      font-size: 18px;
      width: 40px;
      text-align: center;
    }

    .input-group input {
      border: none;
      outline: none;
      padding: 12px;
      width: 100%;
      font-size: 14px;
    }

    .login-btn {
      background-color: #e9ca00;
      border: none;
      color: white;
      padding: 12px 20px;
      font-size: 16px;
      font-weight: bold;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      transition: all 0.3s ease-in-out;
    }

    .login-btn:hover {
      background-color: #c9b000;
    }

    .error-message {
      color: red;
      font-size: 14px;
      margin-bottom: 10px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="wave"></div>
  <div class="logo">Untirta<span>-Ku</span></div>
  

  <div class="container">
    <form action="{{ route('admin.login') }}" method="POST" class="form-box">
      <h2>Web Admin</h2>
      @csrf

      @if (session('error'))
        <div class="error-message">
          {{ session('error') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="error-message">{{ $errors->first() }}</div>
      @endif

      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="email" placeholder="Email" required />
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required />
      </div>
      <button type="submit" class="login-btn">LOGIN</button>
    </form>
  </div>
</body>
</html>
