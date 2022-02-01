<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Validator;

class UserController extends Controller
{
    private  $notification_subject, $notification_to_email = "";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all()->where('id', Auth::user()->id)->first();
        return view("admin.profile_settings")->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 

    public function create()
    {

    }
    // profile setting
    function profileSetting(Request $request)
    {
        /* validate image*/
        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpeg,bmp,png'
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 2, 'error'=> $validator->errors()->all()]);
        }

        $is_file = false;
        $old_file = Auth::user()->image;

        $user =   User::find(Auth::user()->id);
        if ($user)
        {
            if ($request->hasFile('image'))
            {
                $is_file = true;
                $file_name = $input['image'] = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(base_path() . '/assets/images/users/', $input['image']);
                $update_data = array('password' => bcrypt($request->password), 'name' => $request->name, 'plain_password' => $request->password, 'image' => $file_name);
            }else{
                $file_name = $old_file;
                $update_data = array('password' => bcrypt($request->password), 'name' => $request->name, 'plain_password' => $request->password );
            }

            $update = DB::table('users')
                ->where('id', Auth::user()->id)
                ->update( $update_data );

            if ($update)
            {
                // Delete old image
                if ($is_file)
                {
                    if (file_exists(base_path('assets/images/users/' . $old_file)) && $old_file != null )
                    {
                        unlink(base_path('assets/images/users/' . $old_file));
                    }
                }
                return response()->json(['msg' => 1,'file_name' =>  $file_name]);
            }else{
                return response()->json(['msg' => 2]);
            }
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * also receiving request on add-user
     */
    public function store(Request $request)
    {
        if ($request->id =='')
        {
            $check_email = User::where('email', $request->email)->first();
            if ($check_email)
            {
                echo json_encode(['msg' => 'email']);
                exit;
            }
        }

        $obj = new User();
        if ($request->id!='')
        {
            $obj = $obj->findOrFail($request->id);
        }

        /* Start for request on add-user */
        $status = 'Inactive';
        if ($request->status==1)
        {
            $obj->status = $request->status;
            $status = 'Active';
        }
        /* Ends for request on add-user */

        $obj->fill($request->all());
        $obj->password = bcrypt($request->password);
        $obj->plain_password = $request->password;

        if ($obj->save())
        {

            $email_temp = DB::table('email_settings')->select('registration_subject','registration_content')->where('user_id', Auth::user()->id)->first();

            $subject = $email_temp->registration_subject;
            $content = $email_temp->registration_content;

            $content = str_replace('%email%', $request->email, $content);
            $content = str_replace('%name%', $request->name, $content);
            $content = str_replace('%status%', $status, $content);
            $content = str_replace('%password%', $request->password, $content);

            $this->notification_to_email = $request->email;
            $this->notification_subject = $subject;

            $data = array('email' => $request->email, 'content' => $content, 'subject' => $subject );

            Mail::send('admin.user.email_notification', $data, function($msg){
                $msg->subject($this->notification_subject);
                $msg->to($this->notification_to_email);
            });
            echo json_encode(array('msg'=>1));
        }else{
            echo json_encode(array('msg'=>0));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function loadEdit(Request $request)
    {
        $data = User::findOrFail($request->id);
        if ($data)
        {
            echo json_encode($data);
        }else{
            echo 0;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function loadUsers()
    {
        return view("admin.user.list");
    }

    function showCard( Request $request )
    {
        if ($request->id !='')
        {
            $img = User::whereId($request->id)->value('id_card');
            echo $img;
        }else{
           echo 2;
        }
    }
    function vfyCard( Request $request )
    {
        if ($request->id !='')
        {

            $email_temp = DB::table('email_settings')->where('user_id', Auth::user()->id)->first();

            $user = User::whereId($request->id)->first();

            if ($request->status == 2)
            { // success
                $subject = $email_temp->verify_success_subject;
                $content = $email_temp->verify_success_content;
            }
            if ($request->status == 3)
            { // error
                $subject = $email_temp->verify_danger_subject;
                $content = $email_temp->verify_danger_content;
            }

            $content = str_replace('%email%', $user->email, $content);
            $content = str_replace('%name%', $user->name, $content);
            // assign subject and email

            $this->notification_subject = $subject;
            $this->notification_to_email = $user->email;


            $data = array( 'content' => $content);

            Mail::send('admin.user.email_notification', $data, function($msg){
                $msg->subject($this->notification_subject);
                $msg->to($this->notification_to_email);
            });

            $update = User::whereId($request->id)->update(['is_verified' => $request->status]);
            if ($update)
            {
                echo 1;
            }else{
                echo 2;
            }
        }else{
           echo 2;
        }
    }


}
