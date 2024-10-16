@extends('backend.layouts.app')

@section('content')

	<style> 
    #lc-succcess {
    color: green;
}
#lc-error {
    color: red;
}
span#lc-empty {
    color: red;
}

.message-license {
	display:none
}

</style>
<script src="//laravelclassified.com/license/script_update.js"></script>

			<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Update Classified Script</h2>
                    
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
                <div class="col-lg-12">
                
                <div class="ibox float-e-margins">
                       
                        <div class="ibox-content">
                            <form action="{{ url('pages/save') }}" class="form-horizontal" method="POST" enctype='multipart/form-data'>
                               {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Purchased License</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" id="license_key" name="license_key" value=""></div>
                                    <br>
                                    <div class="col-sm-2"><button class="btn btn-primary btn-validate" type="button">Verify License</button></div>
                                    <span class="message-license" id="lc-succcess">License verified successfully!</span>
                                    <span class="message-license" id="lc-error">License not match with our record!</span>
                                    <span class="message-license" id="lc-empty">Write here a valid license key to continue.</span>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 text-center">
                                    <div class="updatenextStep"  style="display:none;">
                                        <input type="hidden" id="currentVersion" value="<?php echo file_get_contents("version"); ?>">
                                        <button class="btn btn-success btn-center checkUpdates " type="button">Check Update</button>
                                        <p id="updateMsg">  </p>
                                    </div>
                                    <br>
                                    <button class="d-none btn btn-warning btn-center forceUpdate" type="button">Force Update</button>
                                    <button class="d-none btn btn-danger btn-center updateNow" type="button">Update Now</button>

                                    <div id="finalInstalltion" class="d-none" >
                                        <h4>Ready to Update</h4>
                                        <p class="step1"><storng> Step 1: </strong> Verifying License Key</p>
                                        <p class="step2"><storng> Step 2: </strong> Downloading Files </p>
                                        <p class="step3"><storng> Step 3: </strong> Exracting Files </p>
                                        <p class="step4"><storng> Step 4: </strong> Finalizing Installation </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </div>
    </div>

<script> 
    $("body").on("click", ".updateNow , .forceUpdate", function() {
        $("#finalInstalltion").removeClass("d-none");
        $(".step1").addClass("text-success");
        $.ajax({
            type: "POST",
            url: "https://laravelclassified.com/license/update.php",
            data: {
                license_key: $("#license_key").val()
            },
            success: function(e) {
                $(".step2").addClass("text-success");
                $.ajax({
                    type: "POST",
                    url: "<?php echo route('download-update'); ?>",
                    headers: {
                        'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    },
                    data: {
                        license_key: $("#license_key").val()
                    },
                    success: function(e) {
                        $(".step3").addClass("text-success");
                        $.ajax({
                            type: "POST",
                            url: "<?php echo route('copy-files'); ?>",
                            headers: {
                                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                            },
                            data: {
                                license_key: $("#license_key").val()
                            },
                            success: function(e) {
                                $(".step4").addClass("text-success");
                                setTimeout(() => {
                                    $("#finalInstalltion").html("<h3>Updated Successfully</h3>");
                                }, 100);
                            }
                        });
                    }
                });
            }
        });
    });     
</script>
@endsection
