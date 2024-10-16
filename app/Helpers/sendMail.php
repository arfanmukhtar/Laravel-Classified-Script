<?php 

use Symfony\Component\Mime\Crypto\DkimOptions;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Crypto\DkimSigner;

function getDsn($host,$port,$user='',$pass='',$protocol='default',$encryptionOrRegion='',$auth_mode='',$verify_peer=1,$allow_self_signed=1,$verify_peer_name='',$restart_threshold='',$restart_threshold_sleep='') :string
{
    return $protocol."://" . $user . ":" . $pass . "@" .$host . ":" . $port."?encryption=$encryptionOrRegion&auth_mode=$auth_mode&verify_peer=$verify_peer&verify_peer_name=$verify_peer_name&allow_self_signed=$allow_self_signed&restart_threshold=$restart_threshold&restart_threshold_sleep=$restart_threshold_sleep";
}


function sendEmail($user, $module_id, $template = "emails.email" , $data = []) { 

    $settings = getApplicationSettings();

    $from_name = $settings["from_name"];
    $from_email = $settings["from_email"];
    $mail_host = $settings["mail_host"];
    $mail_port = $settings["mail_port"];
    $mail_username = $settings["mail_username"];
    $mail_password = $settings["mail_password"];
    $mail_encryption = !empty($settings["mail_encryption"]) ? $settings["mail_encryption"] : "";
    $verify_peer = ($settings["verify_peer"]) ? $settings["verify_peer"] : false; 
    $allow_self_signed = ($settings["allow_self_signed"]) ? $settings["allow_self_signed"] : false;
    $verify_peer_name = ($settings["verify_peer_name"]) ? $settings["verify_peer_name"] : false;


    $module = DB::table("email_template_modules")->where("id" , $module_id)->first();
    if(empty($module)) {
        return "module not found";
    }

    $template = DB::table("email_templates")->where("id" , $module->template_id)->first();
    $subject = $template->subject_title;
    $content = $template->email_template;
    $content_text = $template->email_text;
    $notification_text = $template->notification_text;

    $content = replaceVariables($content , $data);
    $content = str_replace("%%name%%" , $user->name , $content);
    $content = str_replace("%%email%%" , $user->email , $content);
    $to_name = $user->name;
    $to_email = $user->email;


    try { 
        $dsn = getDsn($mail_host, $mail_port, $mail_username, $mail_password, 'smtp', $mail_encryption, '', $verify_peer, $allow_self_signed, $verify_peer_name);
        $transport = \Symfony\Component\Mailer\Transport::fromDsn($dsn);
        $mailer = new \Symfony\Component\Mailer\Mailer($transport);
        $email = new Email();
        $email->from("$from_name <$from_email>")->to($to_email)->html($content)->text($content_text)
        ->replyTo($to_email)->subject($subject);
        $mailer->send($email);
        return ['status' => 1, 'msg' => "Email send successfully"];
    } catch(\Exception $e) { 
        return ['status' => 0, 'msg' => $e->getMessage()];
    }

}

function replaceVariables($content , $data) { 
    foreach($data as $k=>$value) { 
        $content = str_replace("%%$k%%" , "$value" , $content);
    }

    $content = str_replace("%%site_title%%" , getSetting("title") , $content);
    $content = str_replace("%%site_url%%" , url("/") , $content);

    return $content;
}

?>