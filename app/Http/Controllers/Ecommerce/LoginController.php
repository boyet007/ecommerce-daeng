<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        if (Auth::guard('customer')->check()) return redirect(route('customer.dashboard'));
        return view('ecommerce.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|string'
        ]);

        $auth = $request->only('email', 'password');
        $auth['status'] = 1;
        if (Auth::guard('customer')->attempt($auth)) {
            return redirect()->intended(route('customer.dashboard'));
        }
        return redirect()->back()->with(['error' => 'Email / Password Salah']);
    }

    public function dashboard()
    {
        $orders = Order::selectRaw('COALESCE(sum(CASE WHEN status = 0 THEN subtotal END), 0) as pending,
        COALESCE(count(CASE WHEN status = 3 THEN subtotal END), 0) as shipping,
        COALESCE(count(CASE WHEN status = 4 THEN subtotal END), 0) as completeOrder')
            ->where('customer_id', auth()->guard('customer')->user()->id)->get();

        return view('ecommerce.dashboard', compact('orders'));
    }

    public function logout()
    {
        Auth::guard('customer')->logout(); //JADI KITA LOGOUT SESSION DARI GUARD CUSTOMER
        return redirect(route('customer.login'));
    }
}
