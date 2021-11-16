<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invitations;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\InvitationsResource;
use Illuminate\Support\Facades\Mail;


class InvitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function index()
    {
        $invitations = Invitations::all();
        return response([ 'invitations' => InvitationsResource::collection($invitations), 'message' => 'Retrieved successfully'], 200);
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

        
        $invitations = new Invitations($data);

        $email = $request->email;
        $validator = Validator::make($data, [
            'email' => 'required|unique:invitations|email',
         
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }


        $invitations->generateInvitationToken();


        //$link_data = array("invitation_link"=>$invitation_link);

        

        Mail::to($email)->send(new InvitationMail($invitations));

        $invitations->save();

        // Mail::send(['text'=>'mail'], $link_data, function($message) use($email) {
        //     $message->to($email, 'Laravel Test')->subject
        //        ('Here is your invitation link');
        //        $message->from('xyz@gmail.com','Laravel Test');
        // });
   
        return response(['invitations' => new InvitationsResource($invitations), 'message' => 'Created successfully'], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invitations  $invitations
     * @return \Illuminate\Http\Response
     */
    public function show(Invitations $invitation)
    {
        return response(['invitations' => new InvitationsResource($invitation), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invitations  $invitations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invitations $invitation)
    {
        $invitation->update($request->all());

        return response(['invitations' => new InvitationsResource($invitation), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invitations  $invitations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitations $invitation)


    {

       
        if($invitation->delete()){
            
        return response(['message' => 'Deleted']);
        }else{
            
        return response(['message' => 'An error occured!'],201);
        }
        

    }

    
}
