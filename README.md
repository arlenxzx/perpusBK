# Sistem Informasi Perpustakaan

Aplikasi web sederhana untuk mengelola data buku, pengguna, dan transaksi peminjaman buku.

## Fitur

* Login dan autentikasi pengguna
* CRUD data buku
* CRUD data pengguna
* Peminjaman buku
* Pengembalian buku
* Pengelolaan stok buku
* Status transaksi peminjaman

## Teknologi

* Laravel
* PHP
* SQLite
* Bootstrap
* jQuery
* AJAX
* SweetAlert

## Instalasi

Clone repository:

```bash
git clone <url-repository>
cd <nama-folder>
```

Install dependency:

```bash
composer install
```

Copy file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Jalankan migration:

```bash
php artisan migrate
```

Jalankan aplikasi:

```bash
php artisan serve
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

## Struktur Fitur

### Buku

Digunakan untuk mengelola data buku seperti judul, penulis, kategori, deskripsi, dan stok.

### User

Digunakan untuk mengelola data pengguna dan role pengguna.

### Transaksi

Digunakan untuk mencatat peminjaman dan pengembalian buku serta mengatur stok secara otomatis.

## Catatan

Pastikan konfigurasi database pada file `.env` sudah sesuai sebelum menjalankan migration.

---

**Project Sistem Informasi Perpustakaan**
Dibangun menggunakan Laravel untuk kebutuhan pembelajaran dan pengembangan aplikasi web.
