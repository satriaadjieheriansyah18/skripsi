<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Session;


class AdminOrderController extends Controller
{
    public function fetchOrders(Request $request)
{

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

    $query = Order::orderBy('created_at', $dateSort);

    if ($request->has('month') && !empty($request->month)) {
        $query->whereMonth('created_at', $request->month);
    }

    if ($request->has('year') && !empty($request->year)) {
        $query->whereYear('created_at', $request->year);
    }

    $orders = $query->paginate(20);

    if ($request->ajax()) {
        $html = '';
        foreach ($orders as $order) {
            $html .= view('admin.order_row', compact('order'))->render();
        }

        return response()->json([
            'tbody' => $html,
            'pagination' => $orders->links()->render()
        ]);
    }

    // Kirim juga month dan year ke view supaya bisa dipakai default value filter di Blade
    $month = $request->month ?? null;
    $year = $request->year ?? null;

    return view('admin.dashboard', compact('orders', 'month', 'year'));
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
