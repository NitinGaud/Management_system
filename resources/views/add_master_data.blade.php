@include('header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Master Data</h1></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="#" method="POST" id="masterform">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mast_type">Type <span class='text-danger'>*</span></label>
                                    <select name="mast_type" id="mast_type" class="form-control">
                                        <option value="">--Select Type--</option>
                                        <option value="Brand">Brand</option>
                                        <option value="Category">Category</option>
                                        <option value="Size">Size</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mast_val">Value <span class='text-danger'>*</span></label>
                                    <input type="text" class="form-control" name="mast_val" id="mast_val" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row btn_center">
                            <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                <div class="form-group">
                                    <input type="button" class="btn btn-block btn-success" id="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                        <hr style='border-top: 1px solid white'>
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Srno.</th>
                                        <th>Type</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sr = 1;
                                    @endphp
                                    @foreach($master_list as $row)
                                    <tr>
                                        <td>{{ $sr }}</td>
                                        <td>{{ $row->type }}</td>
                                        <td>{{ $row->value }}</td>
                                    </tr>
                                    @php
                                        $sr++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('#submit').on('click', function () {
            let mast_type = $('#mast_type').val();
            let mast_value = $('#mast_val').val();
            if(mast_type =='')
            {
                alert("Please select type.");
                return false;
            }
            if(mast_value =='')
            {
                alert("Please select value.");
                return false;
            }
            $.ajax({
                url: "{{ route('master_insert') }}",
                type: "POST",
                data: $('#masterform').serialize(),
                beforeSend: function () {
                    $('#submit').prop('disabled', true);
                    $('#submit').text('Saving...');
                },
                success: function (response) {
                    alert(response.message);
                    if(response.status===200)
                    {
                        location.reload();
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, messages) {
                            alert(messages[0]);
                        });
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                },
                complete: function () {
                    $('#submit').prop('disabled', false);
                    $('#submit').text('Submit');
                }
            });
        });
    });
</script>

<script src="{{ asset('js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/datatable/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/datatable/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/datatable/buttons.colVis.min.js') }}"></script>
<script>
    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');;
    });
</script>
@include('footer')