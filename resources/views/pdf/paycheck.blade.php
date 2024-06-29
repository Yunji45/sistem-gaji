<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>{{ $title }}</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col">{{session('pt')}}</div>
            <div class="col">Nama Karyawan : {{ $data->user->name }}</div>
            <div class="col">Total Kehadiran Bulan {{ $data->name }} : {{ $data->total_kehadiran }}</div>
        </div>
        <div class="row mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kehadiran</th>
                        <th scope="col">Izin</th>
                        <th scope="col">Cuti</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">*</th>
                        <td>{{$data->total_kehadiran}}</td>
                        <td>{{$data->total_izin}}</td>
                        <td>{{$data->total_cuti}}</td>
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Salary</th>
                        <th scope="col"></th>
                        <th scope="col">{{$data->salary_karyawan}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>
