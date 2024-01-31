@extends("layouts.overall")
@section("page_title", "Create Promotion")
@section('module', 'CMS')
@section("content")

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    {{-- @include('admin.includes.bodytop') --}}
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">@yield('page_title')</h5>
                <!--end::Page Title-->
                <!--begin::Actions-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">@yield('module')</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a>
                    </li>

                </ul>
            </div>
            <a href="{{ route('admin.promotion.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="ki-duotone ki-add-folder"></i> View all Promotions
            </a>
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row">

                <div class="col-xxl-12 col-md-12 order-2 order-xxl-1">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">@yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                
                            </div>
                        </div>

                        <form class="form" action="{{ route('admin.promotion.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Name <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Promotion Name" value="{{ old('name') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Description </label>
                                        <textarea rows="2" class="form-control" name="description" placeholder="Promotion Description">{!! old('description') !!}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Promotion Image <span class="text-danger"><b>*</b></span> <span class="font-weight-bolder">(375px x 159px)</span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="promotion_image" accept="image/png,image/gif,image/jpeg,image/jpg" value="{{ old('banner_image') }}">
                                            <div class="input-group-append">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Select Brands and Discount Percentage:</label>
                                    <table class="table table-bordered" id="promotionTable">
                                        <thead>
                                            <tr>
                                                <th>Brand</th>
                                                <th>Discount Percentage</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="brands[0][brand_id]" class="form-control" required>
                                                        <option value="" selected disabled>Select a Brand</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ $brand->id }}">{{ ($brand->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="brands[0][discount_percentage]" class="form-control" min="1" value="1" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success" onclick="addRow()">Add Row</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                    <div class="col-md-6 mt-4">
                                        <div class="d-flex flex-stack">
           
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" checked="checked" name="status" />
                                                <span class="form-check-label fw-semibold text-muted">Active</span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>

                                        <div class="d-flex flex-stack md-6 mt-4">
           
                                            <!--begin::Switch-->
                                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                                            <a href="{{ route('admin.promotion.index') }}" class="btn btn-secondary">Cancel</a>
                                            <!--end::Switch-->
                                        </div>
                                    </div>
                                <!-- begin: Example Code-->
                                <!-- end: Example Code-->
                            </div>
                            
                        </form>

                         <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 2-->
                </div>
            </div>
            <!--end::Row-->
            <!--end::Dashboard-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>

@endsection
@push('js')
{{-- <script>
    // Function to add a new row to the table
    function addRow() {
        var table = document.getElementById("promotionTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);

        // Cell for SKU dropdown
        var skuCell = newRow.insertCell(0);
        var skuSelect = document.createElement("select");
        skuSelect.name = "brands[" + table.rows.length + "][brand_id]";
        skuSelect.className = "form-control";
        var defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.text = "Select a Brand";
        skuSelect.appendChild(defaultOption);
        @foreach($brands as $brand)
            var option = document.createElement("option");
            option.value = "{{ $brand->id }}";
            option.text = "{{ $brand->name }}";
            skuSelect.appendChild(option);
        @endforeach
        skuCell.appendChild(skuSelect);

        // Cell for quantity input
        var quantityCell = newRow.insertCell(1);
        var quantityInput = document.createElement("input");
        quantityInput.type = "number";
        quantityInput.name = "discount[" + table.rows.length + "][percentage]";
        quantityInput.className = "form-control";
        quantityInput.min = "1";
        quantityInput.value = "1";
        quantityCell.appendChild(quantityInput);

        // Cell for delete button
        var deleteCell = newRow.insertCell(2);
        var deleteButton = document.createElement("button");
        deleteButton.type = "button";
        deleteButton.className = "btn btn-danger";
        deleteButton.textContent = "Remove";
        deleteButton.onclick = function() {
            removeRow(newRow);
        };
        deleteCell.appendChild(deleteButton);

        // Store the index as a data attribute
        newRow.setAttribute('data-index', table.rows.length - 1);
    }

    // Function to remove a row from the table
    function removeRow(row) {
        var table = document.getElementById("promotionTable").getElementsByTagName('tbody')[0];
        table.deleteRow(row.rowIndex);

        // Update data attributes for remaining rows
        for (var i = row.rowIndex; i < table.rows.length; i++) {
            var currentRow = table.rows[i];
            currentRow.setAttribute('data-index', i - 1);
        }
    }
</script> --}}

<script>
    // Function to add a new row to the table
    function addRow() {
        var table = document.getElementById("promotionTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);

        // Cell for brand dropdown
        var brandCell = newRow.insertCell(0);
        var brandSelect = document.createElement("select");
        brandSelect.name = "brands[" + table.rows.length + "][brand_id]";
        brandSelect.className = "form-control";
        var defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.text = "Select a Brand";
        brandSelect.appendChild(defaultOption);
        @foreach($brands as $brand)
            var option = document.createElement("option");
            option.value = "{{ $brand->id }}";
            option.text = "{{ $brand->name }}";
            brandSelect.appendChild(option);
        @endforeach
        brandCell.appendChild(brandSelect);

        // Cell for discount percentage input
        var discountCell = newRow.insertCell(1);
        var discountInput = document.createElement("input");
        discountInput.type = "number";
        discountInput.name = "brands[" + table.rows.length + "][discount_percentage]";
        discountInput.className = "form-control";
        discountInput.min = "1";
        discountInput.value = "1";
        discountCell.appendChild(discountInput);

        // Cell for remove button
        var removeCell = newRow.insertCell(2);
        var removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.className = "btn btn-danger";
        removeButton.textContent = "Remove";
        removeButton.onclick = function() {
            table.deleteRow(newRow.rowIndex);
        };
        removeCell.appendChild(removeButton);
    }
</script>


@endpush
