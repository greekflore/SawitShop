<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Voucher; // Import your Voucher model
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    protected $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher = new CrudRepositories($voucher);
    }

    public function index()
    {
        $data['vouchers'] = $this->voucher->get(); // Get all vouchers
        return view('backend.master.voucher.index', compact('data')); // Send $data to the view
    }

    public function create()
    {
        return view('backend.master.voucher.create'); // Show the create voucher form
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'code' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'expiration_date' => 'required|date|after:today',
        ]);
    
        // Create the voucher using the validated data
        $voucher = new Voucher();
        $voucher->code = $request->code;
        $voucher->discount = $request->discount;
        $voucher->expiration_date = $request->expiration_date;
        $voucher->save();
    
        // Redirect back with success message
        return redirect()->route('master.voucher.index')->with('success', __('message.voucher_added'));
    }

    public function show($id)
    {
        $data['voucher'] = $this->voucher->find($id);
        
        // Ensure the voucher is found before returning the view
        if (!$data['voucher']) {
            return redirect()->route('master.voucher.index')->with('error', __('message.not_found'));
        }
        
        return view('backend.master.voucher.show', compact('data'));
    }

    public function edit($id)
    {
        $data['voucher'] = $this->voucher->find($id);
        
        // Ensure the voucher is found before returning the view
        if (!$data['voucher']) {
            return redirect()->route('master.voucher.index')->with('error', __('message.not_found'));
        }
        
        return view('backend.master.voucher.edit', compact('data')); // Send $data
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'code' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'expiration_date' => 'required|date|after:today',
        ]);
    
        // Find the voucher by ID
        $voucher = $this->voucher->find($id);
        
        // Ensure the voucher is found before updating
        if (!$voucher) {
            return redirect()->route('master.voucher.index')->with('error', __('message.not_found'));
        }
    
        // Update the voucher using the validated data
        $voucher->code = $request->code;
        $voucher->discount = $request->discount;
        $voucher->expiration_date = $request->expiration_date;
        $voucher->save();
    
        return redirect()->route('master.voucher.index')->with('success', __('message.update'));
    }
    
    public function checkVoucher(Request $request)
    {
        $voucher = Voucher::where('code', $request->code)->first();
        
        if ($voucher) {
            $currentDate = now();
    
            // Cek apakah voucher sudah kadaluarsa
            if ($currentDate->greaterThan($voucher->expiration_date)) {
                return response()->json([
                    'valid' => false,
                    'message' => 'expired' // Menambahkan message untuk voucher kadaluarsa
                ]);
            }
    
            // Jika voucher valid dan belum kadaluarsa
            return response()->json([
                'valid' => true,
                'discount_percent' => $voucher->discount // Ambil persentase diskon
            ]);
        } else {
            return response()->json([
                'valid' => false,
                'message' => 'invalid' // Menambahkan message untuk voucher tidak valid
            ]);
        }
    }
    
    
    public function delete($id)
    {
        $this->voucher->hardDelete($id); // Delete the voucher
        return back()->with('success', __('message.harddelete'));
    }
}
