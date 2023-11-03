<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block" style="background-image: url('{{ asset('img/bg.jpg') }}'); background-size: cover;"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                            </div>
                            <form action="{{ route('create-account') }}" method="POST">
                                @csrf

                                @if ($errors->has('NIK'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('NIK') }}
                                </div>
                            @endif
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="NIK" name="NIK" id="NIK" required>     
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Nama Lengkap" name="name" id="name" required>     
                                </div>
                                @if ($errors->has('username'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('username') }}
                                </div>
                                 @endif
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Username" name="username" id="username" required>     
                                </div>
                                @if ($errors->has('email'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="E-mail" name="email" id="email" required>     
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="password" name="password" id="password" required>     
                                </div>
                                <input type="submit" class="btn btn-block btn-primary">
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>