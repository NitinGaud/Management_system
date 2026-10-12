@include('header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Inventory Log List</h1></div>
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
                                <a href="{{ route('inventory_list') }}">
                                    <input type="button" class="btn btn-block btn-primary" value="Back to List">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $inventory->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="purch_date">Purchase Date</label>
                                <input type="text" class="form-control" name="purch_date" id="purch_date" value="{{ \Carbon\Carbon::parse($inventory->purch_date)->format('d/m/Y') }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="batch_no">Batch No.</label>
                                <input type="text" class="form-control" name="batch_no" id="batch_no" value="{{ $inventory->batch_no }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="act_quantity">Actual Quantity</label>
                                <input type="text" class="form-control" name="act_quantity" id="act_quantity" value="{{ $inventory->quantity }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rem_quantity">Remaining Quantity</label>
                                <input type="text" class="form-control" name="rem_quantity" id="rem_quantity" value="{{ $quantity->remaining_quantity }}" disabled>
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
                                    <th>Sold</th>
                                    <th>Sold Date</th>
                                    <th>Sold Amount</th>
                                    <th>Returned</th>
                                    <th>Returned Date</th>
                                    <th>Returned Amount</th>
                                    <th>Damaged</th>
                                    <th>Damaged Date</th>
                                    <th>Created on</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr = 1;
                                @endphp
                                @foreach($inventory_log as $row)
                                    <tr>
                                        <td>{{ $sr }}</td>
                                        <td>{{ $row->sold ?? '' }}</td>
                                        <td>
                                            {{
                                                !empty($row->sold_date)
                                                ? \Carbon\Carbon::parse($row->sold_date)->format('d/m/Y') :'' 
                                            }}
                                        </td>
                                        <td>{{ $row->sold_amount ?? '' }}</td>
                                        <td>{{ $row->returned ?? '' }}</td>
                                        <td>
                                            {{
                                                !empty($row->returned_date)
                                                ? \Carbon\Carbon::parse($row->returned_date)->format('d/m/Y') :'' 
                                            }}
                                        </td>
                                        <td>{{ $row->returned_amount ?? '' }}</td>
                                        <td>{{ $row->damaged ?? '' }}</td>
                                        <td>
                                            {{
                                                !empty($row->damaged_date)
                                                ? \Carbon\Carbon::parse($row->damaged_date)->format('d/m/Y') :'' 
                                            }}
                                        </td>
                                        <td>{{ $row->created_on ?? '' }}</td>
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
@include('footer')