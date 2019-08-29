<?php


/*
-----------------------
 HALAMAN DEPAN / PEMBELI
-----------------------
*/
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'frontend\HomeController@index')->name('index');
Route::get('/shop', 'frontend\ShopController@index')->name('shop');
Route::get('/detail-produk/{id?}', 'frontend\ShopController@detailproduk');

// Keranjang Belanja  (Cart)
// TANPA LOGIN 
Route::get('/cart', 'frontend\CartController@index')->name('cart');
Route::get('/cart/tambah/{id}', 'frontend\CartController@tambah')->name('cart.tambah');
Route::patch('/cart/edit', 'frontend\CartController@edit')->name('cart.edit');
Route::delete('/cart/hapus', 'frontend\CartController@hapus')->name('cart.hapus');
Route::get('/cart/show', 'frontend\CartController@show'); // HAPUS -> development
Route::get('/cart/delete', 'frontend\CartController@delete'); // HAPUS -> development

Route::get('/checkout', 'frontend\CheckoutController@index')->name('checkout');
Route::post('/checkout', 'frontend\CheckoutController@checkout')->name('checkout.proses');
Route::post('/checkout/vouchers', 'frontend\CheckoutController@cekvoucher')->name('checkout.voucher');

Route::get('/session/all', 'frontend\CheckoutController@showsession');
Route::post('/checkout/voucher', 'frontend\CheckoutController@usevoucher')->name('check.voucher');
Route::delete('/checkout/voucher', 'frontend\CheckoutController@delvoucher')->name('del.voucher');

Route::get('/invoice/{id}', 'frontend\InvoiceController@index')->name('invoice');
Route::get('/invoice/status/{id}', 'frontend\InvoiceController@statusPembayaran')->name('invoice.cek');

// Route::get('/transaksi', 'frontend\TransactionController@index')->name('transaksi');
// Route::get('/transaksi', 'frontend\TransactionController@index')->name('transaksi');
Route::get('/transaksi/{orderby?}/', 'frontend\TransactionController@index')->name('transaksi');
Route::get('/transaksi/detail/{id}', 'frontend\TransactionController@detail')->name('transaksi.detail');
// Route::get('/login', function () {
//     return view('frontend.login');
// });
Route::get('register', function () {
    return view('frontend.register');
});
Route::get('/pengaturan', 'frontend\SettingController@pengaturan')->name('pengaturan');
Route::post('/pengaturan/alamat', 'frontend\SettingController@tambahAlamat')->name('pengaturan.tambahalamat');
Route::post('/pengaturan/profil', 'frontend\SettingController@updateProfil')->name('pengaturan.updateProfil');
Route::post('/pengaturan/profil/gambar', 'frontend\SettingController@updateProfilGambar')->name('pengaturan.updateProfilGambar');
Route::post('/pengaturan/password', 'frontend\SettingController@updatePassword')->name('pengaturan.updatePassword');
Route::get('/profil', 'frontend\SettingController@profil')->name('profil');
Route::get('/about', function () {
    return view('frontend.pages.about');
})->name('about');
Route::get('/contact', function () {
    return view('frontend.pages.contact');
})->name('contact');
Route::get('/faq', function () {
    return view('frontend.pages.faq');
})->name('faq');

Route::get('/rajaongkir/kota/{id}', 'frontend\CheckoutController@tampilKota');
Route::get('/rajaongkir/kecamatan/{id}', 'frontend\CheckoutController@tampilKecamatan');
Route::get('/rajaongkir/cekongkir/{asal}/{tujuan}/{berat}', 'frontend\CheckoutController@cekOngkir');

Route::get('/cekstatuspesanan', 'frontend\CekPesananController@index')->name('cek.pesanan');
Route::post('/cekstatuspesanan', 'frontend\CekPesananController@cekPesanan')->name('cek.pesanan.post');



Auth::routes();

