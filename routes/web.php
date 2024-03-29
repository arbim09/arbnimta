<?php

use Illuminate\Support\Str;

//Namespace Auth
use Illuminate\Http\Request;

//Namespace Admin
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
//Namespace User
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Pengurus\EventController as PengurusEventController;
use App\Http\Controllers\Pengurus\DokumentasiController as PengurusDokumentasiController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Pengurus\UserController;
use App\Http\Controllers\Pengurus\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Pengurus\PendaftaranController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Admin\PendaftaranEventsController;
use App\Http\Controllers\PendaftaranController as DaftarControllers;
use App\Http\Controllers\AbsensiController as ControllersAbsensiController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\DokumentasiController;
use App\Http\Controllers\AnggotaController as ControllersAnggotaController;
use App\Http\Controllers\Pengurus\AnggotaController as PengurusAnggotaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::view('/','welcome');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita/{slug}', [HomeController::class, 'berita'])->name('berita.show');
Route::get('/load-more-berita', [HomeController::class, 'loadMoreBerita'])->name('load-more-berita');
Route::get('/load-more-kegiatan', [HomeController::class, 'loadMoreKegiatan'])->name('load-more-kegiatan');
Route::get('/load-more-pelatihan', [HomeController::class, 'loadMorePelatihan'])->name('load-more-pelatihan');
Route::get('/load-more-acara', [HomeController::class, 'loadMoreAcara'])->name('load-more-acara');
Route::get('/form-contact', 'HomeController@create')->name('show.formContact');
Route::post('/register/anggota', [ControllersAnggotaController::class, 'store'])->name('anggota.register');
Route::get('/kegiatan', [HomeController::class, 'kegiatan'])->name('kegiatan.anggota');
Route::get('/kegiatan/{id}', [HomeController::class, 'showKegiatan'])->name('show.kegiatan');
Route::get('/pelatihan', [HomeController::class, 'pelatihan'])->name('pelatihan.anggota');
Route::get('/pelatihan/{id}', [HomeController::class, 'showPelatihan'])->name('show.pelatihan');
Route::get('/acara', [HomeController::class, 'acara'])->name('acara.anggota');
Route::get('/acara/{id}', [HomeController::class, 'showAcara'])->name('show.acara');


