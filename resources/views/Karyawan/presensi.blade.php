@extends('masterFile')
@section('content')
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Presensi Karyawan {{ now()->format('D - M - Y') }}</h6>
                    {{-- <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div> --}}
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    {{-- <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div> --}}
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">Presensi</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">Izin</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                role="tab" aria-controls="nav-contact" aria-selected="false">Cuti</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <form action="{{ route('presensi.store') }}" method="post">
                                @csrf
                                <input type="hidden" value="hadir" name="presensi">
                                <h6 class="mt-3">Presensi dibuka 07.00 - 07.30 masuk</h6>
                                @if (now() > now()->setTime(8, 20) && now() < now()->setTIme(9, 00))
                                    <button type="submit" class="btn btn-primary">Presensi Kehadiran</button>
                                @else
                                    <button type="submit" class="btn btn-primary" disabled>Presensi Kehadiran</button>
                                @endif
                                {{-- <button type="submit" class="btn btn-primary">Presensi Kehadiran</button> --}}
                            </form>

                            <form action="{{ route('presensi.store') }}" method="post">
                                @csrf
                                <input type="hidden" value="pulang" name="presensi">
                                <h6 class="mt-5">Presensi dibuka 16.30 - 17.00 masuk</h6>
                                @if (now() > now()->setTime(8, 20) && now() < now()->setTime(9, 00))
                                    <button type="submit" class="btn btn-primary">Presensi Pulang</button>
                                @else
                                    <button type="submit" class="btn btn-primary" disabled>Presensi Pulang</button>
                                @endif
                                {{-- <button type="submit" class="btn btn-primary">Presensi Pulang</button> --}}
                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <form action="{{ route('presensi.store') }}" method="post">
                                @csrf
                                <input type="hidden" value="izin" name="presensi">
                                <div class="form-group mt-3">
                                    <label for="izin">Alasan Izin Kerja</label>
                                    <textarea class="form-control" id="izin" rows="3" name="deskripsi" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <form action="{{ route('presensi.store') }}" method="post">
                                @csrf
                                <input type="hidden" value="cuti" name="presensi">
                                <div class="form-group mt-3">
                                    <label for="cuti">Alasan Cuti Kerja</label>
                                    <textarea class="form-control" id="cuti" rows="3" name="deskripsi" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
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
    </div>
@endsection
