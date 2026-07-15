# API Perpustakaan — Sistem Informasi Manajemen Perpustakaan

RESTful API untuk sistem manajemen perpustakaan modern berbasis **Laravel 11** dengan fitur sirkulasi buku, reservasi, denda terstruktur, dan otorisasi multi-role.

## Fitur Unggulan

| Fitur | Detail |
|---|---|
| **14 Tabel Relasional** | Normalisasi 3NF, migrasi + foreign key lengkap |
| **61 Endpoint RESTful** | 12 modul (Auth, Master Data, Sirkulasi, Denda) |
| **RBAC Multi-Level** | Admin, Petugas, Anggota — middleware `CheckRole` |
| **Database Transaction** | Atomic multi-tabel untuk peminjaman, pengembalian, pembayaran |
| **Pessimistic Locking** | `lockForUpdate()` pada stok & transaksi — anti race condition |
| **Eager Loading** | `with()` di seluruh endpoint index/show — anti N+1 |
| **Feature Test** | 10 skenario bisnis (peminjaman, pengembalian, denda) |
| **Audit Trail Denda** | Riwayat perubahan status + pembayaran parsial |

## Tech Stack

| Komponen | Teknologi |
|---|---|
| Framework | Laravel 11.x |
| Bahasa | PHP 8.2+ |
| Database | MySQL 8.0+ |
| Auth API | Laravel Sanctum (Bearer Token) |
| ORM | Eloquent |
| Testing | PHPUnit 11 |

## Struktur Tabel

```
kategoris → bukus ← penerbits
                     ↑
                    raks
                     │
anggotas → peminjamans → detail_peminjamans → pengembalians → dendas
              ↑                                         ↑        │
           petugas                                   petugas    ├→ pembayaran_dendas
                                                                 └→ riwayat_status_dendas
reservasis (anggota ↔ buku)
```

## Instalasi

```bash
composer install
copy .env.example .env
# edit .env — sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Server berjalan di `http://localhost:8000`.

## Akun Default

| Role | Email | Password |
|---|---|---|
| Admin | `admin@perpustakaan.com` | `password` |
| Petugas | — | — |

Login: `POST /api/login` dengan body `{ "email": "...", "password": "..." }`.

## Menjalankan Test

```bash
php artisan test
```

Seluruh **15 file test** (1 BisnisFlow + 14 Controller test) lulus.

## Dokumentasi API

| File | Format |
|---|---|
| `docs/dokumentasi-api-perpustakaan.html` | HTML interaktif |
| `docs/LAPORAN.md` | Markdown |
| `docs/laporan-singkat.pdf` | Laporan singkat (PDF, max 5 hlm) |
| `docs/perpustakaan.drawio.png` | ERD |

## Endpoint per Modul

| Modul | Jumlah | Akses |
|---|---|---|
| Auth | 4 | Publik / Authenticated |
| Kategori | 5 | Admin, Petugas |
| Penerbit | 5 | Admin, Petugas |
| Rak | 5 | Admin, Petugas |
| Anggota | 6 | Admin, Petugas |
| Petugas | 5 | Admin, Petugas |
| Buku | 6 | All (lihat) / Admin, Petugas (kelola) |
| Peminjaman | 5 | Admin, Petugas |
| Pengembalian | 3 | Admin, Petugas |
| Reservasi | 7 | Admin, Petugas |
| Denda & Pembayaran | 10 | Admin, Petugas |

---
Dibuat untuk UAS Basis Data Lanjut — TIF 2024 A — UNIROW
