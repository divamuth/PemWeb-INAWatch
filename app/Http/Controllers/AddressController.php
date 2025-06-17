<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddressController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $addresses = Auth::user()->addresses;
        return view('user.address', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'post' => 'required|numeric',
        ]);

        Auth::user()->addresses()->create($request->all());

        return redirect()->back()->with('success', 'Address added.');
    }

    public function update(Request $request, Address $address)
    {

        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'post' => 'required|numeric',
        ]);

        $address->update($request->all());

        return redirect()->back()->with('success', 'Address updated.');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return redirect()->back()->with('success', 'Address deleted.');
    }
}
