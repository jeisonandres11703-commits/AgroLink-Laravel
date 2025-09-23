<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;

class ProducerController extends Controller{


    public function products()
    {
        $producer = auth()->user()->producer;
        $products = $producer ? $producer->products()->with('category', 'images')->get() : collect();
        return view('producer.products', compact('products'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Producer $producer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producer $producer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producer $producer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producer $producer)
    {
        //
    }


    public function dashboard()
    {
        $producer = auth()->user()->producer;
        // Obtener todos los detalles de compra de productos de este productor
        $orders = \App\Models\Purchase::whereHas('details.product', function($q) use ($producer) {
            $q->where('id_user', $producer->id_user);
        })
        ->with(['details.product', 'client.user'])
        ->orderByDesc('purchase_datetime')
        ->get();
        return view('producer.dashboard', compact('orders'));
    }
}