/*
-----------------------
 HALAMAN ADMIN / PENGELOLA
-----------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('dashboard', 'HomeController@index')->name('admin.dashboard');
    Route::get('register', 'Auth\RegisterController@showRegisterForm')->name('admin.auth.register');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.auth.login');
    Route::post('login', 'Auth\LoginController@Login')->name('admin.auth.login');
    Route::get('logout', 'Auth\LoginController@Logout')->name('admin.auth.logout');
});

Route::group(['prefix' => 'admin-panel', 'middleware' => ['admin']], function(){
    Route::get('dashboard', 'HomeController@index')->name('admin.dashboard');
    Route::get('transaksi/pembayaran', 'TransaksiController@index')->name('pembayaran.transaksi');
    Route::get('transaksi/konfirmasi/{id?}', 'TransaksiController@konfirmasiPembayaran');
    Route::get('transaksi/resi', 'TransaksiController@resi')->name('resi.transaksi');
    Route::post('transaksi/uploadresi', 'TransaksiController@uploadresi')->name('resi.upload');
    Route::get('transaksi/cetak/{id}', 'TransaksiController@cetakTransaksi')->name('transaksi.cetak');
    Route::get('transaksi/resi/cek/{id}', 'TransaksiController@cekresi')->name('resi.cek');
    Route::get('transaksi/resi/confirm/{id}', 'TransaksiController@konfirmasi_transaksiselesai');
    Route::get('transaksi/daftartransaksi', 'TransaksiController@daftartransaksi')->name('daftar.transaksi');
    Route::get('transaksi/cek/', 'TransaksiController@cekpembayaran')->name('cek.bayar.bca');



    // Produk
    Route::get('/produk', 'ProductController@index')->name('admin.product');
    Route::get('/produk/tambah', 'ProductController@TambahProduk')->name('admin.product.tambah');
    Route::post('/produk/tambah', 'ProductController@ProsesTambahProduk')->name('admin.product.proses.tambah');
    Route::get('/produk/edit/{id?}', 'ProductController@EditProduk')->name('admin.product.edit');
    Route::post('/produk/edit/{id?}', 'ProductController@ProsesEditProduk')->name('admin.product.proses.edit');;
    Route::get('/produk/hapus/{id?}', 'ProductController@HapusProduk');

    // Kategori
    Route::get('/kategori', 'KategoriController@index')->name('admin.kategori');
    Route::get('/kategori/tambah', 'KategoriController@TambahProduk')->name('admin.kategori.tambah');
    Route::post('/kategori/tambah', 'KategoriController@ProsesTambahProduk')->name('admin.kategori.proses.tambah');
    Route::get('/kategori/edit/{id?}', 'KategoriController@EditProduk')->name('admin.kategori.edit');
    Route::post('/kategori/edit/{id?}', 'KategoriController@ProsesEditProduk')->name('admin.kategori.proses.edit');;
    Route::get('/kategori/hapus/{id?}', 'KategoriController@HapusProduk');

    // Satuan
    Route::get('/satuan', 'SatuanController@index')->name('admin.satuan');
    Route::get('/satuan/tambah', 'SatuanController@TambahProduk')->name('admin.satuan.tambah');
    Route::post('/satuan/tambah', 'SatuanController@ProsesTambahProduk')->name('admin.satuan.proses.tambah');
    Route::get('/satuan/edit/{id?}', 'SatuanController@EditProduk')->name('admin.satuan.edit');
    Route::post('/satuan/edit/{id?}', 'SatuanController@ProsesEditProduk')->name('admin.satuan.proses.edit');;
    Route::get('/satuan/hapus/{id?}', 'SatuanController@HapusProduk');

    // Voucher
    Route::get('admin/voucher', 'VoucherController@index')->name('admin.voucher');
    Route::get('admin/voucher/tambah', 'VoucherController@Tambah')->name('admin.voucher.tambah');
    Route::post('admin/voucher/tambah', 'VoucherController@ProsesTambah')->name('admin.voucher.proses.tambah');
    Route::get('admin/voucher/edit/{id?}', 'VoucherController@Edit')->name('admin.voucher.edit');
    Route::post('admin/voucher/edit/{id?}', 'VoucherController@ProsesEdit')->name('admin.voucher.proses.edit');;
    Route::get('admin/voucher/hapus/{id?}', 'VoucherController@Hapus');

    // Metode Pembayaran
    Route::get('admin/MetodePembayaran', 'MetodePembayaranController@index')->name('admin.metodepembayaran');
    Route::post('admin/MetodePembayaran', 'MetodePembayaranController@getMutasiRekening')->name('admin.cekmutasi');
    Route::get('admin/MetodePembayaran/ceksaldo', 'MetodePembayaranController@cekSaldo')->name('admin.ceksaldo');
    Route::post('admin/MetodePembayaran/gantinorek', 'MetodePembayaranController@changeBCA')->name('admin.changebca');

    //Laporan
    Route::get('laporan/laporantransaksi', 'LaporanController@index')->name('admin.laporan');
    Route::get('laporan/laporanproduk', 'LaporanController@laporanproduk')->name('admin.laporan.produk');

    // Config / Konfigurasi
    Route::get('/pengaturan/tokos', 'ConfigController@index')->name('admin.pengaturan');
    Route::post('/pengaturan', 'ConfigController@updatePengaturan')->name('admin.pengaturan.update');
    Route::post('/pengaturan/logo', 'ConfigController@updateLogo')->name('admin.pengaturan.updateLogo');
    Route::post('/pengaturan/favicon', 'ConfigController@updateFavicon')->name('admin.pengaturan.updateFavicon');

    Route::get('/pengaturan/admins', 'ConfigController@showRegisterAdminForm')->name('register.admin.view');
    Route::post('/pengaturan/admin', 'ConfigController@createAdmin')->name('register.admin');
    
});

Route::get('register', 'Auth\RegisterController@showRegisterForm')->name('register');

Route::group(['middleware' => ['auth', 'web']], function () {
    // your routes go here
});





// Route::view('/home', 'home')->middleware('auth');
// Route::view('/admins', 'admin');
// Route::view('/customer', 'customer')->middleware('auth');