<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Session;


class AdminOrderController extends Controller
{
    public function fetchOrders(Request $request)
{
    \Log::info('Month: ' . $request->input('month'));
    \Log::info('Year: ' . $request->input('year'));
    \Log::info('Date sort: ' . $request->input('date_sort'));


    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $dateSort = $request->input('date_sort', 'desc');

    $orders = Order::whereMonth('created_at', $month)
                   ->whereYear('created_at', $year)
                   ->orderBy('created_at', $dateSort)
                   ->get();


    return response()->json($orders);
}



    
    public function index(Request $request)
{

    if (!Session::has('admin_id')) {
        return redirect()->route('admin.login');
    }
    
    $dateSort = $request->input('date_sort', 'desc');

    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));

    // Filter pesanan berdasarkan bulan dan tahun
    $orders = Order::whereMonth('created_at', $month)
                   ->whereYear('created_at', $year)
                   ->orderBy('created_at', $dateSort)
                   ->paginate(20);

        if ($request->ajax()) {
        $html = '';
        foreach ($orders as $order) {
            $html .= view('admin.order_row', compact('order'))->render();
        }

        return response()->json([
            'orders' => $orders,  // Mengirim data pesanan dalam JSON
            'pagination' => $orders->links()->render()  // Update pagination
        ]);
    }
    return view('admin.dashboard', compact('orders'));
}


    public function updateStatus(Request $request, $id)
    {
         
        $request->validate([
            'status' => 'required|in:sedang diproses,sedang diantar,selesai'
        ]);
        $order = \App\Models\Order::findOrFail($id);


        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
