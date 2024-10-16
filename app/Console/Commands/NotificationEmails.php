<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class NotificationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:emails {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $task_id = $this->argument('id');
        if(!$task_id) { 
            $notificationTasks = DB::table("notification_emails")->where("status" , 0);
        } else { 
            $notificationTasks = DB::table("notification_emails")->where("id" , $task_id)->where("status" , 0);
        }
        $notificationTasks = $notificationTasks->get();

        foreach($notificationTasks as $task) { 
            DB::table("notification_emails")->where("id" , $task->id)->update(["status" => 1]);
            $map_template = DB::table("email_template_modules")->where("id" , $task->module_id)->first();
            $template_id = $map_template->template_id;
            $email_status = $map_template->email_status;
            $notification_status = $map_template->notification_status;
            // $email_template = DB::table("email_templates")->where("id" , $template_id)->first();
            // $subject = $email_template->subject_title;
            // $email_template = $email_template->email_template;
            // $notification_text = $email_template->notification_text;

            if($email_status) { 
                try { 
                    $user  = DB::table("users")->where("id" ,$task->user_id)->first();
                    $taskData = json_decode($task->data , true);
                    sendEmail($user , $task->module_id , '' , $taskData);
                } catch(\Exception $e) { 
                    echo $e->getMessage();
                }
            }
            if($notification_status) { 

            }

        }
    }
}
