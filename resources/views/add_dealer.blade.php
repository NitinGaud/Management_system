@include('header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Add Dealer</h1></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('insert_dealer_data') }}" method="POST" enctype="multipart/form-data" id="dealer_form">
                    @csrf
                    <input type="hidden" name="dealer_id" id="dealer_id" class="form-control" value="{{ $dealer_detail->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Dealer Name <span class='text-danger'>*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $dealer_detail->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_name">Shop Name <span class='text-danger'>*</span></label>
                                    <input type="text" class="form-control" name="shop_name" id="shop_name" value="{{ $dealer_detail->shop_name }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email_id">Email id</label>
                                    <input type="email" class="form-control" name="email_id" id="email_id" value="{{ $dealer_detail->email_id }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile_no">Mobile no. <span class='text-danger'>*</span></label>
                                    <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="{{ $dealer_detail->mobile_no }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wa_mobile_no">Whatsapp Mobile no.</label>
                                    <input type="text" class="form-control" name="wa_mobile_no" id="wa_mobile_no" value="{{ $dealer_detail->wa_mobile_no }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_address">Shop Address</label>
                                    <textarea name="shop_address" id="shop_address" class="form-control">{{ $dealer_detail->shop_address }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row btn_center">
                            <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                <div class="form-group">
                                    <input type="button" class="btn btn-block btn-success" id="dealer_sub" value="Submit">
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
    $('#mobile_no').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });
    $('#wa_mobile_no').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });
</script>
<script>
    $(document).on('click', '#dealer_sub', function () {
        let name=$("#name").val();
        let shop_name=$("#shop_name").val();
        let email_id=$("#email_id").val();
        let mobile_no=$("#mobile_no").val();
        let wa_mobile_no=$("#wa_mobile_no").val();

        if(name =='') {
            alert("Please enter Dealer Name.");
            $("#name").focus();
            return false;
        }

        if(shop_name =='') {
            alert("Please enter Shop name.");
            $("#shop_name").focus();
            return false;
        }

        if(email_id !=='') {
            let email_pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email_pattern.test(email_id)) {
                alert("Please enter a valid email address.");
                $("#email_id").focus();
                return false;
            }
        }

        if(mobile_no.length !== 10) {
            alert("Mobile no. should be 10 digits long.");
            $("#mobile_no").focus();
            return false;
        }

        if(wa_mobile_no !== '' && wa_mobile_no.length !== 10) {
            alert("Whatsapp Mobile no. should be 10 digits long.");
            $("#wa_mobile_no").focus();
            return false;
        }

        $('#dealer_form').submit();
    });
</script>
@include('footer')