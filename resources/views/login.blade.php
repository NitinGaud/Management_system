<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4/dist/css/adminlte.min.css">
        <style>
            .login-page
            {
                min-height: 100vh;
                padding: 20px;
            }
            .login-card
            {
                width: 100%;
                max-width: 500px;
                min-height: 300px;
                margin: 0 auto;
            }
            .card-title
            {
                float: none !important;
                text-align: center;
                display: block;
                width: 100%;
                text-align: center;
                margin: 0;
            }
            .card-body
            {
                padding: 30px;
            }
            .form-control
            {
                width: 100%;
            }
            .btn-block
            {
                width: 100%;
            }

            @media (max-width: 768px)
            { 
                .login-page
                {
                    padding: 15px;
                }
                .login-card
                {
                    max-width: 450px;
                }
                .card-body
                {
                    padding: 25px;
                }
            }

            @media (max-width: 576px)
            {
                .login-page
                {
                    padding: 10px;
                }
                .login-card
                {
                    width: 100%;
                    max-width: 100%;
                }
                .card-body
                {
                    padding: 20px;
                }
                .card-header
                {
                    padding: 15px;
                }
                .card-title
                {
                    font-size: 22px;
                }
                /* Stack Remember Me and Sign In */
                .login-options
                {
                    display: flex;
                    flex-direction: column;
                    gap: 15px;
                }
                .remember-section, .button-section
                {
                    width: 100% !important;
                    max-width: 100%;
                }
                .button-section
                {
                    margin-top: 5px;
                }
            }

            @media (max-width: 360px)
            {
                .login-page
                {
                    padding: 5px;
                }
                .card-body
                {
                    padding: 15px;
                }
                .card-title
                {
                    font-size: 20px;
                }
            }
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="card card-info login-card">
            <div class="card-header">
                <h3 class="card-title">Sign In</h3>
            </div>
            <div class="card-body login-card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="{{ route('authenticate') }}" method="POST" id="signin_form">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                    </div>
                    <div id="emailError" class="text-danger mb-3"></div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" minlength="8" maxlength="15" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>
                    <div id="passwordError" class="text-danger mb-3"></div>
                    <div class="row login-options">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-4 button-section">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
        <!-- <script src="https://jsdelivr.net"></script> -->
        <script>
            document.getElementById('signin_form').addEventListener('submit', function (event)
            {
                event.preventDefault();
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;
                const emailError = document.getElementById('emailError');
                const passwordError = document.getElementById('passwordError');
                // Clear previous errors
                emailError.textContent = '';
                passwordError.textContent = '';
                let isValid = true;
                // Email validation
                if (email === '')
                {
                    emailError.textContent = 'Email is required.';
                    isValid = false;
                }
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
                {
                    emailError.textContent = 'Please enter a valid email address.';
                    isValid = false;
                }
                // Password validation
                if (password === '')
                {
                    passwordError.textContent = 'Password is required.';
                    isValid = false;
                }
                else
                {
                    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).{8,15}$/;
                    if (!passwordPattern.test(password))
                    {
                        passwordError.textContent = 'Password must be 8-15 characters and contain at least one uppercase letter, one lowercase letter, and one special character.';
                        isValid = false;
                    }
                }
                // Submit form if validation passes
                if (isValid)
                {
                    this.submit();
                }
            });
        </script>
    </body>
</html>
