<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        .bg-gradient-primary {
            background: linear-gradient(to bottom, red, black);
        }
        .card-login {
            background-color: black;
            color: white;
        }
        .text-white {
            color: white;
            
        }
    </style>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5 card-login">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row mx-auto d-flex justify-content-center">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-white-900 mb-4">PT.Chavi Makmur Jaya</h1>
                                    </div>
                                    <form class="user" method="post" action="{{ route('authentication') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                aria-describedby="emailHelp" placeholder="Enter Email Address..."
                                                name="email" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                placeholder="Password" name="password">
                                        </div>
                                        {{-- <div class="form-group">
                                            <select class="form-control" name="pt">
                                                <option value="PT Sekawan Mitra Kreasi">PT Sekawan Mitra Kreasi</option>
                                                <option value="PT Avatar Express Indonesia">PT Avatar Express Indonesia
                                                </option>
                                            </select>
                                        </div> --}}
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    @include('sweetalert::alert')

</body>

</html>
