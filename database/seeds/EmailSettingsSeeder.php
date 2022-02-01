<?php

use Illuminate\Database\Seeder;

class EmailSettingsSeeder extends Seeder
{
    public function run()
    {
        if (DB::table('email_settings')->get()->count() == 0) {
            $data = array('user_id' => 1, 'registration_subject' => 'Registration Notification', 'registration_content' => '<p>Dear <strong><span class="label label-info"> %name%</span>,</strong><br /><br />Thank you for registering <strong>Your web</strong></p> <p></p> <p>Your Registration Informations are as<br /><span class="label label-success">Name: %name%<br />Email:</span> <span class="label label-info"> %email% </span><br /><span class="label label-success">Password: </span> <span class="label label-danger"> %password% </span></p>', 'status_subject' => 'Status Change Notification', 'status_content' => '<p>Dear <strong><span class="label label-info"> %name%</span>,</strong><br />Your status change to&nbsp; <span class="label label-warning"> %status% </span></p> <p></p> <p>for more information contact at .....</p>', 'verify_success_subject' => 'Identity Verified Notification', 'verify_success_content' => '<p>Dear&nbsp; <strong><span class="label label-success"> %name% </span> </strong></p> <p></p> <p>Our team reviewed your provided information. we found your are resident of USA and now we are gooing to change your status to verified user.<br />&nbsp;</p>', 'verify_danger_subject' => 'Identity Un-verified Notification', 'verify_danger_content' => '<p>Dear&nbsp; <strong><span class="label label-success"> %name% </span> </strong></p> <p></p> <p>Our team reviewed your provided information. we found that your provided information is not correct ..</p> <p></p> <p>please resubmit your information to become verified user.</p>', 'status' => 1);
            DB::table('email_settings')->insert($data);
        }
    }
}