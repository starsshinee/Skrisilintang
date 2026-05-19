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
        // Setup user dummy
        $this->admin = User::create([
            'name' => 'Admin', 
            'username' => 'admin_sistem',
            'email' => 'admin@test.com', 
            'password' => bcrypt('password')
        ]);
        $this->actingAs($this->admin);
        $this->controller = new AdminPersediaanController();
    }

    private function createRequest($data)
    {
        $request = Request::create('/dummy', 'PUT', $data);
        $request->setLaravelSession(app('session.store'));
        return $request;
    }

    /** Path 1: Validasi stok kurang */
    public function test_tc01_stok_tidak_cukup()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'jumlah' => 2, 'harga_satuan' => 100, 'harga_total' => 200 // 🔥 Ditambahkan
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'jumlah_keluar' => 1, 'harga' => 100, 
            'total' => 100, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest(['kode_kategori' => 'K1', 'kategori' => 'Kat1', 'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'jumlah_keluar' => 5, 'harga' => 100]);
        $response = $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertTrue($response->getSession()->has('errors'));
    }

    /** Path 2: Ganti Barang (Master Ada) */
    public function test_tc02_ganti_barang_master_ada()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'jumlah' => 5, 'harga_satuan' => 100, 'harga_total' => 500 // 🔥 Ditambahkan
        ]);
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'B', 'nama_barang' => 'Barang B', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'jumlah' => 10, 'harga_satuan' => 100, 'harga_total' => 1000 // 🔥 Ditambahkan
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'jumlah_keluar' => 2, 'harga' => 100, 
            'total' => 200, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest(['kode_kategori' => 'K1', 'kategori' => 'Kat1', 'kode_barang' => 'B', 'nama_barang' => 'Barang B', 'jumlah_keluar' => 3, 'harga' => 100]);
        $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertEquals(7, Persediaan::where('kode_barang', 'A')->first()->jumlah); 
        $this->assertEquals(7, Persediaan::where('kode_barang', 'B')->first()->jumlah); 
    }

    /** Path 3: Ganti Barang (Master Tidak Ada) */
    public function test_tc03_ganti_barang_master_tidak_ada()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'B', 'nama_barang' => 'Barang B', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'jumlah' => 10, 'harga_satuan' => 100, 'harga_total' => 1000 // 🔥 Ditambahkan
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'jumlah_keluar' => 2, 'harga' => 100, 
            'total' => 200, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest(['kode_kategori' => 'K1', 'kategori' => 'Kat1', 'kode_barang' => 'B', 'nama_barang' => 'Barang B', 'jumlah_keluar' => 3, 'harga' => 100]);
        $response = $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertEquals(7, Persediaan::where('kode_barang', 'B')->first()->jumlah);
    }

    /** Path 4: Barang Sama, Jumlah dikurangi */
    public function test_tc04_jumlah_dikurangi()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'jumlah' => 5, 'harga_satuan' => 100, 'harga_total' => 500 // 🔥 Ditambahkan
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'jumlah_keluar' => 4, 'harga' => 100, 
            'total' => 400, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest(['kode_kategori' => 'K1', 'kategori' => 'Kat1', 'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'jumlah_keluar' => 1, 'harga' => 100]);
        $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertEquals(8, Persediaan::where('kode_barang', 'A')->first()->jumlah); 
    }

    /** Path 5: Barang Sama, Jumlah ditambah */
    public function test_tc05_jumlah_ditambah()
    {
        Persediaan::create([
            'tanggal_masuk' => now()->format('Y-m-d'),
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'jumlah' => 10, 'harga_satuan' => 100, 'harga_total' => 1000 // 🔥 Ditambahkan
        ]);
        
        $trx = TransaksiKeluarPersediaan::create([
            'tanggal_input' => now()->format('Y-m-d'),
            'kode_kategori' => 'K1', 'kategori' => 'Kat1', 
            'kode_barang' => 'A', 'nama_barang' => 'Barang A', 
            'jumlah_keluar' => 2, 'harga' => 100, 
            'total' => 200, 'user_id' => $this->admin->id
        ]);

        $request = $this->createRequest(['kode_kategori' => 'K1', 'kategori' => 'Kat1', 'kode_barang' => 'A', 'nama_barang' => 'Barang A', 'jumlah_keluar' => 5, 'harga' => 100]);
        $this->controller->updateTransaksiKeluar($request, $trx);

        $this->assertEquals(7, Persediaan::where('kode_barang', 'A')->first()->jumlah); 
    }
}