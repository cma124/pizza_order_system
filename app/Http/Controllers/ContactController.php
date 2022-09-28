<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Direct Contact Page
    public function show() {
        $carts = Cart::where('user_id', auth()->id())->get();
        $orders = Order::where('user_id', auth()->id())->get();

        return view('user.main.contact', compact('carts', 'orders'));
    }

    // Store Contact Info
    public function store(Request $request) {
        $validated = $request->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);

        $validated['user_id'] = auth()->id();
        Contact::create($validated);

        return back()->with('sendSuccess', 'Your message has been sent successfully.');
    }

    // Show All Message
    public function list() {
        $messages = Contact::select('contacts.*', 'users.name as user_name', 'users.email as user_email')
            ->leftJoin('users', 'contacts.user_id', 'users.id')
            ->when(request('searchKey'), function($query) {
                $query->orWhere('users.name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('users.email', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('contacts.subject', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('contacts.message', 'like', '%' . request('searchKey') . '%');
            })
            ->paginate(4);
        return view('admin.contact.list', compact('messages'));
    }

    // Detail Message
    public function detail($id) {
        $message = Contact::select('contacts.*', 'users.name as user_name', 'users.email as user_email')
            ->leftJoin('users', 'contacts.user_id', 'users.id')
            ->where('contacts.id', $id)
            ->first();
        return view('admin.contact.detail', compact('message'));
    }

    // Delete Message
    public function delete($id) {
        Contact::find($id)->delete();
        return back()->with('message', 'Message has been deleted successfully.');
    }
}
