<?php

use Illuminate\Support\Facades\Route;

//Namespace Auth
use App\Http\Controllers\Auth\LoginController;

//Namespace Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChartController;
//Namespace User
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;

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


Route::group(['namespace' => 'Admin','middleware' => 'auth','prefix' => 'admin'],function(){
	

	Route::get('/',[AdminController::class,'dashboard'])->name('admin.dashboard')->middleware(['can:admin']);
	// Route::get('/anggota/chart',[AnggotaController::class,'chart'])->name('chart.gender')->middleware(['can:admin']);
	Route::get('/chart/gender', [ChartController::class, 'gender'])->name('chart.gender')->middleware(['can:admin']);
	//Route Rescource
	Route::resource('/user','UserController')->middleware(['can:admin']);
	Route::resource('/anggota','AnggotaController')->middleware(['can:admin']);
	Route::resource('/admin','AdminController')->middleware(['can:admin']);
	Route::resource('/category','CategoryController')->middleware(['can:admin']);
	Route::resource('/posts','PostsController')->middleware(['can:admin']);
	Route::resource('/test','PercobaabController')->middleware(['can:admin']);
 
	
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
