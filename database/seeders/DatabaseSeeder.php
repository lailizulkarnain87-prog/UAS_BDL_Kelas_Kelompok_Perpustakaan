<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ─── 1. Sanctum User (Admin) ────────────────────────────────
        $user = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@perpustakaan.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Generate a Sanctum token for testing
        $token = $user->createToken('admin-api-token');
        $this->command->info('Sanctum Token: ' . $token->plainTextToken);

        // ─── 2. Kategori ────────────────────────────────────────────
        DB::table('kategoris')->insert([
            ['id_kategori' => 1, 'kode_kategori' => 'FIK', 'nama_kategori' => 'Fiksi', 'deskripsi' => 'Buku cerita fiksi, novel, roman, dan cerpen'],
            ['id_kategori' => 2, 'kode_kategori' => 'NFI', 'nama_kategori' => 'Non-Fiksi', 'deskripsi' => 'Buku pengetahuan, ilmiah, dan referensi'],
            ['id_kategori' => 3, 'kode_kategori' => 'AKD', 'nama_kategori' => 'Akademik', 'deskripsi' => 'Buku teks, modul, dan materi perkuliahan'],
            ['id_kategori' => 4, 'kode_kategori' => 'TEK', 'nama_kategori' => 'Teknologi', 'deskripsi' => 'Buku tentang teknologi, komputer, dan pemrograman'],
            ['id_kategori' => 5, 'kode_kategori' => 'SEJ', 'nama_kategori' => 'Sejarah', 'deskripsi' => 'Buku sejarah, biografi, dan buku dokumenter'],
            ['id_kategori' => 6, 'kode_kategori' => 'AGM', 'nama_kategori' => 'Agama', 'deskripsi' => 'Buku keagamaan dan spiritual'],
            ['id_kategori' => 7, 'kode_kategori' => 'SNI', 'nama_kategori' => 'Seni', 'deskripsi' => 'Buku seni rupa, musik, tari, dan desain'],
            ['id_kategori' => 8, 'kode_kategori' => 'BIS', 'nama_kategori' => 'Bisnis', 'deskripsi' => 'Buku bisnis, manajemen, ekonomi, dan kewirausahaan'],
        ]);

        // ─── 3. Penerbit ────────────────────────────────────────────
        DB::table('penerbits')->insert([
            ['id_penerbit' => 1, 'nama_penerbit' => 'Gramedia Pustaka Utama', 'kota' => 'Jakarta', 'email' => 'info@gramedia.com', 'no_telepon' => '021-1234567'],
            ['id_penerbit' => 2, 'nama_penerbit' => 'Mizan Pustaka', 'kota' => 'Bandung', 'email' => 'redaksi@mizan.com', 'no_telepon' => '022-7654321'],
            ['id_penerbit' => 3, 'nama_penerbit' => 'Erlangga', 'kota' => 'Jakarta', 'email' => 'support@erlangga.co.id', 'no_telepon' => '021-9876543'],
            ['id_penerbit' => 4, 'nama_penerbit' => 'Andi Publisher', 'kota' => 'Yogyakarta', 'email' => 'info@andipublisher.com', 'no_telepon' => '0274-567890'],
            ['id_penerbit' => 5, 'nama_penerbit' => 'Republika Penerbit', 'kota' => 'Jakarta', 'email' => 'redaksi@republika.co.id', 'no_telepon' => '021-3456789'],
            ['id_penerbit' => 6, 'nama_penerbit' => 'Bentang Pustaka', 'kota' => 'Yogyakarta', 'email' => 'info@bentangpustaka.com', 'no_telepon' => '0274-890123'],
            ['id_penerbit' => 7, 'nama_penerbit' => 'Elex Media Komputindo', 'kota' => 'Jakarta', 'email' => 'info@elexmedia.id', 'no_telepon' => '021-4567890'],
            ['id_penerbit' => 8, 'nama_penerbit' => 'Pustaka Al-Kautsar', 'kota' => 'Jakarta', 'email' => 'info@kautsar.co.id', 'no_telepon' => '021-2345678'],
        ]);

        // ─── 4. Rak ─────────────────────────────────────────────────
        DB::table('raks')->insert([
            ['id_rak' => 1, 'kode_rak' => 'RK-A-01', 'nama_rak' => 'Rak A - Baris 1 (Fiksi)', 'lantai' => 1, 'kapasitas' => 100],
            ['id_rak' => 2, 'kode_rak' => 'RK-A-02', 'nama_rak' => 'Rak A - Baris 2 (Fiksi)', 'lantai' => 1, 'kapasitas' => 100],
            ['id_rak' => 3, 'kode_rak' => 'RK-B-01', 'nama_rak' => 'Rak B - Baris 1 (Non-Fiksi)', 'lantai' => 1, 'kapasitas' => 80],
            ['id_rak' => 4, 'kode_rak' => 'RK-B-02', 'nama_rak' => 'Rak B - Baris 2 (Akademik)', 'lantai' => 1, 'kapasitas' => 80],
            ['id_rak' => 5, 'kode_rak' => 'RK-C-01', 'nama_rak' => 'Rak C - Baris 1 (Teknologi)', 'lantai' => 2, 'kapasitas' => 60],
            ['id_rak' => 6, 'kode_rak' => 'RK-C-02', 'nama_rak' => 'Rak C - Baris 2 (Sejarah & Biografi)', 'lantai' => 2, 'kapasitas' => 60],
            ['id_rak' => 7, 'kode_rak' => 'RK-D-01', 'nama_rak' => 'Rak D - Baris 1 (Agama)', 'lantai' => 2, 'kapasitas' => 50],
            ['id_rak' => 8, 'kode_rak' => 'RK-D-02', 'nama_rak' => 'Rak D - Baris 2 (Seni & Bisnis)', 'lantai' => 2, 'kapasitas' => 50],
        ]);

        // ─── 5. Anggota ─────────────────────────────────────────────
        DB::table('anggotas')->insert([
            ['id_anggota' => 1,  'kode_anggota' => 'AGT-2024-001', 'nama_lengkap' => 'Budi Santoso', 'email' => 'budi.santoso@email.com', 'no_telepon' => '081234567890', 'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat', 'tanggal_daftar' => '2024-01-10', 'status_anggota' => 'aktif'],
            ['id_anggota' => 2,  'kode_anggota' => 'AGT-2024-002', 'nama_lengkap' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@email.com', 'no_telepon' => '081234567891', 'alamat' => 'Jl. Mawar Blok C No. 5, Bandung', 'tanggal_daftar' => '2024-01-15', 'status_anggota' => 'aktif'],
            ['id_anggota' => 3,  'kode_anggota' => 'AGT-2024-003', 'nama_lengkap' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@email.com', 'no_telepon' => '081234567892', 'alamat' => 'Komplek Permata No. 12, Surabaya', 'tanggal_daftar' => '2024-01-20', 'status_anggota' => 'aktif'],
            ['id_anggota' => 4,  'kode_anggota' => 'AGT-2024-004', 'nama_lengkap' => 'Dewi Lestari', 'email' => 'dewi.lestari@email.com', 'no_telepon' => '081234567893', 'alamat' => 'Jl. Kenanga No. 7, Semarang', 'tanggal_daftar' => '2024-02-01', 'status_anggota' => 'aktif'],
            ['id_anggota' => 5,  'kode_anggota' => 'AGT-2024-005', 'nama_lengkap' => 'Rudi Hartono', 'email' => 'rudi.hartono@email.com', 'no_telepon' => '081234567894', 'alamat' => 'Jl. Anggrek No. 15, Yogyakarta', 'tanggal_daftar' => '2024-02-05', 'status_anggota' => 'aktif'],
            ['id_anggota' => 6,  'kode_anggota' => 'AGT-2024-006', 'nama_lengkap' => 'Rina Wijaya', 'email' => 'rina.wijaya@email.com', 'no_telepon' => '081334567890', 'alamat' => 'Perumahan Citra Garden A3, Jakarta Timur', 'tanggal_daftar' => '2024-02-10', 'status_anggota' => 'aktif'],
            ['id_anggota' => 7,  'kode_anggota' => 'AGT-2024-007', 'nama_lengkap' => 'Hendra Gunawan', 'email' => 'hendra.gunawan@email.com', 'no_telepon' => '081434567891', 'alamat' => 'Jl. Diponegoro No. 25, Medan', 'tanggal_daftar' => '2024-02-15', 'status_anggota' => 'aktif'],
            ['id_anggota' => 8,  'kode_anggota' => 'AGT-2024-008', 'nama_lengkap' => 'Maya Indah', 'email' => 'maya.indah@email.com', 'no_telepon' => '081534567892', 'alamat' => 'Jl. Ahmad Yani No. 8, Malang', 'tanggal_daftar' => '2024-02-20', 'status_anggota' => 'nonaktif'],
            ['id_anggota' => 9,  'kode_anggota' => 'AGT-2024-009', 'nama_lengkap' => 'Doni Prasetyo', 'email' => 'doni.prasetyo@email.com', 'no_telepon' => '081634567893', 'alamat' => 'Jl. Sudirman No. 30, Makassar', 'tanggal_daftar' => '2024-03-01', 'status_anggota' => 'aktif'],
            ['id_anggota' => 10, 'kode_anggota' => 'AGT-2024-010', 'nama_lengkap' => 'Anita Sari', 'email' => 'anita.sari@email.com', 'no_telepon' => '081734567894', 'alamat' => 'Jl. Gatot Subroto No. 12, Palembang', 'tanggal_daftar' => '2024-03-05', 'status_anggota' => 'aktif'],
        ]);

        // ─── 6. Petugas ─────────────────────────────────────────────
        DB::table('petugas')->insert([
            ['id_petugas' => 1, 'kode_petugas' => 'PTG-001', 'nama_petugas' => 'Ani Wijaya', 'username' => 'ani.wijaya', 'password_hash' => Hash::make('password'), 'jabatan' => 'Kepala Perpustakaan', 'no_telepon' => '082345678901'],
            ['id_petugas' => 2, 'kode_petugas' => 'PTG-002', 'nama_petugas' => 'Bambang Nugroho', 'username' => 'bambang.nugroho', 'password_hash' => Hash::make('password'), 'jabatan' => 'Pustakawan Senior', 'no_telepon' => '082345678902'],
            ['id_petugas' => 3, 'kode_petugas' => 'PTG-003', 'nama_petugas' => 'Citra Dewi', 'username' => 'citra.dewi', 'password_hash' => Hash::make('password'), 'jabatan' => 'Pustakawan', 'no_telepon' => '082345678903'],
            ['id_petugas' => 4, 'kode_petugas' => 'PTG-004', 'nama_petugas' => 'Dedi Kurniawan', 'username' => 'dedi.kurniawan', 'password_hash' => Hash::make('password'), 'jabatan' => 'Pustakawan', 'no_telepon' => '082345678904'],
            ['id_petugas' => 5, 'kode_petugas' => 'PTG-005', 'nama_petugas' => 'Eka Putri', 'username' => 'eka.putri', 'password_hash' => Hash::make('password'), 'jabatan' => 'Pustakawan', 'no_telepon' => '082345678905'],
            ['id_petugas' => 6, 'kode_petugas' => 'PTG-006', 'nama_petugas' => 'Fajar Sidik', 'username' => 'fajar.sidik', 'password_hash' => Hash::make('password'), 'jabatan' => 'Asisten Pustakawan', 'no_telepon' => '082345678906'],
            ['id_petugas' => 7, 'kode_petugas' => 'PTG-007', 'nama_petugas' => 'Gita Permata', 'username' => 'gita.permata', 'password_hash' => Hash::make('password'), 'jabatan' => 'Petugas Administrasi', 'no_telepon' => '082345678907'],
        ]);

        // ─── 7. Buku ────────────────────────────────────────────────
        DB::table('bukus')->insert([
            ['id_buku' => 1,  'isbn' => '978-602-03-1234-5', 'judul' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'id_kategori' => 1, 'id_penerbit' => 6, 'id_rak' => 1, 'tahun_terbit' => 2015, 'edisi' => 'Cetakan Ke-30', 'jumlah_halaman' => 529, 'stok_total' => 5, 'stok_tersedia' => 3, 'bahasa' => 'Indonesia', 'sinopsis' => 'Novel inspiratif tentang perjuangan anak-anak Belitung dalam menempuh pendidikan.'],
            ['id_buku' => 2,  'isbn' => '978-602-42-1234-5', 'judul' => 'Filosofi Teras', 'pengarang' => 'Henry Manampiring', 'id_kategori' => 2, 'id_penerbit' => 2, 'id_rak' => 3, 'tahun_terbit' => 2018, 'edisi' => 'Cetakan Ke-10', 'jumlah_halaman' => 320, 'stok_total' => 3, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Buku pengembangan diri yang mengadaptasi filosofi Stoikisme untuk kehidupan modern.'],
            ['id_buku' => 3,  'isbn' => '978-602-03-5678-9', 'judul' => 'Dilan 1990', 'pengarang' => 'Pidi Baiq', 'id_kategori' => 1, 'id_penerbit' => 1, 'id_rak' => 1, 'tahun_terbit' => 2014, 'edisi' => 'Cetakan Ke-20', 'jumlah_halaman' => 332, 'stok_total' => 4, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Kisah romansa remaja Bandung tahun 1990 yang ikonik.'],
            ['id_buku' => 4,  'isbn' => '978-623-00-1234-5', 'judul' => 'Belajar SQL Dari Nol', 'pengarang' => 'Rizky Ramadhan', 'id_kategori' => 4, 'id_penerbit' => 7, 'id_rak' => 5, 'tahun_terbit' => 2023, 'edisi' => 'Cetakan Ke-2', 'jumlah_halaman' => 450, 'stok_total' => 3, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Panduan lengkap belajar SQL untuk pemula hingga mahir.'],
            ['id_buku' => 5,  'isbn' => '978-602-06-7890-1', 'judul' => 'Atomic Habits', 'pengarang' => 'James Clear', 'id_kategori' => 2, 'id_penerbit' => 1, 'id_rak' => 3, 'tahun_terbit' => 2019, 'edisi' => 'Cetakan Ke-15', 'jumlah_halaman' => 320, 'stok_total' => 4, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Cara kecil mengubah kebiasaan untuk mencapai hasil luar biasa.'],
            ['id_buku' => 6,  'isbn' => '978-602-03-9012-3', 'judul' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'id_kategori' => 1, 'id_penerbit' => 1, 'id_rak' => 2, 'tahun_terbit' => 2016, 'edisi' => 'Cetakan Ke-25', 'jumlah_halaman' => 535, 'stok_total' => 3, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Novel sejarah tentang perjuangan melawan kolonialisme di Indonesia.'],
            ['id_buku' => 7,  'isbn' => '978-602-42-5678-9', 'judul' => 'Rich Dad Poor Dad', 'pengarang' => 'Robert Kiyosaki', 'id_kategori' => 8, 'id_penerbit' => 1, 'id_rak' => 8, 'tahun_terbit' => 2017, 'edisi' => 'Cetakan Ke-12', 'jumlah_halaman' => 256, 'stok_total' => 3, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Buku keuangan pribadi tentang cara berpikir orang kaya vs orang biasa.'],
            ['id_buku' => 8,  'isbn' => '978-623-00-3456-7', 'judul' => 'Algoritma dan Pemrograman', 'pengarang' => 'Budi Raharjo', 'id_kategori' => 4, 'id_penerbit' => 7, 'id_rak' => 5, 'tahun_terbit' => 2022, 'edisi' => 'Cetakan Ke-5', 'jumlah_halaman' => 500, 'stok_total' => 3, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Buku teks lengkap tentang algoritma dan pemrograman untuk mahasiswa.'],
            ['id_buku' => 9,  'isbn' => '978-602-03-2345-6', 'judul' => 'Supernova: Ksatria, Puteri, dan Bintang Jatuh', 'pengarang' => 'Dee Lestari', 'id_kategori' => 1, 'id_penerbit' => 6, 'id_rak' => 1, 'tahun_terbit' => 2018, 'edisi' => 'Cetakan Ke-8', 'jumlah_halaman' => 400, 'stok_total' => 3, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Novel fiksi ilmiah yang menggabungkan sains dan spiritualitas.'],
            ['id_buku' => 10, 'isbn' => '978-602-42-7890-1', 'judul' => 'Sejarah Indonesia Modern', 'pengarang' => 'M.C. Ricklefs', 'id_kategori' => 5, 'id_penerbit' => 3, 'id_rak' => 6, 'tahun_terbit' => 2019, 'edisi' => 'Cetakan Ke-5', 'jumlah_halaman' => 450, 'stok_total' => 2, 'stok_tersedia' => 0, 'bahasa' => 'Indonesia', 'sinopsis' => 'Kajian mendalam tentang sejarah Indonesia dari masa kolonial hingga modern.'],
            ['id_buku' => 11, 'isbn' => '978-623-00-9012-3', 'judul' => 'Pemrograman Web Modern', 'pengarang' => 'Sandhika Galih', 'id_kategori' => 4, 'id_penerbit' => 7, 'id_rak' => 5, 'tahun_terbit' => 2023, 'edisi' => 'Cetakan Ke-3', 'jumlah_halaman' => 380, 'stok_total' => 4, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Panduan membangun aplikasi web menggunakan teknologi terkini.'],
            ['id_buku' => 12, 'isbn' => '978-602-06-3456-7', 'judul' => 'The Power of Habit', 'pengarang' => 'Charles Duhigg', 'id_kategori' => 8, 'id_penerbit' => 1, 'id_rak' => 8, 'tahun_terbit' => 2020, 'edisi' => 'Cetakan Ke-10', 'jumlah_halaman' => 400, 'stok_total' => 3, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Mengungkap ilmu di balik kebiasaan dan cara mengubahnya.'],
            ['id_buku' => 13, 'isbn' => '978-602-03-7890-1', 'judul' => 'Rindu', 'pengarang' => 'Tere Liye', 'id_kategori' => 1, 'id_penerbit' => 5, 'id_rak' => 2, 'tahun_terbit' => 2019, 'edisi' => 'Cetakan Ke-7', 'jumlah_halaman' => 350, 'stok_total' => 4, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Novel tentang perjalanan spiritual dan pencarian makna hidup.'],
            ['id_buku' => 14, 'isbn' => '978-623-00-5678-9', 'judul' => 'Manajemen Basis Data', 'pengarang' => 'Fathul Arifin', 'id_kategori' => 4, 'id_penerbit' => 4, 'id_rak' => 5, 'tahun_terbit' => 2023, 'edisi' => 'Cetakan Ke-1', 'jumlah_halaman' => 420, 'stok_total' => 3, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Buku referensi tentang perancangan dan manajemen basis data.'],
            ['id_buku' => 15, 'isbn' => '978-602-42-2345-6', 'judul' => 'Ayat-Ayat Cinta', 'pengarang' => 'Habiburrahman El Shirazy', 'id_kategori' => 1, 'id_penerbit' => 5, 'id_rak' => 2, 'tahun_terbit' => 2015, 'edisi' => 'Cetakan Ke-20', 'jumlah_halaman' => 420, 'stok_total' => 5, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Novel islami tentang cinta dan spiritualitas di Mesir.'],
            ['id_buku' => 16, 'isbn' => '978-602-03-4567-8', 'judul' => 'Sapiens', 'pengarang' => 'Yuval Noah Harari', 'id_kategori' => 5, 'id_penerbit' => 1, 'id_rak' => 6, 'tahun_terbit' => 2018, 'edisi' => 'Cetakan Ke-8', 'jumlah_halaman' => 480, 'stok_total' => 3, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Sejarah singkat umat manusia dari zaman purba hingga modern.'],
            ['id_buku' => 17, 'isbn' => '978-623-00-7890-1', 'judul' => 'Kecerdasan Buatan', 'pengarang' => 'Suyanto', 'id_kategori' => 4, 'id_penerbit' => 7, 'id_rak' => 5, 'tahun_terbit' => 2023, 'edisi' => 'Cetakan Ke-2', 'jumlah_halaman' => 350, 'stok_total' => 3, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Pengantar kecerdasan buatan dan implementasinya dengan Python.'],
            ['id_buku' => 18, 'isbn' => '978-602-42-9012-3', 'judul' => 'Bicara Itu Ada Seninya', 'pengarang' => 'Oh Su Hyang', 'id_kategori' => 2, 'id_penerbit' => 2, 'id_rak' => 4, 'tahun_terbit' => 2020, 'edisi' => 'Cetakan Ke-5', 'jumlah_halaman' => 240, 'stok_total' => 3, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Seni berkomunikasi dan public speaking yang efektif.'],
            ['id_buku' => 19, 'isbn' => '978-602-06-5678-9', 'judul' => '99 Cahaya di Langit Eropa', 'pengarang' => 'Hanum Salsabiela Rais', 'id_kategori' => 2, 'id_penerbit' => 1, 'id_rak' => 4, 'tahun_terbit' => 2019, 'edisi' => 'Cetakan Ke-12', 'jumlah_halaman' => 380, 'stok_total' => 4, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Perjalanan spiritual di Eropa yang mengungkap sisi Islam di benua biru.'],
            ['id_buku' => 20, 'isbn' => '978-602-03-8901-2', 'judul' => 'Start With Why', 'pengarang' => 'Simon Sinek', 'id_kategori' => 8, 'id_penerbit' => 1, 'id_rak' => 8, 'tahun_terbit' => 2020, 'edisi' => 'Cetakan Ke-6', 'jumlah_halaman' => 280, 'stok_total' => 3, 'stok_tersedia' => 2, 'bahasa' => 'Indonesia', 'sinopsis' => 'Bagaimana pemimpin besar menginspirasi semua orang untuk bertindak.'],
            ['id_buku' => 21, 'isbn' => '978-602-42-3456-7', 'judul' => 'Kitab Anti Bangkrut', 'pengarang' => 'Jouska Indonesia', 'id_kategori' => 8, 'id_penerbit' => 2, 'id_rak' => 8, 'tahun_terbit' => 2021, 'edisi' => 'Cetakan Ke-3', 'jumlah_halaman' => 220, 'stok_total' => 3, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Panduan praktis mengelola keuangan pribadi agar terhindar dari kebangkrutan.'],
            ['id_buku' => 22, 'isbn' => '978-623-00-2345-6', 'judul' => 'Jaringan Komputer', 'pengarang' => 'Andrew S. Tanenbaum', 'id_kategori' => 4, 'id_penerbit' => 3, 'id_rak' => 5, 'tahun_terbit' => 2022, 'edisi' => 'Cetakan Ke-6', 'jumlah_halaman' => 600, 'stok_total' => 2, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Buku klasik tentang jaringan komputer edisi terbaru.'],
            ['id_buku' => 23, 'isbn' => '978-602-06-8901-2', 'judul' => 'Negeri Para Bedebah', 'pengarang' => 'Tere Liye', 'id_kategori' => 1, 'id_penerbit' => 5, 'id_rak' => 1, 'tahun_terbit' => 2020, 'edisi' => 'Cetakan Ke-5', 'jumlah_halaman' => 380, 'stok_total' => 3, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Novel thriller finansial tentang dunia perbankan dan konspirasi.'],
            ['id_buku' => 24, 'isbn' => '978-602-03-6789-0', 'judul' => 'Metode Penelitian Kuantitatif', 'pengarang' => 'Sugiyono', 'id_kategori' => 3, 'id_penerbit' => 3, 'id_rak' => 4, 'tahun_terbit' => 2019, 'edisi' => 'Cetakan Ke-15', 'jumlah_halaman' => 450, 'stok_total' => 5, 'stok_tersedia' => 4, 'bahasa' => 'Indonesia', 'sinopsis' => 'Buku referensi utama metode penelitian kuantitatif untuk mahasiswa.'],
            ['id_buku' => 25, 'isbn' => '978-623-00-4567-8', 'judul' => 'Data Science for Business', 'pengarang' => 'Foster Provost', 'id_kategori' => 4, 'id_penerbit' => 7, 'id_rak' => 5, 'tahun_terbit' => 2023, 'edisi' => 'Cetakan Ke-1', 'jumlah_halaman' => 400, 'stok_total' => 2, 'stok_tersedia' => 1, 'bahasa' => 'Indonesia', 'sinopsis' => 'Penerapan data science untuk pengambilan keputusan bisnis.'],
        ]);

        // ─── 8. Peminjaman ──────────────────────────────────────────
        DB::table('peminjamans')->insert([
            ['id_peminjaman' => 1,  'kode_peminjaman' => 'PJM-2024-0001', 'id_anggota' => 1,  'id_petugas' => 3, 'tanggal_pinjam' => '2024-03-01 09:30:00', 'tanggal_batas_kembali' => '2024-03-08', 'status_peminjaman' => 'selesai', 'total_buku' => 1],
            ['id_peminjaman' => 2,  'kode_peminjaman' => 'PJM-2024-0002', 'id_anggota' => 2,  'id_petugas' => 3, 'tanggal_pinjam' => '2024-03-02 10:00:00', 'tanggal_batas_kembali' => '2024-03-09', 'status_peminjaman' => 'selesai', 'total_buku' => 2],
            ['id_peminjaman' => 3,  'kode_peminjaman' => 'PJM-2024-0003', 'id_anggota' => 3,  'id_petugas' => 4, 'tanggal_pinjam' => '2024-03-03 11:15:00', 'tanggal_batas_kembali' => '2024-03-10', 'status_peminjaman' => 'selesai', 'total_buku' => 1],
            ['id_peminjaman' => 4,  'kode_peminjaman' => 'PJM-2024-0004', 'id_anggota' => 4,  'id_petugas' => 4, 'tanggal_pinjam' => '2024-03-05 13:00:00', 'tanggal_batas_kembali' => '2024-03-12', 'status_peminjaman' => 'terlambat', 'total_buku' => 1],
            ['id_peminjaman' => 5,  'kode_peminjaman' => 'PJM-2024-0005', 'id_anggota' => 5,  'id_petugas' => 5, 'tanggal_pinjam' => '2024-03-10 08:30:00', 'tanggal_batas_kembali' => '2024-03-17', 'status_peminjaman' => 'selesai', 'total_buku' => 2],
            ['id_peminjaman' => 6,  'kode_peminjaman' => 'PJM-2024-0006', 'id_anggota' => 1,  'id_petugas' => 3, 'tanggal_pinjam' => '2024-03-15 14:00:00', 'tanggal_batas_kembali' => '2024-03-22', 'status_peminjaman' => 'aktif', 'total_buku' => 2],
            ['id_peminjaman' => 7,  'kode_peminjaman' => 'PJM-2024-0007', 'id_anggota' => 6,  'id_petugas' => 5, 'tanggal_pinjam' => '2024-03-18 10:45:00', 'tanggal_batas_kembali' => '2024-03-25', 'status_peminjaman' => 'aktif', 'total_buku' => 1],
            ['id_peminjaman' => 8,  'kode_peminjaman' => 'PJM-2024-0008', 'id_anggota' => 7,  'id_petugas' => 4, 'tanggal_pinjam' => '2024-03-20 09:00:00', 'tanggal_batas_kembali' => '2024-03-27', 'status_peminjaman' => 'terlambat', 'total_buku' => 1],
            ['id_peminjaman' => 9,  'kode_peminjaman' => 'PJM-2024-0009', 'id_anggota' => 8,  'id_petugas' => 3, 'tanggal_pinjam' => '2024-03-22 11:30:00', 'tanggal_batas_kembali' => '2024-03-29', 'status_peminjaman' => 'selesai', 'total_buku' => 2],
            ['id_peminjaman' => 10, 'kode_peminjaman' => 'PJM-2024-0010', 'id_anggota' => 9,  'id_petugas' => 5, 'tanggal_pinjam' => '2024-03-25 13:15:00', 'tanggal_batas_kembali' => '2024-04-01', 'status_peminjaman' => 'aktif', 'total_buku' => 1],
            ['id_peminjaman' => 11, 'kode_peminjaman' => 'PJM-2024-0011', 'id_anggota' => 10, 'id_petugas' => 4, 'tanggal_pinjam' => '2024-03-28 08:00:00', 'tanggal_batas_kembali' => '2024-04-04', 'status_peminjaman' => 'aktif', 'total_buku' => 2],
            ['id_peminjaman' => 12, 'kode_peminjaman' => 'PJM-2024-0012', 'id_anggota' => 2,  'id_petugas' => 3, 'tanggal_pinjam' => '2024-04-01 10:00:00', 'tanggal_batas_kembali' => '2024-04-08', 'status_peminjaman' => 'aktif', 'total_buku' => 1],
        ]);

        // ─── 9. Detail Peminjaman ───────────────────────────────────
        DB::table('detail_peminjamans')->insert([
            ['id_detail' => 1,  'id_peminjaman' => 1,  'id_buku' => 1,  'status_buku' => 'dikembalikan'],
            ['id_detail' => 2,  'id_peminjaman' => 2,  'id_buku' => 3,  'status_buku' => 'dikembalikan'],
            ['id_detail' => 3,  'id_peminjaman' => 2,  'id_buku' => 5,  'status_buku' => 'dikembalikan'],
            ['id_detail' => 4,  'id_peminjaman' => 3,  'id_buku' => 6,  'status_buku' => 'dikembalikan'],
            ['id_detail' => 5,  'id_peminjaman' => 4,  'id_buku' => 10, 'status_buku' => 'dikembalikan'],
            ['id_detail' => 6,  'id_peminjaman' => 5,  'id_buku' => 2,  'status_buku' => 'dikembalikan'],
            ['id_detail' => 7,  'id_peminjaman' => 5,  'id_buku' => 7,  'status_buku' => 'dikembalikan'],
            ['id_detail' => 8,  'id_peminjaman' => 6,  'id_buku' => 4,  'status_buku' => 'dipinjam'],
            ['id_detail' => 9,  'id_peminjaman' => 6,  'id_buku' => 8,  'status_buku' => 'dipinjam'],
            ['id_detail' => 10, 'id_peminjaman' => 7,  'id_buku' => 11, 'status_buku' => 'dipinjam'],
            ['id_detail' => 11, 'id_peminjaman' => 8,  'id_buku' => 9,  'status_buku' => 'dikembalikan'],
            ['id_detail' => 12, 'id_peminjaman' => 9,  'id_buku' => 13, 'status_buku' => 'dikembalikan'],
            ['id_detail' => 13, 'id_peminjaman' => 9,  'id_buku' => 15, 'status_buku' => 'dikembalikan'],
            ['id_detail' => 14, 'id_peminjaman' => 10, 'id_buku' => 12, 'status_buku' => 'dipinjam'],
            ['id_detail' => 15, 'id_peminjaman' => 11, 'id_buku' => 14, 'status_buku' => 'dipinjam'],
            ['id_detail' => 16, 'id_peminjaman' => 11, 'id_buku' => 17, 'status_buku' => 'dipinjam'],
            ['id_detail' => 17, 'id_peminjaman' => 12, 'id_buku' => 16, 'status_buku' => 'dipinjam'],
            ['id_detail' => 18, 'id_peminjaman' => 4,  'id_buku' => 18, 'status_buku' => 'dipinjam'],
            ['id_detail' => 19, 'id_peminjaman' => 8,  'id_buku' => 19, 'status_buku' => 'dipinjam'],
            ['id_detail' => 20, 'id_peminjaman' => 3,  'id_buku' => 20, 'status_buku' => 'dikembalikan'],
        ]);

        // ─── 10. Pengembalian ───────────────────────────────────────
        DB::table('pengembalians')->insert([
            ['id_pengembalian' => 21, 'id_peminjaman' => 1, 'id_detail' => 1,  'id_petugas' => 3, 'tanggal_kembali' => '2024-03-07 10:00:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'Laskar Pelangi - Tepat waktu, kondisi prima'],
            ['id_pengembalian' => 22, 'id_peminjaman' => 2, 'id_detail' => 2,  'id_petugas' => 4, 'tanggal_kembali' => '2024-03-09 11:00:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'Dilan 1990 - Tepat waktu'],
            ['id_pengembalian' => 23, 'id_peminjaman' => 2, 'id_detail' => 3,  'id_petugas' => 4, 'tanggal_kembali' => '2024-03-09 11:00:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'Atomic Habits - Tepat waktu'],
            ['id_pengembalian' => 24, 'id_peminjaman' => 3, 'id_detail' => 4,  'id_petugas' => 3, 'tanggal_kembali' => '2024-03-10 14:00:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'Bumi Manusia - Tepat waktu'],
            ['id_pengembalian' => 25, 'id_peminjaman' => 5, 'id_detail' => 6,  'id_petugas' => 5, 'tanggal_kembali' => '2024-03-17 08:00:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'Filosofi Teras - Tepat waktu'],
            ['id_pengembalian' => 26, 'id_peminjaman' => 5, 'id_detail' => 7,  'id_petugas' => 5, 'tanggal_kembali' => '2024-03-17 08:00:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'Rich Dad Poor Dad - Tepat waktu'],
            ['id_pengembalian' => 27, 'id_peminjaman' => 9, 'id_detail' => 12, 'id_petugas' => 3, 'tanggal_kembali' => '2024-03-29 09:30:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'Rindu - Tepat waktu'],
            ['id_pengembalian' => 28, 'id_peminjaman' => 9, 'id_detail' => 13, 'id_petugas' => 3, 'tanggal_kembali' => '2024-03-29 09:30:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'Ayat-Ayat Cinta - Tepat waktu'],
            ['id_pengembalian' => 29, 'id_peminjaman' => 3, 'id_detail' => 20, 'id_petugas' => 5, 'tanggal_kembali' => '2024-03-30 11:00:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'Start With Why - Tepat waktu, masih segel'],
            ['id_pengembalian' => 30, 'id_peminjaman' => 10, 'id_detail' => 14, 'id_petugas' => 3, 'tanggal_kembali' => '2024-04-01 14:00:00', 'terlambat_hari' => 0,  'denda' => 0,     'kondisi_buku' => 'baik',  'keterangan' => 'The Power of Habit - Tepat waktu, ada catatan kecil'],
            ['id_pengembalian' => 31, 'id_peminjaman' => 4, 'id_detail' => 5,  'id_petugas' => 4, 'tanggal_kembali' => '2024-03-15 09:00:00', 'terlambat_hari' => 3,  'denda' => 3000,  'kondisi_buku' => 'baik',  'keterangan' => 'Sejarah Indonesia Modern - Terlambat 3 hari'],
            ['id_pengembalian' => 32, 'id_peminjaman' => 4, 'id_detail' => 18, 'id_petugas' => 4, 'tanggal_kembali' => '2024-03-18 10:00:00', 'terlambat_hari' => 6,  'denda' => 6000,  'kondisi_buku' => 'baik',  'keterangan' => 'Bicara Itu Ada Seninya - Terlambat 6 hari'],
            ['id_pengembalian' => 33, 'id_peminjaman' => 7, 'id_detail' => 10, 'id_petugas' => 5, 'tanggal_kembali' => '2024-04-05 09:00:00', 'terlambat_hari' => 11, 'denda' => 11000, 'kondisi_buku' => 'baik',  'keterangan' => 'Pemrograman Web Modern - Terlambat 11 hari'],
            ['id_pengembalian' => 34, 'id_peminjaman' => 8, 'id_detail' => 11, 'id_petugas' => 4, 'tanggal_kembali' => '2024-04-01 10:00:00', 'terlambat_hari' => 5,  'denda' => 5000,  'kondisi_buku' => 'rusak', 'keterangan' => 'Supernova - Terlambat 5 hari, halaman sobek'],
            ['id_pengembalian' => 35, 'id_peminjaman' => 11, 'id_detail' => 16, 'id_petugas' => 4, 'tanggal_kembali' => '2024-04-12 08:30:00', 'terlambat_hari' => 8,  'denda' => 8000,  'kondisi_buku' => 'baik',  'keterangan' => 'Manajemen Basis Data - Terlambat 8 hari'],
            ['id_pengembalian' => 36, 'id_peminjaman' => 12, 'id_detail' => 17, 'id_petugas' => 5, 'tanggal_kembali' => '2024-04-15 13:00:00', 'terlambat_hari' => 7,  'denda' => 7000,  'kondisi_buku' => 'baik',  'keterangan' => 'Sapiens - Terlambat 7 hari'],
            ['id_pengembalian' => 37, 'id_peminjaman' => 6, 'id_detail' => 9,  'id_petugas' => 3, 'tanggal_kembali' => '2024-03-30 10:00:00', 'terlambat_hari' => 8,  'denda' => 8000,  'kondisi_buku' => 'baik',  'keterangan' => 'Algoritma dan Pemrograman - Terlambat 8 hari'],
            ['id_pengembalian' => 38, 'id_peminjaman' => 8, 'id_detail' => 19, 'id_petugas' => 4, 'tanggal_kembali' => '2024-04-05 09:00:00', 'terlambat_hari' => 9,  'denda' => 9000,  'kondisi_buku' => 'baik',  'keterangan' => '99 Cahaya di Langit Eropa - Terlambat 9 hari'],
            ['id_pengembalian' => 39, 'id_peminjaman' => 10, 'id_detail' => 15, 'id_petugas' => 3, 'tanggal_kembali' => '2024-04-10 14:00:00', 'terlambat_hari' => 9,  'denda' => 9000,  'kondisi_buku' => 'baik',  'keterangan' => 'The Power of Habit - Terlambat 9 hari'],
            ['id_pengembalian' => 40, 'id_peminjaman' => 11, 'id_detail' => 8,  'id_petugas' => 4, 'tanggal_kembali' => '2024-04-12 08:30:00', 'terlambat_hari' => 8,  'denda' => 8000,  'kondisi_buku' => 'rusak', 'keterangan' => 'Kecerdasan Buatan - Terlambat 8 hari, cover rusak'],
        ]);

        // ─── 11. Reservasi ──────────────────────────────────────────
        DB::table('reservasis')->insert([
            ['id_reservasi' => 1,  'id_anggota' => 1,  'id_buku' => 10, 'tanggal_reservasi' => '2024-03-10 08:00:00', 'tanggal_kedaluwarsa' => '2024-03-13', 'status_reservasi' => 'diklaim'],
            ['id_reservasi' => 2,  'id_anggota' => 2,  'id_buku' => 6,  'tanggal_reservasi' => '2024-03-12 10:00:00', 'tanggal_kedaluwarsa' => '2024-03-15', 'status_reservasi' => 'diklaim'],
            ['id_reservasi' => 3,  'id_anggota' => 3,  'id_buku' => 1,  'tanggal_reservasi' => '2024-03-15 14:00:00', 'tanggal_kedaluwarsa' => '2024-03-18', 'status_reservasi' => 'menunggu'],
            ['id_reservasi' => 4,  'id_anggota' => 4,  'id_buku' => 7,  'tanggal_reservasi' => '2024-03-18 09:00:00', 'tanggal_kedaluwarsa' => '2024-03-21', 'status_reservasi' => 'diklaim'],
            ['id_reservasi' => 5,  'id_anggota' => 5,  'id_buku' => 13, 'tanggal_reservasi' => '2024-03-20 11:00:00', 'tanggal_kedaluwarsa' => '2024-03-23', 'status_reservasi' => 'menunggu'],
            ['id_reservasi' => 6,  'id_anggota' => 6,  'id_buku' => 15, 'tanggal_reservasi' => '2024-03-22 13:00:00', 'tanggal_kedaluwarsa' => '2024-03-25', 'status_reservasi' => 'tersedia'],
            ['id_reservasi' => 7,  'id_anggota' => 7,  'id_buku' => 9,  'tanggal_reservasi' => '2024-03-25 08:30:00', 'tanggal_kedaluwarsa' => '2024-03-28', 'status_reservasi' => 'diklaim'],
            ['id_reservasi' => 8,  'id_anggota' => 9,  'id_buku' => 16, 'tanggal_reservasi' => '2024-03-28 10:00:00', 'tanggal_kedaluwarsa' => '2024-03-31', 'status_reservasi' => 'menunggu'],
            ['id_reservasi' => 9,  'id_anggota' => 10, 'id_buku' => 12, 'tanggal_reservasi' => '2024-03-30 09:00:00', 'tanggal_kedaluwarsa' => '2024-04-02', 'status_reservasi' => 'tersedia'],
            ['id_reservasi' => 10, 'id_anggota' => 1,  'id_buku' => 17, 'tanggal_reservasi' => '2024-04-01 11:00:00', 'tanggal_kedaluwarsa' => '2024-04-04', 'status_reservasi' => 'menunggu'],
            ['id_reservasi' => 11, 'id_anggota' => 2,  'id_buku' => 8,  'tanggal_reservasi' => '2024-04-02 14:00:00', 'tanggal_kedaluwarsa' => '2024-04-05', 'status_reservasi' => 'kedaluwarsa'],
            ['id_reservasi' => 12, 'id_anggota' => 3,  'id_buku' => 5,  'tanggal_reservasi' => '2024-04-03 08:00:00', 'tanggal_kedaluwarsa' => '2024-04-06', 'status_reservasi' => 'diklaim'],
            ['id_reservasi' => 13, 'id_anggota' => 6,  'id_buku' => 18, 'tanggal_reservasi' => '2024-04-04 10:30:00', 'tanggal_kedaluwarsa' => '2024-04-07', 'status_reservasi' => 'menunggu'],
            ['id_reservasi' => 14, 'id_anggota' => 4,  'id_buku' => 2,  'tanggal_reservasi' => '2024-04-05 13:00:00', 'tanggal_kedaluwarsa' => '2024-04-08', 'status_reservasi' => 'tersedia'],
            ['id_reservasi' => 15, 'id_anggota' => 8,  'id_buku' => 20, 'tanggal_reservasi' => '2024-04-06 09:00:00', 'tanggal_kedaluwarsa' => '2024-04-09', 'status_reservasi' => 'batal'],
            ['id_reservasi' => 16, 'id_anggota' => 5,  'id_buku' => 14, 'tanggal_reservasi' => '2024-04-07 11:00:00', 'tanggal_kedaluwarsa' => '2024-04-10', 'status_reservasi' => 'menunggu'],
            ['id_reservasi' => 17, 'id_anggota' => 10, 'id_buku' => 3,  'tanggal_reservasi' => '2024-04-08 15:00:00', 'tanggal_kedaluwarsa' => '2024-04-11', 'status_reservasi' => 'tersedia'],
        ]);

        $this->command->info('✅ Seeding selesai! Semua data dari SQL dump berhasil dimasukkan.');
    }
}
