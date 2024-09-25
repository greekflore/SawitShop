<?php

namespace App\Http\Controllers\Backend\Feature;

use App\Http\Controllers\Controller;
use App\Models\Feature\Order;
use App\Models\Master\Product; // Pastikan untuk mengimpor model Product
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk mengimpor kelas Log

class OrderController extends Controller
{   
    protected $order;
    

    public function inputResi(Request $request)
    {
        $request->merge(['status' => 2]);
        $this->order->Query()->where('invoice_number',$request->invoice_number)->first()->update($request->only('status','receipt_number'));
        return back()->with('success',__('message.order_receipt'));
    }
    public function __construct(Order $order)
    {
        $this->order = new CrudRepositories($order);
    }

    public function index($status = null)
    {
        if ($status == null) {
            $data['order'] = $this->order->get();
        } else {
            $data['order'] = $this->order->Query()->where('status', $status)->get();
        }
        return view('backend.feature.order.index', compact('data'));
    }

    public function show($id)
    {
        $data['order'] = Order::find($id);
        return view('backend.feature.order.show', compact('data'));
    }

    public function placeOrder(Request $request)
    {
        try {
            // Buat pesanan baru
            $order = Order::create([
                'user_id' => auth()->user()->id, // Ambil ID pengguna yang sedang login
                'status' => 'pending', // Status awal pesanan
            ]);

            // Kurangi stok produk
            foreach ($request->products as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('stok', $quantity); // Kurangi stok sesuai jumlah
                    $order->products()->attach($productId, ['quantity' => $quantity]); // Simpan hubungan dengan produk
                }
            }

            return redirect()->route('order.index')->with('success', __('message.order_success'));
        } catch (\Throwable $th) {
            Log::error('Error placing order: ' . $th->getMessage()); // Catat error ke log
            return back()->with('error', __('message.order_error'));
        }
    }

    public function cancelOrder($id)
    {
        try {
            $order = $this->order->find($id);
            if ($order && $order->status === 'pending') {
                // Kembalikan stok produk yang dipesan
                foreach ($order->products as $product) {
                    $productModel = Product::find($product->id);
                    if ($productModel) {
                        $productModel->increment('stok', $product->pivot->quantity); // Kembalikan stok
                    }
                }
                $order->update(['status' => 'canceled']); // Update status menjadi dibatalkan
            }
            return back()->with('success', __('message.order_cancel_success'));
        } catch (\Throwable $th) {
            Log::error('Error canceling order: ' . $th->getMessage()); // Catat error ke log
            return back()->with('error', __('message.order_cancel_error'));
        }
    }
}
