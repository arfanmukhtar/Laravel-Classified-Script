@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <div class="panel panel-default">
    <div class="panel-body">
        <form action="{{ route('save-profile') }}" method="POST">
            <input type="hidden" name="_method" value="post">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">@lang('common.name')</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <div class="form-group">
                <label for="email">@lang('common.email')</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
            </div>
			
			

            <div class="form-group">
                <button type="submit" class="btn btn-primary">@lang('common.update')</button>
                <a class="btn btn-link" href="{{ url('admin/settings/profile') }}">@lang('common.cancel')</a>
				<input type="button" data-toggle="modal" data-target="#resetPasswordModal" class="btn btn-primary pull-right" value="@lang('common.reset_password')">
            </div>
        </form>
    </div>
    </div>
    </div>
</div>

<!-- resetPasswordModal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">@lang('common.reset_password')</h4>
      </div>
      <div class="modal-body">
		  	<div class="form-group">
			  <label class="font-14px">@lang('common.old_password')</label>
			  <input type="password" id="user_password_pass"  class="form-control notreadonly">
		  </div>
     		<div class="form-group">
			  <label class="font-14px">@lang('common.new_password')</label>
			  <input type="password" id="new_password" class="form-control notreadonly">
		  </div>
     <div class="form-group">
			  <label class="font-14px">@lang('common.confirm_new_password')</label>
			  <input type="password" id="confirm_password"  class="form-control notreadonly">
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="Update_Password" data-id="pass" class="btn btn-primary">@lang('common.update')</button>
      </div>
    </div>
  </div>
</div>
<link href="{{url('assets/backend/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
 <script src="{{url('assets/backend/js/plugins/toastr/toastr.min.js')}}"></script>

<script> 
$("body").on("click" , "#Update_Password" , function() {
			
						var form_data = {
							ID_User: $("#ID_User").val(),
							user_password: $("#user_password_pass").val(),
							new_password: $("#new_password").val(),
						};
						var error = false;
						if($("#user_password_pass").val() == "") { 
								$("#user_password_pass").addClass("error");
								error = true;
						} else { 
								$("#user_password_pass").removeClass("error");
						}
						
						if($("#new_password").val() == "") { 
								$("#new_password").addClass("error");
								error = true;
						} else { 
								$("#new_password").removeClass("error");
						}
						
						if($("#confirm_password").val() == "") { 
								$("#confirm_password").addClass("error");
								error = true;
						} else { 
								$("#confirm_password").removeClass("error");
						}
						
						if($("#confirm_password").val() != $("#new_password").val()) { 

							toastr.error("Confirm Password does not match");	
							return false;
						}
						
							if(error == true) { 
								toastr.error("Required all fields");
								return false;
							}
						

					$.ajax({
						type: 'POST',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: '<?php echo route("update-password"); ?>',
						data: form_data,
						success: function (msg) {
						
							var obj = JSON.parse(msg);
							if(obj['error'] == 1) {
								toastr.error(obj['message']);	
							}
							
							if(obj['error'] == 0) {
								toastr.success(obj['message']);
								$('#resetPasswordModal').modal('hide');
								$('#changeEmailModal').modal('hide');
							}
								
						}
					});

		});
		</script>
@endsection