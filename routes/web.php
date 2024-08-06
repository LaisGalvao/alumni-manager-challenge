<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\MatriculaController;

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

// rota de teste do email para o cliente novo confirmando o registro
/* Route::get('welcome', function () {
    return new App\Mail\WelcomeUser('test');
});
 */
// rota de teste do email para notificar um novo cliente do pré cadastro
//utilizando o super admin para puxar as infos de teste mesmo
//Route::get('newuser', function () {
    /*$test = ['name'=> 'Super Admin 2',

   'document'=>' 00.000.000/0000-00',

    'email'=>'email@email.com.br',

   'telephone' =>'(99)99999-9999']; */
    //App\Models\User::find('f16ebafc-2c77-4c75-8a42-bf558035391f');
    //return new App\Mail\SendNewUser($test);
//});

Auth::routes();

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rotas protegidas adicionais
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index']);
        // Outras rotas para administradores
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

   /*  Route::prefix('matriculas')->group(function () {
        Route::get('/', [MatriculaController::class, 'index'])->name('matriculas.index');
        Route::post('/new', [MatriculaController::class, 'store'])->name('matriculas.store');
    }); */
});

Route::middleware(['auth'])->group(function () {
    Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
    Route::get('/matriculas/{turma_id}', [MatriculaController::class, 'show'])->name('matriculas.show');
    Route::post('/matriculas', [MatriculaController::class, 'store'])->name('matriculas.store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
