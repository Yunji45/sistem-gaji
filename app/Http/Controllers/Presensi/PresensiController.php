<?php

namespace App\Http\Controllers\Presensi;
use Alert;
use App\Models\Kehadiran;
use App\Models\absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PresensiController extends Controller
{
    public function index()
    {
        return view('Karyawan.presensi');
    }
    // public function store(Request $request)
    // {
    //     if ($request->presensi == 'hadir') {
    //         Kehadiran::create([
    //             'status_presensi' => 'hadir',
    //             'waktu_presensi' => now(),
    //             'deskripsi' => "bekerja di kantor",
    //             'user_id' => getUserId(),
    //         ]);
    //         return redirect()->route('presensi.index')->with('success','Success Presensi!');
    //     } elseif ($request->presensi == 'pulang') {
    //         Kehadiran::create([
    //             'status_presensi' => 'pulang',
    //             'waktu_presensi' => now(),
    //             'deskripsi' => "pulang di kantor",
    //             'user_id' => getUserId(),
    //         ]);
    //         return redirect()->route('presensi.index')->with('success','Success Presensi!');
    //     } elseif ($request->presensi == 'izin'){
    //         Kehadiran::create([
    //             'status_presensi' => 'izin',
    //             'waktu_presensi' => now(),
    //             'deskripsi' => $request->deskripsi,
    //             'user_id' => getUserId()
    //         ]);
    //         return redirect()->route('presensi.index')->with('success','Success Presensi!');
    //     } elseif ($request->presensi == 'cuti'){
    //         Kehadiran::create([
    //             'status_presensi' => 'cuti',
    //             'waktu_presensi' => now(),
    //             'deskripsi' => $request->deskripsi,
    //             'user_id' => getUserId()
    //         ]);
    //         return redirect()->route('presensi.index')->with('success','Success Presensi!');
    //     }
    // }

    public function store(Request $request)
    {
        if ($request->presensi == 'izin'){
            absensi::create([
                'user_id' => getUserId(),
                'status_presensi' => 'izin',
                'deskripsi' => $request->deskripsi,
            ]);
            return redirect()->back()->with('success','Success Presensi!');
        } elseif ($request->presensi == 'cuti'){
            absensi::create([
                'user_id' => getUserId(),
                'status_presensi' => 'cuti',
                'waktu_presensi' => now(),
                'deskripsi' => $request->deskripsi,
            ]);
            return redirect()->back()->with('success','Success Presensi!');
        }
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
        // Validasi input
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
            'status_presensi' => 'hadir',
            'check_in' => now(),
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    
        return response()->json(['message' => 'Check in successful']);
    }
    
    private function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // radius of earth in meters
    
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
