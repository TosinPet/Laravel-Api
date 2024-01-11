@extends("layouts.overall")
@section("page_title", "Create Purchase")
@section("content")
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    @include('admin.includes.bodytop')
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
                                <a href="{{ route('admin.purchase.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="ki-duotone ki-add-folder"></i> View Purchases
                                </a>
                            </div>
                        </div>

                            <form class="form" action="{{ route('admin.purchase.create') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Customer Name <span class="text-danger"><b>*</b></span></label>
                                                <select id="customer_name" name="customer_name" class="form-control">
                                                    <option value="none" selected="" disabled="">Choose a Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->user_id }}" @if($customer->id == old('customer_name')) selected @endif>{{ $customer->full_name }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Phone Number <span class="text-danger"><b>*</b></span></label>
                                            <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ old('phone') }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label>Order Date <span class="text-danger"><b>*</b></span></label>
                                            <input type="date" class="form-control" name="order_date" placeholder="Order Date" value="{{ old('order_date') }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label>Order Number <span class="text-danger"><b>*</b></span></label>
                                            <input type="text" class="form-control" name="order_number" placeholder="Order Number" value="{{ old('order_number') }}">
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <label>Total Amount <span class="text-danger"><b>*</b></span></label>
                                            <input type="text" class="form-control" name="total_amount" placeholder="Total Amount" value="{{ old('total_amount') }}">
                                        </div>
                                    </div>
                                    <!-- begin: Example Code-->
                                    <!-- end: Example Code-->
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
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
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#customer_name').select2({
            placeholder: 'Search for a customer',
            allowClear: true, // Option to clear the selected value
        });
    });
</script>
@endpush