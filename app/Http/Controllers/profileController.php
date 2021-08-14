<?php

namespace App\Http\Controllers;
use App\Models\Monitoria;


use Illuminate\Http\Request;

class profileController extends Controller
{
    public function index() {    
        $monitorias = Monitoria::all();
        return view('profile',  ['nome' => session()->get('nome'), 'monitorias' => $monitorias]);
    }
}