//route anggota
Route::middleware(['auth'])->group(function () {
	Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
	Route::post('/profil/{id}', [ProfilController::class, 'update'])->name('profil.update');
	route::get('/absen', [ControllersAbsensiController::class, 'camera'])->name('camera');
	route::post('/absen', [ControllersAbsensiController::class, 'storeScanData'])->name('store.absensi');
	Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice')->middleware('auth');
	Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
		->middleware(['signed', 'throttle:6,1'])
		->name('verification.verify');
	Route::get('/email/resend', [EmailVerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
	Route::get('/verify-code', [EmailVerificationController::class, 'show'])->name('verification.code');
	// Route::get('/form-pendaftaran', [DaftarControllers::class, 'index'])->name('form-pendaftaran');
	Route::get('/form-pendaftaran/{event_id}', [DaftarControllers::class, 'index'])->name('form-pendaftaran')->middleware('auth');
	Route::post('/store-form-pendaftaran', [DaftarControllers::class, 'store'])->name('form-pendaftaran.store');
	Route::get('/getEvents/{id}', [DaftarControllers::class, 'getEventsByCategory']);
});




//USER)_CONTACT
Route::post('/contact', 'ContactController@sendMail')->name('contact.send');
Route::post('/send-email', 'ContactController@store')->name('send.email');


Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'can:admin'], 'prefix' => 'admin'], function () {

	Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['can:admin']);
	Route::resource('/contact', 'ContactController')->middleware(['can:admin,pengurus']);
	Route::resource('/anggota', 'AnggotaController')->middleware(['can:admin,pengurus']);
	Route::resource('/pengurus', 'PengurusController')->middleware(['can:admin,pengurus']);
	Route::resource('/admin', 'AdminController')->middleware(['can:admin,pengurus']);
	Route::resource('/category', 'CategoryController')->middleware(['can:admin']);
	Route::resource('/posts', 'PostsController')->middleware(['can:admin']);
	Route::resource('/banners', 'BannerController')->middleware(['can:admin']);
	Route::resource('/events', 'EventController')->middleware(['can:admin']);
	Route::resource('/absensi', 'AbsensiController')->middleware(['can:admin']);
	// Route::resource('/dokumentasi', 'DokumentasiController')->middleware(['can:admin']);
	Route::resource('/pendaftaran', 'PendaftaranEventsController')->middleware(['can:admin']);

	Route::get('/dokumentasi/edit/{id}', 'DokumentasiController@edit')->name('dokumentasi.edit');
	Route::put('/dokumentasi/update/{id}', 'DokumentasiController@update')->name('dokumentasi.update');
	Route::get('/dokumentasi/create/{eventId}', 'DokumentasiController@create')->name('dokumentasi.create');
	Route::post('/dokumentasi', 'DokumentasiController@store')->name('dokumentasi.store');




	//datatable
	Route::get('/acara', [EventController::class, 'acara'])->name('acara.event')->middleware(['can:admin']);
	Route::get('/kegiatan', [EventController::class, 'kegiatan'])->name('kegiatan.event')->middleware(['can:admin']);
	Route::get('/pelatihan', [EventController::class, 'pelatihan'])->name('pelatihan.event')->middleware(['can:admin']);
	Route::get('/data-absensi/{id}', [EventController::class, 'dataAbsensi'])->name('dataAbsensi.event')->middleware(['can:admin']);
	Route::get('/absen/kegiatan', [AbsensiController::class, 'kegiatan'])->name('kegiatan.absensi')->middleware(['can:admin']);
	Route::get('/absen/acara', [AbsensiController::class, 'acara'])->name('acara.absensi')->middleware(['can:admin']);
	Route::get('/absen/pelatihan', [AbsensiController::class, 'pelatihan'])->name('pelatihan.absensi')->middleware(['can:admin']);
	Route::get('/daftar/kegiatan', [PendaftaranEventsController::class, 'kegiatan'])->name('kegiatan.pendaftaran')->middleware(['can:admin']);
	Route::get('/daftar/acara', [PendaftaranEventsController::class, 'acara'])->name('acara.pendaftaran')->middleware(['can:admin']);
	Route::get('/daftar/pelatihan', [PendaftaranEventsController::class, 'pelatihan'])->name('pelatihan.pendaftaran')->middleware(['can:admin']);

	//export Excel
	Route::get('/export/data-absensi/{id}', [EventController::class, 'exportToExcel'])->name('dataAbsensiExport.event')->middleware(['can:admin']);
	Route::get('/export/data-anggota', [AnggotaController::class, 'exportToExcel'])->name('dataAnggotaExport')->middleware(['can:admin']);
	Route::get('/export/data-pendaftaran/{event_id}', [PendaftaranEventsController::class, 'exportToExcel'])->name('dataPendaftaranExport')->middleware(['can:admin']);



	//Dokumentasi
	Route::delete('dokumentasi/{id}/delete-gambar1', 'DokumentasiController@deleteGambar1')->name('dokumentasi.delete-gambar1');
	Route::delete('dokumentasi/{id}/delete-gambar2', 'DokumentasiController@deleteGambar2')->name('dokumentasi.delete-gambar2');
	Route::delete('dokumentasi/{id}/delete-gambar3', 'DokumentasiController@deleteGambar3')->name('dokumentasi.delete-gambar3');
	Route::delete('dokumentasi/{id}/delete-gambar4', 'DokumentasiController@deleteGambar4')->name('dokumentasi.delete-gambar4');
	Route::delete('dokumentasi/{id}/delete-gambar5', 'DokumentasiController@deleteGambar5')->name('dokumentasi.delete-gambar5');

	//Route View

	Route::view('/404-page', 'admin.404-page')->name('404-page');
	Route::view('/blank-page', 'admin.blank-page')->name('blank-page');
	Route::view('/buttons', 'admin.buttons')->name('buttons');
	Route::view('/cards', 'admin.cards')->name('cards');
	Route::view('/utilities-colors', 'admin.utilities-color')->name('utilities-colors');
	Route::view('/utilities-borders', 'admin.utilities-border')->name('utilities-borders');
	Route::view('/utilities-animations', 'admin.utilities-animation')->name('utilities-animations');
	Route::view('/utilities-other', 'admin.utilities-other')->name('utilities-other');
	Route::view('/chart', 'admin.chart')->name('chart');
	Route::view('/tables', 'admin.tables')->name('tables');
});


