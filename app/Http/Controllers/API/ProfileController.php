<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = Profile::where('registration_status',1)->get();
        return response([ 'profile' => ProfileResource::collection($profile), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        $data = $request->all();

        $user_id = auth()->user()->id;

        $user = User::where('id',$user_id)->first();

        $profile = new Profile();


        $profile->username = $request->username;

        $validator = Validator::make($data, [
            'username' => 'required|unique:profile|min:4|max:20',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=256,min_height=256',
        ]);

        if($request->hasFile('avatar')){
          $avatar = $request->file('avatar');
          $filename = time() . '.' . $avatar->getClientOriginalExtension();

          $new_name = $avatar.$filename;

          $destinationPath = public_path() . '/upload/profile/';

          $avatar->move($destinationPath, $new_name);

         $profile->avatar = $filename;


        }
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $user->profile()->save($profile);
      
       

        return response(['profile' => new ProfileResource($profile), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return response(['profile' => new ProfileResource($profile), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $data = $request->all();

      
        $user_id = auth()->user()->id;

        $user = User::where('id',$user_id)->first();

        $profile = Profile::where('id',$profile);

        $user->profile->username = $request->username;

        $validator = Validator::make($data, [
            'username' => 'required|unique:profile|min:4|max:20',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=256,min_height=256',
        ]);

        if($request->hasFile('avatar')){
          $avatar = $request->file('avatar');
          $filename = time() . '.' . $avatar->getClientOriginalExtension();

          $new_name = $avatar.$filename;

          $destinationPath = public_path() . '/upload/profile/';

          $avatar->move($destinationPath, $new_name);

         $user->profile->avatar = $filename;


        }
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $user->profile->save();
     

        return response(['profile' => new ProfileResource($user->profile), 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();

        return response(['message' => 'Deleted']);
    }
}
