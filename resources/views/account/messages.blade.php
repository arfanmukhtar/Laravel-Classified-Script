@extends('frontend.app')

@section('content')

<div class="main-container">
        <div class="container">
            <div class="row">
               
               @include('account.sidebar')

               <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2"><i class="icon-mail"></i>{{ trans('account.messages.inbox') }}</h2>
                        <div class="inbox-wrapper">
                            <div class="row">
                               

                                <div class="col-md-12 col-lg-12">

                                    <div class="btn-group  mobile-only-inline">
                                        <a href="account-message-compose.html" class="btn btn-primary text-uppercase"
                                        ><i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group hidden-sm">
                                      
                                        <button type="button" class="btn btn-secondary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false" >
                                            <span class="dropdown-menu-sort-selected">{{ trans('account.messages.all') }}</span>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-sort" role="menu">
                                            <li class="dropdown-item active"><a >{{ trans('account.messages.all') }}</a>
                                            </li>
                                           
                                            <li class="dropdown-item"><a >{{ trans('account.messages.read') }}</a>
                                            </li>
                                            <li class="dropdown-item"><a >{{ trans('account.messages.unread') }}</a>
                                            </li>
                                           
                                        </ul>
                                    </div>

                                    <a type="button" href="" class="btn btn-secondary hidden-sm" data-toggle="tooltip"
                                            title="Refresh"><span class="fas fa-sync-alt"></span>
                                    </a>
                                    <div class="message-tool-bar-right pull-right">
                                        <span class="text-muted count-message"><b>1</b> - <b>20</b> of <b>255</b></span>
                                        <div
                                                class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-secondary"><span
                                                    class="fas fa-arrow-left"></span>
                                            </button>
                                            <button type="button" class="btn btn-secondary"><span
                                                    class="fas fa-arrow-right"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                               
                                <div class="col-md-12 col-lg-12">
                                    <div class="message-list">
                                        <div id="home">
                                           
                                            <div class="list-group">
                                                <?php  $totalUnread = 0;  ?>
                                            @foreach($threads as $thread)
                                                <?php $class = $thread->isUnread(Auth::id()) ? '' : 'seen';
                                                    $totalUnread +=  $thread->userUnreadMessagesCount(Auth::id());
                                                ?>
                                                <div class="list-group-item {{$class}}">
                                                    
                                                    <a href="{{ route('messages.show', $thread->id) }}" class="list-box-user">
                                                        <img src="images/users/6.jpg" alt="user">
                                                        <span class="name"> <i class="fa fa-circle online"></i>{{ $thread->creator()->name }}</span>
                                                    </a> 
                                                    <a href="{{ route('messages.show', $thread->id) }}" class="list-box-content">
                                                        <span class="title">{{ $thread->subject }} <small>({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)</h4></small></span> 
                                                        <div class="message-text  ">
                                                        {{ $thread->latestMessage->body }}
                                                        </div>
                                                        <div class="time text-muted">{{ $thread->latestMessage->created_at->diffForHumans() }}</div>
                                                    </a>
                                                    <div class="list-box-action">
                                                        <a data-toggle="tooltip" class="delete" data-id="{{$thread->id}}" data-placement="top" title="Delete ">
                                                            <i class=" fas fa-trash"></i></a>
                                                        
                                                    </div>
                                                </div>
                                            @endforeach

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


    </div>


<script>
    setTimeout(() => {
        $(".unreadMsgCount").html("<?php echo $totalUnread; ?>");
    }, 1000);
     $("body").on("click" , ".delete" , function() { 
       
        var thread_id = $(this).attr("data-id");
        var form_data = {
            thread_id
        };
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            },
            url: '<?php echo route("delete-thread"); ?>',
            data: form_data,
            success: function ( msg ) {
                location.reload();
            }
        });
    });
</script>


@endsection
