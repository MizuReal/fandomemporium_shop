 @extends('admin.layouts.app')
 @section('style')
 <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
 <style>
   .content-wrapper {
     margin-left: 150px !important;
   }
 </style>
 @endsection 
 
 
@section('content')
 
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard for FandomEmporium</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Yearly Sales Comparison</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">₱{{ number_format(array_sum($yearlySales['data']), 2) }}</span>
                    <span>Total Sales</span>
                  </p>
                  @php
                    $yearlyDiff = ($yearlySales['data'][1] - $yearlySales['data'][0]);
                    $yearlyPercent = $yearlySales['data'][0] ? round(($yearlyDiff / $yearlySales['data'][0]) * 100, 1) : 0;
                  @endphp
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="{{ $yearlyPercent >= 0 ? 'text-success' : 'text-danger' }}">
                      <i class="fas fa-arrow-{{ $yearlyPercent >= 0 ? 'up' : 'down' }}"></i> {{ abs($yearlyPercent) }}%
                    </span>
                    <span class="text-muted">Compared to previous year</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="yearly-sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Current Year
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Previous Year
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Monthly Sales (Current Year)</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="monthly-sales-chart" height="250"></canvas>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h3 class="card-title">Sales by Date Range</h3>
                  <div class="card-tools">
                    <div id="date-range-picker" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                      <i class="fa fa-calendar"></i>&nbsp;
                      <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="date-range-sales-chart" height="250"></canvas>
                </div>
                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-success"></i> Daily Sales
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Product Sales Distribution</h3>
                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="product-sales-chart" height="250"></canvas>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th>Sales Amount</th>
                        <th>Percentage</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($productSalesPercentage as $product)
                      <tr>
                        <td>{{ $product['name'] }}</td>
                        <td>₱{{ number_format($product['sales'], 2) }}</td>
                        <td>
                          <div class="progress progress-xs">
                            <div class="progress-bar bg-primary" style="width: {{ $product['value'] }}%"></div>
                          </div>
                          <span class="text-bold">{{ $product['value'] }}%</span>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection

  @section('script')
<!-- ChartJS -->
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- DateRangePicker -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script>
$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  // Yearly Sales Chart
  var yearlySalesCanvas = document.getElementById('yearly-sales-chart').getContext('2d')
  
  var yearlySalesData = {
    labels: {!! json_encode($yearlySales['years']) !!},
    datasets: [
      {
        backgroundColor: '#007bff',
        borderColor: '#007bff',
        data: {!! json_encode($yearlySales['data']) !!}
      }
    ]
  }
  
  new Chart(yearlySalesCanvas, {
    type: 'bar',
    data: yearlySalesData,
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect,
        callbacks: {
          label: function(tooltipItem, data) {
            return '₱' + Number(tooltipItem.yLabel).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
          }
        }
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return '₱' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

  // Monthly Sales Chart
  var monthlySalesCanvas = document.getElementById('monthly-sales-chart').getContext('2d')
  
  var monthlySalesData = {
    labels: {!! json_encode($monthlySales['months']) !!},
    datasets: [
      {
        backgroundColor: 'rgba(60,141,188,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        pointRadius: 3,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data: {!! json_encode($monthlySales['data']) !!}
      }
    ]
  }
  
  new Chart(monthlySalesCanvas, {
    type: 'line',
    data: monthlySalesData,
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect,
        callbacks: {
          label: function(tooltipItem, data) {
            return '₱' + Number(tooltipItem.yLabel).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
          }
        }
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return '₱' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

  // Date Range Picker
  var start = moment().subtract(29, 'days');
  var end = moment();

  function cb(start, end) {
    $('#date-range-picker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    loadDateRangeSales(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
  }

  $('#date-range-picker').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
  }, cb);

  cb(start, end);

  // Initialize date range sales chart
  var dateRangeSalesChart = new Chart(document.getElementById('date-range-sales-chart').getContext('2d'), {
    type: 'bar',
    data: {
      labels: [],
      datasets: [{
        label: 'Sales',
        backgroundColor: '#28a745',
        borderColor: '#28a745',
        data: []
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect,
        callbacks: {
          label: function(tooltipItem, data) {
            return '₱' + Number(tooltipItem.yLabel).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
          }
        }
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return '₱' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  });

  // Function to load date range sales data
  function loadDateRangeSales(startDate, endDate) {
    $.ajax({
      url: "{{ route('admin.dashboard.salesByDate') }}",
      type: "POST",
      data: {
        start_date: startDate,
        end_date: endDate,
        _token: "{{ csrf_token() }}"
      },
      success: function(response) {
        // Update chart data
        dateRangeSalesChart.data.labels = response.dates;
        dateRangeSalesChart.data.datasets[0].data = response.data;
        dateRangeSalesChart.update();
      },
      error: function(error) {
        console.log("Error loading date range sales data:", error);
      }
    });
  }

  // Product Sales Distribution Chart (Pie Chart)
  var productData = @json($productSalesPercentage);
  var productLabels = productData.map(function(item) { return item.name; });
  var productValues = productData.map(function(item) { return item.value; });
  
  var backgroundColors = [
    '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#6f42c1', '#e83e8c', '#20c997', '#fd7e14'
  ];
  
  new Chart(document.getElementById('product-sales-chart').getContext('2d'), {
    type: 'pie',
    data: {
      labels: productLabels,
      datasets: [
        {
          data: productValues,
          backgroundColor: backgroundColors.slice(0, productLabels.length)
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            var dataset = data.datasets[tooltipItem.datasetIndex];
            var label = data.labels[tooltipItem.index];
            var value = dataset.data[tooltipItem.index];
            return label + ': ' + value + '%';
          }
        }
      }
    }
  });
});
</script>
@endsection 