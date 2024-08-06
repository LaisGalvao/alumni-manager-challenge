<?php

namespace App\Http\Controllers;

use App\Commons;
use App\Library\Services\ExtraFieldValueService;
use App\Library\Services\NotificationService;
use App\Models\User;
use App\Models\Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function isAdmin(){
        return User::where('group_key', '=', 'Super Admin');
    }
 /*    private function isAdmin(){
        return Auth::user()->groups()->where('key', 'Super Admin')->count() >= 1;
    } */


    public function index(Request $request)
    {
        $user = User::find(Auth::id());

        $groupsIds = $user->linearChildrenId();
        $users = User::whereHas('groups', function($group) use($groupsIds) {
            $group->whereIn('id', $groupsIds);
        });

        if(isset($request['group_ids'])){
            $users = $users->whereHas('groups', function($group) use($request) {
                $group->whereIn('id', Commons::stringIdsToArray($request->group_ids));
            });
        }

        if(isset($request['group_key'])){
            $users = $users->whereHas('groups', function($group) use($request) {
                $group->where('key','like', Commons::stringIdsToArray($request->group_key));
            });
        }
        // return response(['users' => $users->get()], 200);
        $lusers = ($this->isAdmin() ? $users : $users->where('tenant_id', $user->id))->orderBy('created_at',"desc")->get();
        // ($this->isAdmin() ? $users : $users->where('tenant_id', $user->id))->orderBy('created_at',"desc")->get();
        //$users->where('tenant_id', $user->id)->orderBy('created_at',"desc")->get();

        if(!empty($lusers)){
            $users = [];
            $efvService = new ExtraFieldValueService();
            foreach($lusers as $user){
                $user['groups'] = $user->groups;
                $user['extra_fields'] = $efvService->indexUser($user);
                $users[] = $user;
            }
            $response = ['users' => $users];
            return response($response, 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        $logged = User::find(Auth::id());

        if($logged->id <> $user->id){
            $groupsIds = $logged->linearChildrenId();
            $user = User::whereHas('groups', function($group) use($groupsIds) {
                $group->whereIn('id', $groupsIds)->where('public',0);
            })->where('id', $user->id)->first();
        }

        if($user){
            $efvService = new ExtraFieldValueService();
            $user->extra_fields = $efvService->indexUser($user);
            $user['groups'] = $user->groups;
            $response = ['user' => $user];
            return response($response, 200);
        }


        return response(['errors'=>'Not found'], 422);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try{
            if(isset($request['user_id'])){
                $user = User::find($request['user_id']);
                DB::table('notifications')->where('user_id', $request['user_id'])->delete();
                DB::table('user_group')->where('user_id', $request['user_id'])->delete();
                $user->delete();
                return response(['messages'=>'ok'], 200);
            }else{
                return response(['errors'=>'user_id necessary'], 422);
            }
        }catch(Exception $e){
            return response(['errors'=>'Not delete throwable', $e], 422);
        }
    }

    /* public function userDelete($id){
        $u = User::find($id);
        if(isset($u)) {
            if($this->isAdmin() || $u->tenant_id == Auth::id()) {
                $u->forceDelete();
                // parent::delete();
                return response()->noContent();
            }
            return response(['error' => 'Sem permissão'], 422);
        }
        return response(['error' => 'Usuário não existe ou já deletado'], 404);
    } */
}