//Pengurus
Route::group(['namespace' => 'Pengurus', 'middleware' => 'auth', 'prefix' => 'pengurus'], function () {

	//resource
	Route::resource('/anggotas', 'AnggotaController')->middleware('can:pengurus');
	Route::resource('/event', 'EventController')->middleware(['can:pengurus']);
	// Route::resource('/dokumen', 'DokumentasiController')->middleware(['can:pengurus']);
	route::get('/dokumen/create', [PengurusDokumentasiController::class, 'create'])->name('dokumen.create')->middleware('can:pengurus');
	route::post('/dokumen/create', [PengurusDokumentasiController::class, 'store'])->name('dokumen.store')->middleware('can:pengurus');
	route::get('/dokumen/edit/{id}', [PengurusDokumentasiController::class, 'edit'])->name('dokumen.edit')->middleware('can:pengurus');
	Route::post('/dokumen/update/{id}', [PengurusDokumentasiController::class, 'update'])->name('dokumen.update')->middleware('can:pengurus');

	//delete
	Route::delete('/daftar/{id}', 'PendaftaranController@destroy')->name('daftar.destroy');

	//delete dokumentasi
	Route::delete('dokumentasi/pengurus/{id}/delete-gambar1', [PengurusDokumentasiController::class, 'deleteGambar1'])->name('dokumentasi.pengurus.delete-gambar1');
	Route::delete('dokumentasi/pengurus/{id}/delete-gambar2', [PengurusDokumentasiController::class, 'deleteGambar2'])->name('dokumentasi.pengurus.delete-gambar2');
	Route::delete('dokumentasi/pengurus/{id}/delete-gambar3', [PengurusDokumentasiController::class, 'deleteGambar3'])->name('dokumentasi.pengurus.delete-gambar3');
	Route::delete('dokumentasi/pengurus/{id}/delete-gambar4', [PengurusDokumentasiController::class, 'deleteGambar4'])->name('dokumentasi.pengurus.delete-gambar4');
	Route::delete('dokumentasi/pengurus/{id}/delete-gambar5', [PengurusDokumentasiController::class, 'deleteGambar5'])->name('dokumentasi.pengurus.delete-gambar5');

	//datatable
	Route::get('/pendaftar/kegiatan', [PendaftaranController::class, 'kegiatan'])->name('kegiatan.pendaftarans')->middleware(['can:pengurus']);
	Route::get('/pendaftar/acara', [PendaftaranController::class, 'acara'])->name('acara.pendaftarans')->middleware(['can:pengurus']);
	Route::get('/pendaftar/pelatihans', [PendaftaranController::class, 'pelatihan'])->name('pelatihan.pendaftarans')->middleware(['can:pengurus']);
	Route::get('/data-absensi/{id}', [PengurusEventController::class, 'dataAbsensi'])->name('pengurus.dataAbsensi.event')->middleware(['can:pengurus']);
	Route::get('/pendaftar', [PendaftaranController::class, 'index'])->name('pengurus.pendaftaran.event')->middleware(['can:pengurus']);


	//export Excel
	Route::get('/export/data-pendaftaran/{event_id}', [PendaftaranController::class, 'exportToExcel'])->name('pengurus.dataPendaftaranExport')->middleware(['can:pengurus']);
	Route::get('/export/data-absensi/{id}', [PengurusEventController::class, 'exportToExcel'])->name('pengurus.dataAbsensiExport.event')->middleware(['can:pengurus']);
	Route::get('/export/data-anggota', [PengurusAnggotaController::class, 'exportToExcel'])->name('pengurus.dataAnggotaExport')->middleware(['can:pengurus']);

	Route::get('/', [UserController::class, 'index'])->name('pengurus');
	Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
	Route::patch('/profile/update/{pengurus}', [ProfileController::class, 'update'])->name('profile.update');
});



Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
	Route::view('/login/admin', 'auth.login')->name('login.admin');
	Route::view('/login', 'auth.loginAnggota')->name('login');
	Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
});

// Other
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('forgot-password');
Route::post('/logout', function () {
	return redirect()->to('/login')->with(Auth::logout());
})->name('logout');

//reset password
Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('password.request');
Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('password.update');
