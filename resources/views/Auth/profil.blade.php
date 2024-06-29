@extends('masterFile')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 row">
        <div class="col-3">
            <!-- <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1> -->
        </div>
    </div>
    <!-- Content Row -->
    <div class="row d-flex">
        <div class="col">
            <div class="card">
                <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="create_user-tab" data-toggle="pill" href="#create_user"
                                role="tab" aria-controls="create_user" aria-selected="true"></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="create_user" role="tabpanel" aria-labelledby="create_user-tab">
                            <form action="{{route('creator.create')}}" method="post">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        Profil User
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="input-name">Name</span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Name"
                                                        aria-label="name" aria-describedby="input-name" name="name" value="{{old('name',$user->name)}}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="input-email">Email</span>
                                                    </div>
                                                    <input type="email" class="form-control" placeholder="Email"
                                                        aria-label="email" aria-describedby="input-email" name="email" value="{{old('email',$user->email)}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="input-password">Password</span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Password"
                                                        aria-label="password" aria-describedby="input-password" name="password" value="{{old('password',$user->password)}}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Hak Akses</span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Role"
                                                        aria-label="role" aria-describedby="input-password" name="role" value="{{old('name', $role)}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>
    @endpush
    @push('style')
        <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endpush
@endsection
