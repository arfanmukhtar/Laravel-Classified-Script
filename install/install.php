<?php 
error_reporting(0);
$ROOT_PATH = str_replace('\\','/',dirname(__FILE__,2).DIRECTORY_SEPARATOR);
$license_key = trim($_POST['license_key']);
$db_host = trim($_POST['db_host']);
$db_port = trim($_POST['db_port']);
$db_name = trim($_POST['db_database']);
$db_username = trim($_POST['db_user']);
$db_password = trim($_POST['db_password']);
$email = trim($_POST['f1-email']);
$password = trim($_POST['f1-password']);
// $db_password = trim($_POST['f1-confirm_password']);

 $str = '';
 $status = true;
if($_POST["install_step"] == 1) { 
    sleep(1);
    $str = 'step 1 complete';
} else if($_POST["install_step"] == 2) { 
    sleep(1);
    $str = 'step 2 complete';
} else if($_POST["install_step"] == 3) { 
    $app_key = "base64:0piKvCi+aRvk1/BIaf+sLAAS+yu6tfIp/JfbxMl8t5M="; 
    $app_url = "http://" . $_SERVER['SERVER_NAME'];

   setEnvFile($app_key, $app_url, $db_host, $db_name, $db_username, $db_password,$db_port,$ROOT_PATH);


   try {

    $filename = "../database/schema/mysql-schema.sql";
    $fp = fopen($filename, "r");

    $content = fread($fp, filesize($filename));
    $queries = explode(';', $content);
   
   
    if(empty($_POST['db_port']) or $_POST['db_port'] == 3306) { 
        $con = mysqli_connect($db_host,  $db_username, $db_password, $db_name);
    } else {
        $con = mysqli_connect($db_host .":" . $db_port, $db_username, $db_password, $db_name);
    }

    if(!$con) {
        // $str .= "<span class='text-danger'>Failed<span>";
        $str .= "<span class='text-danger'>". mysqli_connect_error() . "<span>";
        $status = false;
        $data = ['status' => $status, 'str' => $str];
        echo $return = json_encode($data);
        die;

    }

    
    foreach($queries as $query) {
        try {
            mysqli_query($con, $query);
        } catch (\Exception $e) {
            // echo $e->getMessage();
            //echo 'Query already executed';
        }
    }
    fclose($fp);
    } catch(\Exception $e) {
        $status = false;
        $str = $e->getMessage();
    }

} else if($_POST["install_step"] == 4) { 
    sleep(1);
    try {
        $password = password_hash($_POST['admin_password'], PASSWORD_BCRYPT, [10]);
        $email =$_POST['admin_email'];
        $con = mysqli_connect(trim($db_host), trim($db_username), trim($db_password), trim($db_name));
        $query = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`) VALUES
        (1, 'Super Admin', '$email', '$password',1);";
        mysqli_query($con, $query);

    } catch(\Exception $e) { 
        echo $e->getMessage(); exit;
    }

    try { 
        $title = $_POST["application_title"];
        $applicationQuery = "UPDATE application_settings SET  `value`= '$title' WHERE  `key` = 'title'";
        mysqli_query($con, $applicationQuery);
    } catch (\Exception $e) {
        // db user update error
    }
    $str = 'step 4 complete';
}  elseif($_POST['install_step'] == 5) {
    sleep(1);
    $str .= "<div class='mnBloksc'><span class='text-success'><h1 class='m-form__heading-title text-success text-center'>Congratulations</h1><h3 class='m-form__heading-title text-success text-center'>You have installed laravel classified successfully</h3></span><div class='successIcon'><i class='fa fa-check-square text-success'></i><br></div>";
    try { 
        $phpPath = exec("which php");
    } catch(\Exception $e) { 
        $phpPath = "/usr/bin/php81";
    }

    if(!$phpPath)
        $phpPath = "/usr/bin/php";

       
    unlink("../storage/install.txt");

    $str .= "<div class='fpath'><input readonly type='text' title='".$installer['copy_to_clipboard']."' id='optkey' class='form-control' value='* * * * * ".$phpPath .' '.str_replace(DIRECTORY_SEPARATOR.'install', '',__DIR__).DIRECTORY_SEPARATOR."artisan schedule:run'></div>";

    $str .= "<a href='/login' class='btn btn-success save-btn btn-lg'>Login to Admin</a></div>";

    $main_dir = str_replace(DIRECTORY_SEPARATOR.'install', '',__DIR__);

    // unlink($main_dir.DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'install.txt');
}

$data = ['status' => $status, 'str' => $str];
echo $return = json_encode($data);
die;


function setEnvFile($app_key, $app_url, $db_host, $db_name, $db_username, $db_password, $db_port,$root_path) {
    $env_file_content = "APP_ENV=production
APP_KEY={$app_key}
APP_DEBUG=false
APP_LOG_LEVEL=critical
APP_URL = {$app_url}
DOMAIN_URL={$app_url}
DB_CONNECTION=mysql
DB_HOST={$db_host}
DB_PORT={$db_port}
DB_DATABASE={$db_name}
DB_USERNAME={$db_username}";

$env_file_content .='
DB_PASSWORD="' . $db_password . '"';
$env_file_content .="
TBL_PREFIX=
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
";
    $fp_env = fopen($root_path.'.env', 'w');
    fwrite($fp_env, $env_file_content);
    fclose($fp_env);
}

function generateRandomString($length = 30)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

