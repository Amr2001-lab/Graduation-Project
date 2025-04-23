<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Apartment;
use App\Mail\BuyerInquiryMail;
use Illuminate\Support\Facades\Mail;
class InquiryController extends Controller
{
    public function store(Request $request, $apartmentId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $inquiry = Inquiry::create([
            'apartment_id' => $apartmentId,
            'full_name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'phone' => $validated['phone'],
            'buyer_id' => auth()->check() ? auth()->id() : null,
        ]);

        $apartment = Apartment::with('seller')->findOrFail($apartmentId);

        $sellerEmail = $apartment->seller->email ?? null;
        if($sellerEmail)
        {
            Mail::to($sellerEmail)->send(new BuyerInquiryMail($validated['name'], $validated['email'], $validated['phone'], $validated['message']));
        }
        return back()->with('success', 'Inquiry submitted successfully!');
    }
}
