<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Property;
use App\Models\Proprietario;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $imoveis = Property::withTrashed()->count();
        $clientes = Cliente::count();
        $proprietarios = Proprietario::count();
        $usuarios = User::count();

        return response()->json(['imoveis' => $imoveis ?? 0, 'clientes' => $clientes ?? 0, 'proprietarios' => $proprietarios ?? 0, 'usuarios' => $usuarios ?? 0]);
    }

    // public function teste()
    // {
    //     $imoveis = Property::withTrashed()->count();
    //     $clientes = Cliente::count();
    //     $proprietarios = Proprietario::count();
    //     $usuarios = User::count();


    // }
}
