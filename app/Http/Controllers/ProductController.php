<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Obtener productos con sus imágenes
        $products = Product::with(['images', 'producer', 'category'])
            ->where('stock', '>', 0)
            ->orderBy('product_name', 'asc')
            ->get();


        // Obtener un producto destacado (puedes cambiar la lógica según lo necesites)
        $featuredProduct = Product::with('images')
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->first();

        return view('client.index', compact('products', 'featuredProduct'));
    }

  public function show($id)
{
    $product = Product::with(['producer.user', 'images'])->findOrFail($id);
    
    // Obtener productos similares (misma categoría, excluyendo el actual)
    $similarProducts = Product::with('images')
        ->where('id_category', $product->id_category)
        ->where('id_product', '!=', $id)
        ->inRandomOrder()
        ->limit(4)
        ->get();
    
    return view('products.show', compact('product', 'similarProducts'));
}

    // Método para que los productores agreguen imágenes
    public function storeImage(Request $request, $productId)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'nullable|integer'
        ]);

        $product = Product::findOrFail($productId);

        // Verificar que el usuario autenticado es el dueño del producto
        if (auth()->id() !== $product->id_user) {
            return redirect()->back()->with('error', 'No tienes permiso para modificar este producto');
        }

        // Procesar imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/images', 'public');

                ProductImage::create([
                    'id_product' => $productId,
                    'file_path' => $path,
                    'file_type' => 'image',
                    'is_primary' => ($request->primary_image == $index),
                    'uploaded_at' => now()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Imágenes agregadas correctamente');
    }
}