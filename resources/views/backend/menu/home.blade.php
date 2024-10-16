@extends('backend.layouts.app')

@section('content')
<?php $currency =  setting_by_key("currency"); ?>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Update Menu</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('admin/dashboard')}}">Home</a>
                        </li>
                       
                        <li class="breadcrumb-item active">
                            <strong>Menu Settings</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content  animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>All menu</h5>
                        </div>
                        <div class="ibox-content">

                            <p  class="m-b-lg">
                                <strong>Available Menu</strong> .
                            </p>

                            <div class="dd" id="nestable">
                                <ol class="dd-list">
                                    @if(!in_array("/", $jsonArray))
                                    <li class="dd-item" data-name="menu.home" data-id="/">
                                        <div class="dd-handle">Home</div>
                                    </li>
                                    @endif
                                    @if(!in_array("category", $jsonArray))
                                    <li class="dd-item"  data-name="menu.category" data-id="category">
                                        <div class="dd-handle">Categories with Parent List</div>
                                    </li>
                                    @endif
                                    @php 
                                        $pages = DB::table("pages")->where("title" , "!=" , "footer")->get();
                                    @endphp
                                    @foreach($pages as $page) 
                                        @if(!in_array($page->slug, $jsonArray))
                                        <li class="dd-item"  data-name="{{$page->title}}" data-id="{{$page->slug}}">
                                            <div class="dd-handle">{{$page->title}}</div>
                                        </li>
                                        @endif
                                    @endforeach
                                   
                                </ol>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Main Menu</h5>
                        </div>
                        <div class="ibox-content">

                            <p class="m-b-lg">
                                
                            </p>

                            <div class="dd" id="nestable2">
                                <ol class="dd-list">

                                    @foreach($jsonData as $json)
                                    <li class="dd-item" data-name="{{$json['name']}}" data-id="{{$json['id']}}">
                                        <div class="dd-handle"><small>{{trans($json['name'])}}</small></div>
                                    </li>
                                    @endforeach
                                   
                                </ol>
                            </div>
                            <div class="m-t-md">
                                <h5>Serialised Output</h5>
                            </div>
                            <textarea id="nestable2-output" class="form-control"></textarea>
                            <br>
                            <button type="button" id="saveMenu" class="btn btn-primary"> Save Menu </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script src="{{url('assets/backend/js/plugins/nestable/jquery.nestable.js')}}"></script>
        <script>
         $(document).ready(function(){

            $("body").on("click" , "#saveMenu" , function() { 
                $("#loading").show();
                 var json = $("#nestable2-output").val();
                 var form_data = {
                    json
                 };
                 $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    },
                    url: '<?php echo route("save-menu"); ?>',
                    data: form_data,
                    success: function ( msg ) {
                        // location.reload();
                    },
                    complete: function(msg) { 
                        $("#loading").hide();
                    }
                });
            });

             var updateOutput = function (e) {
                 var list = e.length ? e : $(e.target),
                         output = list.data('output');
                 if (window.JSON) {
                     output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                 } else {
                     output.val('JSON browser support required for this demo.');
                 }
             };
             // activate Nestable for list 1
             $('#nestable').nestable({
                 group: 1
             }).on('change', updateOutput);

             // activate Nestable for list 2
             $('#nestable2').nestable({
                 group: 1
             }).on('change', updateOutput);

             // output initial serialised data
             updateOutput($('#nestable').data('output', $('#nestable-output')));
             updateOutput($('#nestable2').data('output', $('#nestable2-output')));

             $('#nestable-menu').on('click', function (e) {
                 var target = $(e.target),
                         action = target.data('action');
                 if (action === 'expand-all') {
                     $('.dd').nestable('expandAll');
                 }
                 if (action === 'collapse-all') {
                     $('.dd').nestable('collapseAll');
                 }
             });
         });
    </script>

@endsection
