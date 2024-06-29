@extends('masterFile')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 row">
        <div class="col-3">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>
    </div>

    {{-- Content Row --}}
    <div class="row d-flex">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('creator.edit')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="input-name">Name</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Name" aria-label="name"
                                        aria-describedby="input-name" name="name" value="{{ $data->name }}" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="input-email">Email</span>
                                    </div>
                                    <input type="email" class="form-control" placeholder="Email" aria-label="email"
                                        aria-describedby="input-email" name="email" value="{{ $data->email }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="input-password">Password</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Password" aria-label="password"
                                        aria-describedby="input-password" name="password" value="{{ $data->password }}"
                                        required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Hak Akses</span>
                                    </div>
                                    <select name="hak_akses" class="form-control">
                                        <option value="karyawan">Karyawan</option>
                                        <option value="hrd">HRD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
