@extends("layouts.overall")
@section("page_title", "Customers")
@section('module', 'Users')
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
                                <span class="card-label font-weight-bolder text-dark">List of @yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                <a href="#" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#addCustomer">
                                    <i class="la la-upload"></i> Import Customers
                                </a>
                                <a href="{{ asset('sample/customers/customers.csv') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3" download>
                                    <i class="la la-download"></i> Sample
                                </a>
                                <a href="{{ route('admin.customer.export') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="la la-download"></i> Export Customers List
                                </a>
                                <a href="{{ route('admin.customer.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="ki-duotone ki-add-folder"></i> Create Customer
                                </a>
                            </div>

                            

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table id="example" class="table table-separate table-head-custom table-checkable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Customer Reference</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td>
                                            {{ $customer->id }}
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $customer->full_name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $customer->address }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ "("."+".$customer->country_code.")"."".$customer->phone }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $customer->reference_no }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($customer->active == 1)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Active</span>
                                            @endif
                                            @if ($customer->active == 0)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Inactive</span>
                                            @endif

                                            {{-- @if ($customer->suspend == 1)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Suspended</span>
                                            @endif
                                            @if ($customer->suspend == 0)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Not Suspended</span>
                                            @endif --}}
                                        </td>
                                        <td>
                                            <button href="#" class="btn btn-icon btn-warning" data-toggle="modal" data-target="#edit-customer{{ $customer->id }}">
                                                <i class="flaticon-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $customer->render() }} --}}
                        </div>
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
<div class="modal fade" id="addCustomer" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Customers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-custom">

                    <!--begin::Form-->
                    <form action="{{ route('admin.customer.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="card-body">

                            <div class="form-group">
                                <label>Select CSV File <span class="text-danger">*</span></label>
                                <input type="file" name="csv_file" class="form-control" required="required">
                            </div>
                            <div class="form-group mb-1">
                                <button type="submit" class="btn btn-warning mr-2">Import</button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>


            </div>

        </div>
    </div>
</div>
@foreach($customers as $customer)
    <div class="modal fade" id="edit-customer{{ $customer->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">

                        <!--begin::Form-->
                        <form action="{{ route('admin.customer.edit', $customer->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input name="target" value="{{ $customer->id }}" type="hidden" readonly>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="full_name" value="{{ $customer->full_name }}" class="form-control" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address<span class="text-danger">*</span></label>
                                            <input type="text" name="address" value="{{ $customer->address }}" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Business Type<span class="text-danger">*</span></label>
                                            <select id="projectinput3" name="business_type" class="form-control">
                                                <option value="none" selected="" disabled="">Choose Business Type</option>
                                                <option value="Proprietorship" {{ $customer->business_type == "Proprietorship" ? 'selected' : '' }}>Proprietorship</option>
                                                <option value="Partnership" {{ $customer->business_type == "Partnership" ? 'selected' : '' }}>Partnership</option>
                                                <option value="LTD Company" {{ $customer->business_type == "LTD Company" ? 'selected' : '' }}>LTD Company</option>
                                                <option value="PLC" {{ $customer->business_type == "PLC" ? 'selected' : '' }}>PLC</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Customer Type <span class="text-danger">*</span></label>
                                            <select id="projectinput3" name="customer_type" class="form-control">
                                                <option value="none" selected="" disabled="">Choose Customer Type</option>
                                                <option value="Kirana" {{ $customer->customer_type == "Kirana" ? 'selected' : '' }}>Kirana</option>
                                                <option value="Uwargida" {{ $customer->customer_type == "Uwargida" ? 'selected' : '' }}>Uwargida</option>
                                                <option value="Others" {{ $customer->customer_type == "Others" ? 'selected' : '' }}>Others</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>State</label>
                                            <select onchange="toggleLGA(this);" name="state" id="state" class="form-control" required>
                                                <option value="" selected="selected">- Select -</option>
                                                <option value="Abia">Abia</option>
                                                <option value="Adamawa">Adamawa</option>
                                                <option value="AkwaIbom">AkwaIbom</option>
                                                <option value="Anambra">Anambra</option>
                                                <option value="Bauchi">Bauchi</option>
                                                <option value="Bayelsa">Bayelsa</option>
                                                <option value="Benue">Benue</option>
                                                <option value="Borno">Borno</option>
                                                <option value="Cross River">Cross River</option>
                                                <option value="Delta">Delta</option>
                                                <option value="Ebonyi">Ebonyi</option>
                                                <option value="Edo">Edo</option>
                                                <option value="Ekiti">Ekiti</option>
                                                <option value="Enugu">Enugu</option>
                                                <option value="FCT">FCT</option>
                                                <option value="Gombe">Gombe</option>
                                                <option value="Imo">Imo</option>
                                                <option value="Jigawa">Jigawa</option>
                                                <option value="Kaduna">Kaduna</option>
                                                <option value="Kano">Kano</option>
                                                <option value="Katsina">Katsina</option>
                                                <option value="Kebbi">Kebbi</option>
                                                <option value="Kogi">Kogi</option>
                                                <option value="Kwara">Kwara</option>
                                                <option value="Lagos">Lagos</option>
                                                <option value="Nasarawa">Nasarawa</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Ogun">Ogun</option>
                                                <option value="Ondo">Ondo</option>
                                                <option value="Osun">Osun</option>
                                                <option value="Oyo">Oyo</option>
                                                <option value="Plateau">Plateau</option>
                                                <option value="Rivers">Rivers</option>
                                                <option value="Sokoto">Sokoto</option>
                                                <option value="Taraba">Taraba</option>
                                                <option value="Yobe">Yobe</option>
                                                <option value="Zamfara">Zamafara</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>LGA</label>
                                            <select name="lga" id="lga" class="form-control select-lga" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-4">
                                        <div
                                            class="d-flex flex-stack mt-5">
                                            <!--begin::Switch-->
                                            <label
                                                class="form-check form-switch form-check-custom form-check-solid">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    value="1"
                                                    @if ($customer->active == 1) checked @endif
                                                    name="active" />
                                                <span
                                                    class="form-check-label fw-semibold text-muted">Active</span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="d-flex flex-stack mt-5">
                                            <!--begin::Switch-->
                                            <label
                                                class="form-check form-switch form-check-custom form-check-solid">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    value="1"
                                                    @if ($customer->suspend == 1) checked @endif
                                                    name="suspend" />
                                                <span
                                                    class="form-check-label fw-semibold text-muted">Suspend</span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-1">
                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>


                </div>

            </div>
        </div>
    </div>

@endforeach

@endsection