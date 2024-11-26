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
            <h5 class="card-title">الفئات <span>| الإجمالي</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-tags"></i>
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
            <h5 class="card-title">المنتجات <span>| الإجمالي</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-seam"></i>
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
            <h5 class="card-title">الفواتير <span>| الإجمالي</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $bills }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Revenue Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">الإيرادات <span>| الإجمالي</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ round($revenue) }}$</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Today Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">الإيرادات <span>| اليوم</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ round($revenueToday) }}$</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Average Bills Card -->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">الفواتير <span>| المتوسط</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ round($averageBillPrice) }}$</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart Section -->
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">الإيرادات <span>| آخر 7 أيام</span></h5>
            <div id="revenueChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const last7Days = @json(array_keys($last7DaysRevenue));
                    const dailyRevenue = @json(array_values($last7DaysRevenue));
                    
                    new ApexCharts(document.querySelector("#revenueChart"), {
                        series: [{
                            name: 'الإيرادات',
                            data: dailyRevenue,
                        }],
                        chart: {
                            height: 350,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                        },
                        markers: {
                            size: 4
                        },
                        colors: ['#0e123e'],
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            type: 'datetime',
                            categories: last7Days,
                        },
                        yaxis: {
                            labels: {
                                formatter: function (val) {
                                    return Math.round(val) + "$";
                                }
                            },
                            min: 0,
                            forceNiceScale: true
                        },
                        tooltip: {
                            x: {
                                format: 'dd/MM/yy'
                            },
                        }
                    }).render();
                });
            </script>
        </div>
    </div>
</div>

@endsection