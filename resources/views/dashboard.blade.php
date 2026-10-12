@include('header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Dashboard</h1></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <div class="card">
                    <div class="card-body">
                      <div class="card-body">
                        <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script>
  $(function () {
    var labels = @json($sold_by_brand->pluck('brand')->values());
    var soldData = @json($sold_by_brand->pluck('total_sold')->values());
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieData = { 
      labels: labels, 
      datasets: [ 
        { 
          data: soldData, 
          backgroundColor: 
          [
            '#f56954', 
            '#00a65a', 
            '#f39c12', 
            '#00c0ef', 
            '#3c8dbc', 
            '#d2d6de' 
          ] 
        } 
      ] 
    };
    var pieOptions = { 
      maintainAspectRatio: false, 
      responsive: true 
    };
    new Chart(pieChartCanvas, { 
      type: 'pie', 
      data: pieData, 
      options: pieOptions 
    });
  });
</script>
@include('footer')