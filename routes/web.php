<?php

use Illuminate\Support\Facades\Auth;

//Namespace Auth
use Illuminate\Support\Facades\Route;

//Namespace Admin
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
//Namespace User
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Pengurus\UserController;
use App\Http\Controllers\Pengurus\ProfileController;
use App\Http\Controllers\Pengurus\PendaftaranController;
use App\Http\Controllers\Admin\PendaftaranEventsController;
use App\Http\Controllers\AnggotaController as ControllersAnggotaController;
use App\Http\Controllers\AbsensiController as ControllersAbsensiController;

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
Route::get('/form-contact', 'HomeController@create')->name('show.formContact');
Route::post('/register/anggota', [ControllersAnggotaController::class, 'store'])->name('anggota.register');
Route::get('/kegiatan', [HomeController::class, 'kegiatan'])->name('kegiatan.anggota');
Route::get('/kegiatan/{id}', [HomeController::class, 'showKegiatan'])->name('show.kegiatan');
Route::get('/pelatihan', [HomeController::class, 'pelatihan'])->name('pelatihan.anggota');
Route::get('/pelatihan/{id}', [HomeController::class, 'showPelatihan'])->name('show.pelatihan');

//resource anggota
Route::middleware(['auth'])->group(function () {
	Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
	Route::post('/profil/{id}', [ProfilController::class, 'update'])->name('profil.update');
	route::get('/absen', [ControllersAbsensiController::class, 'camera'])->name('camera');
	route::post('/absen', [ControllersAbsensiController::class, 'storeScanData'])->name('store.absensi');
});



//USER)_CONTACT
Route::post('/contact', 'ContactController@sendMail')->name('contact.send');
Route::post('/send-email', 'ContactController@store')->name('send.email');


route::get('/absensi/kegiatan', 'AbsensiController@kegiatan')->name('form-absensi.kegiatan');
route::post('/absensi/kegiatan', 'AbsensiController@submitKegiatan')->name('absensi.kegiatan');
route::get('/absensi/acara', 'AbsensiController@acara')->name('form-absensi.acara');
route::post('/absensi/acara', 'AbsensiController@submitAcara')->name('absensi.acara');
route::get('/absensi/pelatihan', 'AbsensiController@pelatihan')->name('form-absensi.pelatihan');
route::post('/absensi/pelatihan', 'AbsensiController@submitPelatihan')->name('absensi.pelatihan');


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
	Route::resource('/pendaftaran', 'PendaftaranEventsController')->middleware(['can:admin']);

	//datatable
	Route::get('/acara', [EventController::class, 'acara'])->name('acara.event')->middleware(['can:admin']);
	Route::get('/kegiatan', [EventController::class, 'kegiatan'])->name('kegiatan.event')->middleware(['can:admin']);
	Route::get('/pelatihan', [EventController::class, 'pelatihan'])->name('pelatihan.event')->middleware(['can:admin']);
	Route::get('/absen/kegiatan', [AbsensiController::class, 'kegiatan'])->name('kegiatan.absensi')->middleware(['can:admin']);
	Route::get('/absen/acara', [AbsensiController::class, 'acara'])->name('acara.absensi')->middleware(['can:admin']);
	Route::get('/absen/pelatihan', [AbsensiController::class, 'pelatihan'])->name('pelatihan.absensi')->middleware(['can:admin']);
	Route::get('/daftar/kegiatan', [PendaftaranEventsController::class, 'kegiatan'])->name('kegiatan.pendaftaran')->middleware(['can:admin']);
	Route::get('/daftar/acara', [PendaftaranEventsController::class, 'acara'])->name('acara.pendaftaran')->middleware(['can:admin']);
	Route::get('/daftar/pelatihan', [PendaftaranEventsController::class, 'pelatihan'])->name('pelatihan.pendaftaran')->middleware(['can:admin']);
	// Route::resource('/user', 'UserController')->middleware('can:admin,pengurus');


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

Route::group(['namespace' => 'Pengurus', 'middleware' => 'auth', 'prefix' => 'pengurus'], function () {

	//resource
	Route::resource('/anggotas', 'AnggotaController')->middleware('can:pengurus');
	Route::resource('/event', 'EventController')->middleware(['can:pengurus']);

	//delete
	Route::delete('/daftar/{id}', 'PendaftaranController@destroy')->name('daftar.destroy');

	//datatable
	Route::get('/pendaftar/kegiatan', [PendaftaranController::class, 'kegiatan'])->name('kegiatan.pendaftarans')->middleware(['can:pengurus']);
	Route::get('/pendaftar/acara', [PendaftaranController::class, 'acara'])->name('acara.pendaftarans')->middleware(['can:pengurus']);
	Route::get('/pendaftar/pelatihans', [PendaftaranController::class, 'pelatihan'])->name('pelatihan.pendaftarans')->middleware(['can:pengurus']);

	Route::get('/', [UserController::class, 'index'])->name('pengurus');
	Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
	Route::patch('/profile/update/{pengurus}', [ProfileController::class, 'update'])->name('profile.update');
});



Route::group(['namespace' => 'Anggota', 'middleware' => 'auth', 'prefix' => 'anggota'], function () {
	// Route::resource('/profiles', 'AnggotaController')->middleware('can:anggota');
	// Route::get('/profiles',[AnggotaController::class,'cek'])->name('cek.profile');
	// Route::get('/',[UserController::class,'index'])->name('anggota');
	// Route::get('/profile',[ProfileController::class,'index'])->name('profile');
	// Route::patch('/profile/update/{anggota}',[ProfileController::class,'update'])->name('profile.update');
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
