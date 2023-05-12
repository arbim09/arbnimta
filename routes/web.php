<?php

use Illuminate\Support\Facades\Auth;

//Namespace Auth
use Illuminate\Support\Facades\Route;

//Namespace Admin
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
//Namespace User
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PendaftaranEventsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pengurus\UserController;
use App\Http\Controllers\Pengurus\ProfileController;

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
Route::get('/berita/{id}', [HomeController::class, 'berita'])->name('berita.show');
Route::get('/menuBell', [HomeController::class, 'menubell'])->name('menuBell');
Route::get('/menu-bell', function () {
    return view('layout.anggotaLayouts.menuBell');
})->name('menu.bell');


//USER)_CONTACT
Route::post('/contact', 'ContactController@sendMail')->name('contact.send');
Route::post('/send-email', 'ContactController@store')->name('send.email');
Route::get('/coba', 'ContactController@create')->name('show.form');


route::get('/absensi/kegiatan', 'AbsensiController@kegiatan')->name('form-absensi.kegiatan');
route::post('/absensi/kegiatan', 'AbsensiController@submitKegiatan')->name('absensi.kegiatan');
route::get('/absensi/acara', 'AbsensiController@acara')->name('form-absensi.acara');
route::post('/absensi/acara', 'AbsensiController@submitAcara')->name('absensi.acara');
route::get('/absensi/pelatihan', 'AbsensiController@pelatihan')->name('form-absensi.pelatihan');
route::post('/absensi/pelatihan', 'AbsensiController@submitPelatihan')->name('absensi.pelatihan');


Route::group(['namespace' => 'Admin','middleware' => ['auth', 'can:admin'],'prefix' => 'admin'],function(){
	
	Route::get('/',[AdminController::class,'dashboard'])->name('admin.dashboard')->middleware(['can:admin']);
	Route::resource('/contact', 'ContactController')->middleware(['can:admin,pengurus']);
	Route::resource('/anggota','AnggotaController')->middleware(['can:admin,pengurus']);
	Route::resource('/pengurus','PengurusController')->middleware(['can:admin,pengurus']);
	Route::resource('/admin','AdminController')->middleware(['can:admin,pengurus']);
	Route::resource('/category','CategoryController')->middleware(['can:admin']);
	Route::resource('/posts','PostsController')->middleware(['can:admin']);
	Route::resource('/banners','BannerController')->middleware(['can:admin']);
	Route::resource('/events','EventController')->middleware(['can:admin']);
	Route::resource('/absensi','AbsensiController')->middleware(['can:admin']);
	Route::resource('/pendaftaran','PendaftaranEventsController')->middleware(['can:admin']);

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
	
	Route::view('/404-page','admin.404-page')->name('404-page');
	Route::view('/blank-page','admin.blank-page')->name('blank-page');
	Route::view('/buttons','admin.buttons')->name('buttons');
	Route::view('/cards','admin.cards')->name('cards');
	Route::view('/utilities-colors','admin.utilities-color')->name('utilities-colors');
	Route::view('/utilities-borders','admin.utilities-border')->name('utilities-borders');
	Route::view('/utilities-animations','admin.utilities-animation')->name('utilities-animations');
	Route::view('/utilities-other','admin.utilities-other')->name('utilities-other');
	Route::view('/chart','admin.chart')->name('chart');
	Route::view('/tables','admin.tables')->name('tables');
	

});

Route::group(['namespace' => 'Pengurus','middleware' => 'auth' ,'prefix' => 'pengurus'],function(){

	//resource
	Route::resource('/anggotas', 'AnggotaController')->middleware('can:pengurus');
	Route::resource('/event','EventController')->middleware(['can:pengurus']);

	Route::get('/',[UserController::class,'index'])->name('pengurus');
	Route::get('/profile',[ProfileController::class,'index'])->name('profile');
	Route::patch('/profile/update/{pengurus}',[ProfileController::class,'update'])->name('profile.update');

});



Route::group(['namespace' => 'Anggota','middleware' => 'auth' ,'prefix' => 'anggota'],function(){
	// Route::get('/',[UserController::class,'index'])->name('anggota');
	// Route::get('/profile',[ProfileController::class,'index'])->name('profile');
	// Route::patch('/profile/update/{anggota}',[ProfileController::class,'update'])->name('profile.update');
});

Route::group(['namespace' => 'Auth','middleware' => 'guest'],function(){
	Route::view('/login','auth.login')->name('login');
	Route::post('/login',[LoginController::class,'authenticate'])->name('login.post');
});

// Other
Route::view('/register','auth.register')->name('register');
Route::view('/forgot-password','auth.forgot-password')->name('forgot-password');
Route::post('/logout',function(){
	return redirect()->to('/login')->with(Auth::logout());
})->name('logout');
