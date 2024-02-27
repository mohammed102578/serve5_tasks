<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repository\ProductRepository;

class ProductController extends BaseController
{
    public $product;
   
    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }
    public function index(Request $request)
    { 
       return $this->product->index($request);
    }
    
    
    public function filter(Request $request)
    {
        return $this->product->filter($request);

    }
    
    
    }