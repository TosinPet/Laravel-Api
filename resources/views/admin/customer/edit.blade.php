@extends("layouts.overall")
@section("page_title", "Create Customer")
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
                                <span class="card-label font-weight-bolder text-dark">@yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                <a href="{{ route('admin.customer.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="ki-duotone ki-add-folder"></i> Manage Customers
                                </a>
                            </div>
                        </div>

                        <form class="form" action="{{ route('admin.customer.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" placeholder="Address" value="{{ old('address') }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Year of Business</label>
                                        <input type="date" class="form-control" name="year_of_business" placeholder="Year of Business" value="{{ old('year_of_business') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Business Type</label>
                                        <input type="text" class="form-control" name="business_type" placeholder="Business Type" value="{{ old('business_type') }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Business Name</label>
                                        <input type="text" class="form-control" name="business_name" placeholder="Business Name" value="{{ old('business_name') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Customer Type</label>
                                        <input type="text" class="form-control" name="customer_type" placeholder="" value="{{ old('customer_type') }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ old('phone') }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>State</label>
                                        <input type="text" class="form-control" name="state" placeholder="" value="{{ old('state') }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>LGA</label>
                                        <input type="text" class="form-control" name="lga" placeholder="" value="{{ old('lga') }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Guarantor Name</label>
                                        <input type="text" class="form-control" name="guarantor_name" placeholder="Guarantor Name" value="{{ old('guarantor_name') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Guarantor Address</label>
                                        <input type="text" class="form-control" name="guarantor_address" placeholder="Guarantor's Address" value="{{ old('guarantor_address') }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Guarantor's Phone Number</label>
                                        <input type="number" class="form-control" name="guarantor_phone" placeholder="Guarantor'S Phone Number" value="{{ old('guarantor_phone') }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Relationship with Applicant</label>
                                        <input type="text" class="form-control" name="relationship_with_applicant" placeholder="eg Brother" value="{{ old('relationship_with_applicant') }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Years of Relationship</label>
                                        <input type="text" class="form-control" name="years_of_relationship" placeholder="5 years/3 months" value="{{ old('years_of_relationship') }}" />
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="d-flex flex-stack mt-5">
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" checked
                                                name="active" />
                                            <span class="form-check-label fw-semibold text-muted">Active</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-stack mt-5">
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="suspend" />
                                            <span class="form-check-label fw-semibold text-muted">Suspend</span>
                                        </label>
                                        <!--end::Switch-->
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

@endsection