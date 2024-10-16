<?php 
    error_reporting(0);
    $phpCheck = 0;
    $php_version = substr(PHP_VERSION, 0, 3);
    if($php_version >= 8.1)  $phpCheck = 1;
    $ROOT_PATH = str_replace('\\','/',dirname(__FILE__,2).DIRECTORY_SEPARATOR);
    $tab = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : null;
    $status = true;
    $str = "";
    if($tab == 2) { 
        
        try {
            if(empty($_POST['db_port']) or $_POST['db_port'] == 3306) { 
                $con = mysqli_connect(trim($_POST['db_host']), trim($_POST['db_user']), $_POST['db_password'], trim($_POST['db_name']));
            } else {
                $con = mysqli_connect(trim($_POST['db_host']).":".trim($_POST['db_port']), trim($_POST['db_user']), $_POST['db_password'], trim($_POST['db_name']));
            }
            if($con) {
                $str .= "<span  class='text-success'>Successfull<span>";
            } else {
                // $str .= "<span class='text-danger'>Failed<span>";
                $str .= "<span class='text-danger'>". mysqli_connect_error() . "<span>";
                $status = false;
            }
            
        }   catch (\Exception $e) {
            $status = false;
            $str .= "<span class='text-danger'>".$installer['failed_to_connect']." MySQL: " . mysqli_connect_error()."</span>";
        }

        $data = ['status' => $status, 'str' => $str];
        $return = json_encode($data);
        echo  $return;exit;

        
    }

    if($tab == null) {
        $str = '<ul class="list-group w-50">';
        if($phpCheck) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>PHP >= 8.1 (Your Version ' . $php_version . ') </li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4 "></i>PHP >= 8.1 (Your Version ' . $php_version . ') </li>';
            $status = false;
        }

        if(extension_loaded ('openssl')) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>openssl</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>openssl</li>';
            $status = false;
        }


        if(extension_loaded ('PDO')) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>PDO</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>PDO</li>';
            $status = false;
        }

        if(extension_loaded ('mbstring')) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>mbstring</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>mbstring</li>';
            $status = false;
        }
        if(extension_loaded ('tokenizer')) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>tokenizer</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>tokenizer</li>';
            $status = false;
        }
        if(extension_loaded ('xml')) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>xml</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>xml</li>';
            $status = false;
        }
        if(extension_loaded ('zip')) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>zip</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>zip</li>';
            $status = false;
        }
        if(ini_get('allow_url_fopen')) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>allow_url_fopen</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>allow_url_fopen</li>';
            $status = false;
        }
        if(extension_loaded ('fileinfo')) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>fileinfo</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>fileinfo</li>';
            $status = false;
        }
        $env_file = $ROOT_PATH.'.env';
        $env_file_permission = substr(sprintf('%o', fileperms($env_file)), -4);

        if($env_file_permission >= '0777') {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>.env &nbsp;&nbsp;&nbsp;(777)</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>.env &nbsp;&nbsp;&nbsp;(777)</li>';
            $status = false;
        }

        $bootstrap_folder = $ROOT_PATH.'bootstrap';
        $bootstrap_folder_permissions = substr(sprintf('%o', fileperms($bootstrap_folder)), -4);
        $is_bootstrap_folder_permissions =  checkAllInnerFolderPermissionsInstall($bootstrap_folder);

        if($bootstrap_folder_permissions >= '0777' and $is_bootstrap_folder_permissions) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>bootstrap &nbsp;(777 recursively)</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>bootstrap &nbsp;(777 recursively)</li>';
            $status = false;
        }

        $storage_folder = $ROOT_PATH.'storage';
        if (!file_exists($storage_folder))
            mkdir($storage_folder, 0777, true);
        $storage_folder_permissions = substr(sprintf('%o', fileperms($storage_folder)), -4);

        $is_storage_folder_permissions =  checkAllInnerFolderPermissionsInstall($storage_folder);

        if($is_storage_folder_permissions >= '0777' and $is_storage_folder_permissions) {
            $str .= '<li class="list-group-item "><i class="fa fa-check fa-fw me-4"></i>storage &nbsp;(777 recursively)</li>';
        } else {
            $str .= '<li class="list-group-item text-danger"><i class="fa fa-close fa-fw me-4"></i>storage &nbsp;(777 recursively)</li>';
            $status = false;
        }


        $str .= "</ul>";
    }


     function checkAllInnerFolderPermissionsInstall($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        if (is_writable($dir . "/" . $object)) {
                            checkAllInnerFolderPermissionsInstall($dir . "/" . $object);
                        } else {
                            return 0;
                        }
                    }
                }
            }
            reset($objects);
            return 1;
        }
    }



