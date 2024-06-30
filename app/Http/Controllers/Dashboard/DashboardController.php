<?php

namespace App\Http\Controllers\Dashboard;
use Auth;
use App\Models\User;
use App\Models\SetBulan;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    private $dasbor;
    public function countPresensi($data)
    {
        $number = 0;
        foreach ($data as $key => $value) {
            $number += $value['total'];
        }
        return $number;
    }
    public function getActiveMonth()
    {
        return SetBulan::where('is_active', '1')->first();
    }
    public function convertMonth()
    {
        $set_bulan = $this->getActiveMonth();
        if (is_null($set_bulan)) {
            $set_bulan = null;
            return;
        } else {
            return date('m', strtotime($set_bulan->bulan));
        }
    }
    public function getStatusPresensi($nama, $status)
    {
        return Kehadiran::selectRaw('count(status_presensi) as ' . $nama)
            ->where('status_presensi', 'like', $status)
            ->where('check_in', 'like', '2023-' . $this->convertMonth() . '-%')
            ->groupBy('user_id')
            ->orderBy('check_in', 'asc')
            ->get();
    }
    public function getTotalKehadiranKaryawan($status)
    {
        return Kehadiran::where('user_id', '=', getUserId())
            ->where('status_presensi', '=', $status)
            ->where('check_in','like','%-'.$this->convertMonth().'-%')
            ->get();
    }
    public function dasborKaryawan()
    {
        $date = getDateNowParse();
        $weekdays = $this->countDays($date['year'], $this->convertMonth(), [0, 6]);
        $presensi = is_null($this->getTotalKehadiranKaryawan('hadir')) == true ? [] : $this->getTotalKehadiranKaryawan('hadir');
        $izin = is_null($this->getTotalKehadiranKaryawan('izin')) == true ? [] : $this->getTotalKehadiranKaryawan('izin');
        $cuti = is_null($this->getTotalKehadiranKaryawan('cuti')) == true ? [] : $this->getTotalKehadiranKaryawan('cuti');
        $izin_cuti = Kehadiran::where('user_id', '=', getUserId())
            ->whereIn('status_presensi', ['izin', 'cuti'])
            ->where('check_in','like','%-'.$this->convertMonth().'-%')
            ->orderBy('check_in', 'asc')
            ->get();
        $title = 'Dashboard ' . Auth::user()->name;
        $set_bulan = $this->getActiveMonth();
        if (is_null($set_bulan)) {
            $set_bulan = null;
        }
        $bulan = SetBulan::all();
        return compact('weekdays', 'presensi', 'izin', 'cuti', 'izin_cuti', 'title', 'set_bulan', 'bulan');
    }
    public function dasborHRD()
    {
        $date = getDateNowParse();
        $presensi = $this->countPresensi($this->getStatusPresensi('total', 'hadir'));
        $izin = $this->countPresensi($this->getStatusPresensi('total', 'izin'));
        $cuti = $this->countPresensi($this->getStatusPresensi('total', 'cuti'));
        $weekdays = $this->countDays($date['year'], $this->convertMonth(), [0, 6]);
        $total_karyawan = User::count();
        $total_presensi = $weekdays * $total_karyawan;
        $title = 'Dashboard ' . Auth::user()->name;
        $set_bulan = $this->getActiveMonth();
        if (is_null($set_bulan)) {
            $set_bulan = null;
        }
        $bulan = SetBulan::all();
        return compact('presensi', 'izin', 'cuti', 'total_presensi', 'title', 'set_bulan', 'bulan');
    }
    public function index()
    {
        if (Auth::user()->hasRole('karyawan')) {
            $this->dasbor = $this->dasborKaryawan();
        } elseif (Auth::user()->hasRole('hrd')) {
            $this->dasbor = $this->dasborHRD();
        }
        // $pt = ['PT_SMK','PT_AEI'];
        // return response()->json([
        //     'data' => User::permission('PT_AEI')->get()
        //     // 'data' => $pt[array_rand($pt,1)]
        // ]);
        // dd($this->total_presensi);
        return view('Karyawan.dashboard', $this->dasbor);
    }
    public function countDays($year, $month, $ignore)
    {
        $count = 0;
        $counter = mktime(0, 0, 0, $month, 1, $year);
        while (date('n', $counter) == $month) {
            if (in_array(date('w', $counter), $ignore) == false) {
                $count++;
            }
            $counter = strtotime('+1 day', $counter);
        }
        return $count;
        // echo countDays(2013, 1, array(0, 6)); // 23
    }
    public function getDataKehadiranKaryawan()
    {
        if (Auth::user()->hasRole('karyawan')) {
            $presensi = count(
                $this->getTotalKehadiranKaryawan('hadir'),
            );
            $izin = count(
                $this->getTotalKehadiranKaryawan('izin'),
            );
            $cuti = count(
                $this->getTotalKehadiranKaryawan('cuti'),
            );
        } elseif (Auth::user()->hasRole('hrd')) {
            $presensi = $this->countPresensi($this->getStatusPresensi('total', 'hadir'));
            $izin = $this->countPresensi($this->getStatusPresensi('total', 'izin'));
            $cuti = $this->countPresensi($this->getStatusPresensi('total', 'cuti'));
        }
        return response()->json(['total_presensi' => $presensi, 'total_izin' => $izin, 'total_cuti' => $cuti]);
    }
}
