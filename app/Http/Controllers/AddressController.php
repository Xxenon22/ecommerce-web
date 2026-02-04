<?php

namespace App\Http\Controllers;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string',
            'phone' => 'required|string',
            'address_detail' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address_detail' => $request->address_detail,
            'district' => $request->district,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'is_default' => Auth::user()->addresses()->count() === 0, // alamat pertama otomatis default
        ]);

        return redirect()->back()->with('success', 'Address added successfully');
    }

    public function update(Request $request, Address $address)
    {
        // 🔐 pastikan address milik user
        abort_if($address->user_id !== Auth::id(), 403);

        $request->validate([
            'recipient_name' => 'required|string',
            'phone' => 'required|string',
            'address_detail' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        $address->update($request->all());

        return back()->with('success', 'Address updated successfully');
    }

    public function destroy(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        $address->delete();

        return back()->with('success', 'Address deleted successfully');
    }

}

