<?php

namespace App\Classes\Notifications;

use Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Mail;

trait NotificationEmails
{
    public function sendEmail($user_id, $module_id, $data = [])
    {
        $mail_attributes = DB::table('application_settings')->where('setting_name', 'mail_attributes')->value('setting_value');
        if (empty($mail_attributes)) {
            $mail_attributes = \App\user_settings::where('user_id', '=', 2)->value('mail_attributes');
        }

        if ($mail_attributes) {
            $smtp = json_decode($mail_attributes);
        } else {
            throw new \Exception('Mail attributes are not set correctly in application settings.', 1);
        }
        $parse = parse_url(url('/'));
        $domain = $parse['host'];
        $from = isset($smtp->from_email) && ! empty($smtp->from_email) ? $smtp->from_email : 'admin@'.$domain;
        $fromName = isset($smtp->from_name) && ! empty($smtp->from_name) ? $smtp->from_name : 'Smartmails';
        if (isset($smtp->mail_type) && $smtp->mail_type != 'php_mail_function') {
            $user = [
                'from' => $from,
                'from_name' => $fromName,
            ];

            $smtp_pass = Crypt::decrypt($smtp->password);
            //    $smtp_pass = "60f036f84791e1626355448";
            Config::set('mail.driver', 'smtp');
            Config::set('mail.host', $smtp->host);
            Config::set('mail.port', $smtp->port);
            Config::set('mail.username', $smtp->username);
            Config::set('mail.password', $smtp_pass);
            Config::set('mail.from.address', $user['from']);
            Config::set('mail.from.name', $user['from_name']);
            Config::set('mail.encryption', $smtp->smtp_encryption ? $smtp->smtp_encryption : '');
        }

        $espMapTemplatesRow = DB::table('addon_subscription_templates_module')->join('addon_subscription_email_templates', 'addon_subscription_templates_module.template_id', 'addon_subscription_email_templates.id')
            ->select('addon_subscription_email_templates.subject_title', 'addon_subscription_email_templates.email_template', 'addon_subscription_email_templates.email_text', 'addon_subscription_templates_module.variables', 'addon_subscription_templates_module.email_status', 'addon_subscription_templates_module.notification_status', 'addon_subscription_email_templates.notification_text', 'addon_subscription_email_templates.notification_icon', 'addon_subscription_email_templates.icon_color', 'addon_subscription_templates_module.module_name', 'addon_subscription_templates_module.type')
            ->where('addon_subscription_templates_module.id', $module_id)->first();

        $userRow = \App\User::where('id', $user_id)->first();
        $subject_title = $espMapTemplatesRow->subject_title;
        $subject_title = $this->replaceVeriables($userRow, $subject_title, $data);
        $email_template = $espMapTemplatesRow->email_template;
        $email_template = $this->replaceVeriables($userRow, $email_template, $data);
        $notificaiton = $espMapTemplatesRow->notification_text;
        $notificaiton = $this->replaceVeriables($userRow, $notificaiton, $data);

        if ($espMapTemplatesRow->notification_status == 1) {
            $user_notification_data = [
                'type' => -1,
                'user_id' => $user_id,
                'notification' => $notificaiton,
                'is_show' => 0,
                'notification_url' => '',
                'module_id' => $module_id,
            ];
            // $objUserNotifications = new UserNotifications();
            // $objUserNotifications->fill($user_notification_data);
            // $objUserNotifications->save();
        }

        $emails = [];
        $emails[] = $userRow->email;

        $email_header_footer = DB::table('reputation_header_footer')->first();
        $headerTemplate = $email_header_footer->header;
        $footerTemplate = $email_header_footer->footer;
        $dirPath = base_path();
        $headerTemplate = file_get_contents($dirPath.'/Addons/Subscriptions/templates/header.html');
        $footerTemplate = file_get_contents($dirPath.'/Addons/Subscriptions/templates/footer.html');

        $final_template = $headerTemplate;
        $final_template .= $email_template;
        $final_template .= $footerTemplate;

        $user = [
            'from' => $from,
            'from_name' => $fromName,
            'subject' => $subject_title,
        ];

        $this->saveEmailtoTable([
            'user_id' => $user_id,
            'subject' => $user['subject'],
            'content' => $final_template,
            'created_at' => gmdate('Y-m-d H:i:s'),
        ]);

        Mail::send('subscriptions::emails.signup', ['email_content' => $final_template], function ($m) use ($user, $emails) {
            $m->from($user['from'], $user['from_name']);
            $m->to($emails)->subject($user['subject']);
        });

    }

    public function replaceVeriables($userRow, $content, $replace_array)
    {
        try {
            $content = str_replace('%%name%%', $userRow->name, $content);
            $content = str_replace('%%email%%', $userRow->email, $content);
            $content = str_replace('%%email_address%%', $userRow->email, $content);
            $content = str_replace('%%country%%', $userRow->country, $content);
            $content = str_replace('%%address_line_1%%', $userRow->address_line_1, $content);
            $content = str_replace('%%city%%', $userRow->city, $content);
            $content = str_replace('%%state%%', $userRow->state, $content);
            $content = str_replace('%%post_code%%', $userRow->post_code, $content);
            $content = str_replace('%%renewal_date%%', $userRow->renewal_date, $content);
            $content = str_replace('%%mobile%%', $userRow->mobile, $content);
        } catch (\Exception $e) {
            // echo $e->getMessage();
        }
        try {
            $replace_array = json_decode($replace_array);
            foreach ($replace_array as $key => $array) {
                $content = str_replace("%%$key%%", $array, $content);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        try {
            $primary_domain = getSetting('primary_domain');
            $content = str_replace('%%site_url%%', 'https://'.$primary_domain, $content);
        } catch (\Exception $e) {
        }

        return $content;

    }

    public function saveEmailtoTable($data)
    {
        try {
            DB::table('notification_task_logs')->insert($data);
        } catch (\Exception $e) {
        }

    }
}
