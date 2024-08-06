<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Group;
use App\Library\Services\ExtraFieldValueService;
use App\User as AppUser;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function recoverRequest(Request $request){

        $cpf = isset($request->cpf)? $request->cpf: $request->document;
        if(!$cpf){
            return response(['errors'=>"Document is required"], 422);
        }else{
            $request->cpf = $cpf;
        }

        $u = User::where('cpf', $request->cpf)->whereHas('groups', function($group) use($request) {
            $group->where('key', $request->group);
        });
        if(!$u) { return response(['error' => 'user not found'], 404); }
        if($u->email != $request->email){
            return response(['error' => 'user email not correct'], 404);
        }

        $group = Group::where('key', 'like', $request->group)->first();
        if(!$group) {return response(['error' => 'Group not found: ' . $request->group], 404); }

        $efvService = new ExtraFieldValueService();
        $group->extra_fields = $efvService->indexGroup($group, false);

        $color = collect([]);
        $email = collect([]);

        foreach($group->extra_fields as $field) {
            if($field->key === "style_colors") {
                foreach($field->children as $fieldcolor) {
                    $color->put($fieldcolor->key, $fieldcolor->value[0]);
                }
            }
            else if($field->key === "email") {
                foreach($field->children as $fieldemail) {
                    $email->put($fieldemail->key, $fieldemail->value[0]);
                }
            }
        }

        $size = 6;
        $code = "";
        for($i = 0; $i < $size; $i++){
            $code .= strval(rand(0,9));
        }

        $r = DB::table('reset_password')->where('user_id', $u->id)->first();

        DB::table('reset_password')->updateOrInsert(
            ['id' => $r ? $r->id : null],
            [
                'user_id' => $u->id,
                'token' => $code,
                'tries' => $r ? $r->tries + 1 : 1
            ]
        );

        $r = DB::table('reset_password')->where('user_id', $u->id)->first();

        (new EmailController)->sendEmail($email, ['userEmail' => $request->email, 'userName' => $u->name, 'subject' => 'Código de Verificação', 'name' => $group->name, 'body' => view('emails.verification', ['code' => $code, 'key' => $group->key, 'name' => $group->name, 'color' => $color])]);

        //ClearResetPassword::dispatch($r->id)->delay(now()->addMinutes(5));
    }

    public function recoverConfirm(Request $request){

        $cpf = isset($request->cpf)? $request->cpf: $request->document;
        if(!$cpf){
            return response(['errors'=>"Document is required"], 422);
        }else{
            $request->cpf = $cpf;
        }

        $u = User::where('cpf', $request->cpf)->whereHas('groups', function($group) use($request) {
            $group->where('key', $request->group);
        });
        if(!$u) { return response(['error' => 'user not found'], 404); }
        if($u->email != $request->email){
            return response(['error' => 'user email not correct'], 404);
        }

        $r = DB::table('reset_password')
            ->where('user_id', $u->id);

        $rFirst = $r->first();

        // No token
        if(!$rFirst){
            return response(['error' => 'no recover token registered or expired'], 401);
        }

        $v = $r->where('token', $request->code);

        // Invalid token
        if(!$v->first()){

            DB::table('reset_password')
                ->where('id', $rFirst->id)
                ->update(['tries' => $rFirst->tries + 1]);

            return response(['error' => 'invalid token'], 401);
        }

        DB::table('reset_password')->where('id', $rFirst->id)->delete();

        $token = $u->createToken('Laravel Password Grant Client')->accessToken;
        return response(['token' => $token, 'user' => $u], 200);
    }

    protected function resetPassword(Request $request)
    {
       /*  $group = Group::where('key', '=', $request->group)->first();
        if(!$group) {return response(['error' => 'group not found'], 404); }
        $efvService = new ExtraFieldValueService();
        $group->extra_fields = $efvService->indexGroup($group, false);

        $color = collect([]);
        $email = collect([]);

        foreach($group->extra_fields as $field) {
            if($field->key === "style_colors") {
                foreach($field->children as $fieldcolor) {
                    $color->put($fieldcolor->key, $fieldcolor->value[0]);
                }
            }
            else if($field->key === "email") {
                foreach($field->children as $fieldemail) {
                    $email->put($fieldemail->key, $fieldemail->value[0]);
                }
            }
        } */

        $request->validate([
            'password' => 'required|string|confirmed',
        ]);

        User::find(Auth::user()->id)->fill([
            'password' => bcrypt($request->password)
        ])->save();

        /* (new EmailController)->sendEmail($email, ['userEmail' => Auth::user()->email, 'subject' => 'Senha atualizada com sucesso', 'name' => $group->name, 'body' => view('emails.updatedpassword', ['key' => $group->key, 'name' => $group->name, 'color' => $color])]); */

        //event(new PasswordReset($u));
    }
    protected function sendResetResponse(Request $request, $response)
    {
        $response = ['message' => "Password reset successful"];

        return response($response, 200);
    }
    protected function sendResetFailedResponse(Request $request, $response)
    {
        $response = "Token Invalid";

        return response($response, 401);
    }
}
