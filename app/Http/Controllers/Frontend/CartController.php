<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Feature\Cart;
use App\Models\Master\Product;
use App\Repositories\CrudRepositories;
use App\Services\Feature\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;
    protected $cartService;

    public function __construct(Cart $cart, CartService $cartService)
    {
        $this->cart = new CrudRepositories($cart);
        $this->cartService = $cartService;
    }

    public function index()
    {
        $data['carts'] = $this->cart->Query()->where('user_id', auth()->user()->id)->get();
        return view('frontend.cart.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $product = Product::find($request->cart_product_id);
            
            // Periksa apakah stok mencukupi
            if ($product->stok >= $request->cart_qty) {
                $this->cartService->store($request);
    
                // Stok berkurang sementara dalam keranjang
                $product->stok -= $request->cart_qty;
                $product->save();
    
                return redirect()->route('cart.index')->with('success', __('message.cart_success'));
            } else {
                return back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    

    public function delete($id)
    {
        $cart = $this->cart->hardDelete($id);
        return back()->with('success', __('message.cart_delete'));
    }

    public function update(Request $request)
    {
        try {
            $i = 0;
            foreach ($request['cart_id'] as $cart_id) {
                $cart = $this->cart->find($cart_id);
                $product = Product::find($cart->product_id); // Ambil produk terkait
                
                // Periksa jika stok cukup untuk update jumlah barang
                if ($product->stok >= $request['cart_qty'][$i]) {
                    $cart->qty = $request['cart_qty'][$i];
                    $cart->save();
                    
                    // Kurangi stok produk
                    $stok_diff = $cart->qty - $cart->getOriginal('qty'); // Selisih antara qty lama dan yang baru
                    $product->stok -= $stok_diff;
                    $product->save();
                } else {
                    return back()->with('error', 'Stok produk tidak mencukupi.');
                }
                
                $i++;
            }
            return redirect()->route('cart.index')->with('success', __('message.cart_update'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function checkout()
    {
        try {
            $carts = $this->cart->Query()->where('user_id', auth()->user()->id)->get();
            
            if ($carts->isEmpty()) {
                return back()->with('error', 'Opps! kamu belum memiliki barang untuk dicheckout, lakukan pembelian terlebih dahulu :)');
            }

            foreach ($carts as $cart) {
                $product = Product::find($cart->product_id);

                // Periksa jika stok cukup untuk checkout
                if ($product->stok >= $cart->qty) {
                    // Kurangi stok produk di database
                    $product->stok -= $cart->qty;
                    $product->save();
                } else {
                    return back()->with('error', 'Stok produk tidak mencukupi untuk beberapa item di keranjang Anda.');
                }
            }

            // Logika untuk menyelesaikan checkout (misalnya mengirim order, mengosongkan keranjang, dsb.)
            
            return redirect()->route('checkout.success')->with('success', 'Checkout berhasil!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
