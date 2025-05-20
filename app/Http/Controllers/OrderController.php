<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;


class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi
            $validated = $request->validate([
                'nama' => 'required|string',
                'no_telp' => 'required|string',
                'alamat' => 'required|string',
                'maps_link' => 'nullable|string',
                'qty' => 'required|integer',
                'total' => 'required|integer',
                'status' => 'required|string',
                'product' => 'required|string',
                'user_id' => 'required|integer',
                'bukti_transfer' => 'required|image', // Validasi bukti transfer (gambar)
            ]);


            // Mengupload bukti transfer
            $imagePath = $request->file('bukti_transfer')->store('bukti_transfer', 'public'); // Simpan ke storage/bukti_transfer

            // Membuat pesanan baru
            $order = new Order();
            $order->nama = $validated['nama'];
            $order->no_telp = $validated['no_telp'];
            $order->alamat = $validated['alamat'];
            $order->maps_link = $validated['maps_link'] ?? null;
            $order->qty = $validated['qty'];
            $order->total = $validated['total'];
            $order->status = $validated['status'];
            $order->product = $validated['product'];
            $order->user_id = $validated['user_id'];
            $order->bukti_transfer = $imagePath; // Simpan path bukti transfer
            $order->order_time = now(); // Tanggal pemesanan saat ini

            $order->save();


            return response()->json($order, 201); // Mengembalikan data order yang baru dibuat
        } catch (\Exception $e) {
        \Log::error('Order creation failed: ', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);  // Response error
    }
    }

    public function index(Request $request)
    {
        $userId = $request->query('user_id');

        $orders = Order::where('user_id', $userId)
                       ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan tanggal pesanan
                       ->get()
                       ->map(function ($order) {
                           return [
                               'id' => $order->id,
                               'nama' => $order->nama,
                               'no_telp' => $order->no_telp,
                               'alamat' => $order->alamat,
                               'maps_link' => $order->maps_link,
                               'qty' => $order->qty,
                               'total' => $order->total,
                               'status' => $order->status,
                               'product' => $order->product,
                               'order_time' => $order->created_at->format('d M Y'),
                               'bukti_transfer' => Storage::url($order->bukti_transfer), // URL bukti transfer
                           ];
                       });

        return response()->json($orders);
    }
}
