<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Persediaan;
use App\Models\TransaksiKeluarPersediaan;
use App\Http\Controllers\AdminPersediaanController;

class UpdateTransaksiKeluarPersediaanTest extends TestCase
{
    use RefreshDatabase; 

    protected $admin;
    protected $controller;

   protected function setUp(): void
   {
       parent::setUp();
       $this->admin = \App\Models\User::factory()->create(['role' => 'admin_persediaan']);
       $this->actingAs($this->admin);
       $this->controller = new \App\Http\Controllers\AdminPersediaanController();
   }

    /**
     * Helper untuk membuat Request tiruan (Dummy) beserta Session
     */
    private function createRequest($method, $data)
    {
        $request = Request::create('/dummy-url', $method, $data);
        $request->setLaravelSession(app('session.store')); 
        return $request;
    }

    /**
     * TC-01 (Path 1): Uji Validasi Stok Tidak Mencukupi
     */
    public function test_gagal_karena_stok_baru_tidak_mencukupi()
    {
        $persediaan = Persediaan::create([
            'kode_barang' => 'BRG-TINTA', 'nama_barang' => 'Tinta Printer', 'kode_kategori' => 'ATK', 'kategori' => 'Alat Tulis', 'tanggal_masuk' => now(), 'harga_satuan' => 50000, 'jumlah' => 2, 'harga_total' => 100000
        ]);

        $transaksi = TransaksiKeluarPersediaan::create([
            'nomor_transaksi' => 'TRX-001', 'tanggal_input' => now(), 'kode_kategori' => 'ATK', 'kategori' => 'Alat Tulis', 'kode_barang' => 'BRG-TINTA', 'nama_barang' => 'Tinta Printer', 'jumlah_keluar' => 1, 'harga' => 50000
        ]);

        // Skenario: Stok sisa 2, tapi admin coba update jumlah_keluar jadi 5
        $request = $this->createRequest('PUT', array_merge($transaksi->toArray(), [
            'jumlah_keluar' => 5
        ]));

        $response = $this->controller->updateTransaksiKeluar($request, $transaksi);
        
        // ✅ PERBAIKAN: Ambil error dari object response
        $this->assertTrue($response->getSession()->has('errors'));
        $this->assertEquals('Stok persediaan tidak mencukupi!', $response->getSession()->get('errors')->first('jumlah_keluar'));
        $this->assertEquals(2, $persediaan->fresh()->jumlah); // Stok gudang tidak boleh berubah
    }

    /**
     * TC-02 (Path 2): Uji Ganti Barang dan Stok Lama Dikembalikan
     */
    public function test_sukses_ganti_barang_dan_stok_lama_dikembalikan()
    {
        $kertas = Persediaan::create(['kode_barang' => 'BRG-KRT', 'nama_barang' => 'Kertas', 'kode_kategori' => 'ATK', 'kategori' => 'ATK', 'tanggal_masuk' => now(), 'harga_satuan' => 10, 'jumlah' => 5, 'harga_total' => 50]);
        $tinta = Persediaan::create(['kode_barang' => 'BRG-TNT', 'nama_barang' => 'Tinta', 'kode_kategori' => 'ATK', 'kategori' => 'ATK', 'tanggal_masuk' => now(), 'harga_satuan' => 20, 'jumlah' => 20, 'harga_total' => 400]);

        $transaksi = TransaksiKeluarPersediaan::create([
            'nomor_transaksi' => 'TRX-002', 'tanggal_input' => now(), 'kode_kategori' => 'ATK', 'kategori' => 'ATK', 'kode_barang' => 'BRG-KRT', 'nama_barang' => 'Kertas', 'jumlah_keluar' => 5, 'harga' => 10
        ]);

        // Skenario: Awalnya keluar kertas 5. Diubah jadi keluar Tinta 2.
        $request = $this->createRequest('PUT', array_merge($transaksi->toArray(), [
            'kode_barang' => 'BRG-TNT', 'nama_barang' => 'Tinta', 'jumlah_keluar' => 2
        ]));

        $response = $this->controller->updateTransaksiKeluar($request, $transaksi);

        // Kertas dikembalikan 5 (5+5=10). Tinta dikurangi 2 (20-2=18)
        $this->assertEquals(10, $kertas->fresh()->jumlah);
        $this->assertEquals(18, $tinta->fresh()->jumlah);
        
        // ✅ PERBAIKAN: Ambil success dari object response
        $this->assertTrue($response->getSession()->has('success'));
    }

    /**
     * TC-03 (Path 3): Uji Ganti Barang (Barang Lama Telah Dihapus dari Gudang)
     */
    public function test_sukses_ganti_barang_meskipun_barang_lama_telah_dihapus()
    {
        $buku = Persediaan::create(['kode_barang' => 'BRG-BK', 'nama_barang' => 'Buku', 'kode_kategori' => 'ATK', 'kategori' => 'ATK', 'tanggal_masuk' => now(), 'harga_satuan' => 10, 'jumlah' => 10, 'harga_total' => 100]);

        // Skenario: Awalnya keluar Pulpen, tapi master data Pulpen sudah terhapus di database
        $transaksi = TransaksiKeluarPersediaan::create([
            'nomor_transaksi' => 'TRX-003', 'tanggal_input' => now(), 'kode_kategori' => 'ATK', 'kategori' => 'ATK', 'kode_barang' => 'BRG-PLP', 'nama_barang' => 'Pulpen', 'jumlah_keluar' => 2, 'harga' => 10
        ]);

        // Diubah menjadi keluarkan Buku 3
        $request = $this->createRequest('PUT', array_merge($transaksi->toArray(), [
            'kode_barang' => 'BRG-BK', 'nama_barang' => 'Buku', 'jumlah_keluar' => 3
        ]));

        $response = $this->controller->updateTransaksiKeluar($request, $transaksi);

        // Tidak boleh crash, dan stok Buku berkurang 3 (jadi 7)
        $this->assertEquals(7, $buku->fresh()->jumlah);
        $this->assertTrue($response->getSession()->has('success'));
    }

