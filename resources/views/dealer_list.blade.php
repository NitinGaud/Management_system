@include('header')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Dealer List</h1></div>
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
                                <a href="{{ route('add_dealer') }}">
                                    <input type="button" class="btn btn-block btn-success" id="add_dealer" value="Add Dealer">
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
                                    <th>Dealer Name</th>
                                    <th>Shop Name</th>
                                    <th>Email Id</th>
                                    <th>Mobile No.</th>
                                    <th>Whatsapp Mobile No.</th>
                                    <th>Shop Address</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr = 1;
                                @endphp
                                @foreach($dealer_list as $row)
                                <tr>
                                    <td>{{ $sr }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->shop_name }}</td>
                                    <td>{{ $row->email_id }}</td>
                                    <td>{{ $row->mobile_no }}</td>
                                    <td>{{ $row->wa_mobile_no }}</td>
                                    <td>{{ $row->shop_address }}</td>
                                    <td>{{ $row->created_on }}</td>
                                    <td>
                                        <i class="fa-solid fa-pen-to-square edit_dealer" data-id="{{ $row->id }}" title="Edit Dealer Information"></i>|
                                        <i class="fa-solid fa-trash-can delete_dealer" data-id="{{ $row->id }}" title="Delete Dealer"></i>
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
<script>
    $(document).on('click', '.edit_dealer', function () {
        let dealer_id = $(this).data('id');
        $.ajax({
            url: "{{ route('set_dealer_session') }}",
            type: "POST",
            data: {
                dealer_id: dealer_id,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {

                if (response.status === 200) {
                    window.location.href = "{{ route('edit_dealer') }}";
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
    $(document).on('click', '.delete_dealer', function () {
        let dealer_id = $(this).data('id');
        $.ajax({
            url: "{{ route('delete_dealer') }}",
            type: "POST",
            data: {
                dealer_id: dealer_id,
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
@include('footer')