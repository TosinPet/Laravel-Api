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
                                        <label>Full Name <span class="text-danger"><b>*</b></span> </label>
                                        <input type="text" class="form-control" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Address <span class="text-danger"><b>*</b></span> </label>
                                        <input type="text" class="form-control" name="address" placeholder="Address" value="{{ old('address') }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Year of Business <span class="text-danger"><b>*</b></span> </label>
                                        <input type="date" class="form-control" name="year_of_business" placeholder="Year of Business" value="{{ old('year_of_business') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Business Type <span class="text-danger"><b>*</b></span> </label>
                                        <select id="projectinput3" name="business_type" class="form-control">
                                            <option value="none" selected="" disabled="">Choose Business Type</option>
                                            <option value="Proprietorship">Proprietorship</option>
                                            <option value="Partnership">Partnership</option>
                                            <option value="LTD Company">LTD Company</option>
                                            <option value="PLC">PLC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Business Name <span class="text-danger"><b>*</b></span> </label>
                                        <input type="text" class="form-control" name="business_name" placeholder="Business Name" value="{{ old('business_name') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Customer Type <span class="text-danger"><b>*</b></span> </label>
                                        <select id="projectinput3" name="customer_type" class="form-control">
                                            <option value="none" selected="" disabled="">Choose Business Type</option>
                                            <option value="Kirana">Kirana</option>
                                            <option value="Uwargida">Uwargida</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Phone Number <span class="text-danger"><b>*</b></span> </label>
                                        <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ old('phone') }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>State <span class="text-danger"><b>*</b></span> </label>
                                        <select onchange="toggleLGA(this);" name="state" id="state" class="form-control">
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
                                    <div class="col-lg-4">
                                        <label>LGA <span class="text-danger"><b>*</b></span> </label>
                                        <select name="lga" id="lga" class="form-control select-lga" required>
                                        </select>
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