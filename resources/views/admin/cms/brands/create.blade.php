@extends("layouts.overall")
@section("page_title", "Create Brand")
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
            <a href="{{ route('admin.brand.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="ki-duotone ki-add-folder"></i> View all Brands
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

                        <form class="form" action="{{ route('admin.brand.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Name <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Brand Name" value="{{ old('name') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Description</label>
                                        <textarea rows="2" class="form-control" name="description" placeholder="Brand Description">{!! old('description') !!}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Brand Image <span class="text-danger"><b>*</b></span></span> <span class="font-weight-bolder">(94px x 53px)</span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="brand_image" accept="image/png,image/gif,image/jpeg,image/jpg" value="{{ old('brand_image') }}">
                                            <div class="input-group-append">
                                                {{-- <span class="input-group-text"> --}}
                                                    {{-- <i class="la la-map-marker"></i> --}}
                                                {{-- </span> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-5">
                                        <div class="d-flex flex-stack">
           
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" checked="checked" name="status" />
                                                <span class="form-check-label fw-semibold text-muted">Active</span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>
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