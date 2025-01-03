<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In & Sign Up</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {

            overflow: hidden;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: white;
            background-image: url('/asset/img/vector_bg.png');
            background-repeat: no-repeat;
            background-position: right top;
            background-size: 400px;

            /* Dark blue background for body */
        }

        .outer-container {
            background-color: #ffffff;
            /* Dark blue */

        }

        .container {
            background-color: #ffffff;
            /* Medium blue */
            width: 500px;
            height: 400px;
            border-radius: 10px;
            position: absolute;
            display: flex;
            top: 120px;
            left: 350px;
        }

        /* .form-container.active {
            margin-left: 275px;
        }

        .form-container {
            margin-left: 25px;
            background-color: white;
            /* height: 380px;
            width: 305px; */
            align-self: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: absolute;
            transition: margin-left 1.5s ease-in-out;
            /* Smooth animation */
        /* } */ */

        /* .form-item form {
            z-index: 2;
            position: relative;
            animation: fadeIn 1s ease-out;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        } */

        /* .form-item form input {
      display: block;
      padding: 12px;
      width: 500px;
      margin: 20px auto;
      border: 1px solid #83a3be;
      border-radius: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

    }

    .form-item form .btn {
      cursor: pointer;
      display: block;
      padding: 12px;
      width: 250px;
      margin: 10px auto;
      text-align: center;
      border: 2px solid #4A6D8C;
      background-color: #4A6D8C;
      color: white;
      border-radius: 5px;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .form-item form .btn:hover {

      background-color: #3A5D75; /* Darker blue on hover */
        /* transform: scale(1.05); */
        /* Slight scaling effect */
        /* }

    .info-container {
      width: 100%;
      display: flex;
      justify-content: space-around;
      position: relative;

    }
    .login:hover {
      text-decoration: underline;
      text-underline-offset: 10px;
      color: #3A5D75;
    }
    .register:hover {
      text-decoration: underline;
      text-underline-offset: 10px;
      color: #3A5D75;
    }

    .info-item {
      color: white;
      display: flex;
      align-content: center;
      align-items: center;
      flex-direction: column;
      font-weight: 500;
      font-size: 20px;
      z-index: 1;
    }

    .info-item .btn {
      cursor: pointer;
      background-color: transparent;
      width: 90px;
      padding: 12px;
      border: 1px solid white;
      font-size: 16px;
      border-radius: 5px;
      transition: opacity 0.3s, transform 0.3s ease;
    }

    .info-item .btn:hover {
      opacity: 0.7;
      transform: scale(1.05); /* Slight scaling effect */

      /* } */

        .wrapper {
            overflow: hidden;
            max-width: 390px;
            background: #fff;
            padding: 30px;
            border-radius: px;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
        }

        .wrapper .title-text {
            display: flex;
            width: 200%;
        }

        .wrapper .title {
            width: 50%;
            font-size: 35px;
            font-weight: 600;
            text-align: center;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .slide-controls {
            position: relative;
            display: flex;
            height: 50px;
            width: 100%;
            overflow: hidden;
            margin: 15px 0 10px 0;
            justify-content: space-between;
            border-radius: 5px;
            right: 50px;
        }

        .slide-controls .slide {
            height: 100%;
            width: 100%;
            color: #000000;
            font-size: 18px;
            text-align: center;
            line-height: 48px;
            cursor: pointer;
            z-index: 1;
            transition: all 0.6s ease;
            font-size:25px ;
        }

        .slide-controls label.signup {

            color: #000;
        }

        .slide-controls .slider-tab {
            position: absolute;
            height: 100%;
            width: 50%;
            left: 0;
            z-index: 0;
            border-radius: 5px;

        }

        input[type="radio"] {
            display: none;
        }

        #signup:checked~.slider-tab {
            left: 50%;
        }

        #signup:checked~label.signup {
            cursor: default;
            user-select: none;
        }

        #signup:checked~label.login {
            color: #000;

        }

        #login:checked~label.signup {
            color: #000;
        }

        #login:checked~label.login {
            cursor: default;
            user-select: none;
        }
        .signup:hover{
          text-decoration: underline;
          text-underline-offset: 10px;
          color: #c689cf;

        }
        .login:hover{
          text-decoration: underline;
          text-underline-offset: 10px;
          color: #c689cf;
        }

        .wrapper .form-container {
            width: 100%;
            overflow: hidden;
        }

        .form-container .form-inner {
            display: flex;
            width: 200%;
            height: 100%;
        }

        .form-container .form-inner form {
            width: 50%;

            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .form-inner form .field {
            height: 40px;
            width: 75%;
            margin-top: 10px;
        }

        .form-inner form .field input {
            height: 100%;
            width: 100%;
            outline: none;
            padding-left: 15px;
            border-radius: 15px;
            border: 1px solid lightgrey;
            border-bottom-width: 2px;
            font-size: 17px;
            transition: all 0.3s ease;
        }

        .form-inner form .field input:focus {
            border-color: #fc83bb;
            /* box-shadow: inset 0 0 3px #fb6aae; */
        }

        .form-inner form .field input::placeholder {
            color: #000000;
            transition: all 0.3s ease;
        }

        form .field input:focus::placeholder {
            color: #000000;
        }

        .form-inner form .pass-link {
            margin-top: 5px;
        }

        .form-inner form .signup-link {
            text-align: center;
            margin-top: 30px;
        }

        .form-inner form .pass-link a,
        .form-inner form .signup-link a {
          color: rgb(160, 160, 229);
            text-decoration: none;
        }

        .form-inner form .pass-link a:hover,
        .form-inner form .signup-link a:hover {
            text-decoration: underline;
        }

        form .btn {
            height: 50px;
            width: 100%;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }
        .slide-btn{
            margin-left: 70px;

        }

        form .btn .btn-layer {
            height: 100%;
            width: 300%;
            position: absolute;
            left: -100%;
            /* background: -webkit-linear-gradient(right, #e5dfe6, #fa4299, #a445b2, #fa4299); */
            background-color: rgb(160, 160, 229);
            border-radius: 5px;
            transition: all 0.4s ease;
            ;
        }

        form .btn:hover .btn-layer {
            left: 0;
        }

        form .btn input[type="submit"] {
            height: 100%;
            width: 100%;
            z-index: 1;
            position: relative;
            background: none;
            border: none;
            color: #fff;
            padding-left: 0;
            border-radius: 5px;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
        }

        /* Lottie animation at the top */
        dotlottie-player {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 200px;
        }

        .header-text {
            color: rgb(100, 100, 192);
            position: absolute;
            top: 20px;
            left: 100px;
        }

        .lotie {
            position: absolute;
            top: 25%;
            left: 75%;
            z-index: 4;
        }


        .btn-no-color {
      background-color: transparent !important;
      border-color: transparent !important;
      color: inherit !important;
      transition: background-color 0.5s ease, border-color 0.5s ease, color 0.5s ease;

        }
        #btn1, #btn2 {
    display: none;
}
#specialty-field.hidden {
    height: 0;
    margin: 0;
    overflow: hidden;
    opacity: 0;
}
#nohp-field.hidden {
    height: 0;
    margin: 0;
    overflow: hidden;
    opacity: 0;
}
.field-btn{
    color: blue;
    z-index: 1;
}
.gambar img{
    position: relative;
    z-index: 10;
    top: 240px;
}
    </style>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body>
    <div class="header-text">
        <h1 style="font-family: open sans; font-weight: bold">KLINIK</h1>
    </div>
    <div class="gambar">
        <img src="{{asset('asset/img/titik.png')}}" alt="">
    </div>
    <div class="container">
        <div class="wrapper">
            <div class="form-container">
                <div class="slide-controls">
                    <input type="radio" name="slide" id="login" checked>
                    <input type="radio" name="slide" id="signup">
                    <label style="font-family: open sans; font-weight: bold" for="login" class="slide login">Login</label>
                    <label style="font-family: open sans; font-weight: bold" for="signup" class="slide signup">Register</label>
                    <div class="slider-tab"></div>

                </div>

                <div class="form-inner">
                    <form action="{{route('login')}}" class="login" method="POST">
                      @csrf
                        <div class="field">
                            <input type="text" placeholder="Email Address" name="email" required>
                        </div>
                        <div class="field">
                            <input type="password" placeholder="Password" name="password" required>
                        </div>
                        <div class="field btn">
                            <div class="btn-layer"></div>
                            <input type="submit" value="Login">
                        </div>
                        <div class="signup-link">
                            Not a member? <a href="">Signup now</a>
                        </div>
                    </form>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="field">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>role kamu</option>
                                <option value="1">pasien</option>
                                <option value="2">dokter</option>
                              </select>
                          </div>
                        <div class="field">
                            <input type="text" placeholder="Name" name="name" required>
                        </div>
                        <div class="field">
                            <input type="email" placeholder="Email Address" name="email" required>
                        </div>
                        <div class="field" id="specialty-field">
                            <input type="text" id="specialty" placeholder="Specialty" name="specialty">
                        </div>
                        <div class="field" id="nohp-field">
                            <input type="text" id="nohp" placeholder="Phone Number" name="phone" required>
                            @error('phone')
                                   <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <input type="password" placeholder="Password" name="password" required>
                        </div>
                        <div class="field">
                            <input type="password" placeholder="Confirm Password" name="password_confirmation" required>
                        </div>
                        <div class="field btn">
                            <div class="btn-layer"></div>
                            <input type="submit" value="simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="lotie">
      <dotlottie-player src="https://lottie.host/621f36a4-85ad-48cc-aa5f-acbae0c13265/iO2nGuesOg.lottie"
          background="transparent" speed="1" style="width: 300px; height: 300px" loop
          autoplay></dotlottie-player>
  </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentlyVisible = ".form-log-in";
        let currentlyHidden = ".form-sign-up";

        $(".info-item .btn").click(function() {
            $(".form-container").toggleClass("active");
            $(currentlyVisible).fadeToggle(750, function() {
                $(currentlyHidden).fadeToggle();
                let temp = currentlyVisible;
                currentlyVisible = currentlyHidden;
                currentlyHidden = temp;
            });
        });
    </script>
    <script>
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Errors',
                html: "<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>",
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <script>
        const loginText = document.querySelector(".title-text .login");
        const loginForm = document.querySelector("form.login");
        const loginBtn = document.querySelector("label.login");
        const signupBtn = document.querySelector("label.signup");
        const signupLink = document.querySelector("form .signup-link a");
        signupBtn.onclick = (() => {
            loginForm.style.marginLeft = "-50%";
            loginText.style.marginLeft = "-50%";
        });
        loginBtn.onclick = (() => {
            loginForm.style.marginLeft = "0%";
            loginText.style.marginLeft = "0%";
        });
        signupLink.onclick = (() => {
            signupBtn.click();
            return false;
        });
    </script>
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}',
            confirmButtonText: 'Tutup'
        });
    </script>
@endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
