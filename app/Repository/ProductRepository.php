<?php

namespace App\Repository;


use App\Interface\ProductInterface;
use App\Models\Product;

class ProductRepository implements ProductInterface
{
    public function index($request)
    { 
        $categories = Product::distinct('category')->pluck('category');
        $brands = Product::distinct('brand')->pluck('brand');
        
        $products = Product::paginate(10);
        if ($request->ajax()) {
            return view('products.partials.products', compact('products'))->render();
        }

        return view('products.index', compact('products', 'categories', 'brands'));

    }
    
    
    public function filter($request)
    {
        $category = $request->input('category');
        $brand = $request->input('brand');
        $search = $request->input('search');
    
        $query = Product::query();
    
        if ($category) {
            $query->where('category', $category);
        }
    
        if ($brand) {
            $query->where('brand', $brand);
        }
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('product', 'like', "%$search%")
                  ->orWhere('category', 'like', "%$search%")
                  ->orWhere('brand', 'like', "%$search%");
            });
        }
    
        $products = $query->paginate(10);
    
        if ($request->ajax()) {
            return response()->json([
                'data' => view('products.partials.products', compact('products'))->render(),
            ]);
        }
    }
    
}