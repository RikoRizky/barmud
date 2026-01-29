<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Kedai Barmud</title>
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

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            transition: all 0.3s;
        }

        .navbar a:hover {
            background: rgba(255,255,255,0.3);
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .form-card h2 {
            color: #5d4037;
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 26px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #5d4037;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 14px;
            border: 2px solid #d7ccc8;
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Segoe UI', sans-serif;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #5d4037;
            box-shadow: 0 0 0 3px rgba(93, 64, 55, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #2196f3;
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: #1976d2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
        }

        .btn-secondary {
            background: #999;
            color: white;
        }

        .btn-secondary:hover {
            background: #777;
        }

        .helper-text {
            font-size: 13px;
            color: #999;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🥛 Kedai Barmud - Edit Menu</h1>
        <a href="{{ route('admin.dashboard') }}">← Kembali</a>
    </nav>

    <div class="container">
        <div class="form-card">
            <h2>Edit Menu: {{ $item->name }}</h2>

            @if ($errors->any())
                <div class="error">
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.items.update', $item) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Nama Menu *</label>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}" placeholder="Contoh: Susu Cokelat" required>
                    <p class="helper-text">Masukkan nama menu yang akan ditampilkan</p>
                </div>

                <div class="form-group">
                    <label>Gambar Menu</label>
                    @if($item->image)
                        <div class="current-image">
                            <p style="margin: 0 0 5px 0; font-size: 13px; color: #666;">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*">
                    <p class="helper-text">Upload gambar baru untuk mengganti gambar lama (opsional, max 2MB)</p>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" placeholder="Deskripsi menu (opsional)">{{ old('description', $item->description) }}</textarea>
                    <p class="helper-text">Tambahkan deskripsi singkat tentang menu (opsional)</p>
                </div>

                <div class="form-group">
                    <label>Harga *</label>
                    <input type="number" name="price" value="{{ old('price', $item->price) }}" placeholder="14000" required min="0" step="1000">
                    <p class="helper-text">Masukkan harga dalam Rupiah (tanpa titik atau koma)</p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Update Menu</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>