@extends('frontend.app')

@section('content')
<?php 
      $app_setting = getApplicationSettings();
      $currency_symbol = !empty($app_setting["currency_symbol"]) ? $app_setting["currency_symbol"] : "$";
?>
<div class="main-container">
        <div class="container">
            <div class="row">
               
               @include('account.sidebar')

                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2"><i class="icon-docs"></i>{{ trans('account.my_ads.my_ads') }} </h2>

                        <div class="table-responsive">
                            <div class="table-action">
                                <label for="checkAll">{{ trans('account.my_ads.my_ads') }}</label>

                                <div class="table-search pull-right col-sm-7">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-5 control-label text-right">{{ trans('account.my_ads.search') }}<br>
                                                <a title="clear filter" class="clear-filter" href="#clear">[clear]</a>
                                            </label>

                                            <div class="col-sm-7 searchpan">
                                                <input type="text" class="form-control" id="filter">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table id="addManageTable"
                                   class="table table-striped table-bordered add-manage-table table demo"
                                   data-filter="#filter" data-filter-text-only="true">
                                <thead>
                                <tr>
                                    <th> Photo</th>
                                    <th data-sort-ignore="true">{{ trans('account.my_ads.adds_details') }} </th>
                                    <th data-type="numeric">{{ trans('account.my_ads.price') }} </th>
                                    <th>{{ trans('account.my_ads.option') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ads as $ad)
                                <tr>
                                 
                                    
                                    <td style="width:14%" class="add-img-td"><a href="{{url('detail/' . $ad->slug)}}">
                                        
                                    @if(!empty($ad->mainPhoto->filename))
                                        <img class="thumbnail  img-responsive"
                                            src="{{url('storage/' . $ad->mainPhoto->filename)}}"
                                            alt="img">
                                    @endif
                                        </a></td>
                                    <td style="width:58%" class="ads-details-td">
                                        <div>
                                            <p><strong> <a href="{{url('detail/' . $ad->slug)}}" title="{{$ad->title}}">{{$ad->title}}</a> </strong></p>

                                            <p><strong>{{ trans('account.my_ads.posted_on') }} </strong>: {{time_elapsed_string($ad->created_at)}} </p>

                                            <p><strong>{{ trans('account.my_ads.visitors') }}  </strong>: {{$ad->visits}} <br>
                                             <strong>{{ trans('account.my_ads.located_in') }}</strong> {{$ad->city->name}} <br>
                                             <strong>{{ trans('account.my_ads.category') }}</strong> {{$ad->category->name}} <br>
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width:16%" class="price-td">
                                        <div><strong> {{ $currency_symbol}}{{number_format($ad->price)}}</strong></div>
                                    </td>
                                    <td style="width:15%" class="action-td">
                                        <div>
                                            <p>
                                                <a title="Edit" href="{{url('account/edit-ad/' . $ad->id)}}" class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i>  </a>
                                                <a class="btn btn-danger btn-sm"> <i class=" fa fa-trash"></i> 
                                            </a>
                                            </p>

                                            <p>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(url('detail/' . $ad->slug)); ?>" target="_blank"><i class="btn btn-sm btn-primary fab fa-facebook-f"></i></a>
                                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(url('detail/' . $ad->slug)); ?>&text=<?php echo urlencode($ad->title); ?>" target="_blank"><i class="btn btn-sm btn-primary fab fa-twitter"></i>
        </a>
                                            </p>

                                            <p><a href="{{url('account/edit-photos/' . $ad->id)}}" class="btn btn-success btn-sm"> <i class=" fa fa-image"></i> 
                                            </a> 
                                            <a title="Change status" href="javascript:void(0);" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i>  </a>
                                        </p>

                                            
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                                </tbody>
                            </table>
                        </div>
                        <br>
                        {!! $ads->render() !!}
                        <!--/.row-box End-->

                    </div>
                </div>
                <!--/.page-content-->
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>


@endsection
