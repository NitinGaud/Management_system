@include('header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Inventory List</h1></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                            <div class="form-group">
                                <a href="{{ route('add_inventory') }}">
                                    <input type="button" class="btn btn-block btn-success" id="add_inventory" value="Add Inventory">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Srno.</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Size</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Batch no.</th>
                                    <th>Amount</th>
                                    <th>Purchase Date</th>
                                    <th></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr = 1;
                                @endphp
                                @foreach($inventory_list as $row)
                                <tr>
                                    <td>{{ $sr }}</td>
                                    <td>{{ $row->brand }}</td>
                                    <td>{{ $row->category }}</td>
                                    <td>{{ $row->size }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->quantity }}</td>
                                    <td>{{ $row->batch_no }}</td>
                                    <td>{{ $row->amount }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->purch_date)->format('d/m/Y') }}</td>
                                    <td><input type="button" class="btn btn-sm btn-block btn-primary" data-id="{{ $row->id }}" value="Check Log" id="log_button"></td>
                                    <td>
                                        <i class="fa-solid fa-pen-to-square update_inventory" data-id="{{ $row->id }}" title="Update Inventory"></i>|
                                        <i class="fa-solid fa-trash-can delete_inventory" data-id="{{ $row->id }}" title="Delete Inventory"></i>
                                    </td>
                                </tr>
                                @php
                                    $sr++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
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
<script>
    $(document).on('click', '.update_inventory', function () {
        let inventory_id = $(this).data('id');
        $.ajax({
            url: "{{ route('set_inventory_session') }}",
            type: "POST",
            data: {
                inventory_id: inventory_id,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {

                if (response.status === 200) {
                    window.location.href = "{{ route('update_inventory') }}";
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Something went wrong. Please try again.');
            }
        });

    });
</script>
<script>
    $(document).on('click', '.delete_inventory', function () {
        let inventory_id = $(this).data('id');
        $.ajax({
            url: "{{ route('delete_inventory') }}",
            type: "POST",
            data: {
                inventory_id: inventory_id,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                alert(response.message);
                if (response.status === 200) {
                    location.reload();
                }
            },
            error: function () {
                alert('Something went wrong. Please try again.');
            }
        });

    });
</script>
<script>
    $(document).on('click', '#log_button', function () {
        let inventory_id = $(this).data('id');
        $.ajax({
            url: "{{ route('set_inventory_session') }}",
            type: "POST",
            data: {
                inventory_id: inventory_id,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {

                if (response.status === 200) {
                    window.location.href = "{{ route('log_list') }}";
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Something went wrong. Please try again.');
            }
        });

    });
</script>
@include('footer')