<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Kedai Barmud</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #fafafa;
            color: #333;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: #5d4037;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            font-size: 14px;
        }

        .btn-logout {
            padding: 10px 20px;
            background: #d32f2f;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            background: #b71c1c;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-section h2 {
            color: #5d4037;
            margin: 0;
            font-size: 28px;
        }

        .btn-add {
            padding: 12px 25px;
            background: #4caf50;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #5d4037;
            color: white;
        }

        th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f9f9f9;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn-edit {
            padding: 8px 16px;
            background: #2196f3;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-edit:hover {
            background: #1976d2;
        }

        .btn-delete {
            padding: 8px 16px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-delete:hover {
            background: #d32f2f;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state p {
            font-size: 18px;
            margin: 10px 0;
        }

        .pagination {
            margin-top: 25px;
            display: flex;
            justify-content: center;
        }

        .price {
            font-weight: 600;
            color: #5d4037;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🥛 Kedai Barmud - Admin Panel</h1>
        <div class="navbar-right">
            <span class="user-info">Admin: {{ Auth::user()->username }}</span>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="header-section">
            <h2>Manajemen Menu</h2>
            <a href="{{ route('admin.items.create') }}" class="btn-add">
                <span>+</span> Tambah Menu Baru
            </a>
        </div>

        <div class="table-container">
            @if($items->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Menu</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>{{ $item->description ?: '-' }}</td>
                            <td class="price">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.items.edit', $item) }}" class="btn-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.items.destroy', $item) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <p>📋</p>
                    <p>Belum ada menu tersedia</p>
                    <p style="font-size: 14px; color: #bbb;">Klik tombol "Tambah Menu Baru" untuk menambah menu</p>
                </div>
            @endif
        </div>

        @if($items->hasPages())
            <div class="pagination">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</body>
</html>