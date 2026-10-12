@include('header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Add Inventory</h1></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('inventory_insert') }}" method="POST" enctype="multipart/form-data" id="inventoryForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand">Brand <span class='text-danger'>*</span></label>
                                    <select name="brand" id="brand" class="form-control" required>
                                        <option value="">--Select Brand--</option>
                                        @foreach($brand_list as $row)
                                        <option value="{{ $row->value }}">{{ $row->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Category <span class='text-danger'>*</span></label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">--Select Category--</option>
                                        @foreach($category_list as $row)
                                        <option value="{{ $row->value }}">{{ $row->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="size">Size <span class='text-danger'>*</span></label>
                                    <select name="size" id="size" class="form-control" required>
                                        <option value="">--Select Size--</option>
                                        @foreach($size_list as $row)
                                        <option value="{{ $row->value }}">{{ $row->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name <span class='text-danger'>*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="batch_no">Batch No. <span class='text-danger'>*</span></label>
                                    <input type="text" class="form-control" name="batch_no" id="batch_no" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purch_date">Purchase Date <span class='text-danger'>*</span></label>
                                    <input type="date" class="form-control" name="purch_date" id="purch_date" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity">Purchased Quantity (In Pieces) <span class='text-danger'>*</span></label>
                                    <input type="text" class="form-control" name="quantity" id="quantity" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount">Purchase Amount</label>
                                    <input type="text" class="form-control" name="amount" id="amount" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purch_date">Upload image</label>
                                    <input type="file" name="img_file" id="img_file" accept="image/jpeg,image/png,image/jpg" class="form-control">
                                </div>
                                <img id="imagePreview" src="" alt="Image Preview" style="display:none; max-width:200px; max-height:200px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row btn_center">
                            <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-block btn-success" value="Submit">
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
    $('#quantity').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#amount').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
<script>
    $(document).ready(function () 
    {
        $('#img_file').on('change', function ()
        {
            const file = this.files[0];
            const $preview = $('#imagePreview');

            if (!file) {
                $preview.hide();
                return;
            }

            // Validate image type
            const allowedTypes = [
                'image/jpeg',
                'image/jpg',
                'image/png'
            ];

            if ($.inArray(file.type, allowedTypes) === -1)
            {
                alert('Please select a JPG, JPEG or PNG image.');
                $(this).val('');
                $preview.hide();
                return;
            }

            // Validate size - 2 MB
            if (file.size > 2 * 1024 * 1024)
            {
                alert('Image size must be less than 2 MB.');
                $(this).val('');
                $preview.hide();
                return;
            }
            const imageURL = URL.createObjectURL(file);
            $preview.attr('src', imageURL);
            $preview.show();
        });
    });
</script>
@include('footer')