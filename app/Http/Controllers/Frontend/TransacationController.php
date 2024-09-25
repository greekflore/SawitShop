<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Feature\Order;
use App\Repositories\CrudRepositories;
use App\Services\Feature\OrderService;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;

class TransacationController extends Controller
{   
    protected $orderService;
    protected $order;
    public function __construct(OrderService $orderService,Order $order)
    {
        $this->orderService = $orderService;
        $this->order = new CrudRepositories($order);
    }

    public function index()
    {
        $data['orders'] = $this->orderService->getUserOrder(auth()->user()->id);
        return view('frontend.transaction.index',compact('data'));
    }

    public function show($invoice_number)
    {
        $data['order'] = $this->order->Query()->where('invoice_number',$invoice_number)->first();
        $snapToken = $data['order']->snap_token;
        if (empty($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database
            $midtrans = new CreateSnapTokenService($data['order']);
            $snapToken = $midtrans->getSnapToken();
            $data['order']->snap_token = $snapToken;
            $data['order']->save();
        }
        return view('frontend.transaction.show',compact('data'));
    }

    public function received($invoice_number)
    {
        $this->order->Query()->where('invoice_number',$invoice_number)->first()->update(['status' => 3]);
        return back()->with('success',__('message.order_received'));
    }

    public function canceled($invoice_number)
    {
        $this->order->Query()->where('invoice_number',$invoice_number)->first()->update(['status' => 4]);
        return back()->with('success',__('message.order_canceled'));
    }

    public function storeReview(Request $request, $productId)
    {
        // Validasi input
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review_text' => 'string|nullable'
        ]);
    
        // Buat review baru
        $review = new Review();
        $review->user_id = auth()->user()->id; // User yang memberi review
        $review->product_id = $productId; // Produk yang di-review
        $review->rating = $request->rating; // Nilai rating
        $review->review_text = $request->review_text; // Teks review
        $review->save();
    
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Thank you for your review!');
    }
    

}
