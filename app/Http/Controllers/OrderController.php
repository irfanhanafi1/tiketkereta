<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Tiket;
use App\Models\User;

class OrderController extends Controller
{
    // Menyimpan order baru
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',  // Pastikan user ada
            'tiket_id' => 'required|exists:tikets,id',  // Pastikan tiket ada
            'jumlah' => 'required|integer|min:1',  // Pastikan jumlah tiket valid
        ]);

        // Mengambil tiket berdasarkan tiket_id
        $tiket = Tiket::find($validated['tiket_id']);

        // Cek apakah stok tiket mencukupi
        if ($tiket->stok < $validated['jumlah']) {
            return response()->json(['message' => 'Stok tiket tidak mencukupi'], 400);
        }

        // Mengurangi stok tiket
        $tiket->stok -= $validated['jumlah'];
        $tiket->save();

        // Membuat order baru
        $order = Order::create([
            'user_id' => $validated['user_id'],
            'tiket_id' => $validated['tiket_id'],
            'jumlah' => $validated['jumlah'],
        ]);

        // Mengembalikan respons sukses
        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    // Menampilkan daftar order
    public function index()
    {
        $orders = Order::with('user', 'tiket')->get();  // Mengambil semua order beserta relasi user dan tiket
        return response()->json($orders);
    }
}