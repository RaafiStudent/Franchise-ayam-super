<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // 1. Simpan Pesan dari Pengunjung (Public)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create($request->all());

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Terima kasih.');
    }

    // 2. Admin Melihat Daftar Pesan (Admin Only)
    public function index(Request $request)
{
    $search = $request->input('search');
    $perPage = $request->input('per_page', 10);

    $messages = \App\Models\Message::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         // UBAH DISINI: dari 'email' jadi 'contact' sesuai migration kamu
                         ->orWhere('contact', 'like', "%{$search}%") 
                         ->orWhere('message', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate($perPage)
        ->withQueryString();

    return view('admin.messages.index', compact('messages'));
}

    // 3. Admin Hapus Pesan
    public function destroy($id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pesan dihapus.');
    }
}