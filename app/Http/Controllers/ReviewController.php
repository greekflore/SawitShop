<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\OrderDetail;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $orderDetailId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $orderDetailId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string'
        ]);
    
        // Implementasi logika penyimpanan review
        $review = new Review();
        $review->order_detail_id = $orderDetailId;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();
    
        return redirect()->back()->with('success', 'Thank you for your review!');
    }
    
    
    
}
