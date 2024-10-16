<div class="col-md-3 page-sidebar">
  <aside>
    <div class="inner-box">
      <div class="user-panel-sidebar">
        <div class="collapse-box">
          <h5 class="collapse-title no-border">{{ trans('account.sidebar.my_classified') }}
            <a class="pull-right" aria-expanded="true" data-bs-toggle="collapse" href="#MyClassified">
              <i class="fa fa-angle-down"></i>
            </a>
          </h5>
          <div id="MyClassified" class="panel-collapse collapse show">
            <ul class="acc-list">
              <li @if(Request::segment(2)=="home" ) class="active" @endif>
                <a href="{{route('personal_home')}}">
                  <i class="icon-home"></i>{{ trans('account.sidebar.personal_home') }}
                </a>
              </li>
            </ul>
          </div>
        </div>
        <!-- /.collapse-box  -->
        <div class="collapse-box">
          <h5 class="collapse-title">{{ trans('account.sidebar.my_ads') }}
            <a class="pull-right" aria-expanded="true" data-bs-toggle="collapse" href="#MyAds">
              <i class="fa fa-angle-down"></i>
            </a>
          </h5>
          <div id="MyAds" class="panel-collapse collapse show">
            <ul class="acc-list">
              <li @if(Request::segment(2)=="my-ads" ) class="active" @endif>
                <a href="{{route('my_ads')}}">
                  <i class="icon-docs"></i>
                  {{ trans('account.sidebar.my_ads') }}
                  <span class="badge bg-secondary"></span>
                </a>
              </li>
              <li @if(Request::segment(2)=="favourite-ads" ) class="active" @endif>
                <a href="{{route('favourite_ads')}}">
                  <i class="icon-heart"></i>
                  {{ trans('account.sidebar.favourite_ads') }}
                  <span class="badge bg-secondary"></span>
                </a>
              </li>
              <!-- <li @if(Request::segment(2) == "saved_search") class="active" @endif><a href="{{route('saved_search')}}"><i class="icon-star-circled"></i>
                                                Saved search <span class="badge bg-secondary"></span></a></li> -->
              <li @if(Request::segment(2)=="archived_ads" ) class="active" @endif>
                <a href="{{route('archived_ads')}}">
                  <i class="icon-folder-close"></i>
                  {{ trans('account.sidebar.archived_ads') }}
                  <span class="badge bg-secondary"></span>
                </a>
              </li>
              <li @if(Request::segment(2)=="pending-approval" ) class="active" @endif>
                <a href="{{route('pending-approval')}}">
                  <i class="icon-hourglass"></i> {{ trans('account.sidebar.pending_approval') }}
                  <span class="badge"></span>
                </a>
              </li>
              <li @if(Request::segment(1)=="messages" ) class="active" @endif>
                <a href="{{route('personal_inbox')}}">
                  <i class="icon-mail"></i> {{ trans('account.sidebar.message_inbox') }}
                  <span class="badge unreadMsgCount">0</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <!-- /.collapse-box  -->
        <div class="collapse-box">
          <h5 class="collapse-title">{{ trans('account.sidebar.terminate_account') }}
            <a class="pull-right" aria-expanded="true" data-bs-toggle="collapse" href="#TerminateAccount">
              <i class="fa fa-angle-down"></i>
            </a>
          </h5>
          <div id="TerminateAccount" class="panel-collapse collapse show">
            <ul class="acc-list">
              <li>
                <a href="account-close.html">
                  <i class="icon-cancel-circled "></i>{{ trans('account.sidebar.close_account') }}
                </a>
              </li>
            </ul>
          </div>
        </div>
        <!-- /.collapse-box  -->
      </div>
    </div>
    <!-- /.inner-box  -->
  </aside>
</div>
<!--/.page-sidebar-->
<!-- include footable   -->
<script src="{{url('assets/js/footablecd98.js?v=2-0-1')}}" type="text/javascript"></script>
<script src="{{url('assets/js/footable.filtercd98.js?v=2-0-1')}}" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
    $('#addManageTable').footable().bind('footable_filtering', function(e) {
      var selected = $('.filter-status').find(':selected').text();
      if (selected && selected.length > 0) {
        e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
        e.clear = !e.filter;
      }
    });
    $('.clear-filter').click(function(e) {
      e.preventDefault();
      $('.filter-status').val('');
      $('table.demo').trigger('footable_clear_filter');
    });
  });
</script>
<!-- include custom script for ads table [select all checkbox]  -->
<script>
  function checkAll(bx) {
    var chkinput = document.getElementsByTagName('input');
    for (var i = 0; i < chkinput.length; i++) {
      if (chkinput[i].type == 'checkbox') {
        chkinput[i].checked = bx.checked;
      }
    }
  }
</script>