@extends('backend.layouts.app')

@section('content')
<?php $currency =  setting_by_key("currency");   ?> 
<style>
    svg g g[opacity][aria-labelledby][transform][filter] {
        display: none;
    }
    #userschart {
        width: 100%;
        height: 500px;
    }
    #pre-users {
        width: 100%;
        height: 500px;
        margin-bottom:-50px;
    }
    #postscount {
        width: 100%;
        height: 450px;
    }
    .post-name {
        width: 100%;
        display: block;
        max-width: 230px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .ibox-content>h4 {
        font-size: 36px;
        font-weight: bold;
    }
    .ibox-content>h5 {
        color: #8e8e8e;
    }
    .dash-stats .ibox-content {
        padding: 30px;
        border-bottom: 4px solid #ddd;
        border-top: 0;
    }
    .ibox-content.success {
        border-color: #1ab394;
    }
    .ibox-content.info {
        border-color: #23C6C9;
    }
    .ibox-content.primary {
        border-color: #1c84c6;
    }
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<div class="container">
<div class="wrapper wrapper-content">
        <div class="row dash-stats">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content success">
                        <h4 class="no-margins">{{$total_active}}</h4>
                        <h5>Total Active</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content success">
                        <h4 class="no-margins">{{$total_pending}}</h4>
                        <h5>Total Pending</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content success">
                        <h4 class="no-margins">{{$total_rejected}}</h4>
                        <h5>Total Rejected</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content success">
                        <h4 class="no-margins">{{$total_archived}}</h4>
                        <h5>Total Archived</h5>
                    </div>
                </div>
            </div>


            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content info">
                        <h4 class="no-margins">{{$today}}</h4>
                        <h5>Today Post</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content info">
                        <h4 class="no-margins">{{$yesterday}}</h4>
                        <h5>Yesterday Post</h5>
                    </div>
                </div>
            </div>

			
			 <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content info">
                        <h4 class="no-margins">{{$last_week}}</h4>
                        <h5>Last 7 Days  </h5>
                    </div>
                </div>
            </div>

			
			 <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content info">
                        <h4 class="no-margins">{{$last_month}}</h4>
                        <h5>Last 30 days</h5>
                    </div>
                </div>
            </div>
			
			 <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content primary">
                        <h4 class="no-margins">{{$last_3_month}}</h4>
                        <h5>Last 3 Month</h5>
                    </div>
                </div>
            </div>
			 <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content primary">
                        <h4 class="no-margins">{{$last_6_month}}</h4>
                         <h5>Last 6 Month</h5>
                    </div>
                </div>
            </div>
			 <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content primary">
                        <h4 class="no-margins">{{$last_1_year}}</h4>
                         <h5>Last 1 year</h5>
                    </div>
                </div>
            </div>
			
			<div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content primary">
                        <h4 class="no-margins">{{$total_earning}}</h4>    
                        <h5>@lang('All Posts')</h5>                    
                    </div>
                </div>
            </div>
            
        </div>
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Users Posts <small>(Last 30 Days)</small></h5>
                    <div class="ibox-tools">
                        <h5>Aug 19 2023 - Sep 18 2023</h5>
                    </div>
                </div>
                <div class="ibox-content">

                    <!-- Chart code -->
                    <script>
                        am4core.ready(function() {

                            // Themes begin
                            am4core.useTheme(am4themes_animated);
                            // Themes end

                            // Create chart instance
                            var chart = am4core.create("userschart", am4charts.XYChart);
                           
                            // Add data
                            chart.data = generateChartData();

                            // Create axes
                            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                            dateAxis.renderer.minGridDistance = 50;

                            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                            // Create series
                            var series = chart.series.push(new am4charts.LineSeries());
                            series.dataFields.valueY = "visits";
                            series.dataFields.dateX = "date";
                            series.strokeWidth = 2;
                            series.minBulletDistance = 10;
                            series.tooltipText = "[bold]Posts:[/] {valueY}";
                            series.tooltip.pointerOrientation = "vertical";
                            series.tooltip.background.cornerRadius = 20;
                            series.tooltip.background.fillOpacity = 0.5;
                            series.tooltip.label.padding(12,12,12,12)

                            // Add scrollbar
                            chart.scrollbarX = new am4charts.XYChartScrollbar();
                            chart.scrollbarX.series.push(series);

                            // Add cursor
                            chart.cursor = new am4charts.XYCursor();
                            chart.cursor.xAxis = dateAxis;
                            chart.cursor.snapToSeries = series;

                            function generateChartData() {
                                var chartData = [];
                                <?php 
                                foreach($postarray as $dd) {
                            ?>

                                    chartData.push({
                                        date: "<?php echo $dd["date"]; ?>",
                                        visits: <?php echo $dd["visits"]; ?>
                                    });
                                    <?php } ?>
                                return chartData;
                            }

                        }); // end am4core.ready()
                    </script>

                    <!-- HTML -->
                    <div id="userschart"></div>
                </div>
            </div>
        </div>
    </div>
<?php /*
    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Top Premium Users <small>(By Posts)</small></h5>
                    <div class="ibox-tools">
                        <h5>Aug 18 2023 - Sep 17 2023</h5>
                    </div>
                </div>
                <div class="ibox-content">

                    <!-- Chart code -->
                    <script>
                        am4core.ready(function() {

                            // Themes begin
                            am4core.useTheme(am4themes_animated);
                            // Themes end

                            // Create chart instance
                            var chart = am4core.create("pre-users", am4charts.XYChart);
                            // chart.scrollbarX = new am4core.Scrollbar();

                            // Add data
                            chart.data = [{
                            "country": "Shahbaz",
                            "visits": 60
                            }, {
                            "country": "Arfan",
                            "visits": 58
                            }, {
                            "country": "Zahid",
                            "visits": 56
                            }, {
                            "country": "Amjad",
                            "visits": 54
                            }, {
                            "country": "Ishtiaq",
                            "visits": 52
                            }, {
                            "country": "Ashfaq",
                            "visits": 50
                            }, {
                            "country": "Shahid",
                            "visits": 48
                            }, {
                            "country": "Moosa",
                            "visits": 46
                            }, {
                            "country": "Imran",
                            "visits": 44
                            }, {
                            "country": "Umer",
                            "visits": 42
                            }];

                            // Create axes
                            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                            categoryAxis.dataFields.category = "country";
                            categoryAxis.renderer.grid.template.location = 0;
                            categoryAxis.renderer.minGridDistance = 30;
                            categoryAxis.renderer.labels.template.horizontalCenter = "right";
                            categoryAxis.renderer.labels.template.verticalCenter = "middle";
                            categoryAxis.renderer.labels.template.rotation = -45;
                            categoryAxis.tooltip.disabled = true;
                            categoryAxis.renderer.minHeight = 110;

                            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                            valueAxis.renderer.minWidth = 50;

                            // Create series
                            var series = chart.series.push(new am4charts.ColumnSeries());
                            series.sequencedInterpolation = true;
                            series.dataFields.valueY = "visits";
                            series.dataFields.categoryX = "country";
                            series.tooltipText = "[bold]{categoryX}:[/] {valueY}";
                            series.columns.template.strokeWidth = 0;

                            series.tooltip.pointerOrientation = "vertical";

                            series.columns.template.column.cornerRadiusTopLeft = 10;
                            series.columns.template.column.cornerRadiusTopRight = 10;
                            series.columns.template.column.fillOpacity = 0.8;

                            // on hover, make corner radiuses bigger
                            var hoverState = series.columns.template.column.states.create("hover");
                            hoverState.properties.cornerRadiusTopLeft = 0;
                            hoverState.properties.cornerRadiusTopRight = 0;
                            hoverState.properties.fillOpacity = 1;

                            series.columns.template.adapter.add("fill", function(fill, target) {
                            return chart.colors.getIndex(target.dataItem.index);
                            });

                            // Cursor
                            chart.cursor = new am4charts.XYCursor();

                        }); // end am4core.ready()
                    </script>

                    <!-- HTML -->
                    <div id="pre-users"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Free Posts VS Premium Posts</h5>
                    <div class="ibox-tools">
                        <!-- <h5>Aug 19 2023 - Sep 18 2023</h5> -->
                    </div>
                </div>
                <div class="ibox-content">
                    <!-- Chart code -->
                    <script>
                        am4core.ready(function() {

                            // Themes begin
                            am4core.useTheme(am4themes_animated);
                            // Themes end

                            // Create chart instance
                            var chart = am4core.create("postscount", am4charts.PieChart);

                            // Add and configure Series
                            var pieSeries = chart.series.push(new am4charts.PieSeries());
                            pieSeries.dataFields.value = "counts";
                            pieSeries.dataFields.category = "posts";

                            // Let's cut a hole in our Pie chart the size of 30% the radius
                            chart.innerRadius = am4core.percent(30);

                            // Put a thick white border around each Slice
                            pieSeries.slices.template.stroke = am4core.color("#fff");
                            pieSeries.slices.template.strokeWidth = 2;
                            pieSeries.slices.template.strokeOpacity = 1;
                            pieSeries.slices.template
                            // change the cursor on hover to make it apparent the object can be interacted with
                            .cursorOverStyle = [
                                {
                                "property": "cursor",
                                "value": "pointer"
                                }
                            ];

                            pieSeries.alignLabels = false;
                            pieSeries.labels.template.bent = true;
                            pieSeries.labels.template.radius = 3;
                            pieSeries.labels.template.padding(0,0,0,0);

                            pieSeries.ticks.template.disabled = true;

                            // Create a base filter effect (as if it's not there) for the hover to return to
                            var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
                            shadow.opacity = 0;

                            // Create hover state
                            var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

                            // Slightly shift the shadow and make it more prominent on hover
                            var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
                            hoverShadow.opacity = 0.7;
                            hoverShadow.blur = 5;

                            // Add a legend
                            // chart.legend = new am4charts.Legend();

                            chart.data = [{
                            "posts": "Free Posts",
                            "counts": 1147
                            },{
                            "posts": "Paid Posts",
                            "counts": 247
                            }];

                        }); // end am4core.ready()
                    </script>

                    <!-- HTML -->
                    <div id="postscount"></div>
                </div>
            </div>
        </div>
    </div>
    */?>

    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Last 10 Transactions </h5>
                    <div class="ibox-tools"></div>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover mb-0" id="payments">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lastest_users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{date("d M, Y" , strtotime($user->created_at))}}</td>
                            </tr>
                            @endforeach
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Recent 10 Premium Posts</h5>
                    <div class="ibox-tools">
                        <!-- <h5>Aug 19 2023 - Sep 18 2023</h5> -->
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover mb-0" id="payments">
                        <thead>
                            <tr>
                                <th width="50%">Posts Name</th>
                                <th>User</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($lastest_posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                <td>{{$post->user->name}}</td>
                                <td>{{date("d M, Y" , strtotime($post->created_at))}}</td>
                            </tr>
                            @endforeach
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<br /><br />

@endsection