    /**
     * TC-04 (Path 4): Uji Barang Sama, Jumlah Keluar Diubah Lebih Sedikit (Stok Gudang +)
     */
    public function test_sukses_jumlah_keluar_dikurangi_sehingga_stok_gudang_bertambah()
    {
        $spidol = Persediaan::create(['kode_barang' => 'BRG-SPD', 'nama_barang' => 'Spidol', 'kode_kategori' => 'ATK', 'kategori' => 'ATK', 'tanggal_masuk' => now(), 'harga_satuan' => 10, 'jumlah' => 8, 'harga_total' => 80]);

        $transaksi = TransaksiKeluarPersediaan::create([
            'nomor_transaksi' => 'TRX-004', 'tanggal_input' => now(), 'kode_kategori' => 'ATK', 'kategori' => 'ATK', 'kode_barang' => 'BRG-SPD', 'nama_barang' => 'Spidol', 'jumlah_keluar' => 5, 'harga' => 10
        ]);

        // Skenario: Awalnya keluar 5, diedit menjadi keluar 3 saja. Sisa 2 kembali ke gudang.
        $request = $this->createRequest('PUT', array_merge($transaksi->toArray(), [
            'jumlah_keluar' => 3
        ]));

        $response = $this->controller->updateTransaksiKeluar($request, $transaksi);

        // Gudang awal 8 + selisih 2 = 10
        $this->assertEquals(10, $spidol->fresh()->jumlah);
        $this->assertTrue($response->getSession()->has('success'));
    }

    /**
     * TC-05 (Path 5): Uji Barang Sama, Jumlah Keluar Diubah Lebih Banyak (Stok Gudang -)
     */
    public function test_sukses_jumlah_keluar_ditambah_sehingga_stok_gudang_berkurang()
    {
        $sapu = Persediaan::create(['kode_barang' => 'BRG-SP', 'nama_barang' => 'Sapu', 'kode_kategori' => 'BRS', 'kategori' => 'Kebersihan', 'tanggal_masuk' => now(), 'harga_satuan' => 10, 'jumlah' => 10, 'harga_total' => 100]);

        $transaksi = TransaksiKeluarPersediaan::create([
            'nomor_transaksi' => 'TRX-005', 'tanggal_input' => now(), 'kode_kategori' => 'BRS', 'kategori' => 'Kebersihan', 'kode_barang' => 'BRG-SP', 'nama_barang' => 'Sapu', 'jumlah_keluar' => 2, 'harga' => 10
        ]);

        // Skenario: Awalnya keluar 2, diedit menjadi keluar 5. Gudang harus dikurangi lagi 3.
        $request = $this->createRequest('PUT', array_merge($transaksi->toArray(), [
            'jumlah_keluar' => 5
        ]));

        $response = $this->controller->updateTransaksiKeluar($request, $transaksi);

        // Gudang awal 10 - selisih 3 = 7
        $this->assertEquals(7, $sapu->fresh()->jumlah);
        $this->assertTrue($response->getSession()->has('success'));
    }

    /**
     * TC-06 (Path 6): Uji Barang Sama, Jumlah Sama, Hanya Edit Keterangan
     */
    public function test_sukses_edit_keterangan_saja_tanpa_ubah_stok()
    {
        $map = Persediaan::create(['kode_barang' => 'BRG-MAP', 'nama_barang' => 'Map', 'kode_kategori' => 'ATK', 'kategori' => 'ATK', 'tanggal_masuk' => now(), 'harga_satuan' => 10, 'jumlah' => 50, 'harga_total' => 500]);

        $transaksi = TransaksiKeluarPersediaan::create([
            'nomor_transaksi' => 'TRX-006', 'tanggal_input' => now(), 'kode_kategori' => 'ATK', 'kategori' => 'ATK', 'kode_barang' => 'BRG-MAP', 'nama_barang' => 'Map', 'jumlah_keluar' => 10, 'harga' => 10, 'keterangan' => 'Awal'
        ]);

        // Skenario: Barang tetap, jumlah tetap, hanya merubah teks keterangan
        $request = $this->createRequest('PUT', array_merge($transaksi->toArray(), [
            'keterangan' => 'Keterangan Diperbarui'
        ]));

        $response = $this->controller->updateTransaksiKeluar($request, $transaksi);

        // Gudang tetap 50, Keterangan harus berubah
        $this->assertEquals(50, $map->fresh()->jumlah);
        $this->assertEquals('Keterangan Diperbarui', $transaksi->fresh()->keterangan);
        $this->assertTrue($response->getSession()->has('success'));
    }
}