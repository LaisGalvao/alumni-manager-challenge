<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Http\Controllers\Controller;
use App\Library\Services\ExtraFieldValueService;
use App\Library\Services\NotificationService;
use App\Models\Group;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\SendNewUser;
use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Logger\ConsoleLogger;

class ApiAuthController extends Controller
{
    public function edit(Request $request)
    {
        $user = User::find($request['user_id']);

        if ($user == null) {
            return response(['errors' => 'User not found'], 422);
        }

        return $this->saveEdit($request, $user);
    }

    public function update(Request $request, User $user)
    {
        if ($user->id != Auth::id()) {
            return response(['errors' => 'You do not have permission to edit this user'], 422);
        }

        return $this->saveEdit($request, $user);
    }

    private function saveEdit(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255',
            'password' => 'string|min:6|confirmed',
            'telephone' => 'string|min:11|celular_com_ddd',
            'cpf' => 'string|min:10',
            //'document' => 'string|min:9',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        if (isset($request['group_key']) && !Group::where('key', $request['group_key'])->where('public', 1)->get()) {
            return response(['errors' => 'this group is not for open registration'], 422);
        }

        $user->name = (isset($request['name'])) ? $request['name'] : $user->name;
        $user->email = (isset($request['email'])) ? $request['email'] : $user->email;
        $user->password = (isset($request['password'])) ? Hash::make($request['password']) : $user->password;
        $user->telephone = (isset($request['telephone'])) ? $request['telephone'] : $user->telephone;
        $user->cpf = (isset($request['cpf'])) ? $request['cpf'] : $user->cpf;
        $this->linkGroup($user, $request);

        $efvService = new ExtraFieldValueService();
        $efvService->createUser($request, $user);

        $user->save();
        $user->extra_fields = $efvService->indexUser($user);

        $response = ['user' => $user];

        return response($response, 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'telephone' => 'required|string|min:11|celular_com_ddd',
            'group_key' => 'required|string|max:255',
            'cpf' => 'required|string|min:10',
            // 'document' => 'required_without:cpf|string|min:10',
            // 'cnh' => 'required_without:document|string|min:10',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

      /*   if(isset($request->cpf)) {
            $cpf = $request->cpf;
        } elseif (isset($request->document)) {
            $cpf = $request->document;
        } else{
            $cpf = $request->cnh;
        } */

       $cpf = isset($request->cpf) ? $request->cpf : $request->document;
        if (!$cpf) {
            return response(['errors' => "Document is required"], 422);
        } else {
            $request->cpf = $cpf;
        }

        if (!Group::where('key', $request['group_key'])->where('public', 1)->get()) {
            return response(['errors' => 'this group is not for open registration'], 422);
        }

        $users = User::where('cpf', $request->cpf)->get();
        if (!empty($users)) {
            foreach ($users as $user) {
                $user_groups = $user->whereHas('groups', function ($group) use ($request) {
                    $group->where('key', $request->group_key);
                })->get();
                if ($user_groups->count() > 0) {
                    return response(['errors' => "User is already registered in this group"], 422);
                }
            }
        }

        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);

        $user = User::create($request->toArray());
        $user->tenant_id = $user->id;
        $notificationService = new NotificationService();
        $request['user_id'] = $user->id;


        $resp = $notificationService->updateNotification($request);

        // verificando se veio a partir do register store (possui type)
        if (!isset($request->type)) {
            if ($resp['response'] > 0) {
                $user->forceDelete();
                return response(['errors' => $resp['errors']], 422);
            }
        }

        //envio de email com os dados do cliente
        Mail::to('cassiops7@gmail.com')->send(
            new SendNewUser($request->all())
        );

