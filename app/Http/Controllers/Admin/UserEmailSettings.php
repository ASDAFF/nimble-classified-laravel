<?php


namespace App\Http\Controllers\Admin;

use App\EmailSettings;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Mail;

class UserEmailSettings extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function search_env($search, $path)
    {
        // Read from file
        $lines = file($path);
        foreach($lines as $line)
        {
            // Check if the line contains the string we're looking for, and print if it does
            if(strpos($line, $search) !== false)
                return $line;
        }
    }

    function replace_string_in_file($filename, $string_to_replace, $replace_with)
    {
        $content=file_get_contents($filename);
        $content_chunks=explode($string_to_replace, $content);
        $content=implode($replace_with, $content_chunks);
        file_put_contents($filename, $content);
    }

    function expl($data)
    {
        $temp = explode('=', $data);
        $data = '';
        if(is_array($temp))
        {
            if(isset($temp[1]))
            {
                $data =$temp[1];
            }
            return $data;
        }
    }

    public function index()
    {
        $filename = base_path('.env');
        $mail = [
            'APP_NAME' => $this->expl($this->search_env('APP_NAME', $filename)),

            'MAIL_FROM_ADDRESS' => $this->expl($this->search_env('MAIL_FROM_ADDRESS', $filename)),
            'MAIL_FROM_NAME'    => $this->expl($this->search_env('MAIL_FROM_NAME', $filename)),

            'MAIL_DRIVER'       => $this->expl($this->search_env('MAIL_DRIVER', $filename)),
            'MAIL_HOST'         => $this->expl($this->search_env('MAIL_HOST', $filename)),
            'MAIL_PORT'         => $this->expl($this->search_env('MAIL_PORT', $filename)),
            'MAIL_USERNAME'     => $this->expl($this->search_env('MAIL_USERNAME', $filename)),
            'MAIL_PASSWORD'     => $this->expl($this->search_env('MAIL_PASSWORD', $filename)),
            'MAIL_ENCRYPTION'   => $this->expl($this->search_env('MAIL_ENCRYPTION', $filename)),
        ];
        $data = EmailSettings::where('user_id', Auth::user()->id)->first();
        return view('admin.account_email.add', compact('data', 'mail'));
    }

    function saveEmailSettings(Request $request)
    {
        try {
            unset($request->email);
            $filename = base_path('.env');
            foreach ($request->all() as $i => $item)
            {
                if ($i != 'email' && $i != '_token' && $i != 'MAIL_ENCRYPTION')
                {
                    $string_to_replace = $this->search_env($i, $filename);
                    $replace_with = $i."=" .str_replace(' ', '', $item).PHP_EOL;
                    $this->replace_string_in_file($filename, $string_to_replace, $replace_with);
                }
            }
            if($request->MAIL_ENCRYPTION!='')
            {
                $string_to_replace = $this->search_env('MAIL_ENCRYPTION', $filename);
                $replace_with = "MAIL_ENCRYPTION=" .str_replace(' ', '', $request->MAIL_ENCRYPTION).PHP_EOL;
                $this->replace_string_in_file($filename, $string_to_replace, $replace_with);
            }else{
                $string_to_replace = $this->search_env('MAIL_ENCRYPTION', $filename);
                $replace_with = "MAIL_ENCRYPTION=".PHP_EOL;
                $this->replace_string_in_file($filename, $string_to_replace, $replace_with);
            }

        }catch (\Exception $e){
            $err = $e->getMessage();
        }

        if(isset($err) && $err != '')
        {
            return response()->json(['error' => $err]);
        }else{
              DB::table('setting')->update(['is_mail_configured' => 1]);
            return response()->json(['success' => 'success']);
        }
    }

    function testEmail(Request $request)
    {

        try {
            $this->notification_to_email = $request->email;

            $this->notification_subject = 'Test email';
            $content = 'Test email to test email configuration';
            $data = array('content' => $content);

            $mail = Mail::send('admin.user.email_notification', $data, function ($msg) {

                $msg->subject($this->notification_subject);
                $msg->to($this->notification_to_email);
            });
        }catch (\Exception $e){
            $err = $e->getMessage();
        }

        if(isset($err) && $err != '')
        {
            return response()->json(['error' => $err]);
        }else{
            Setting::where('id', 1)->update(['mail_conf' => 1]);
            return response()->json(['success' => 'success']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obj = new EmailSettings();
        if($request->id !="")
        {
            $obj = $obj->findOrFail($request->id);
        }

        $obj->fill($request->all());

//        $obj->registration_subject = $request->registration_subject;
//        $obj->registration_content = $request->registration_content;
//        $obj->status_subject = $request->status_subject;
//        $obj->status_content = $request->status_content;

        $obj->user_id = Auth::User()->id;

        if($obj->save())
        {
            echo 1;
        }else{
            echo 0;
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
}
