<?php

namespace App\Http\Controllers\Dashboard\Hrd;

use App\Models\User;
use App\Models\Sallaryreport;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SallaryReportController extends Controller
{
    const Month = ['january', 'february', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'novmber', 'desember'];
    public function sallaryReportTrainer(Request $request)
    {
        try {
            return $this->viewSallaryReportTrainer($this->getAbsenOfTrainer($request), static::Month);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function sallaryReportTrainerConfirm($users_id, $kelas_id, $total_gaji)
    {
        try {
            $submitMapRequestSallaryReports = $this->mapRequestSallaryReports($users_id, $kelas_id, $total_gaji);
            return $this->submitRequestSallaryReports($submitMapRequestSallaryReports);
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    private function mapRequestSallaryReports($users_id, $kelas_id, $total_gaji): array
    {
        return array('users_id' => $users_id, 'kelas_id' => $kelas_id, 'total_gaji' => $total_gaji);
    }

    private function submitRequestSallaryReports($mapRequestSallaryReports): RedirectResponse
    {
        if (!$this->ValidateSallaryAlreadyExists($mapRequestSallaryReports)) {
            Sallaryreport::create($mapRequestSallaryReports);
            return $this->ResponseOfSuccessSallarySubmit();
        } else {
            return $this->ResponseOfValidateSallaryAlreadyExists();
        }
    }

    private function ValidateSallaryAlreadyExists($mapRequestSallaryReports): bool
    {
        return Sallaryreport::where([['kelas_id', '=', $mapRequestSallaryReports['kelas_id']], ['users_id', '=', $mapRequestSallaryReports['users_id']]])->first() ? true : false;
    }

    private function ResponseOfSuccessSallarySubmit()
    {
        return $this->Response('Berhasil Confirm Sallary', 'hrd.trainer.sallary_report.list');
    }

    private function ResponseOfValidateSallaryAlreadyExists(): RedirectResponse
    {
        return $this->Response('sallary trainer sudah di ajukan', 'hrd.trainer.sallary_report.list', 'error');
    }

    private function getAbsenOfTrainer($request)
    {
        return User::orderByDesc('id')
            ->where('roles', 'trainer')
            ->with(['levelTrainer', 'AssignedClass'])
            ->when($request->nama_kelas_filter, function ($query) use ($request) {
                $query->whereHas('absen.jadwal.kelas', function ($query) use ($request) {
                    $query->where('nama_kelas', 'like', "%{$request->nama_kelas_filter}%");
                });
            })
            ->when($request->tanggal_absen_filter, function ($query) use ($request) {
                $query->whereHas('absen', function ($query) use ($request) {
                    $query->where('created_at', 'like', "%{$request->tanggal_absen_filter}%");
                });
            })
            ->when($request->bulan_absen_filter, function ($query) use ($request) {
                $query->whereHas('absen', function ($query) use ($request) {
                    $query->whereMonth('created_at', $request->bulan_absen_filter);
                });
            })
            ->get();
    }

    private function viewSallaryReportTrainer($getAbsenOfTrainer, $Month): View
    {
        return view('dashboard.hrd.sallary_report_trainer', compact('getAbsenOfTrainer', 'Month'));
    }
}
