<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Mostrar perfil del cliente con compras realizadas
     */
    public function clientProfile()
    {
        $user = auth()->user();
        $purchases = $user->client ? $user->client->purchases()->with(['details.product'])->get() : collect();
        return view('profile.client', compact('purchases'));
    }
}