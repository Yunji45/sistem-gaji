<?php

namespace App\Http\Controllers\Presensi;

use Alert;
use App\Models\Kehadiran;
use App\Models\absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('Karyawan.presensi');
    }
    public function store(Request $request)
    {
        // Validasi input request
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'presensi' => 'required|string|in:hadir,izin,cuti',
            'deskripsi' => 'nullable|string'
        ]);
    
        // Ambil lokasi kantor dan radius dari variabel lingkungan
        $officeLatitude = (float)env('OFFICE_LATITUDE');
        $officeLongitude = (float)env('OFFICE_LONGITUDE');
        $radius = (float)env('RADIUS');
    
        // Ambil latitude dan longitude dari pengguna
        $latitude = (float)$request->latitude;
        $longitude = (float)$request->longitude;
    
        // Log koordinat kantor dan pengguna
        Log::info("Latitude Kantor: $officeLatitude, Longitude Kantor: $officeLongitude");
        Log::info("Latitude Pengguna: $latitude, Longitude Pengguna: $longitude");
    
        // Hitung jarak antara pengguna dan kantor
        $distance = $this->getDistance($latitude, $longitude, $officeLatitude, $officeLongitude);
    
        // Log ID pengguna dan jarak yang dihitung
        Log::info("ID Pengguna: " . Auth::id() . ", Latitude: $latitude, Longitude: $longitude, Jarak: $distance");
    
        // Periksa apakah pengguna berada dalam radius yang diizinkan
        if ($distance > $radius) {
            return response()->json(['message' => 'Anda tidak berada dalam radius yang diizinkan'], 400);
        }
    
        // Tentukan status presensi dan buat catatan presensi baru
        $statusPresensi = $request->presensi;
        $deskripsi = $request->deskripsi ?? '';
    
        if ($statusPresensi == 'hadir') {
            absensi::create([
                'user_id' => Auth::id(),
                'status_presensi' => 'hadir',
                'check_in' => now(),
                'latitude' => $latitude,
                'longitude' => $longitude,
                'deskripsi' => 'bekerja di kantor',
            ]);
        } else {
            absensi::create([
                'user_id' => Auth::id(),
                'status_presensi' => $statusPresensi,
                'check_in' => null,
                'latitude' => null,
                'longitude' => null,
                'deskripsi' => $deskripsi,
            ]);
        }
    
        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil!');
    }
    
    public function absen()
    {
        $title = 'absensi';
        return view('Karyawan.absensi',compact('title'));
    }    

    public function checkOut(Request $request)
    {
        $officeLatitude = env('OFFICE_LATITUDE');
        $officeLongitude = env('OFFICE_LONGITUDE');
        $radius = env('RADIUS');

        $distance = $this->getDistance($request->latitude, $request->longitude, $officeLatitude, $officeLongitude);

        if ($distance > $radius) {
            return response()->json(['message' => 'You are not within the allowed radius'], 400);
        }

        $absensi = Absensi::where('user_id', Auth::id())->whereNull('check_out')->first();

        if ($absensi) {
            $absensi->update([
                'check_out' => now(),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            return response()->json(['message' => 'Check out successful']);
        }

        return response()->json(['message' => 'No active check in found'], 400);
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);
    
        $officeLatitude = (float)env('OFFICE_LATITUDE');
        $officeLongitude = (float)env('OFFICE_LONGITUDE');
        $radius = (float)env('RADIUS');
    
        $latitude = (float)$request->latitude;
        $longitude = (float)$request->longitude;
    
        Log::info("Office Latitude: " . $officeLatitude . ", Office Longitude: " . $officeLongitude);
        Log::info("User Latitude: " . $latitude . ", User Longitude: " . $longitude);
    
        $distance = $this->getDistance($latitude, $longitude, $officeLatitude, $officeLongitude);
    
        Log::info("User ID: " . Auth::id() . ", Latitude: " . $latitude . ", Longitude: " . $longitude . ", Distance: " . $distance);
    
        if ($distance > $radius) {
            return response()->json(['message' => 'You are not within the allowed radius'], 400);
        }
    
        Absensi::create([
            'user_id' => Auth::id(),
            'status_presensi' => 'Masuk',
            'check_in' => now(),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'deskripsi' => null,

        ]);
    
        return response()->json(['message' => 'Check in successful']);
    }
    
    private function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;
    
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;
        return $distance;
    }    
}

