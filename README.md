# 🛒 MukitCell POS - Point of Sale System

Sistem Point of Sale (POS) modern untuk konter HP, dibangun dengan Laravel 12 dan Tailwind CSS.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=flat-square&logo=tailwind-css)

## ✨ Fitur

| Fitur | Deskripsi |
|-------|-----------|
| 📊 **Dashboard** | Statistik penjualan, transaksi terbaru, stok rendah |
| 🛒 **POS** | Interface kasir intuitif dengan pencarian real-time |
| 📦 **Produk** | CRUD produk dengan kategori dan status aktif/nonaktif |
| 💳 **Transaksi** | Riwayat lengkap dengan filter tanggal |
| 📈 **Laporan** | Laporan harian/mingguan/bulanan dengan grafik |
| 📁 **Arsip** | Arsip transaksi lama dengan restore |
| ⚙️ **Pengaturan** | Kategori, metode pembayaran, dan pengguna |

---

## 🚀 Instalasi

### 1. Clone & Install

```bash
git clone <repository-url>
cd kasir-pos
composer install
npm install
```

### 2. Konfigurasi

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_DATABASE=kasir_pos
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Database & Seed

```bash
php artisan migrate:fresh --seed
```

### 4. Build & Run

```bash
npm run build
php artisan serve
```

Akses di `http://127.0.0.1:8000`

---

## 👤 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@konter.com | password |
| Kasir | budi@konter.com | password |
| Kasir | siti@konter.com | password |
| Kasir | andi@konter.com | password |

---

## 🗄️ Database Schema

```
users ──────┬──< transactions ──< transaction_items >──── products
            │                         │                      │
categories ─┴───────────────────------┘                      │
                                                             │
payment_methods ──< transactions                             │
                                                             │
archived_transactions ──< archived_transaction_items        ─┘
```

### Tabel Utama
- `users` - Admin & Kasir
- `categories` - Kategori produk
- `products` - Produk dengan stok
- `payment_methods` - Metode pembayaran
- `transactions` - Transaksi penjualan
- `transaction_items` - Detail item transaksi
- `archived_transactions` - Arsip transaksi lama

---

## 👥 Peran Pengguna

| Fitur | Admin | Kasir |
|-------|:-----:|:-----:|
| Dashboard | ✅ | ✅ |
| POS | ✅ | ✅ |
| Produk | ✅ | ❌ |
| Transaksi | ✅ | ❌ |
| Laporan | ✅ | ❌ |
| Arsip | ✅ | ❌ |
| Pengaturan | ✅ | ❌ |

---

## 🛠️ Troubleshooting

```bash
# Clear cache
php artisan config:clear && php artisan cache:clear

# Rebuild assets
npm run build

# Reload autoload
composer dump-autoload
```

---

## 📄 Lisensi

[MIT License](https://opensource.org/licenses/MIT)
