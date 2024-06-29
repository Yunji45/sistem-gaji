@extends('masterFile')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 row">
        <div class="col-3">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row d-flex">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="show_user-tab" data-toggle="pill" href="#show_user"
                                role="tab" aria-controls="show_user" aria-selected="true">User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="create_user-tab" data-toggle="pill" href="#create_user" role="tab"
                                aria-controls="create_user" aria-selected="false">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="restore-tab" data-toggle="pill" href="#restore" role="tab"
                                aria-controls="restore" aria-selected="false">Restore</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="show_user" role="tabpanel"
                            aria-labelledby="show_user-tab">
                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">PT</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($no = 1)
                                    @foreach ($data['data'] as $val)
                                        <tr>
                                            <th scope="row">{{ $no }}</th>
                                            <td>{{ $val->name }}</td>
                                            <td>{{ $val->email }}</td>
                                            <td>{{ $val->roles[0]->name }}</td>
                                            <td>{{ $val->permissions[0]->name ?? 'HRD' }}</td>
                                            <td>
                                                <a class="btn btn-primary mr-1" href="{{route('creator.view',['id' => $val->id])}}"
                                                    role="button">Edit
                                                </a>
                                                <a class="btn btn-danger ml-1"
                                                    href="{{ route('creator.delete', ['id' => $val->id]) }}"
                                                    role="button">Delete
                                                </a>
                                            </td>
                                        </tr>
                                        @php($no++)
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="create_user" role="tabpanel" aria-labelledby="create_user-tab">
                            <form action="{{route('creator.create')}}" method="post">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        Create User
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="input-name">Name</span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Name"
                                                        aria-label="name" aria-describedby="input-name" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="input-email">Email</span>
                                                    </div>
                                                    <input type="email" class="form-control" placeholder="Email"
                                                        aria-label="email" aria-describedby="input-email" name="email" required>
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
                                                        aria-label="password" aria-describedby="input-password" name="password" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Hak Akses</span>
                                                    </div>
                                                    <select name="hak_akses" class="form-control">
                                                        <option value="karyawan">User</option>
                                                        <option value="hrd">HRD</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="restore" role="tabpanel" aria-labelledby="restore-tab">
                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($no = 1)
                                    @foreach ($data['trashed'] as $val)
                                        <tr>
                                            <th scope="row">{{ $no }}</th>
                                            <td>{{ $val->name }}</td>
                                            <td>{{ $val->email }}</td>
                                            <td>{{ $val->roles[0]->name }}</td>
                                            <td>
                                                <a class="btn btn-warning mr-1"
                                                    href="{{ route('creator.restore', ['id' => $val['id']]) }}"
                                                    role="button">Restore
                                                </a>
                                            </td>
                                        </tr>
                                        @php($no++)
                                    @endforeach
                                </tbody>
                            </table>
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
