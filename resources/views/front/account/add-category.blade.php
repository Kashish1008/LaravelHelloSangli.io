@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')

                <div class="card border-0 shadow mb-4 ">
                    <div class="position-relative">
                        <button class="btn btn-primary position-absolute top-0 end-0 m-3" onclick="catg_list()">LIST</button>
                    </div>
                    <form action="" method="get" id="addcategories" name="addcategories">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Categories</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Add Category<span class="req">*</span></label>
                                    <input type="text" placeholder="Category Name" id="category" name="category"
                                        class="form-control">
                                    <p></p>&nbsp;&nbsp;&nbsp;
                                    <label for="status" class="mb-2">Active<span class="req">*</span></label>
                                    <input type="checkbox" id="status" name="status" class="form-check-input">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <button type="submit" class="btn btn-primary">ADD</button>
                        </div>
                    </form>
                    @include('front.account.category-list')
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@section('customJs')




<script>
    $("#addcategories").submit(function(e) {
        let formData = $("#addcategories").serializeArray();

        // Add checkbox value manually
        const statusCheckbox = $("#status").is(':checked') ? '1' : '0';
        formData.push({
            name: 'status',
            value: statusCheckbox
        });

        $.ajax({
            url: '{{ route("account.saveCategory") }}',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(response) {


            }

        });
    });
</script>

@endsection