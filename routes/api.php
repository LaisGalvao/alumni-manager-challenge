<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors', 'json.response']], function () {
    //funcionalidades aberta para todos os usuários
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api');
    Route::post('/register/store', 'Auth\ApiAuthController@registerStore')->name('register.store.api');

    Route::post('/notification/create','NotificationController@create')->name('create.notification.api');

    Route::get('/group/public/index', 'GroupController@publicIndex')->name('index.public.group.api');

    // recover account
    Route::post('/recover/request', 'Auth\ResetPasswordController@recoverRequest')->name('recover.request.api');
    Route::post('/recover/confirm', 'Auth\ResetPasswordController@recoverConfirm')->name('recover.confirm.api');


    Route::group(['middleware' => ['auth:api']], function () {
        //funcionalidades aberta para todos os usuários logados
        Route::get('/auth/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
        Route::post('/auth/update/{user}', 'Auth\ApiAuthController@update')->name('update.api');

        Route::post('/reset_password', 'Auth\ResetPasswordController@resetPassword')->name('reset_password.user.api');

        Route::get('/message/index', 'MessageController@index')->name('index.message.api');
        Route::get('/message/priority/index', 'MessageController@priorityIndex')->name('index.priority.message.api');
        Route::get('/message/show/{msg}', 'MessageController@show')->name('show.message.api');

        Route::get('/group/index', 'GroupController@index')->name('index.group.api');
        Route::put('/group/update', 'GroupController@update')->name('update.group.api');

        Route::get('/role/index', 'RoleController@index')->name('index.role.api');
        Route::get('/role/show/{role}', 'RoleController@show')->name('show.role.api');

        Route::get('/user/show/{user}', 'UserController@show')->name('show.user.api');

        Route::get('/extra_field/user', 'ExtraFieldController@user')->name('user.extraField.api');
        Route::post('/extra_field/owner_delete', 'ExtraFieldController@ownerDelete')->name('delete.user.extraField.api');

        // reset password
        Route::post('/reset_password', 'Auth\ResetPasswordController@resetPassword')->name('reset_password.user.api');

        // image profile
        Route::get('/image/show', 'ImageController@getImages')->name('show.image.api');
        Route::post('/image/upload', 'ImageController@postUpload')->name('upload.image.api');
        Route::post('/logo/upload', 'ImageController@logoUpload')->name('upload.logo.api');

        Route::group(['middleware' => ['api.groups']], function () {
            //funcionalidades aberta para usuário validando se o grupo tem a regra associada
            Route::get('/user/index', 'UserController@index')->name('index.user.api');
            Route::delete('/user/delete', 'UserController@delete')->name('delete.user.api');

            Route::group(['middleware' => ['higher']], function () {
                //funcionalidades aberta para usuário que levam em consideração a hierarquia do grupo
                Route::post('/role/create', 'RoleController@create')->name('create.role.api');
                Route::post('/role/linkgroup/{role}', 'RoleController@linkGroup')->name('linkgroup.role.api');

                Route::post('/group/create', 'GroupController@create')->name('create.group.api');
                Route::get('/group/show', 'GroupController@show')->name('show.group.api');
                Route::post('/group/linkuser', 'GroupController@linkUser')->name('linkuser.group.api');
                Route::post('/group/user/index', 'GroupController@userIndex')->name('index.user.group.api');

                Route::post('/auth/edit', 'Auth\ApiAuthController@edit')->name('edit.auth.api');
                Route::post('/auth/create', 'Auth\ApiAuthController@create')->name('create.auth.api');

                Route::post('/extra_field/create', 'ExtraFieldController@create')->name('create.extraField.api');
                Route::post('/extra_field/update/{ex}', 'ExtraFieldController@update')->name('update.extraField.api');
                Route::get('/extra_field/useringroup', 'ExtraFieldController@useringroup')->name('useringroup.extraField.api');
                Route::post('/extra_field/delete/{user}', 'ExtraFieldController@extraFieldDelete')->name('delete.extraField.api');

                Route::post('/message/create', 'MessageController@create')->name('create.message.api');

                Route::get('/object/index', 'ObjectController@index')->name('index.object.api');
                Route::get('/object/create', 'ObjectController@store')->name('create.object.api');
                Route::get('/object/update/{object}', 'ObjectController@update')->name('update.object.api');
                Route::get('/object/linkgroup/{object}', 'ObjectController@linkGroup')->name('linkgroup.object.api');
                Route::get('/object/linkuser/{object}', 'ObjectController@linkUser')->name('linkuser.object.api');
                Route::get('/object/linkobject/{object}', 'ObjectController@linkObject')->name('linkobject.object.api');
                Route::get('/object/show/{object}', 'ObjectController@show')->name('show.object.api');
            });
        });
    });
});
