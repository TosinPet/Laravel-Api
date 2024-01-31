@extends("layouts.overall")
@section("page_title", "Raise Order")
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
            <a href="{{ route('admin.order.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="ki-duotone ki-add-folder"></i> View all Orders
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
                        <div class="container">

                            <form method="post" action="{{ route('admin.order.create') }}" enctype="multipart/form-data">
                                @csrf
                    
                                <div class="form-group">
                                    <label for="customer_id">Select Customer:</label>
                                    <select name="customer_id" id="customer_id" class="form-control" required>
                                        <option value="" selected disabled>Select a Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->user_id }}">{{ $customer->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                    
                                <div class="form-group">
                                    <label>Select SKUs and Quantities:</label>
                                    <table class="table table-bordered" id="skuTable">
                                        <thead>
                                            <tr>
                                                <th>SKU</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="skus[0][sku_id]" class="form-control" required>
                                                        <option value="" selected disabled>Select a SKU</option>
                                                        @foreach($skus as $sku)
                                                            <option value="{{ $sku->id }}">{{ ($sku->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="skus[0][quantity]" class="form-control" min="1" value="1" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success" onclick="addRow()">Add Row</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-5">
                                        <label>Order Date <span class="text-danger"><b>*</b></span></label>
                                        <input type="date" class="form-control" name="order_date" placeholder="Order Date" value="{{ old('order_date') }}" required>
                                    </div>
                                    
                                    <div class="col-lg-7">
                                        <label>Shipping Address <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="shipping_address" placeholder="Shipping Address" value="{{ old('shipping_address') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-4">
                                    <div class="d-flex flex-stack md-6 mt-4">
                                        <button type="submit" class="btn btn-primary mr-2">Create Order</button>
                                        <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">Cancel</a> 
                                    </div>
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
<!--end::Content-->
<!--begin::Footer-->
<!--end::Main-->
@endsection
@push('js')
{{-- <script>
    $(document).ready(function() {
        // Initialize Select2
        $('#customer_name').select2({
            placeholder: 'Search for a customer',
            allowClear: true, // Option to clear the selected value
        });

        $('#product_name').select2({
            placeholder: 'Search for a product',
            allowClear: true, // Option to clear the selected value
        });
    });
</script> --}}
<script>
    // Function to add a new row to the table
    function addRow() {
        var table = document.getElementById("skuTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);

        // Cell for SKU dropdown
        var skuCell = newRow.insertCell(0);
        var skuSelect = document.createElement("select");
        skuSelect.name = "skus[" + table.rows.length + "][sku_id]";
        skuSelect.className = "form-control";
        var defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.text = "Select a SKU";
        skuSelect.appendChild(defaultOption);
        @foreach($skus as $sku)
            var option = document.createElement("option");
            option.value = "{{ $sku->id }}";
            option.text = "{{ $sku->name }}";
            skuSelect.appendChild(option);
        @endforeach
        skuCell.appendChild(skuSelect);

        // Cell for quantity input
        var quantityCell = newRow.insertCell(1);
        var quantityInput = document.createElement("input");
        quantityInput.type = "number";
        quantityInput.name = "skus[" + table.rows.length + "][quantity]";
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
        var table = document.getElementById("skuTable").getElementsByTagName('tbody')[0];
        table.deleteRow(row.rowIndex);

        // Update data attributes for remaining rows
        for (var i = row.rowIndex; i < table.rows.length; i++) {
            var currentRow = table.rows[i];
            currentRow.setAttribute('data-index', i - 1);
        }
    }
</script>

@endpush