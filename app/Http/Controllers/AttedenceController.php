<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttedenceController extends Controller
{

    // halaman absen biasa
    public function index()
    {
        return view('components.features.employes.attedance.attedance-work.attedance');
    }

    // halaman absen sholat (riwayat)
    public function attedanceIshomaIndex()
    {
        return view('components.features.employes.attedance.attdance-ishoma.index');
    }

    public function attedanceIshoma()
    {
        return view('components.features.employes.attedance.attdance-ishoma.attedance-ishoma');
    }

    // absen aksi (selfie)
    public function attedanceAction()
    {
        return view('components.features.employes.attedance.attedance-work.attedance-action');
    }




    // absen sukses alert 
    public function attedanceSuccess()
    {
        return view('components.features.employes.attedance.alert-attedance.attedance-success');
    }
}
