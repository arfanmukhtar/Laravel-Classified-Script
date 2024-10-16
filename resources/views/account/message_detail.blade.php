@extends('frontend.app')

@section('content')

<div class="main-container">
        <div class="container">
            <div class="row">
               
               @include('account.sidebar')

               <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2"><i class="icon-mail"></i>{{ trans('account.message_detals.inbox') }} </h2>
                        <div class="inbox-wrapper">
                            <div class="row">
                               

                                <div class="col-md-12 col-lg-12">
                                    

                                    <button type="button" class="btn btn-secondary hidden-sm" data-toggle="tooltip"
                                            title="Refresh"><span class="fas fa-sync-alt"></span>
                                    </button>
                                    {{ $thread->subject }}
                                   
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                               
                            <div class="col-md-12 col-lg-12 chat-row">
                                    <div class="message-chat">
                                        <div class="message-chat-history">
                                            @foreach($thread->messages as $message)
                                            <div class="chat-item object-user">

                                                <div class="object-user-img">
                                                {{ $message->user->name }}
                                                    <img src="images/users/8.jpg" alt="User ">
                                                </div>

                                                <div class="chat-item-content">
                                                    <div class="chat-item-content-inner">
                                                        <div class="msg">
                                                            <p>{{ $message->body }} </p>
                                                        </div>
                                                        <span class="time-and-date">  {{ $message->created_at->diffForHumans() }} </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        
                                        </div>

                                        <div class="type-message">
                                            <div class="type-form">
                                                <input type="text" id="message" class="input-write form-control" placeholder="Type a message...">
                                                <div class="button-wrap">
                                                    <!-- <button class="btn btn-secondary" type="button"><i class="fas fa-paperclip" aria-hidden="true"></i></button> -->
                                                    <button class="btn btn-secondary sendReply" type="button"><i class="fas fa-paper-plane" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--/. inbox-wrapper-->
                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>


    <script>
         $("body").on("click" , ".sendReply" , function() { 
            var message = $("#message").val();
            var thread_id = <?php  echo $thread->id; ?>;
            var form_data = {
                thread_id,message
            };
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                },
                url: '<?php echo route("reply-message"); ?>',
                data: form_data,
                success: function ( msg ) {
                    $("#message").val("");
                }
            });
        });
    </script>


@endsection
