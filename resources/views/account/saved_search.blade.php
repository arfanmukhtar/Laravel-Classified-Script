@extends('frontend.app')

@section('content')

<div class="main-container">
        <div class="container">
            <div class="row">
               
               @include('account.sidebar')

                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2"><i class="icon-docs"></i>{{ trans('account.saved_search.my_ads') }} </h2>

                        <div class="table-responsive">
                            <div class="table-action">
                                <label for="checkAll">
                                    <input type="checkbox" id="checkAll">
                                    Select: All | <a href="#" class="btn btn-sm btn-danger">{{ trans('account.saved_search.delete' ) }} <i
                                        class="glyphicon glyphicon-remove "></i></a> </label>

                                <div class="table-search pull-right col-sm-7">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-5 control-label text-right">{{ trans('account.saved_search.search' ) }} <br>
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
                                    <th data-type="numeric" data-sort-initial="true"></th>
                                    <th>{{ trans('account.saved_search.photo') }}</th>
                                    <th data-sort-ignore="true">{{ trans('account.saved_search.adds_details') }}</th>
                                    <th data-type="numeric">{{ trans('account.saved_search.price') }}</th>
                                    <th>{{ trans('account.saved_search.option') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="width:2%" class="add-img-selector">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox">
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width:14%" class="add-img-td"><a href="ads-details.html"><img
                                            class="thumbnail  img-responsive"
                                            src="images/item/12.jpg"
                                            alt="img"></a></td>
                                    <td style="width:58%" class="ads-details-td">
                                        <div>
                                            <p><strong> <a href="ads-details.html" title="Brand New Nexus 4">{{ trans('account.saved_search.brand_nexus') }}</a> </strong></p>

                                            <p><strong>{{ trans('account.saved_search.posted_on') }} </strong>:
                                                02-Oct-2014, 04:38 PM </p>

                                            <p><strong>{{ trans('account.saved_search.visitors') }} </strong>: 221 <strong>{{ trans('account.saved_search.located_in') }}</strong>{{ trans('account.saved_search.new_york') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width:16%" class="price-td">
                                        <div><strong> $199</strong></div>
                                    </td>
                                    <td style="width:10%" class="action-td">
                                        <div>
                                            <p><a class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i>{{ trans('account.saved_search.edit') }} </a>
                                            </p>

                                            <p><a class="btn btn-info btn-sm"> <i class="fa fa-mail-forward"></i>{{ trans('account.saved_search.share') }}
                                            </a></p>

                                            <p><a class="btn btn-danger btn-sm"> <i class=" fa fa-trash"></i>{{ trans('account.saved_search.delete') }}
                                            </a></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:2%" class="add-img-selector">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox">
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width:14%" class="add-img-td"><a href="ads-details.html"><img
                                            class="thumbnail  img-responsive" src="images/item/tp/Image00020.jpg"
                                            alt="img"></a></td>
                                    <td style="width:58%" class="ads-details-td">
                                        <div>
                                            <p><strong> <a href="ads-details.html" title="I pod 16 gb">{{ trans('account.saved_search.ipod') }} </a>
                                            </strong></p>

                                            <p><strong>{{ trans('account.saved_search.posted_on') }}</strong>:
                                                02-Oct-2014, 04:38 PM </p>

                                            <p><strong>{{ trans('account.saved_search.visitors') }} </strong>: 680 <strong>{{ trans('account.saved_search.located_in') }}</strong> {{ trans('account.saved_search.new_york') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width:16%" class="price-td">
                                        <div><strong> $90</strong></div>
                                    </td>
                                    <td style="width:10%" class="action-td">
                                        <div>
                                            <p><a class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i>{{ trans('account.saved_search.edit') }} </a>
                                            </p>

                                            <p><a class="btn btn-info btn-sm"> <i class="fa fa-mail-forward"></i>{{ trans('account.saved_search.share') }}
                                            </a></p>

                                            <p><a class="btn btn-danger btn-sm"> <i class=" fa fa-trash"></i>{{ trans('account.saved_search.delete') }}
                                            </a></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:2%" class="add-img-selector">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox">
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width:14%" class="add-img-td"><a href="ads-details.html"><img
                                            class="thumbnail  img-responsive" src="images/item/tp/Image00014.jpg"
                                            alt="img"></a></td>
                                    <td style="width:58%" class="ads-details-td">
                                        <div>
                                            <p><strong> <a href="ads-details.html" title="SAMSUNG GALAXY S CORE Duos ">{{ trans('account.saved_search.samsung_galaxy') }}
                                                </a> </strong></p>

                                            <p><strong>{{ trans('account.saved_search.posted_on') }}</strong>:
                                                02-Oct-2014, 04:38 PM </p>

                                                <p><strong>{{ trans('account.saved_search.visitors') }} </strong>: 221 <strong>{{ trans('account.saved_search.located_in') }}</strong>{{ trans('account.saved_search.new_york') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width:16%" class="price-td">
                                        <div><strong> $150</strong></div>
                                    </td>
                                    <td style="width:10%" class="action-td">
                                        <div>
                                            <p><a class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i>{{ trans('account.saved_search.edit') }} </a>
                                            </p>

                                            <p><a class="btn btn-info btn-sm"> <i class="fa fa-mail-forward"></i> {{ trans('account.saved_search.share') }}
                                            </a></p>

                                            <p><a class="btn btn-danger btn-sm"> <i class=" fa fa-trash"></i> {{ trans('account.saved_search.delete') }}
                                            </a></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:2%" class="add-img-selector">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox">
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width:14%" class="add-img-td"><a href="ads-details.html"><img
                                            class="thumbnail  img-responsive" src="images/item/tp/Image00002.jpg"
                                            alt="img"></a></td>
                                    <td style="width:58%" class="ads-details-td">
                                        <div>
                                            <p><strong> <a href="ads-details.html"
                                                           title="HTC one x 32 GB intact Seal box For sale">
                                                           {{ trans('account.saved_search.htc_one') }}</a> </strong></p>

                                            <p><strong>{{ trans('account.saved_search.posted_on') }}</strong>:
                                                02-Sept-2014, 09:00 PM </p>

                                                <p><strong>{{ trans('account.saved_search.visitors') }} </strong>: 896 <strong>{{ trans('account.saved_search.located_in') }}</strong>{{ trans('account.saved_search.new_york') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width:16%" class="price-td">
                                        <div><strong> $210</strong></div>
                                    </td>
                                    <td style="width:10%" class="action-td">
                                        <div>
                                            <p><a class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i>{{ trans('account.saved_search.edit') }} </a>
                                            </p>

                                            <p><a class="btn btn-info btn-sm"> <i class="fa fa-mail-forward"></i> {{ trans('account.saved_search.share') }}
                                            </a></p>

                                            <p><a class="btn btn-danger btn-sm"> <i class=" fa fa-trash"></i>{{ trans('account.saved_search.delete') }}
                                            </a></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:2%" class="add-img-selector">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox">
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width:14%" class="add-img-td"><a href="ads-details.html"><img
                                            class="thumbnail  img-responsive" src="images/item/tp/Image00011.jpg"
                                            alt="img"></a></td>
                                    <td style="width:58%" class="ads-details-td">
                                        <div>
                                            <p><strong> <a href="ads-details.html" title="Sony Xperia TX ">
                                            {{ trans('account.saved_search.sony_xperia') }} </a> </strong></p>

                                            <p><strong> {{ trans('account.saved_search.posted_on') }} </strong>:
                                                02-Oct-2014, 04:38 PM </p>

                                                <p><strong>{{ trans('account.saved_search.visitors') }} </strong>: 221 <strong>{{ trans('account.saved_search.located_in') }}</strong>{{ trans('account.saved_search.new_york') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width:16%" class="price-td">
                                        <div><strong> $260</strong></div>
                                    </td>
                                    <td style="width:10%" class="action-td">
                                        <div>
                                            <p><a class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i>{{ trans('account.saved_search.edit') }}</a>
                                            </p>

                                            <p><a class="btn btn-info btn-sm"> <i class="fa fa-mail-forward"></i> {{ trans('account.saved_search.share') }}
                                            </a></p>

                                            <p><a class="btn btn-danger btn-sm"> <i class=" fa fa-trash"></i> {{ trans('account.saved_search.delete') }}
                                            </a></p>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
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
