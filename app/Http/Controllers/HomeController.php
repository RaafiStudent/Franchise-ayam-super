<?php

namespace App\Http\Controllers;

use App\Models\Menu; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    // FUNGSI LIKE (LOGIKA SAKLAR & ON/OFF)
    public function toggleLove($id)
    {
        $menu = Menu::findOrFail($id);
        $likedMenus = Session::get('liked_menus', []);
        $dislikedMenus = Session::get('disliked_menus', []);

        // SKENARIO 1: SUDAH LIKE -> MAU UN-LIKE (CANCEL)
        if (in_array($id, $likedMenus)) {
            $menu->decrement('loves');
            // Hapus dari session
            $likedMenus = array_diff($likedMenus, [$id]);
            Session::put('liked_menus', $likedMenus);
        } 
        // SKENARIO 2: BELUM LIKE -> MAU LIKE
        else {
            // Cek dulu, apakah dia lagi Dislike? Kalau iya, matikan Dislike-nya (Switching)
            if (in_array($id, $dislikedMenus)) {
                $menu->decrement('dislikes');
                $dislikedMenus = array_diff($dislikedMenus, [$id]);
                Session::put('disliked_menus', $dislikedMenus);
            }

            // Baru tambahkan Like
            $menu->increment('loves');
            Session::push('liked_menus', $id);
        }

        // PENTING: Refresh data dari database agar angka yang dikirim ke JS akurat
        // Tanpa ini, hitungan rating di JS bakal ngaco
        $menu->refresh(); 

        return response()->json([
            'success' => true,
            'likes' => $menu->loves,
            'dislikes' => $menu->dislikes,
            // Kirim status terbaru (apakah sekarang sedang dilike atau tidak)
            'is_liked' => in_array($id, Session::get('liked_menus', [])),
            'is_disliked' => false // Karena kalau masuk sini, pasti dislike mati
        ]);
    }

    // FUNGSI DISLIKE (LOGIKA SAKLAR & ON/OFF)
    public function toggleDislike($id)
    {
        $menu = Menu::findOrFail($id);
        $likedMenus = Session::get('liked_menus', []);
        $dislikedMenus = Session::get('disliked_menus', []);

        // SKENARIO 1: SUDAH DISLIKE -> MAU UN-DISLIKE (CANCEL)
        if (in_array($id, $dislikedMenus)) {
            $menu->decrement('dislikes');
            $dislikedMenus = array_diff($dislikedMenus, [$id]);
            Session::put('disliked_menus', $dislikedMenus);
        } 
        // SKENARIO 2: BELUM DISLIKE -> MAU DISLIKE
        else {
            // Cek dulu, apakah dia lagi Like? Kalau iya, matikan Like-nya (Switching)
            if (in_array($id, $likedMenus)) {
                $menu->decrement('loves');
                $likedMenus = array_diff($likedMenus, [$id]);
                Session::put('liked_menus', $likedMenus);
            }

            // Baru tambahkan Dislike
            $menu->increment('dislikes');
            Session::push('disliked_menus', $id);
        }

        // PENTING: Refresh data
        $menu->refresh();

        return response()->json([
            'success' => true,
            'likes' => $menu->loves,
            'dislikes' => $menu->dislikes,
            'is_liked' => false, // Karena kalau masuk sini, pasti like mati
            'is_disliked' => in_array($id, Session::get('disliked_menus', []))
        ]);
    }
}