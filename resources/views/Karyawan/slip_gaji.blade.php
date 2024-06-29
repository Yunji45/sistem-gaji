@extends('masterFile')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Pie Chart -->
        <div class="col-xl-12">
            <!-- Card Body -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row">
                            @can('slip_gaji_admin')
                                <div class="col-5">
                                    <form action="{{ route('slip_gaji.storeKelolaSalary') }}" method="post">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control mr-1" placeholder="Input Gaji..."
                                                aria-label="Recipient's username" aria-describedby="basic-addon2" name="salary"
                                                @if ($status_kelola['status']) value="{{ $status_kelola['salary'] }}" @endif
                                                required>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="submit">
                                                    @if ($status_kelola['status'])
                                                        Update Salary
                                                    @else
                                                        Input Salary
                                                    @endif
                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            @endcan
                            <div class="col-5">
                                <form action="{{ route('slip_gaji.storeSetBulan') }}" method="post">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <select class="form-control mr-1" aria-label="Default select example"
                                            name="bulan">
                                            <option selected>
                                                @if (is_null($set_bulan))
                                                    Select Bulan
                                                @else
                                                    {{ $set_bulan->bulan }}
                                                @endif
                                            </option>
                                            @foreach ($bulan as $value)
                                                <option value="{{ $value->bulan }}">{{ $value->bulan }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="submit">
                                                Set bulan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Hadir</th>
                                    <th>Izin</th>
                                    <th>Cuti</th>
                                    <th>Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Hadir</th>
                                    <th>Izin</th>
                                    <th>Cuti</th>
                                    <th>Salary</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data as $val)
                                    <tr>
                                        @can('slip_gaji_admin')
                                            <td>{{ $val['name'] }}</td>
                                            <td>{{ $val['hadir'] }}</td>
                                            <td>{{ $val['izin'] }}</td>
                                            <td>{{ $val['cuti'] }}</td>
                                            <td>{{ $val['salary'] }}</td>
                                            <td>
                                                <form action="{{ route('slip_gaji.gajiKaryawan') }}" method="post">
                                                    @csrf
                                                    <div class="row px-3">
                                                        <input type="hidden" name="salary" value="{{ $val['salary'] }}">
                                                        <input type="hidden" name="name" value="{{ $val['name'] }}">
                                                        <input type="hidden" name="hadir" value={{ $val['hadir'] }}>
                                                        <input type="hidden" name="cuti" value={{ $val['cuti'] }}>
                                                        <input type="hidden" name="izin" value={{ $val['izin'] }}>
                                                        @if ($val['gaji'])
                                                            <button class="btn btn-primary btn-sm mr-2" href="#" role="button"
                                                                disabled>Sudah digaji</button>
                                                                <a href="{{route('slip_gaji.reset-gaji',['id' => $val['id']])}}" class="btn btn-danger">Reset</a>
                                                        @else
                                                            <button class="btn btn-success btn-sm" href="#"
                                                                role="button">Gaji Karyawan</button>
                                                        @endif
                                                    </div>
                                                </form>
                                            </td>
                                        @endcan
                                        @can('slip_gaji_user')
                                            <td>{{ $val['name'] }}</td>
                                            <td>{{ count($val['hadir']) }}</td>
                                            <td>{{ count($val['izin']) }}</td>
                                            <td>{{ count($val['cuti']) }}</td>
                                            <td>{{ $val['salary'] }}</td>
                                            <td style="width : 17%">
                                                <div class="row px-3">
                                                    <a class="btn btn-primary btn-sm mb-1"
                                                        href="{{ route('view-pdf', ['id' => getUserId()]) }}" target="_blank" role="button">View Slip
                                                        Gaji</a>
                                                    <a class="btn btn-success btn-sm mb-1"
                                                        href="{{ route('download-pdf', ['id' => getUserId()]) }}" target="_blank" role="button">Download Slip
                                                        Gaji</a>
                                                    {{-- <a class="btn btn-success btn-sm mt-1" href="{{ route('view-pdf') }}"
                                                        role="button">Download Slip Gaji</a> --}}
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
