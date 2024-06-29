@extends('masterFile')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 row">
        <div class="col-3">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>
        <div class="col-6"></div>
        <div class="col">
            <form action="{{ route('slip_gaji.storeSetBulan') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <select class="form-control mr-1" aria-label="Default select example" name="bulan">
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
                            Set Bulan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            {{-- Presensi --}}
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            @can('dashboard_user')
                                <h5>Presensi</h5>
                            @endcan
                            @can('dashboard_admin')
                                <h5>Presensi Karyawan</h5>
                            @endcan
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{-- Bulan {{ date_format(now(), 'M') }}</div> --}}
                                Bulan {{$set_bulan->bulan ?? ''}}</div>
                            @can('dashboard_user')
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($presensi) . ' / ' . $weekdays }}
                                @endcan
                                @can('dashboard_admin')
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $presensi . ' / ' . $total_presensi }}
                                    @endcan
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Izin --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                @can('dashboard_user')
                                    <h5>Izin</h5>
                                @endcan
                                @can('dashboard_admin')
                                    <h5>Izin Karyawan</h5>
                                @endcan
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Bulan {{$set_bulan->bulan ?? ''}}</div>
                                @can('dashboard_user')
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($izin) }}</div>
                                @endcan
                                @can('dashboard_admin')
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $izin }}</div>
                                @endcan
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cuti --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                @can('dashboard_user')
                                    <h5>Cuti</h5>
                                @endcan
                                @can('dashboard_admin')
                                    <h5>Cuti Karyawan</h5>
                                @endcan
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bulan
                                    {{$set_bulan->bulan ?? ''}}
                                </div>
                                <div class="row no-gutters align-items-center">
                                    @can('dashboard_user')
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ count($cuti) }}</div>
                                        </div>
                                    @endcan
                                    @can('dashboard_admin')
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $cuti }}</div>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Pie Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Total Kehadiran</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> Total presensi
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Total izin
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-info"></i> Total cuti
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @can('dashboard_user')
                {{-- Izin / Cuti --}}
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Izin / Cuti</h6>

                        </div>
                        <!-- Card Body -->
                        <div class="card-body" style="overflow:scroll;height:22.5rem">
                            @foreach ($izin_cuti as $val)
                                <div
                                    class="card border-left-{{ $val['status_presensi'] == 'izin' ? 'success' : 'danger' }} shadow h-50 mb-3">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <h5>{{ strtoupper($val['status_presensi']) }}</h5>
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Bulan {{ date_format(new DateTime($val['waktu_presensi']), 'M') }}</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ date_format(new DateTime($val['waktu_presensi']), 'D-M-Y') }}
                                                </div>
                                                <div class="mt-2 font-weight-bold text-gray-1000">
                                                    {{$val['deskripsi']}}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endcan
@endsection