        Mail::to($request->email)->send(
            new WelcomeUser($request->name)
        );
        $this->linkGroup($user, $request);
        $efvService = new ExtraFieldValueService();
        //TODO quando for do tipo sender criar tabela de preço
        /**
         * "tax_deliver": {
            *"fixed": [0, "2,00"],
            *"2km": [0, "5,00"],
            *"6km": [0, "7,00"],
            *"10km": [0, "10,00"],
            *"add": [0, "1,00"],
        *}
         */
        $efvService->createUser($request, $user);
        $this->getExtraFields($request, $user, isset($request->type) ? true : false);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token, 'user' => $user];

        return response($response, 200);
    }


    public function registerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:240',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'telephone' => 'required|string|min:11|celular_com_ddd',
            'cpf' => 'string|min:11',
            'document' => 'string|min:9',
            'type' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $cpf = isset($request->cpf) ? $request->cpf : $request->document;
        if (!$cpf) {
            return response(['errors' => "Document is required"], 422);
        } elseif (User::where('cpf', $cpf)->first()) {
            return response(['errors' => "The document has already been taken"], 422);
        }

        $master_group_id = Group::where('key', $request->type)->pluck('id')->first();

        if (!$master_group_id) {
            return response(['errors' => "Valid type is required"], 422);
        }

        $request->merge(['key' => $request->cpf, 'description' => 'Loja do(a) ' . $request->name, 'master_group_id' => $master_group_id]);

        $response_group = (new GroupController)->create($request);
        $response_group = json_decode($response_group->content(), true);

        $group = Group::find($response_group['group']['id']);

        $efvService = new ExtraFieldValueService();
        $efvService->updateGroup($request, $group, 'group');

        $group->save();
        $group->extra_fields = $efvService->indexGroup($group);

        $request->merge(['group_key' => $request->key]);

        return $this->register($request);
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'telephone' => 'required|string|min:11|celular_com_ddd',
            'cpf' => 'string|min:10',
            'document' => 'string|min:9',
            'group_key' => 'string|max:255',
            'group_keys' => 'string|max:255'
        ]);



        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $cpf = isset($request->cpf) ? $request->cpf : $request->document;
        if (!$cpf) {
            return response(['errors' => "Document is required"], 422);
        } else {
            $request->cpf = $cpf;
        }

        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);

        $user = User::create($request->toArray());
        $user->tenant_id = $user->id;

        $this->linkGroup($user, $request);
        $this->getExtraFields($request, $user);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token, 'user' => $user];
        return response($response, 200);
    }


    private function sendEmail(Request $request, $group_key, $efvService)
    {
        $group = Group::where('key', 'like', $group_key)->first();
        if (!$group) {
            return response(['error' => 'Group not found: ' . $group_key], 404);
        }

        $efvService = new ExtraFieldValueService();
        $group->extra_fields = $efvService->indexGroup($group, false);

        $color = collect([]);
        $email = collect([]);

        foreach ($group->extra_fields as $field) {
            if ($field->key === "style_colors") {
                foreach ($field->children as $fieldcolor) {

                    $color->put($fieldcolor->key, $fieldcolor->value[0] ?? '#fff');
                }
            } else if ($field->key === "email") {
                foreach ($field->children as $fieldemail) {
                    $email->put($fieldemail->key, $fieldemail->value[0]);
                }
            }
        }

        if ($email->count() > 0) {
            (new EmailController)->sendEmail($email, ['userEmail' => $request->email, 'userName' => $request->name, 'subject' => 'Bem-vindo ao nosso app!', 'name' => $group->name, 'body' => view('emails.welcome', ['key' => $group->key, 'name' => $group->name, 'color' => $color])]);
        }
    }


    private function getExtraFields(Request $request, User $user, $new_group = false)
    {
        $efvService = new ExtraFieldValueService();
        $efvService->createUser($request, $user);

        if ($new_group) {
            $this->sendEmail($request, 'gold', $efvService);
        } elseif (isset($request->group_keys)) {
            foreach ($request->group_keys as $group_key) {
                $this->sendEmail($request, $group_key, $efvService);
            }
        } elseif (isset($request->group_key)) {
            $this->sendEmail($request, $request->group_key, $efvService);
        }
    }


    private function linkGroup(User $user, Request $request)
    {
        if (isset($request->group_key)) {
            $group = Group::where('key', $request->group_key)->first();
            $user->groups()->attach($group->id);
        }

        if (isset($request->group_keys)) {
            foreach ($request->group_keys as $group_key) {
                $group = Group::where('key', $group_key)->first();
                $user->groups()->attach($group->id);
            }
        }
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cpf' => 'string|min:10',
            //'document' => 'string|min:11',
            'password' => 'required|string|min:6',
            'group_key' => 'required|string|max:40'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $cpf = isset($request->cpf) ? $request->cpf : $request->document;

        if (!$cpf) {
            return response(['errors' => "Document is required"], 422);
        } else {
            $request->cpf = $cpf;
        }

        $user = User::where('cpf', $request->cpf)->whereHas('groups', function ($group) use ($request) {
            $group->where('key', $request->group_key);
        })->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if (isset($request['token'])) {
                    $notificationService = new NotificationService();
                    $request['user_id'] =  $user->id;
                    $resp = $notificationService->updateNotification($request);
                    if ($resp['response'] > 0) {
                        return response(['errors' => $resp['errors']], 422);
                    }
                }
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'user' => $user];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => "User not found"];
            return response($response, 404);
        }
    }


    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