?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Classified Installer</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Top content -->
        <div class="loading" id="loading">
            <div class="loader"></div>
        </div>

        <!-- Top content -->
        <div class="top-content">
            <div class="container">
                
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 text">
                        <h1>Laravel   <strong>Classified</strong> Installer</h1>
                        <div class="description">
                       	    <p>
                                This is a laravel classified installer 
                                Download and purcahse it on <a href="http://laravelclassified.com"><strong>Laravel Classified</strong></a>, customize and use it as you like!
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 form-box">
                    	<form role="form" action="" id="dataForm" method="post" class="f1">

                    		<h3>Register To Our App</h3>
                    		<p>Fill in the form to get instant access</p>
                    		<div class="f1-steps">
                    			<div class="f1-progress">
                    			    <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
                    			</div>
                    			<div class="f1-step active">
                    				<div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    				<p>License Verification</p>
                    			</div>
                    			<div class="f1-step">
                    				<div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    				<p>Dependency Check</p>
                    			</div>
                    		    <div class="f1-step">
                    				<div class="f1-step-icon"><i class="fa fa-twitter"></i></div>
                    				<p>Database Check</p>
                    			</div>
                    		    <div class="f1-step">
                    				<div class="f1-step-icon"><i class="fa fa-twitter"></i></div>
                    				<p>Add an Administrator</p>
                    			</div>
                    		</div>
                    		
                    		<fieldset>
                    		    <h4>License Verification</h4>
                                <p> We appreciate your purchase. Please enter your license key and press validate.</p>
                    			<div class="form-group">
                    			    <label class="sr-only" for="license_key">License key</label>
                                    <input type="text" name="license_key" value="" placeholder="License key..." class="license_key form-control" id="license_key">
                                    <span class="message-license" id="lc-succcess">License verified successfully!</span>
                                    <span class="message-license" id="lc-error">License not match with our record!</span>
                                    <span class="message-license" id="lc-empty">Write here a valid license key to continue.</span>
                                </div>
                                <div class="f1-buttons" >
                                    <button type="button"  class="btn btn-success btn-validate">Validate</button>
                                    <button type="button"  class=" btn btn-next btnNext1" disabled>Next</button>
                                </div>

                            </fieldset>

                            <fieldset>
                                 <h4>Dependency Check</h4>
                                <p> Before proceeding with the full installation, we will carry out some tests on your server configuration to ensure that you are able to install and run our software.</p>
                    			
                                <?php echo  $str; ?>
                                <div class="f1-buttons">
                                    <button type="button" class="btn btn-previous">Previous</button>
                                    <button type="button" class="btn btn-next">Next</button>
                                </div>
                            </fieldset>

                            <fieldset>
                                <h4>Database Details</h4>
                                <p>Specify your database settings here. Please note that the database for our software must be created prior to this step. </p>
                                <div class="form-group">
                                    <label class="sr-only" for="f1-hostname">Host name</label>
                                    <input type="text" name="db_host" placeholder="localhost" class="f1-hostname form-control" id="db_host">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="db_user">Username</label>
                                    <input type="text" name="db_user" placeholder="root" class="db_user form-control" id="db_user">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="db_password">Password</label>
                                    <input type="textt" name="db_password" placeholder="Password" class="db_password form-control" id="db_password">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="db_database">Database</label>
                                    <input type="text" name="db_database" placeholder="Database Name" class="db_database form-control" id="db_database">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="db_port">Port</label>
                                    <input type="text" name="db_port" placeholder="Port (default 3306)" value="3306" class="db_port form-control" id="db_port">
                                </div>
                                <div class="form-group">
                                        <p style="text-danger" id="db_msg"></p>
                                </div>
                                
                                <div class="f1-buttons">
                                    <button type="button" class="btn btn-success validateDb">Validate</button>
                                    <button type="button" class="btn btn-previous">Previous</button>
                                    <button type="button" disabled class="btn btn-next dbNext">Next</button>
                                   
                                </div>
                            </fieldset>

                            <fieldset id="AddingAdmin">
                                <h4>Adding Administrator:</h4>
                                <div class="form-group">
                                    <label class="sr-only" for="f1-facebook">Application title</label>
                                    <input type="text" name="application_title" placeholder="Application title..." class="f1-facebook form-control" id="site_title">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="f1-facebook">Admin Email</label>
                                    <input type="text" name="admin_email" placeholder="Admin Email.." class="f1-facebook form-control" id="admin_email">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="f1-facebook">Password</label>
                                    <input type="password" name="admin_password" placeholder="Password..." class="f1-facebook form-control" id="admin_password">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="f1-facebook">Confirm Password</label>
                                    <input type="password" name="admin_confirm_password" placeholder="Confirm Password..." class="f1-facebook form-control" id="admin_c_password">
                                </div>
                               
                                <div class="f1-buttons">
                                    <button type="button" class="btn btn-previous">Previous</button>
                                    <button type="button" class="btn btn-submit">Finish</button>
                                   
                                </div>
                            </fieldset>
                    	    <input type="hidden" value="0" id="step">

                            
                            <div id="finalInstalltion" style="text-align:left !important; display:none;">
                                <h4>Ready to install</h4>
                                 <p class="step1"><storng> Step 1: </strong> Verifying License Key</p>
                                 <p class="step2"><storng> Step 2: </strong> Checking Database Connection </p>
                                 <p class="step3"><storng> Step 3: </strong> Generating Tables </p>
                                 <p class="step4"><storng> Step 4: </strong> Adding Administrator </p>
                                 <p class="step5"><storng> Step 5: </strong> Finalizing Installation </p>
                            </div>

                            <div class="row succss" style="display:none;">
                                <div class="col-xl-12 col-lg-12">
                                    <div id="insallation-text"></div>

                                </div>
                            </div>

                    	</form>
                        
                    </div>
                </div>

                
                    
            </div>
        </div>


        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/retina-1.1.0.min.js"></script>
        <script src="//laravelclassified.com/license/scripts.js"></script>

        <script> 
            $('.validateDb').click(function() {
                var title = $('#title').val();
                var db_host = $('#db_host').val();
                var db_name = $('#db_database').val();
                var db_user = $('#db_user').val();
                var db_port = $('#db_port').val();
                var password = $('#db_password').val();
                $("#loading").show();
                $.ajax({
                    url: 'index.php',
                    type: "POST",
                    data: { tab: "2", title: title, db_host: db_host, db_name: db_name,db_port: db_port, db_user: db_user, db_password: password},
                    beforeSend: function(xhr){
                        $('#verify-db').val('Verifing...');
                    },
                    success: function(result) {
                        setTimeout(() => {
                            $("#loading").hide();
                            var obj = JSON.parse(result);
                            if(obj.status) {
                                $('#db_msg').html(obj.str);
                                $(".dbNext").prop("disabled" , false);
                            } else {
                                $('#db_msg').html(obj.str);
                                $(".dbNext").prop("disabled" , true);
                                return false;
                            }
                        }, 1500);
                    }
                });
            });


            $('.btn-submit').click(function() {
                $("#AddingAdmin").hide();
                $("#finalInstalltion").show();

                var form_data =  $("#dataForm").serialize();
                //console.log(form_data);
                $.ajax({
                    url: 'install.php',
                    type: "POST",
                    data: form_data + '&tab=3&install_step=1',
                    success: function(result) {
                        var obj = JSON.parse(result);
                        if(obj.status) {
                            $(".step1").addClass("text-success");
                            $.ajax({
                                url: 'install.php',
                                type: "POST",
                                data: form_data + '&tab=3&install_step=2',
                                success: function(result) {
                                    var obj = JSON.parse(result);
                                    if(obj.status) {
                                        $(".step2").addClass("text-success");
                                        $.ajax({
                                            url: 'install.php',
                                            type: "POST",
                                            data: form_data + '&tab=3&install_step=3',
                                            success: function(result) {
                                                var obj = JSON.parse(result);
                                                if(obj.status) {
                                                    $(".step3").addClass("text-success");
                                                    $.ajax({
                                                        url: 'install.php',
                                                        type: "POST",
                                                        data: form_data + '&tab=3&install_step=4',
                                                        success: function(result) {
                                                            var obj = JSON.parse(result);
                                                            if(obj.status) {
                                                                $(".step4").addClass("text-success");
                                                                $.ajax({
                                                                    url: 'install.php',
                                                                    type: "POST",
                                                                    data: form_data + '&tab=3&install_step=5',
                                                                    success: function(result) {
                                                                        var obj = JSON.parse(result);
                                                                        if(obj.status) {
                                                                            $('#insallation-text').fadeIn(1500).html(obj.str);
                                                                            $(".succss").show();
                                                                            $("#AddingAdmin").hide();
                                                                            $("#finalInstalltion").hide();
                                                                        } else { 
                                                                            $(".succss").show();
                                                                            $("#AddingAdmin").hide();
                                                                            $("#finalInstalltion").hide();
                                                                            $('#insallation-text').fadeIn(1500).html(obj.str);
                                                                        }
                                                                    }
                                                                });

                                                            } else  {
                                                                $("#succss").show();
                                                                $("#AddingAdmin").hide();
                                                                $("#finalInstalltion").hide();
                                                                $('#insallation-text').fadeIn(1500).html(obj.str);
                                                            }
                                                        }
                                                    });

                                                } else { 
                                                    $("#succss").show();
                                                    $("#AddingAdmin").hide();
                                                    $("#finalInstalltion").hide();
                                                    $('#insallation-text').fadeIn(1500).html(obj.str);
                                                }
                                            }
                                        });
                                    } else { 
                                        $("#succss").show();
                                        $("#AddingAdmin").hide();
                                        $("#finalInstalltion").hide();
                                        $('#insallation-text').fadeIn(1500).html(obj.str);
                                    }
                                }
                            });
                        }
                    }
                });
            });

            


        </script>
    

    </body>

</html>