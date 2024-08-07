<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rotas com regra de admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index']);
    });
});


Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('alunos')->group(function () {
        Route::get('/', [AlunoController::class, 'index'])->name('alunos.index');
        Route::get('create', [AlunoController::class, 'create'])->name('alunos.create');
        Route::post('/', [AlunoController::class, 'store'])->name('alunos.store');
        Route::get('{aluno}/edit', [AlunoController::class, 'edit'])->name('alunos.edit');
        Route::put('{aluno}', [AlunoController::class, 'update'])->name('alunos.update');
        Route::delete('{aluno}', [AlunoController::class, 'destroy'])->name('alunos.destroy');
        Route::get('search', [AlunoController::class, 'search'])->name('alunos.search');
    });

    Route::prefix('turmas')->group(function () {
        Route::get('/', [TurmaController::class, 'index'])->name('turmas.index');
        Route::get('create', [TurmaController::class, 'create'])->name('turmas.create');
        Route::post('/', [TurmaController::class, 'store'])->name('turmas.store');
        Route::get('{turma}/edit', [TurmaController::class, 'edit'])->name('turmas.edit');
        Route::put('{turma}', [TurmaController::class, 'update'])->name('turmas.update');
        Route::delete('{turma}', [TurmaController::class, 'destroy'])->name('turmas.destroy');
    });

});

Route::middleware(['auth'])->group(function () {
    Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
    Route::get('/matriculas/check', 'MatriculaController@check');
    Route::delete('/matriculas/{id}', 'MatriculaController@destroy');
    Route::get('/matriculas/{turma_id}', [MatriculaController::class, 'show'])->name('matriculas.show');
    Route::post('/matriculas', [MatriculaController::class, 'store'])->name('matriculas.store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
