# Website Kecamatan Borea

Tugas kuliah — Website informasi **Kecamatan Borea** dengan tiga desa di bawahnya: **Hainan, Joreu, dan Kartula**.

Dibuat menggunakan **Laravel 10**, autentikasi **Laravel Breeze** (Blade), database **MySQL**, dan front-end **Tailwind CSS** + **Chart.js**.

---

## ✨ Fitur

### Halaman Publik
- **Landing Kecamatan** (`/borea`) — sambutan, rekap gabungan, kartu tiga desa, berita terbaru.
- **Beranda Desa** (`/borea/{desa}`) — sambutan, ringkasan angka, 3 berita terbaru, 6 kartu menu.
- **Profil** — sejarah, letak geografis, statistik warga (KK, jenis kelamin, kelompok usia) dengan grafik batang, ringkasan keuangan.
- **Kontak** — alamat, telepon, jam layanan, Google Maps, form aspirasi via WhatsApp.
- **Laporan Keuangan** — tabel + grafik batang pemasukan/pengeluaran.
- **Berita** — daftar dan detail berita per desa.
- **UMKM** — daftar dan detail UMKM.
- **Wisata** — daftar dan detail wisata.

### Autentikasi
- Registrasi (nama, nama akun, email, password)
- Login, logout
- Dua peran: `admin` dan `warga`

### Komentar
- Warga bisa berkomentar di detail UMKM dan Wisata
- Popup login jika belum masuk
- Pemilik bisa menghapus komentarnya sendiri
- Admin desa bisa menghapus komentar di desanya
- Admin kecamatan bisa menghapus komentar di semua desa

### Panel Admin (`/admin`)
- **Dashboard** — jumlah UMKM, wisata, berita, komentar terbaru
- **UMKM & Wisata** — tambah, ubah, nonaktifkan, upload satu foto
- **Berita** — CRUD
- **Laporan Keuangan** — tambah periode, pemasukan, pengeluaran, status draf/dipublikasikan. Saldo dihitung otomatis.
- **Data Warga** — jumlah KK, laki-laki, perempuan, 3 kelompok usia per desa
- **Moderasi Komentar** — daftar dan hapus

---

## 🛠️ Teknologi

| Komponen | Pilihan |
|---|---|
| Framework | Laravel 10 |
| PHP | 8.1+ |
| Autentikasi | Laravel Breeze (Blade) |
| Database | MySQL |
| Front-end | Blade + Tailwind CSS |
| Build Tool | Vite |
| Grafik | Chart.js (CDN) |

---

## 📦 Persyaratan Sistem

- **PHP 8.1+** (ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`)
- **Composer 2.x** — [getcomposer.org](https://getcomposer.org)
- **Node.js 16+** & **npm** — [nodejs.org](https://nodejs.org)
- **MySQL 5.7+** atau **MariaDB 10.3+**

> 💡 **Rekomendasi:** Gunakan [Laragon](https://laragon.org/download/) (Windows) — sudah termasuk PHP, MySQL, Composer, Node.js sekaligus.

---

## 🚀 Cara Install & Jalankan

### 1. Clone repository
```bash
git clone https://github.com/USERNAME/website-kecamatan-borea.git
cd website-kecamatan-borea