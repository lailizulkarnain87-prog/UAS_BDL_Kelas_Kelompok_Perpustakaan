<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Rak;
use App\Models\Anggota;
use App\Models\Petugas;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;

class BisnisFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $kategori;
    protected $penerbit;
    protected $rak;
    protected $anggota;
    protected $petugas;
    protected $buku;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);

        $this->kategori = Kategori::create([
            'kode_kategori' => 'K001',
            'nama_kategori' => 'Fiksi'
        ]);

        $this->penerbit = Penerbit::create([
            'nama_penerbit' => 'Penerbit A'
        ]);

        $this->rak = Rak::create([
            'kode_rak' => 'R001',
            'nama_rak' => 'Rak 1',
            'lantai' => 1,
            'kapasitas' => 50
        ]);

        $this->anggota = Anggota::create([
            'kode_anggota' => 'A001',
            'nama_lengkap' => 'Anggota Test',
            'email' => 'anggota@test.com',
            'tanggal_daftar' => now()->toDateString(),
            'status_anggota' => 'aktif'
        ]);

        $this->petugas = Petugas::create([
            'kode_petugas' => 'PTG001',
            'nama_petugas' => 'Petugas Test',
            'username' => 'petugas1',
            'password_hash' => bcrypt('password')
        ]);

        $this->buku = Buku::create([
            'isbn' => '1234567890',
            'judul' => 'Buku Test',
            'pengarang' => 'Pengarang Test',
            'id_kategori' => $this->kategori->id_kategori,
            'id_penerbit' => $this->penerbit->id_penerbit,
            'id_rak' => $this->rak->id_rak,
            'stok_total' => 10,
            'stok_tersedia' => 10
        ]);
    }

    // ─── PEMINJAMAN FLOW ────────────────────────────────────────────

    public function test_unauthenticated_cannot_create_peminjaman()
    {
        $response = $this->postJson('/api/peminjaman', []);
        $response->assertStatus(401);
    }

    public function test_create_peminjaman_success()
    {
        Sanctum::actingAs($this->user);
        $response = $this->postJson('/api/peminjaman', [
            'kode_peminjaman' => 'PMJ001',
            'id_anggota' => $this->anggota->id_anggota,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_batas_kembali' => now()->addDays(7)->toDateString(),
            'buku_ids' => [$this->buku->id_buku]
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['success', 'data' => ['kode_peminjaman', 'detail_peminjamans']]);

        $this->assertDatabaseHas('peminjamans', [
            'kode_peminjaman' => 'PMJ001',
            'id_anggota' => $this->anggota->id_anggota,
        ]);

        $this->assertDatabaseHas('detail_peminjamans', [
            'id_buku' => $this->buku->id_buku,
            'status_buku' => 'dipinjam'
        ]);

        $this->assertDatabaseHas('bukus', [
            'id_buku' => $this->buku->id_buku,
            'stok_tersedia' => 9
        ]);
    }

    public function test_create_peminjaman_fails_when_stok_habis()
    {
        $bukuKosong = Buku::create([
            'isbn' => '0000000000',
            'judul' => 'Buku Kosong',
            'pengarang' => 'Test',
            'id_kategori' => $this->kategori->id_kategori,
            'id_penerbit' => $this->penerbit->id_penerbit,
            'id_rak' => $this->rak->id_rak,
            'stok_total' => 0,
            'stok_tersedia' => 0
        ]);

        Sanctum::actingAs($this->user);
        $response = $this->postJson('/api/peminjaman', [
            'kode_peminjaman' => 'PMJ002',
            'id_anggota' => $this->anggota->id_anggota,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_batas_kembali' => now()->addDays(7)->toDateString(),
            'buku_ids' => [$bukuKosong->id_buku]
        ]);

        $response->assertStatus(500);
        $response->assertSee('stok habis');
    }

    public function test_create_peminjaman_validation_fails()
    {
        Sanctum::actingAs($this->user);
        $response = $this->postJson('/api/peminjaman', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'kode_peminjaman', 
                     'id_anggota', 
                     'id_petugas', 
                     'tanggal_pinjam', 
                     'tanggal_batas_kembali', 
                     'buku_ids'
                 ]);
    }

    // ─── PENGEMBALIAN FLOW ──────────────────────────────────────────

    public function test_create_pengembalian_tepat_waktu_success()
    {
        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => 'PMJ003',
            'id_anggota' => $this->anggota->id_anggota,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_pinjam' => now()->subDays(2)->toDateString(),
            'tanggal_batas_kembali' => now()->addDays(5)->toDateString(),
            'status_peminjaman' => 'aktif',
            'total_buku' => 1
        ]);
        
        $detail = DetailPeminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_buku' => $this->buku->id_buku,
            'status_buku' => 'dipinjam'
        ]);
        
        $this->buku->decrement('stok_tersedia');

        Sanctum::actingAs($this->user);
        $response = $this->postJson('/api/pengembalian', [
            'id_detail' => $detail->id_detail,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_kembali' => now()->toDateString(),
            'kondisi_buku' => 'baik'
        ]);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('pengembalians', [
            'id_detail' => $detail->id_detail,
            'terlambat_hari' => 0,
            'denda' => 0
        ]);
        
        $this->assertDatabaseHas('bukus', [
            'id_buku' => $this->buku->id_buku,
            'stok_tersedia' => 10
        ]);
        
        $this->assertDatabaseHas('detail_peminjamans', [
            'id_detail' => $detail->id_detail,
            'status_buku' => 'dikembalikan'
        ]);
    }

    public function test_create_pengembalian_terlambat_dan_kena_denda()
    {
        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => 'PMJ004',
            'id_anggota' => $this->anggota->id_anggota,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_pinjam' => now()->subDays(10)->toDateString(),
            'tanggal_batas_kembali' => now()->subDays(3)->toDateString(),
            'status_peminjaman' => 'aktif',
            'total_buku' => 1
        ]);
        
        $detail = DetailPeminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_buku' => $this->buku->id_buku,
            'status_buku' => 'dipinjam'
        ]);

        Sanctum::actingAs($this->user);
        $response = $this->postJson('/api/pengembalian', [
            'id_detail' => $detail->id_detail,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_kembali' => now()->toDateString(),
            'kondisi_buku' => 'baik'
        ]);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('pengembalians', [
            'id_detail' => $detail->id_detail,
            'terlambat_hari' => 3
        ]);
        
        $pengembalian = Pengembalian::where('id_detail', $detail->id_detail)->first();
        $this->assertTrue($pengembalian->denda > 0);
    }

    public function test_create_pengembalian_fails_buku_sudah_dikembalikan()
    {
        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => 'PMJ005',
            'id_anggota' => $this->anggota->id_anggota,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_batas_kembali' => now()->addDays(7)->toDateString(),
            'status_peminjaman' => 'selesai',
            'total_buku' => 1
        ]);
        
        $detail = DetailPeminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_buku' => $this->buku->id_buku,
            'status_buku' => 'dikembalikan'
        ]);

        Sanctum::actingAs($this->user);
        $response = $this->postJson('/api/pengembalian', [
            'id_detail' => $detail->id_detail,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_kembali' => now()->toDateString(),
            'kondisi_buku' => 'baik'
        ]);

        $response->assertStatus(500);
    }

    // ─── DENDA FLOW ─────────────────────────────────────────────────

    public function test_authenticated_user_can_access_denda_index()
    {
        Sanctum::actingAs($this->user);
        $response = $this->getJson('/api/denda');
        $response->assertStatus(200)
                 ->assertJsonStructure(['success', 'data']);
    }

    public function test_create_denda_with_pembayaran_success()
    {
        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => 'PMJ006',
            'id_anggota' => $this->anggota->id_anggota,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_pinjam' => now()->subDays(10)->toDateString(),
            'tanggal_batas_kembali' => now()->subDays(3)->toDateString(),
            'status_peminjaman' => 'selesai',
            'total_buku' => 1
        ]);
        
        $detail = DetailPeminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_buku' => $this->buku->id_buku,
            'status_buku' => 'dikembalikan'
        ]);
        
        $pengembalian = Pengembalian::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_detail' => $detail->id_detail,
            'id_petugas' => $this->petugas->id_petugas,
            'tanggal_kembali' => now()->toDateString(),
            'terlambat_hari' => 3,
            'denda' => 3000,
            'kondisi_buku' => 'baik'
        ]);

        // Buat Denda Baru
        Sanctum::actingAs($this->user);
        $responseDenda = $this->postJson('/api/denda', [
            'id_pengembalian' => $pengembalian->id_pengembalian,
            'id_anggota' => $this->anggota->id_anggota,
            'total_denda' => 3000,
            'sisa_denda' => 3000,
            'tanggal_dikenakan' => now()->toDateString(),
            'status_denda' => 'pending'
        ]);
        
        $responseDenda->assertStatus(201);
        $dendaId = $responseDenda->json('data.id');

        $this->assertDatabaseHas('dendas', [
            'id' => $dendaId,
            'status_denda' => 'pending'
        ]);
        $this->assertDatabaseHas('riwayat_status_dendas', [
            'id_denda' => $dendaId,
            'status_sesudah' => 'pending'
        ]);

        // Bayar Denda tersebut
        $responseBayar = $this->postJson("/api/denda/{$dendaId}/pembayaran", [
            'id_denda' => $dendaId,
            'id_petugas' => $this->petugas->id_petugas,
            'jumlah_bayar' => 3000,
            'tanggal_bayar' => now()->toDateString(),
            'metode_bayar' => 'cash'
        ]);
        
        $responseBayar->assertStatus(201);
        
        $this->assertDatabaseHas('dendas', [
            'id' => $dendaId,
            'sisa_denda' => 0,
            'status_denda' => 'lunas'
        ]);
        $this->assertDatabaseHas('riwayat_status_dendas', [
            'id_denda' => $dendaId,
            'status_sesudah' => 'lunas'
        ]);
    }

    public function test_create_denda_validation_fails()
    {
        Sanctum::actingAs($this->user);
        $response = $this->postJson('/api/denda', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'id_anggota', 
                     'total_denda', 
                     'sisa_denda', 
                     'tanggal_dikenakan'
                 ]);
    }
}
