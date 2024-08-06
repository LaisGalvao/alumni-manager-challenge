<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Models\Group;
use App\Models\ExtraField;
use App\Models\ExtraFieldValue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ImageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getImages()
    {
        $user = User::find(Auth::id());

        $image = Image::where('user_id', '=', $user->id)->latest()->first();
        if(!empty($image)){
            $path = $image->path;
            $url = $this->getTemporaryUrlAttribute($path);

            return response(["url" => $url], 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    public function getTemporaryUrlAttribute($path)
    {
        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $expiry = "+10 minutes";

        $command = $client->getCommand('GetObject', [
            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
            'Key'    => $path
        ]);

        $request = $client->createPresignedRequest($command, $expiry);

        return (string) $request->getUri();
    }

     /**
     * Upload profile image.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image'
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        };
        $user = User::find(Auth::id());
        $path = Storage::disk('s3')->put('images/originals', $request->file);

        $image = new Image();
        $image->path = $path;
        $image->user_id = $user->id;
        $image->save();

        $response = ['image' => $path];

        return response($response, 200);
    }

     /**
     * Upload logo image.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logoUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image'
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        };

        $path = Storage::disk('s3')->put('images/logos', $request->file);

        $image = new Image();
        $image->path = $path;

        $group = Group::find($request->group_id);

        $image->group_id = $group->id;

        $id = $group->pattern->extraFields->where('key', 'splash_screen')->pluck('id');
        // print_r($id);
        $ext_val = ExtraField::where('master_extra_field', $id)->where('key', 'logo')->first();
        $url = (new ImageController)->getTemporaryUrlAttribute($path);
        if ($exFValue = ExtraFieldValue::where('group_id', $group->id)->where('extra_field_id', $ext_val->id)->first()) {
            $exFValue->value = $url;
            $exFValue->save();
        } else {
            $exFValue = [
                'value'=>$url,
                'type'=>'group',
                'extra_field_id'=>$ext_val->id,
                'group_id'=>$request->group_id
            ];

            ExtraFieldValue::create($exFValue);
        }

        $image->save();
        $response = ['image' => $image];
        return response($response, 200);
    }
}
