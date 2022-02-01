@extends('admin.layout.app')
@section('content')
  <div class="content-page">
    <!-- Start content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="page-title-box">
              <h4 class="page-title">Dashboard</h4>
              <ol class="breadcrumb p-0 m-0">
                <li><a href="{{ url('dashboard') }}">Home</a> </li>
                <li class="active"> Dashboard</li>
              </ol>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
        <!-- end row -->
        <div class="row">
          @if(\App\Setting::first()->value('is_mail_configured') == 0)
            <div class="alert alert-warning">
              <p><strong> Please set up your <a  href="{!! Route('email-settings.index') !!}">mail settings </strong></a> </p>
            </div>
          @endif

          <div class="card-box widget-box-two">
            <div class="row">
              <div class="col-md-12 col-xs-12 col-xxs-12">
                <div id="container"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-two widget-two-info">
              <i class="fa fa-users widget-two-icon"></i>
              <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Users</p>
                <h2 class="text-white"><span data-plugin="counterup">{{ $total_user }}</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                <p class="m-0"><b>Today:</b> {{ $today_user }}</p>
              </div>
            </div>
          </div><!-- end col -->
          <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-two widget-two-primary">
              <i class="mdi mdi-layers widget-two-icon"></i>
              <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Ads</p>
                <h2 class="text-white"><span data-plugin="counterup">{{ $total_ads }}</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                <p class="m-0"><b>Today:</b> {{ $today_ads }}</p>
              </div>
            </div>
          </div><!-- end col -->

          <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-two widget-two-brown">
              <i class="mdi mdi-message widget-two-icon"></i>
              <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Messages</p>
                <h2 class="text-white"><span data-plugin="counterup">{{ $total_messages }}</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                <p class="m-0"><b>Today:</b> {{ $today_messages }}</p>
              </div>
            </div>
          </div><!-- end col -->

          <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-two widget-two-pink">
              <i class="mdi mdi-content-save widget-two-icon"></i>
              <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Save Ads</p>
                <h2 class="text-white"><span data-plugin="counterup">{{ $total_save_ads }}</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                <p class="m-0"><b>Today:</b> {{ $today_save_ads }}</p>
              </div>
            </div>
          </div><!-- end col -->

        </div>
        <!-- end row -->
      </div> <!-- container -->
    </div> <!-- content -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>
        // high chart
        Highcharts.chart('container', {
            chart: {
                height: 250,
            },
            title: {
                text: 'Stats of last 12 months',
                align: 'center'
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    month: '%b',
                    year: '%Y'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [
                {
                    data: [{{$ads_view}}],
                    name: 'Ads views',
                    color: '#1B53B7',
                    pointStart: Date.UTC({{date("Y,m", strtotime("-12 months"))}}),
                    pointIntervalUnit: 'month'
                },
                {
                    data: [{{$profile_view}}],
                    name: 'Profile views',
                    color: '#f9423a',
                    pointStart: Date.UTC({{date("Y,m", strtotime("-12 months"))}}),
                    pointIntervalUnit: 'month'
                },
                {
                    data: [{{$register_stats}}],
                    name: 'User Registered',
                    color: '#70d5de',
                    pointStart: Date.UTC({{date("Y,m", strtotime("-12 months"))}}),
                    pointIntervalUnit: 'month'
                },
                {
                    data: [{{$message_stats}}],
                    name: 'Messages',
                    color: '#00bc1e',
                    pointStart: Date.UTC({{date("Y,m", strtotime("-12 months"))}}),
                    pointIntervalUnit: 'month'
                },
            ],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 1000,
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    </script>
@endsection
