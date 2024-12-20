<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Order;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index()
    {
        return response()->json(Tiket::with('kereta')->get());
    }
    public function pesan(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tiket_id' => 'required|exists:tikets,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $tiket = Tiket::find($validated['tiket_id']);

        if ($tiket->stok < $validated['jumlah']) {
            return response()->json(['message' => 'Stok tidak cukup'], 400);
        }

        // Kurangi stok tiket
        $tiket->stok -= $validated['jumlah'];
        $tiket->save();

        // Simpan order
        $order = Order::create($validated);

        return response()->json(['order' => $order, 'message' => 'Pesanan berhasil'], 201);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kereta_id' => 'required|exists:keretas,id',
            'stok' => 'required|integer|min:1',
        ]);
    
        $tiket = Tiket::create($validated);
    
        return response()->json([
            'message' => 'Tiket berhasil ditambahkan',
            'data' => $tiket,
        ], 201);
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'tiket_id' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);
        try {
            // Simpan order ke database
            $order = Order::create($validated);
            return response()->json(['message' => 'Order berhasil ditambahkan', 'data' => $order], 201);
        } catch (\Exception $e) {
            // Jika ada error, tampilkan pesan error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    
        $order = Order::create($validated);
    
        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tiket = Tiket::with('kereta')->find($id);

    if (!$tiket) {
        return response()->json(['message' => 'Tiket tidak ditemukan'], 404);
    }

    return response()->json($tiket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tiket = Tiket::find($id);

    if (!$tiket) {
        return response()->json(['message' => 'Tiket tidak ditemukan'], 404);
    }

    $tiket->delete();

    return response()->json(['message' => 'Tiket berhasil dihapus']);
    }
}
