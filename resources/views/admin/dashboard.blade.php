<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  font-size: 16px;  
}

.pagination a,
.pagination .page-item {
  text-decoration: none;
  color: #2148d4;
  padding: 8px 16px;
  margin: 0 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: background-color 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  
}

.pagination a:hover,
.pagination .page-item:hover {
  background-color: #2148d4;
  color: white;
}

.pagination .active {
  background-color: #2148d4;
  color: white;
  font-weight: bold;
}

.pagination .disabled {
  width: 13px; /* Menyamakan ukuran kotak */
  height: 25px;
  color: #ccc;
  pointer-events: none;
}

.pagination .page-item {
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.pagination .page-link {
  padding: 10px 15px;
  display: inline-block;
}

.pagination .page-item:first-child .page-link {
  border-radius: 4px 0 0 4px;
}

.pagination .page-item:last-child .page-link {
  border-radius: 0 4px 4px 0;
}

.pagination .prev-next {
  display: flex;
  align-items: center;
}

.pagination .prev-next a {
  padding: 10px 15px;
  display: inline-block;
}

.pagination .prev-next a:hover {
  background-color: #2148d4;
  color: white;
}

@media screen and (max-width: 768px) {
  .pagination {
    flex-direction: column;
  }

  .pagination .page-item {
    margin: 5px 0;
  }
}




    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #f9f9f9;
    }

    .header {
      display: flex;
      justify-content: space-between;
      padding: 20px 40px;
      align-items: center;
      background-color: white;
    }

    .logo {
      font-size: 28px;
      font-weight: bold;
      color: #2148d4;
      text-shadow: 1px 1px 2px #aaa;
    }

    .logo span {
      color: gold;
    }

    .logout {
      font-weight: bold;
      color: orange;
      text-decoration: underline;
      cursor: pointer;
    }

    .container {
      padding: 20px 40px;
    }

    h2 {
      text-align: center;
      color: #2148d4;
      text-shadow: 1px 1px 2px #ccc;
    }

    table {
      width: 100%;
      background-color: #e4e4e4;
      border-collapse: collapse;
      border-radius: 25px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 16px;
      text-align: center;
      font-size: 16px;
      border-bottom: 1px solid #ccc;
    }

    th {
      background-color: #f3f3f3;
      font-weight: bold;
      color: #222;
      text-shadow: 1px 1px 1px #aaa;
      cursor: pointer;
    }

    th:hover {
      background-color: #f0f0f0;
    }

    select {
      padding: 8px;
      border-radius: 8px;
      border: 1px solid #ccc;
      background-color: #fff;
    }

    .status-form {
      margin: 0;
    }

    .new-order-row {
      background-color: #dff0d8; /* hijau muda sebagai contoh */
      font-weight: bold;
    }

  </style>
</head>
<body>

<div class="header">
  <div class="logo">Untirta<span>-Ku</span></div>
  <form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button type="submit" class="logout">LOGOUT</button>
  </form>
</div>

<div class="container">
  <h2>Data Pesanan Masuk</h2>

  <form style = "margin-bottom : 10px;" action="{{ route('admin.dashboard') }}" method="GET">
    <div style="display: flex; justify-content: flex-end;">
      <div>
        <label for="month">Bulan:</label>
        <select name="month" id="month">
          @for ($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}" {{ (old('month', $month ?? now()->month) == $i) ? 'selected' : '' }}>
              {{ \Carbon\Carbon::create()->month($i)->format('F') }}
            </option>
          @endfor
        </select>
      </div>

      <div style = "margin-left : 10px; margin-right : 15px;">
        <label for="year">Tahun:</label>
        <select name="year" id="year">
          @foreach (range(2020, \Carbon\Carbon::now()->year) as $y)
             <option value="{{ $y }}" {{ (old('year', $year ?? now()->year) == $y) ? 'selected' : '' }}>
                {{ $y }}
            </option>
          @endforeach
        </select>
      </div>

      <button type="submit">Filter</button>
    </div>
  </form>
  

  <table id ="ordersTable">
    <thead>
      <tr>
        <th>Nama</th>
        <th>No Telp</th>
        <th>Alamat Lengkap</th>
        <th>Link Maps Alamat</th>
        <th>Jumlah Item</th>
        <th>Total</th>
        <th id="tanggalPesanan">Tanggal Pesanan</th> <!-- Kolom Tanggal Pesanan -->
        <th>Bukti Transfer</th>
        <th>Ubah Status Pesanan</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($orders as $order)
        @php
          $isNew = $order->created_at->isToday();
        @endphp
        <tr class="{{ $isNew ? 'new-order-row' : '' }}" data-id="{{ $order->id }}">
          <td>{{ $order->nama }}</td>
          <td>{{ $order->no_telp }}</td>
          <td>{{ $order->alamat }}</td>
          <td>
              <a href="{{ $order->maps_link }}" target="_blank">
                Lihat Maps
              </a>
          </td>
          <td>{{ $order->qty }}</td>
          <td>Rp.{{ number_format($order->total, 0, ',', '.') }}</td>
          <td>{{ $order->created_at->format('d M Y') }}</td>
          <td>
            <!-- Link untuk melihat bukti transfer -->
            <a href="{{ Storage::url($order->bukti_transfer) }}" target="_blank">Lihat Bukti Transfer</a>
            <!-- Jika Anda ingin menampilkan gambar bukti transfer -->
            <!-- <img src="{{ Storage::url($order->bukti_transfer) }}" width="100" height="100" /> -->
          </td>
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
      @endforeach
    </tbody>
  </table>

  <div class="pagination">
    <div class="pagination-container">
      <!-- Previous Link -->
      @if ($orders->onFirstPage())
        <span class="disabled page-item"><span class="page-link">&lt;</span></span>
      @else
        <a href="{{ $orders->previousPageUrl() }}" class="page-item page-link">&lt;</a>
      @endif

      <!-- Pagination Links -->
      @foreach ($orders->links()->elements[0] as $page => $url)
        <a href="{{ $url }}" class="page-item {{ $page == $orders->currentPage() ? 'active' : '' }} page-link">{{ $page }}</a>
      @endforeach

      <!-- Next Link -->
      @if ($orders->hasMorePages())
        <a href="{{ $orders->nextPageUrl() }}" class="page-item page-link">&gt;</a>
      @else
        <span class="disabled page-item"><span class="page-link">&gt;</span></span>
      @endif
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/pusher-js@7.0.3/dist/web/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.js"></script>
<script>
  const storageKey = 'clickedOrderRows';

  // Ambil array ID order yang sudah diklik dari localStorage, atau buat kosong jika belum ada
  let clickedRows = JSON.parse(localStorage.getItem(storageKey)) || [];

  // Saat halaman load
  document.querySelectorAll('tbody tr.new-order-row').forEach(row => {
    const id = row.getAttribute('data-id');

    // Kalau row ini sudah diklik sebelumnya, hilangkan kelas highlight
    if (clickedRows.includes(id)) {
      row.classList.remove('new-order-row');
    }

    // Pas klik row, hilangkan highlight dan simpan ID ke localStorage
    row.addEventListener('click', () => {
      row.classList.remove('new-order-row');
      if (!clickedRows.includes(id)) {
        clickedRows.push(id);
        localStorage.setItem(storageKey, JSON.stringify(clickedRows));
      }
    });
  });
</script>


</body>
</html>