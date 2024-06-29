<?php

namespace App\Http\Controllers\SlipGaji;
use Alert;
use App\Models\User;
use App\Models\Salary;
use App\Models\SetBulan;
use App\Models\Kehadiran;
use App\Models\KelolaSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;
use Illuminate\Support\Facades\Auth;

class SlipGajiController extends Controller
{
    private $dasbor;
    public function eachPresensi($status_presensi, $bulan)
    {
        // -- where status_presensi = "'.$status_presensi.'" and waktu_presensi like "%-'.$bulan.'-%"
        return DB::select(
            DB::raw(
                'SELECT u.id as id,status_presensi, u.name as name, count(status_presensi) as jumlah FROM `kehadiran` k
                JOIN users u on k.user_id = u.id
                where status_presensi = "' .
                    $status_presensi .
                    '" and waktu_presensi like "%-' .
                    $bulan .
                    '-%"
                group by status_presensi,u.name;',
            ),
        );
    }
    public function getKelolaSalary()
    {
        return is_null(KelolaSalary::all()->first()) == true ? 0 : KelolaSalary::all()->first()->salary;
    }
    public function convertMonth()
    {
        $set_bulan = SetBulan::where('is_active', '1')->first();
        if (is_null($set_bulan)) {
            $set_bulan = null;
            return;
        } else {
            return date('m', strtotime($set_bulan->bulan));
        }
    }
    public function getActiveMonth()
    {
        return SetBulan::where('is_active', '1')->first();
    }
    public function slipGajiHRD()
    {
        $title = 'Slip Gaji Karyawan';
        $data = [];
        $set_bulan = $this->getActiveMonth();
        if (is_null($set_bulan)) {
            $set_bulan = null;
        }

        // Hadir
        $hadir = $this->eachPresensi('hadir', $this->convertMonth());
        foreach ($hadir as $key => $value) {
            $data[$key]['name'] = $value->name;
            $data[$key]['hadir'] = $value->jumlah;
            $data[$key]['name'] = $value->name;
            $data[$key]['id'] = $value->id;
            $id = User::where('name', 'like', $value->name)->first();
            $cek_gaji = Salary::where('user_id', $id->id)
                ->where('name', 'like', $set_bulan->bulan)
                ->first();
            if (!is_null($cek_gaji)) {
                $data[$key]['gaji'] = true;
            } else {
                $data[$key]['gaji'] = false;
            }
        }

        // Izin
        $izin = $this->eachPresensi('izin', $this->convertMonth());
        foreach ($izin as $key => $value) {
            $data[$key]['izin'] = $value->jumlah;
        }

        // Cuti
        $cuti = $this->eachPresensi('cuti', $this->convertMonth());
        foreach ($cuti as $key => $value) {
            $data[$key]['cuti'] = $value->jumlah;
            $data[$key]['salary'] = $data[$key]['hadir'] - $data[$key]['cuti'] - $data[$key]['izin'] < 0 ? 0 : round((($data[$key]['hadir'] - $data[$key]['cuti'] - $data[$key]['izin']) / weekdays()) * $this->getKelolaSalary());
        }

        // dd($data);
        $kelola_salary = KelolaSalary::all()->first();

        $status_kelola['status'] = true;
        if (is_null($kelola_salary)) {
            $status_kelola['status'] = false;
        } else {
            $status_kelola['salary'] = $kelola_salary['salary'];
        }
        $bulan = SetBulan::all();
        return compact('title', 'data', 'status_kelola', 'bulan', 'set_bulan');
    }
    public function getTotalKehadiranKaryawan($status)
    {
        return Kehadiran::where('user_id', '=', getUserId())
            ->where('status_presensi', '=', $status)
            ->where('waktu_presensi', 'like', '%-' . $this->convertMonth() . '-%')
            ->get();
    }
    public function slipGajiKaryawan()
    {
        $set_bulan = $this->getActiveMonth();
        if (is_null($set_bulan)) {
            $set_bulan = null;
        }
        $bulan = SetBulan::all();
        $title = 'Slip Gaji ' . Auth::user()->name;
        $hadir = is_null($this->getTotalKehadiranKaryawan('hadir')) == true ? [] : $this->getTotalKehadiranKaryawan('hadir');
        $izin = is_null($this->getTotalKehadiranKaryawan('izin')) == true ? [] : $this->getTotalKehadiranKaryawan('izin');
        $cuti = is_null($this->getTotalKehadiranKaryawan('cuti')) == true ? [] : $this->getTotalKehadiranKaryawan('cuti');
        $name;
        if(is_null($this->getActiveMonth())){
            // return redirect()->back()->with('error','Bulan belum disetting admin!');
            return abort(500,'Bulan belum disetting!');
        }else{
            $name = $this->getActiveMonth()->bulan;
        }
        // $name = $this->getActiveMonth();
        $salary =
            is_null(
                Salary::where('name', 'like', $name)
                    ->where('user_id', getUserId())
                    ->first(),
            ) == true
                ? ''
                : Salary::where('name', 'like', $name)
                    ->where('user_id', getUserId())
                    ->first()->salary_karyawan;
        $data = [
            0 => compact('hadir', 'izin', 'cuti', 'name', 'salary'),
        ];
        return compact('data', 'title', 'set_bulan', 'bulan');
        // return;
    }
    public function index()
    {
        if (Auth::user()->hasRole('karyawan')) {
            $this->dasbor = $this->slipGajiKaryawan();
        } elseif (Auth::user()->hasRole('hrd')) {
            $this->dasbor = $this->slipGajiHRD();
        }
        // return response()->json([
        //     'result' => $this->dasbor
        // ]
        // );
        return view('Karyawan.slip_gaji',$this->dasbor);
    }
    public function storeKelolaSalary(SalaryRequest $request)
    {
        // dd($request->all());
        $kelola_salary = KelolaSalary::all()->first();
        $status_kelola['status'] = true;
        if (is_null($kelola_salary)) {
            $status_kelola['status'] = false;
            KelolaSalary::create($request->validated());
            Alert::success('Success', 'Berhasil input salary!');
        } else {
            KelolaSalary::where('id', '1')->update($request->validated());
            Alert::success('Success', 'Berhasil update salary!');
        }
        return redirect()->back();
    }
    public function storeSetBulan(Request $request)
    {
        $bulan = $request->bulan;
        SetBulan::where('is_active', '1')->update(['is_active' => 0]);
        $update = SetBulan::where('bulan', $bulan)->update(['is_active' => 1]);

        return redirect()
            ->back()
            ->with('success', 'Set Bulan Berhasil');
    }
    public function gajiKaryawan(Request $request)
    {
        $user = User::where('name', 'like', $request->name)->first();
        $cek_delete = Salary::where('user_id',$user->id)->restore();
        // if (!is_null($cek_delete->deleted_at)) {
        //     $cek_delete->restore();
        //     return 'berhasil';
        // }
        // return response()->json([
        //     'data' => $cek_delete,
        // ]);
        Salary::updateOrCreate([
            'name' => $this->getActiveMonth()->bulan,
            'total_kehadiran' => $request->hadir,
            'total_izin' => $request->izin,
            'total_cuti' => $request->cuti,
            'salary_karyawan' => $request->salary,
            'user_id' => $user->id,
        ]);
        return redirect()
            ->back()
            ->with('success', 'Success Gaji Karyawan!');
        // dd($request->all());
        // dd($user);
    }
    public function resetGajiKaryawan($id)
    {
        Salary::where('user_id', $id)->delete();
        return redirect()
            ->back()
            ->with('success', 'Berhasil reset!');
    }

    function isErrorSalary() {

    }
}
