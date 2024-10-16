@extends('frontend.appother')

@section('content')


<div class="main-container inner-page">
        <div class="container">
            <div class="section-content">
                <div class="row ">
                    <div class="col-xl-12">
                        <h1 class="text-center title-1"> {{$page->title}} </h1>
                        <hr class="center-block small text-hr">
                    </div>
                   

                        <div class="col-sm-6">
                            <div class="text-content has-lead-para text-left">
                            {!! $page->body !!}
                            </div>
                        </div>

                        <div class="col-sm-6"><img src="{{url('storage/' .  $page->image)}}" alt="imfo" class="img-responsive"></div>
                   
                </div>
            </div>
        </div>
    </div>

   
@endsection