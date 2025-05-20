{{-- resources/views/admin/order_row.blade.php --}}
<tr>
  <td>{{ $order->nama }}</td>
  <td>{{ $order->no_telp }}</td>
  <td>{{ $order->alamat }}</td>
  <td><a href="{{ $order->maps_link }}" target="_blank">Lihat Maps</a></td>
  <td>{{ $order->qty }}</td>
  <td>Rp.{{ number_format($order->total, 0, ',', '.') }}</td>
  <td>{{ $order->created_at->format('d M Y') }}</td>
  <td><a href="{{ Storage::url($order->bukti_transfer) }}" target="_blank">Lihat Bukti Transfer</a></td>
  <td>
    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="status-form">
      @csrf
      @method('PUT')
      <select name="status" onchange="this.form.submit()">
        <option value="sedang diproses" {{ $order->status == 'sedang diproses' ? 'selected' : '' }}>Diproses</option>
        <option value="sedang diantar" {{ $order->status == 'sedang diantar' ? 'selected' : '' }}>Diantar</option>
        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
      </select>
    </form>
  </td>
</tr>
