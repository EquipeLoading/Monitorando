<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Monitoria;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::user();
        $data = null;
        if(isset($usuario)){
            $usuario = User::where('id', Auth::user()->id)->get()->first();
            $data = $usuario->monitorias()->wherePivot('tipo', 'Inscrito')->get();
        }
    	return view('calendario', ['data' => $data]);
    }
}
