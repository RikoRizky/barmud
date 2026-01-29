<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kedai Barmud | Susu Murni Premium</title>
  <link rel="stylesheet" href="style.css">
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
}
.navbar nav a {
  margin-left: 20px;
  color: white;
  text-decoration: none;
  font-weight: 500;
}

/* Hero */
.hero {
  height: 80vh;
  background: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)),
              url('https://images.unsplash.com/photo-1580910051074-7b7d8c8f44c2');
  background-size: cover;
  background-position: center;
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 20px;
}

.hero button {
  margin-top: 20px;
  padding: 14px 30px;
  background: #25D366;
  border: none;
  border-radius: 30px;
  color: white;
  font-size: 16px;
  cursor: pointer;
}

.section {
  max-width: 1100px;
  margin: auto;
  padding: 60px 20px;
}

.produk {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 25px;
}

.card {
  background: white;
  padding: 25px;
  border-radius: 15px;
  text-align: center;
  box-shadow: 0 10px 25px rgba(0,0,0,.08);
  transition: transform .3s;
  width: 280px;
}

.card img {
  width: 100%;
  height: 170px;
  object-fit: cover;
  border-radius: 12px;
  margin-bottom: 15px;
}
.card:hover {
  transform: translateY(-8px);
}

.card button {
  margin-top: 15px;
  padding: 10px 20px;
  background: #5d4037;
  color: white;
  border: none;
  border-radius: 20px;
  cursor: pointer;
}

.wa-float {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background: #25D366;
  color: white;
  font-size: 28px;
  width: 55px;
  height: 55px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  box-shadow: 0 8px 20px rgba(0,0,0,.3);
}


footer {
  background: #5d4037;
  color: white;
  text-align: center;
  padding: 3px;
}
  </style>
</head>
<body>

  <header class="navbar">
    <h1>Kedai Barmud</h1>
    <nav>
      <a href="#tentang">Tentang</a>
      <a href="#produk">Produk</a>
      <a href="#kontak">Kontak</a>
      <a href="{{ route('admin.login') }}" style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px;">🔐 Owner</a>
    </nav>
  </header>

  <section id="tentang" class="section">
    <h2>Tentang Kami</h2>
    <p>
     <strong>
         Barmud sendiri adalah singkatan dari "Barokah Mudah" karena kami tidak hanya ingin sukses, tetapi kami juga ingin tempat ini memiliki keberkahan tentunya untuk semua orang, khususnya orang di sekitar. Selain itu, alasan kami menyediakan menu hanya susu murni karena kami ingin menyediakan kumpulan atau tempat berkumpul yang baik dan sehat.
      Maka dari itu pihak kami hanya menyediakan menu susu murni dengan berbagai macam rasa yang tentunya selain enak juga menyehatkan tubuh.
     </strong>
    </p>
  </section>

<section id="produk" class="section">
    <h2>Menu Kami</h2>
    <div class="produk">
      @forelse($items as $item)
      <div class="card">
        <h3>{{ $item->name }}</h3>
        @if($item->image)
          <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
        @else
          <img src="{{ asset('images/ori.jpeg') }}" alt="{{ $item->name }}">
        @endif
        <p>Rp {{ number_format($item->price, 0, ',', '.') }}</p>
        <button onclick="pesanWhatsApp('{{ $item->name }}', {{ $item->price }})">Pesan</button>
      </div>
      @empty
      <p style="text-align: center; width: 100%; color: #999;">Belum ada menu tersedia</p>
      @endforelse
    </div>
</section>

  

  <section id="kontak" class="section">
    <h2>Kontak</h2>
    <p>📍 Jl. Cilengkrang II</p>
    <p>📞 08987489968</p>
  </section>

  
  <a class="wa-float" onclick="pesanWhatsApp()">
    💬
  </a>

  <footer>
    <p>Thanks for coming to Kedai Barmud</p>
    <p>See you later</p>
  </footer>

  <script src="script.js"></script>
  <script>
    function pesanWhatsApp(produk = "", harga = "") {
  const nomor = "08987489968";
  let pesan = "Halo Kedai Barmud, saya ingin memesan";

  if (produk) {
    pesan += " " + produk;
    if (harga) {
      pesan += " (Rp " + harga.toLocaleString('id-ID') + ")";
    }
  } 

  const url = `https://wa.me/${nomor}?text=${encodeURIComponent(pesan)}`;
  window.open(url, "_blank");
}

  </script>
</body>
</html>
