@extends('frontend.app')

@section('content')

<div class="main-container">
        <div class="container">
            <div class="row">
               
               @include('account.sidebar')

                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2"><i class="icon-docs"></i> {{ trans('account.archived_ads.my_ads') }} </h2>

                        <div class="table-responsive">
                            <div class="table-action">
                                
                                <div class="table-search pull-right col-sm-7">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-5 control-label text-right">{{ trans('account.archived_ads.search') }}<br>
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
                                    <th>{{ trans('account.archived_ads.photo') }} </th>
                                    <th data-sort-ignore="true">{{ trans('account.archived_ads.adds_details') }} </th>
                                    <th data-type="numeric">{{ trans('account.archived_ads.price') }}</th>
                                    <th>{{ trans('account.archived_ads.option') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ads as $ad)
                                <tr>
                                    
                                    <td style="width:14%" class="add-img-td"><a href="{{url('detail/' . $ad->slug)}}"><img
                                            class="thumbnail  img-responsive"
                                            src="{{url('storage/' . $ad->image)}}"
                                            alt="img"></a></td>
                                    <td style="width:58%" class="ads-details-td">
                                        <div>
                                            <p><strong> <a href="{{url('detail/' . $ad->slug)}}" title="{{$ad->title}}">{{$ad->title}}</a> </strong></p>

                                            <p><strong> {{ trans('account.archived_ads.posted_on') }} </strong>: {{time_elapsed_string($ad->created_at)}} </p>

                                            <p><strong>{{ trans('account.archived_ads.visitors') }} </strong>: 221 <strong>{{ trans('account.archived_ads.located_in') }}</strong> {{$ad->city->name}}
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width:16%" class="price-td">
                                        <div><strong> {{number_format($ad->price)}}</strong></div>
                                    </td>
                                    <td style="width:10%" class="action-td">
                                        <div>
                                            <p><a class="btn btn-danger btn-sm"> <i class=" fa fa-trash"></i>{{ trans('account.archived_ads.delete') }}
                                            </a></p>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <br>
                        {!! $ads->render() !!}

                    </div>
                </div>
                <!--/.page-content-->
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>


@endsection
