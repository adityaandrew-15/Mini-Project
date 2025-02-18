<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Background</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <!-- Font Awesome untuk Icon -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        * {
            font-family: 'Open Sans', sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            height: 100vh;
            position: relative;
            background-color: #f4f4f4;
        }

        body::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 20%;
            height: 50vh;
            background-image: url('/images/bg2left.png');
            background-size: cover;
            background-position: center;
        }

        body::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100vh;
            background-image: url('/images/vector_bg.png');
            background-size: cover;
            background-position: center;
        }

        .container {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 50px;
            color: white;
        }

        .header {
            color: #103F91;
            font-size: 3rem;
            font-weight: 900;
        }

        .slider {
            color: #333333;
            display: flex;
            justify-content: space-evenly;
            width: 50%
        }

        .slider .active {
            color: #103F91;
            margin-bottom: 10px;
            border-bottom: 2px solid #103F91;
        }

        .form-container {
            display: flex;
        }

        .content-left,
        .content-right {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .login-form,
        .reg-form,
        .input-login,
        .input-reg {
            display: flex;
            flex-direction: column;
            width: 70%;
            align-items: center;
            justify-content: center;
        }

        .input-group {
            position: relative;
            width: 100%;
            margin: 10px 0 10px 0;
        }

        .input-group input {
            height: 50px;
            width: 100%;
            border-radius: 1rem;
            outline: none;
            border: 1px solid #333333;
            padding-left: 40px;
            font-size: 16px;
            transition: border 0.3s ease-in-out;
        }

        .input-group input:focus {
            border: 2px solid #103F91;
        }

        /* Label animasi */
        .input-group label {
            position: absolute;
            top: 50%;
            left: 40px;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
            transition: 0.3s;
            pointer-events: none;
        }

        .input-group input:focus+label,
        .input-group input:not(:placeholder-shown)+label {
            top: 10px;
            font-size: 12px;
            color: #103F91;
            background: white;
            padding: 0 5px;
        }

        /* Icon dalam input */
        .input-group i {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #666;
        }

        .footer-login,
        .footer-reg {
            display: flex;
            width: 70%;
            margin-top: 20px;
            justify-content: space-between;
            align-items: center;
        }

        .footer-login a,
        .footer-reg a {
            font-size: 20px;
            text-decoration: none;
            color: #103F91;
            font-weight: 600;
        }

        .button-login,
        .button-reg {
            background-color: #103F91;
            color: white;
            border: none;
            padding: 20px 40px;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 30px;
            font-weight: 900;
            margin-top: 10px;
        }

        /* reg */

        /* Sembunyikan form register secara default */
        .reg-form {
            display: none;
        }

        /* Tambahkan animasi transisi */
        .form-container {
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .login-form,
        .reg-form {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        /* Style untuk slider aktif */
        .slider h2 {
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }

        .slider h2.active {
            color: #103F91;
            border-bottom: 2px solid #103F91;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="header">ALLCARE</h2>

        <div class="form-container">
            <div class="content-left">
                <div class="slider">
                    <h2 class="active">Login</h2>
                    <h2>Register</h2>
                </div>

                <form action="{{ route('login') }}" class="login-form" method="POST">
                    @csrf
                    <div class="input-login">
                        <!-- Input Email -->
                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input name="email" type="email" id="email" placeholder=" " required>
                            <label for="email">Email</label>
                        </div>

                        <!-- Input Password -->
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input name="password" type="password" id="password" placeholder=" " required>
                            <label for="password">Password</label>
                        </div>
                    </div>

                    <div class="footer-login">
                        <a href="">Don't have an account?</a>
                        <button type="submit" class="button-login">Login</button>
                    </div>
                </form>

                <form action="{{ route('register') }}" method="POST" class="reg-form">
                    @csrf
                    <div class="input-reg">
                        <!-- Input Email -->
                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input name="name" type="text" id="name" placeholder=" " required>
                            <label for="name">Nama Lengkap</label>
                        </div>

                        <!-- Input Password -->
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input name="email" type="email" id="email" placeholder=" " required>
                            <label for="email">Email</label>
                        </div>

                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input name="phone" type="number" id="phone" placeholder=" " required>
                            <label for="phone">Nomor Telepon</label>
                        </div>

                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input name="password" type="password" id="password" placeholder=" " required>
                            <label for="password">Password</label>
                        </div>

                        <!-- Input Password -->
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input name="password_confirmation" type="password" id="confirmpassword" placeholder=" " required>
                            <label for="confirmpassword">Confirm Password</label>
                        </div>
                    </div>

                    <div class="footer-reg">
                        <a href="#">have an account?</a>
                        <button type="submit" class="button-reg">Register</button>
                    </div>
                </form>
            </div>

            <div class="content-right">
                <img src="{{ asset('images/img_vector.png') }}" alt="">
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loginForm = document.querySelector(".login-form");
            const regForm = document.querySelector(".reg-form");
            const sliderOptions = document.querySelectorAll(".slider h2");

            sliderOptions.forEach((option, index) => {
                option.addEventListener("click", function() {
                    sliderOptions.forEach((item) => item.classList.remove("active"));
                    this.classList.add("active");

                    if (index === 0) {
                        loginForm.style.display = "flex";
                        regForm.style.display = "none";
                    } else {
                        loginForm.style.display = "none";
                        regForm.style.display = "flex";
                    }
                });
            });
        });
    </script>
</body>

</html>
