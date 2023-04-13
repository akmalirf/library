<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index']);
Route::get('/transactionDetails', [App\Http\Controllers\TransactionDetailController::class, 'index']);
Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);

//book
Route::resource('/books', App\Http\Controllers\BookController::class);
Route::get('/api/books', [App\Http\Controllers\BookController::class, 'api']);

//author
Route::resource('/authors', App\Http\Controllers\AuthorController::class);
Route::get('/api/authors', [App\Http\Controllers\AuthorController::class, 'api']);

//catalog
// Route::get('/catalogs', [App\Http\Controllers\CatalogController::class, 'index']);
// Route::get('/catalogs/create', [App\Http\Controllers\CatalogController::class, 'create']);
// Route::post('/catalogs', [App\Http\Controllers\CatalogController::class, 'store']);
// Route::get('/catalogs/{catalog}/edit', [App\Http\Controllers\CatalogController::class, 'edit']);
// Route::put('/catalogs/{catalog}', [App\Http\Controllers\CatalogController::class, 'update']);
// Route::delete('/catalogs/{catalog}', [App\Http\Controllers\CatalogController::class, 'destroy']);
Route::resource('/catalogs',App\Http\Controllers\CatalogController::class);

//publisher
// Route::resource('publishers',App\Http\Controllers\PublisherController::class)->names([
    //     'index'=>'publishers.index',
//     'create'=>'publishers.create',
//     'store'=>'publishers.store',
//     'show'=>'publishers.show',
//     'edit'=>'publishers.edit',
//     'update'=>'publishers.update',
//     'destroy'=>'publishers.destroy',
// ]);
Route::resource('/publishers',App\Http\Controllers\PublisherController::class);
Route::get('/api/publishers', [App\Http\Controllers\PublisherController::class, 'api']);

Route::resource('/members',App\Http\Controllers\MemberController::class);
Route::get('/api/members', [App\Http\Controllers\MemberController::class, 'api']);

Route::resource('/transactions',App\Http\Controllers\TransactionController::class);
Route::get('api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);
Route::get('/transactions/{transaction}/show', [App\Http\Controllers\TransactionController::class, 'show']);

