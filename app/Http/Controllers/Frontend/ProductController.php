<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Master\Product;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;
    public function __construct()
    {
        $this->product = new CrudRepositories(new Product());
    }

    public function index()
    {
        $data['product'] = $this->product->getPaginate(12);
        return view('frontend.product.index',compact('data'));
    }

    public function show($categoriSlug, $productSlug)
    {
        // Memuat produk beserta ulasan dan data user yang memberikan ulasan
        $data['product'] = $this->product->Query()
            ->with(['reviews.user']) // Pastikan user dimuat bersama reviews
            ->where('slug', $productSlug)
            ->first();
    
        if (!$data['product']) {
            abort(404); // Jika produk tidak ditemukan
        }
    
        // Memuat produk terkait
        $data['product_related'] = $this->product->Query()
            ->where('categories_id', $data['product']->categories_id)
            ->where('slug', '!=', $productSlug)
            ->limit(4)
            ->get();
    
        return view('frontend.product.show', compact('data'));
    }
    
    

    public function search(Request $request)
    {
        $data['product'] = $this->product->Query()->where('name','like','%'.$request->q.'%')->paginate
        (12);

        return view('frontend.product.search',compact('data'));
    }
}
