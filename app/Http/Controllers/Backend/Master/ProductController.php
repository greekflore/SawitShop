<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Category;
use App\Models\Master\Product;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = new CrudRepositories($product);
        $this->category = new CrudRepositories($category);
    }

    public function index()
    {
        $data['product'] = $this->product->get(); // Ambil semua produk
        return view('backend.master.product.index', compact('data')); // Kirimkan $data ke tampilan
    }
    

    public function create()
    {
        $data['category'] = $this->category->get(); // Ubah 'category' menjadi 'categories'
        return view('backend.master.product.create', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $this->product->store($data, true, ['thumbnails'], 'product/thumbnails');
        return redirect()->route('master.product.index')->with('success', __('message.store'));
    }

    public function show($id)
    {
        $data['product'] = $this->product->find($id);
        
        // Pastikan produk ditemukan sebelum mengembalikan view
        if (!$data['product']) {
            return redirect()->route('master.product.index')->with('error', __('message.not_found'));
        }
        
        return view('backend.master.product.show', compact('data'));
    }

    public function edit($id)
    {
        $data['product'] = $this->product->find($id);
        $data['category'] = $this->category->get(); // Ambil kategori dari database
    
        // Pastikan produk ditemukan sebelum mengembalikan view
        if (!$data['product']) {
            return redirect()->route('master.product.index')->with('error', __('message.not_found'));
        }
        
        return view('backend.master.product.edit', compact('data')); // Kirimkan $data
    }
    

    public function update(Request $request, $id)
    {
        $productData = $request->except('_token'); // Ambil semua data kecuali token
        
        if (isset($request->thumbnails)) {
            $this->product->update($id, $productData, true, ['thumbnails'], 'product/thumbnails');
        } else {
            $this->product->update($id, $productData);
        }
        
        return redirect()->route('master.product.index')->with('success', __('message.update'));
    }

    public function delete($id)
    {
        $this->product->hardDelete($id);
        return back()->with('success', __('message.harddelete'));
    }

    public function show($id)
{
    // Temukan produk dengan ulasan terkait
    $data['product'] = $this->product->find($id)->load('reviews');
    
    // Pastikan produk ditemukan sebelum mengembalikan view
    if (!$data['product']) {
        return redirect()->route('master.product.index')->with('error', __('message.not_found'));
    }
    
    return view('backend.master.product.show', compact('data'));
}

    
}
