@extends('layouts-verticalmenu-light.master')
@section('css')
    <link rel="stylesheet" src="{{ URL::asset('assets/plugins/apexcharts/apexcharts.min.css') }}">

    <!-- Internal DataTables css-->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />

    <style>
        .plant-type {
          cursor: pointer;
        }
      </style>
@endsection
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Plant</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Plant</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="card-order">
                        <label class="main-content-label mb-3 pt-1">Total</label>
                        <h2 class="text-right"><i class="icon-size mdi mdi-flower float-left text-primary"></i><span
                                class="font-weight-bold">₹{{ $totalPlants }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="card-order">
                        <label class="main-content-label mb-3 pt-1">Current month</label>
                        <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span
                                class="font-weight-bold">₹{{ $currentMonthPlants }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="card-order ">
                        <label class="main-content-label mb-3 pt-1">Previous month</label>
                        <h2 class="text-right card-item-icon card-icon">
                            <i class="mdi mdi-flower icon-size float-left text-primary"></i><span
                                class="font-weight-bold">₹{{ $prevMonthPlants }}</span>
                        </h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="card-order">
                        <label class="main-content-label mb-3 pt-1">This Year</label>
                        <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span
                                class="font-weight-bold">₹{{ $currentYearPlants }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body" >
                        <label class="main-content-label mb-3 pt-1">Total Plants</label>
                        <h2 class="text-right all-type"><i class="mdi mdi-cube icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $plantsCount }}</span></h2>
                    <div class="mt-4">
                        @foreach ($plantsByType as $type => $plant)
                            <div class="row mb-1 text-muted plant-row" data-type="{{ $type }}">
                                <div class="col-8">
                                    <strong class="plant-type" data-type="{{ $type }}">{{ $type }}</strong>
                                    <input type="hidden" id="plant_type">
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

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <form method="POST" action="{{ route('plants-reports.generate-pdf') }}">
                        <div class="row">
                            @csrf
                            <div class="col-md-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="reportrange" id="reportrange" class="form-control"
                                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="form-group">
                                    <select class="form-control select2" name="nursery_id" id="nursery_id">
                                        <option value="" selected disabled>Select Nursery</option>
                                        @if (isset($nursery) && !empty($nursery))
                                            <option value="">All</option>
                                            @foreach ($nursery as $id => $name)
                                                <option value="{{ $name }}"
                                                    {{ old('nursery_id') == $name ? 'selected' : '' }}>{{ $name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <button type="submit" class="btn btn-success" id="download-pdf">Report Pdf</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive" id="plants-container">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <!-- Internal Apexchart js-->
    <script src="{{ URL::asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Internal Data Table js -->
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>

    @include('reports.JS.plant_js')


@endsection
