@extends('layouts-verticalmenu-light.master')
@section('css')
    <link rel="stylesheet" src="{{ URL::asset('assets/plugins/apexcharts/apexcharts.min.css') }}">
@endsection
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Welcome To Dashboard</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->

    {{-- Total All over dashboard expenses --}}
    <div class="row row-sm">
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="#">
                        <label class="main-content-label mb-3 pt-1">Total Dashboard Expense (Currnet Month)</label>
                        <h2 class="text-right"><i class="icon-size mdi mdi-poll-box   float-left text-primary"></i><span
                                class="font-weight-bold">₹{{ $totalExpenses }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        {{-- Total All over dashboard expenses --}}

        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="{{ route('expenses-reports.index') }}">
                        <label class="main-content-label mb-3 pt-1">Total Expense</label>
                        <h2 class="text-right"><i class="icon-size mdi mdi-poll-box   float-left text-primary"></i><span
                                class="font-weight-bold">₹{{ $totalExpense }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="{{ route('water.index') }}">
                        <label class="main-content-label mb-3 pt-1">Total Water Expense</label>
                        <h2 class="text-right"><i class="mdi mdi-cart icon-size float-left text-primary"></i><span
                                class="font-weight-bold">₹{{ $totalWaterExpense }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="{{ route('staffs.index') }}">
                        <label class="main-content-label mb-3 pt-1">Total staff</label>
                        <h2 class="text-right card-item-icon card-icon">
                            <i class="mdi mdi-account-multiple icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ $staffsCount }}</span>
                        </h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="{{ route('plants.index') }}">
                        <label class="main-content-label mb-3 pt-1">Total Plants</label>
                        <h2 class="text-right"><i class="mdi mdi-cube icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $plantsCount }}</span></h2>
                        {{-- <p class="mb-0 mt-4 text-muted"> - <span class="float-right"></span></p> --}}
                    </a>
                    <div class="mt-4">
                        @foreach ($plantsByType as $type => $plant)
                            <div class="row mb-1 text-muted">
                                <div class="col-8">
                                    <strong>{{ $type }}</strong>
                                </div>
                                <div class="col-4 text-right">
                                    {{ $plant['total_quantity'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <div class="row row-sm">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-header border-bottom-0">
                    <label class="main-content-label my-auto pt-2">Map wise Expense chart</label>
                    <!-- <span class="d-block tx-12 mb-0 mt-1 text-muted">An Overview. Revenue is the total amount of income generated by the sale of goods or services related to the company's primary operations.</span> -->
                </div>
                <div class="card-body">
                    <div class="chart-wrapper">
                        <div id="mapWiseExpenseChart" class=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row row-sm">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                        <div class="card custom-card">
                            <form action="{{ route('send.notification') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                    <div class="form-group">
                                        <label>Body</label>
                                        <textarea class="form-control" name="body"></textarea>
                                        </div>
                                    <button type="submit" class="btn btn-primary">Send Notification</button>
                                </form>
                        </div>
                    </div>
                </div> -->
@endsection
@section('script')
    <!-- Internal Apexchart js-->
    <script src="{{ URL::asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        var mapWiseExpenses = JSON.parse('{!! $mapWiseExpensesSeries !!}');
        var landArr = JSON.parse('{!! $landArr !!}');
        var options = {
            series: mapWiseExpenses,
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: landArr,
            },
            yaxis: {
                title: {
                    text: '₹ (rupees)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "₹ " + val
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#mapWiseExpenseChart"), options);
        chart.render();
    </script>
@endsection
