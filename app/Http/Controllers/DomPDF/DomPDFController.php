<?php

namespace App\Http\Controllers\DomPDF;

use DB;
use App\Models\Salary;
use App\Models\SetBulan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class DomPDFController extends Controller
{
    public function getActiveMonth()
    {
        return SetBulan::where('is_active', '1')->first();
    }
    public function getUserFromSalary($id)
    {
        return Salary::where('name', $this->getActiveMonth()->bulan)
            ->where('user_id', $id)
            ->with('user')
            ->first();
    }
    public function viewPDF($id)
    {
        $data = $this->getUserFromSalary($id);
        if (is_null($data)) {
            return redirect()
                ->back()
                ->with('error', 'HRD belum set gaji!');
        }
        $title = 'Slip Gaji ' . $data->user->nama;
        // return response()->json([
        //     'data' => $data,
        // ]);

        $pdf = Pdf::loadView('pdf.paycheck', compact('data', 'title'));
        return $pdf->stream();
    }
    public function downloadPDF($id)
    {
        $data = $this->getUserFromSalary($id);
        if (is_null($data)) {
            return redirect()
                ->back()
                ->with('error', 'HRD belum set gaji!');
        }
        $title = 'Slip Gaji ' . $data->user->nama;
        $pdf = Pdf::loadView('pdf.paycheck', compact('data', 'title'));
        return $pdf->download('laporan-karyawan-pdf');
    }
}
