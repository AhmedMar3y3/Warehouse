@extends('layout')
@section('main')
<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<div class="container dashboard">
    <div class="row">
   <!-- New Users Today Card -->
   <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">Category <span>| Total</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-plus"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $categories }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Doctors Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">Products <span>| Total</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $products }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Total Bills Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">Bills <span>| Total</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-prescription"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $bills }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Total Bills Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">Revenue <span>| Total</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-prescription"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $revenue }}$</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Total Bills Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">Revenue <span>| Today</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-prescription"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $revenueToday }}$</h6>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection