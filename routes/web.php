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

Route::get('/home', 'HomeController@index')->name('home');
