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
        $this->admin = User::create([
            'name' => 'Admin', 
            'username' => 'admin_sistem',
            'email' => 'admin@test.com', 
            'password' => bcrypt('password'),
            'role' => 'adminpersediaan'
        ]);
        $this->actingAs($this->admin);
        $this->controller = new AdminPersediaanController();
    }

    // 🔥 PERBAIKAN DI SINI: Menggunakan $request->merge() agar input terbaca 100% oleh validasi Laravel
    private function createRequest($data)
    {
        $request = new Request();
        $request->setMethod('PUT');
        $request->merge($data);
        $request->setLaravelSession(app('session.store'));
        return $request;
    }

    /** TC-01 (Path 1): Stok Persediaan Baru Tidak Mencukupi */
    public function test_tc01_stok_tidak_cukup()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 'satuan' => 'Unit',
            'jumlah' => 2, 'harga_satuan' => 100, 'harga_total' => 200
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 1, 'harga' => 100, 
            'total' => 100, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest([
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 5, 'harga' => 100
        ]);
        
        $response = $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertTrue($response->getSession()->has('errors'));
        $this->assertEquals('Stok persediaan tidak mencukupi!', $response->getSession()->get('errors')->first('jumlah_keluar'));
    }

    /** TC-02 (Path 2): Barang Diganti (Master Barang Lama Tersedia) */
    public function test_tc02_ganti_barang_master_lama_ada()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 'satuan' => 'Unit',
            'jumlah' => 5, 'harga_satuan' => 100, 'harga_total' => 500
        ]);
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'B', 'nama_barang' => 'Barang B', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 'satuan' => 'Unit',
            'jumlah' => 10, 'harga_satuan' => 100, 'harga_total' => 1000
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 5, 'harga' => 100, 
            'total' => 500, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest([
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'B', 'nama_barang' => 'Barang B', 'satuan' => 'Unit',
            'jumlah_keluar' => 3, 'harga' => 100
        ]);
        $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertEquals(10, Persediaan::where('kode_barang', 'A')->first()->jumlah); 
        $this->assertEquals(7, Persediaan::where('kode_barang', 'B')->first()->jumlah); 
    }

    /** TC-03 (Path 3): Barang Diganti (Master Barang Lama Dihapus) */
    public function test_tc03_ganti_barang_master_lama_dihapus()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'B', 'nama_barang' => 'Barang B', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 'satuan' => 'Unit',
            'jumlah' => 10, 'harga_satuan' => 100, 'harga_total' => 1000
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 5, 'harga' => 100, 
            'total' => 500, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest([
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'B', 'nama_barang' => 'Barang B', 'satuan' => 'Unit',
            'jumlah_keluar' => 3, 'harga' => 100
        ]);
        $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertEquals(7, Persediaan::where('kode_barang', 'B')->first()->jumlah);
    }

    /** TC-04 (Path 4): Barang Sama (Input jumlah_keluar Dikurangi) */
    public function test_tc04_barang_sama_jumlah_dikurangi()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 'satuan' => 'Unit',
            'jumlah' => 10, 'harga_satuan' => 100, 'harga_total' => 1000
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 5, 'harga' => 100, 
            'total' => 500, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest([
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 2, 'harga' => 100
        ]);
        $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertEquals(13, Persediaan::where('kode_barang', 'A')->first()->jumlah); 
    }

    /** TC-05 (Path 5): Barang Sama (Input jumlah_keluar Ditambah) */
    public function test_tc05_barang_sama_jumlah_ditambah()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 'satuan' => 'Unit',
            'jumlah' => 10, 'harga_satuan' => 100, 'harga_total' => 1000
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 5, 'harga' => 100, 
            'total' => 500, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest([
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 8, 'harga' => 100
        ]);
        $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertEquals(7, Persediaan::where('kode_barang', 'A')->first()->jumlah); 
    }

    /** TC-06 (Path 6): Barang Sama (Hanya Ubah Keterangan/Tanggal) */
    public function test_tc06_barang_sama_jumlah_tetap()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 'satuan' => 'Unit',
            'jumlah' => 10, 'harga_satuan' => 100, 'harga_total' => 1000
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 5, 'harga' => 100, 
            'total' => 500, 'user_id' => $this->admin->id
        ]);

        // Request simulasi edit data tanpa merubah angka jumlah_keluar (Selisih == 0)
        $request = $this->createRequest([
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'satuan' => 'Unit',
            'jumlah_keluar' => 5, 'harga' => 100
        ]);
        
        $this->controller->updateTransaksiKeluar($request, $trx);

        // Assert: Stok master persediaan harus tetap 10 (tidak dipotong/ditambah)
        $this->assertEquals(10, Persediaan::where('kode_barang', 'A')->first()->jumlah); 
    }
}
