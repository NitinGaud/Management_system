@include('header')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Inventory Report</h1></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('generate_report') }}" method="POST" enctype="multipart/form-data" id="report_form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="from_date">From Date <span class='text-danger'>*</span></label>
                                    <input type="date" class="form-control" name="from_date" id="from_date" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="to_date">To Date <span class='text-danger'>*</span></label>
                                    <input type="date" class="form-control" name="to_date" id="to_date" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rep_type">Report Type <span class='text-danger'>*</span></label>
                                    <select name="rep_type" id="rep_type" class="form-control" required>
                                        <option value="">-- Select Report Type --</option>
                                        <option value="all">All</option>
                                        <option value="sold">Sold Report</option>
                                        <option value="damaged">Damaged Report</option>
                                        <option value="returned">Returned Report</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row btn_center">
                            <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                <div class="form-group">
                                    <input type="button" class="btn btn-block btn-success" id="report_sub" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).on('click', '#report_sub', function () {
        let from_date=$("#from_date").val();
        let to_date=$("#to_date").val();
        let rep_type=$("#rep_type").val();
        
        if (from_date === '' || to_date === '') {
            alert('Please enter both Dates.');
            return false;
        }
        let date1 = new Date(from_date);
        let date2 = new Date(to_date);

        let difference = Math.abs(date2 - date1);

        let days = difference / (1000 * 60 * 60 * 24);
        if(days > 30) {
            alert('Date difference should not be more than 30 days.');
            return false;
        }

        if(rep_type ==='') {
            alert("Please select Report type to be generated.");
            return false;
        }
        $('#report_form').submit();
    });
</script>
@include('footer')