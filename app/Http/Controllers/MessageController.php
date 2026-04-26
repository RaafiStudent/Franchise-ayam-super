<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Simpan Pesan dari Pengunjung (Public)
     */
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

    /**
     * Admin Melihat Daftar Pesan (Admin Only)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default 10 data

        $messages = Message::when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('contact', 'like', "%{$search}%") // Gunakan 'contact' sesuai migration
                      ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Admin Hapus Pesan
     */
    public function destroy($id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pesan berhasil dihapus dari sistem.');
    }
}