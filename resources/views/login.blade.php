<?php
session_start();
session_destroy();
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/authentication/form-1.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Kantumruy:wght@300;400&display=swap" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Open Sans', 'Kantumruy', serif;
    }

    .login, .image {
        min-height: 100vh;
    }

    .bg-image {
        /*background-image: url('https://bootstrapious.com/i/snippets/sn-page-split/bg.jpg');*/
        background-image: url('/login_Mesa.jpg');
        background-size: cover;
        background-position: center center;
    }
    h1 {
        margin-bottom: 10px; /* Add some space below the heading */
        margin-top: 0;       /* Reduce the space above */
        text-align: center;  /* Align the heading to the center */
        backdrop-filter: blur();
    }

    .logo-final {
        width: 200px;        /* Adjust the size of the logo */
        height: auto;        /* Maintain aspect ratio */
        object-fit: contain; /* Ensure no distortion */
        display: block;      /* Center the logo */
        margin: 0 auto 50px; /* Center horizontally and add margin below */
        backdrop-filter: drop-shadow(12px 1px 5px rgba(0, 0, 0, 0.5));

    }

    .col-lg-10.mx-auto {
        margin-top: -100px; /* Move the content section upward */
    }


</style>

<body class="form">
<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 d-none d-md-flex bg-image" style="width: 100px"></div>

        <!-- The content half -->
        <div class="col-md-6 bg-light">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                        <h1 align="center"> MAWARID TECH ACADEMY</h1>
                        <img class="logo-final" src="/logo-final.png" alt="MAWARID LOGO">
                        </div>

                        <div class="col-lg-6 col-xl-7 mx-auto">
{{--                            <h1>Login Here</h1>--}}
                            <form id="loginForm" method="POST" action="{{ route('do_login') }}">
                                @csrf
                                @if(session('status'))
                                    <div class="alert alert-danger">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <div class="form-group mb-3">
                                    <input
                                        name="email"
                                        {{--autocomplete="off"--}}
                                        id="email"
                                        type="email"
                                        value="admin@mail.com"
                                        placeholder="Email"
                                        required=""
                                        autofocus=""
                                        class="form-control rounded-pill border-0 shadow-sm px-4"
                                        aria-labelledby="name">
                                </div>
                                <div class="form-group mb-3">
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        value="123456"
                                        autocomplete="off"
                                        placeholder="Password"
                                        required=""
                                        class="form-control
                                       rounded-pill border-0 shadow-sm px-4 text-primary">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div><!-- End -->
            </div>
        </div><!-- End -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const emailInput = document.getElementById('email');
        const storedEmail = sessionStorage.getItem('lastEmail');
        if (storedEmail) {
            emailInput.value = storedEmail; // Restore last entered email if exists
        }

        document.getElementById('loginForm').addEventListener('submit', function (event) {
            const enteredEmail = emailInput.value;
            sessionStorage.setItem('lastEmail', enteredEmail); // Save last entered email
        });
    });

</script>


<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('assets/js/authentication/form-1.js') }}"></script>
</body>
</html>
