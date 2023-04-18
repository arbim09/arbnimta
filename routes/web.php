<?php

use Illuminate\Support\Facades\Auth;

//Namespace Auth
use Illuminate\Support\Facades\Route;

//Namespace Admin
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
//Namespace User
use App\Http\Controllers\Admin\ContactController;
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

Route::view('/','welcome');


//USER)_CONTACT
Route::post('/contact', 'ContactController@sendMail')->name('contact.send');
Route::post('/send-email', 'ContactController@store')->name('send.email');
Route::get('/coba', 'ContactController@create')->name('show.form');


route::get('/absensi/kegiatan', 'AbsensiController@kegiatan')->name('form-absensi.kegiatan');
route::post('/absensi/kegiatan', 'AbsensiController@submitKegiatan')->name('absensi.kegiatan');


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
