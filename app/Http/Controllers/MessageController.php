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
    public function index()
    {
        $messages = Message::latest()->paginate(10);
        return view('admin.messages.index', compact('messages'));
    }

    // 3. Admin Hapus Pesan
    public function destroy($id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pesan dihapus.');
    }
}