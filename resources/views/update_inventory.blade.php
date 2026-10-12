@include('header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Update Inventory</h1></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('update_inventory_data') }}" method="POST" enctype="multipart/form-data" id="inventoryForm">
                    @csrf
                    <input type="hidden" name="inventory_id" class="form-control" id="inventory_id" value="{{$inventory->id}}">
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sold">Sold</label>
                                    <input type="text" class="form-control" name="sold" id="sold" value="" inputmode="numeric" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sold_date">Sold Date</label>
                                    <input type="date" class="form-control" name="sold_date" id="sold_date" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sold_amount">Sold Amount</label>
                                    <input type="text" class="form-control" name="sold_amount" id="sold_amount" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="returned">Returned</label>
                                    <input type="text" class="form-control" name="returned" id="returned" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="return_date">Returned Date</label>
                                    <input type="date" class="form-control" name="return_date" id="return_date" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="return_amount">Returned Amount</label>
                                    <input type="text" class="form-control" name="return_amount" id="return_amount" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="damaged">Damaged</label>
                                    <input type="text" class="form-control" name="damaged" id="damaged" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="damaged_date">Damaged Date</label>
                                    <input type="date" class="form-control" name="damaged_date" id="damaged_date" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row btn_center">
                            <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                <div class="form-group">
                                    <input type="button" class="btn btn-block btn-success" id="sub_inventory"  value="Submit">
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
    $('#sold').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#sold_amount').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#returned').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#return_amount').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#damaged').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
<script>
    $(document).on('click', '#sub_inventory', function () {
        let sold = parseInt($('#sold').val()) || 0;
        let sold_date=$('#sold_date').val();
        let sold_amount = parseInt($('#sold_amount').val()) || 0;

        let returned=parseInt($('#returned').val()) || 0;
        let return_date=$('#return_date').val();
        let return_amount=parseInt($('#return_amount').val()) || 0;

        let damaged=parseInt($('#damaged').val()) || 0;
        let damaged_date=$('#damaged_date').val();

        if(sold > 0) {
            if(sold_date ==='') {
                alert("Sold Date should not be blank.");
                return false;
            } else if(sold_amount < 1){
                alert("Sold Amount should be more than 0.");
                return false;
            }
        }
        
        if(returned > 0) {
            if(return_date ==='') {
                alert("Return Date should not be blank.");
                return false;
            } else if(return_amount < 1){
                alert("Return Amount should be more than 0.");
                return false;
            }
        }

        if(damaged > 0) {
            if(damaged_date ==='')
            {
                alert("Damaged Date should not be blank.");
                return false;
            }
        }
        $('#inventoryForm').submit();
    });
</script>
@include('footer')