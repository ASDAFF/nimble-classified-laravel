<div style="width:100%;background-color:#e9e8e8;height:auto; padding:20px">
    <div style="width:50%;margin:auto;background-color:white;padding:11px 20px 35px 20px">
    <h2> Hi {{ ucwords($name) }} Just one more step...</h2>
        <p>Click the big button below to activate your {{ \App\Setting::value('title') }} account.</p>
        <center>
        	<a href="{{ $link }}" target="_blank" style="background-color:#d54937;color:white;padding:10px 10px;text-decoration:none">Active Account</a>
    	</center>
    </div>
<br><br>
Regards,<br><strong>{{ config('app.name') }}</strong>
</div>
