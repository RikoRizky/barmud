# Deployment Laravel ke Vercel

## Persiapan Awal

### 1. Install Dependencies
```bash
composer install
npm install
npm run build
```

### 2. Generate APP_KEY
Jika belum ada APP_KEY di `.env.production`, generate dengan:
```bash
php artisan key:generate --show
```
Copy hasil generate ke `APP_KEY` di `.env.production`

---

## Database untuk Vercel

Vercel adalah platform serverless, jadi tidak mendukung MySQL persistent. Gunakan salah satu layanan berikut:

### Opsi A: Railway (Disarankan)
1. Buat akun di https://railway.app
2. Buat MySQL database baru
3. Copy credentials ke `.env.production`:
   ```
   DB_HOST=your-db-host.railway.app
   DB_PORT=3306
   DB_DATABASE=railway
   DB_USERNAME=root
   DB_PASSWORD=your-password
   ```

### Opsi B: PlanetScale (MySQL-compatible)
1. Buat akun di https://planetscale.com
2. Buat database baru
3. Install CLI: `brew install planetscale/tap/pscale`
4. Connect database ke aplikasi

### Opsi C: Neon (PostgreSQL)
1. Buat akun di https://neon.tech
2. Buat PostgreSQL database
3. Convert app ke PostgreSQL atau gunakan Neon's MySQL

---

## Setup Environment Variables di Vercel

1. Buka https://vercel.com
2. Import project dari GitHub/GitLab
3. Di Settings → Environment Variables, tambahkan:
   ```
   APP_NAME=Laravel App
   APP_ENV=production
   APP_KEY=base64:4x3jtRbZS/HfUkootvE1cj9OKEa2H6lsTJUCnDKU74s=
   APP_DEBUG=true
   APP_URL=https://your-project.vercel.app
   
   DB_CONNECTION=mysql
   DB_HOST=xxx.railway.app
   DB_PORT=3306
   DB_DATABASE=railway
   DB_USERNAME=root
   DB_PASSWORD=xxx
   
   CACHE_DRIVER=file
   SESSION_DRIVER=file
   QUEUE_CONNECTION=sync
   ```

---

## Deployment Steps

### Cara 1: Deploy via Git (Recommended)

```bash
# 1. Push project ke GitHub
git add .
git commit -m "Add Vercel configuration"
git push origin main

# 2. Import ke Vercel
# Buka vercel.com → Add New → Project → Import dari GitHub
```

### Cara 2: Deploy via Vercel CLI

```bash
# 1. Install Vercel CLI
npm i -g vercel

# 2. Login
vercel login

# 3. Deploy
vercel --prod
```

---

## Konfigurasi File

File yang sudah dibuat:
- `vercel.json` - Konfigurasi build dan routes Vercel
- `api/index.php` - Entry point untuk serverless functions
- `bootstrap/app.php` - Fixed untuk Vercel environment
- `public/index.php` - Support untuk Vercel environment
- `.env.production` - Template environment variables

---

## Troubleshooting

### Error: "No such file or directory" saat build
Pastikan `vendor` sudah terinstall dan di-commit:
```bash
git add vendor
git commit -m "Add vendor directory"
```

### Error: Database Connection Failed
1. Pastikan credentials MySQL sudah benar di Environment Variables
2. Cek apakah database sudah di-setup (migration + seeder)

### Error: 404 pada assets (CSS/JS)
Pastikan sudah run `npm run build` dan asset di-commit:
```bash
npm run build
git add public/css public/js
git commit -m "Add compiled assets"
```

### Error: "The Mix manifest does not exist"
Assets belum di-compile. Jalankan:
```bash
npm run build
```

---

## Catatan Penting

1. **Static Assets**: Untuk performa optimal, gambar dan file statis disimpan di `public/` dan di-commit ke repo.

2. **Database Migration**: Jalankan migration setelah deploy:
   ```bash
   vercel exec php artisan migrate --force
   ```

3. **Storage**: Jika perlu upload file, gunakan Vercel Blob atau external storage (AWS S3, Cloudinary).

4. **Session & Cache**: Untuk production, gunakan Redis. Tambahkan Redis credentials ke environment variables.

---

## Commands Berguna

```bash
# Build assets
npm run build

# Generate key
php artisan key:generate

# Run migration
php artisan migrate

# Seed database
php artisan db:seed

# Local development
php artisan serve
```

---

## Demo URL
Setelah deploy, akses aplikasi di: `https://your-project.vercel.app`

- Halaman Utama: `/`
- Admin Dashboard: `/admin/dashboard`
- Admin Login: `/admin/login`

