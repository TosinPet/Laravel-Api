@extends("layouts.overall")
@section("page_title", "Edit Brand")
@section('module', 'CMS')
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
                                <a href="{{ route('admin.brand.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="ki-duotone ki-add-folder"></i> Manage Brands
                                </a>
                            </div>
                        </div>

                        <form class="form" action="{{ route('admin.brand.edit', $brand->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <input name="target" value="{{ $brand->id }}" type="hidden" readonly>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Brand Name" value="{{ $brand->name }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Description</label>
                                        <textarea rows="3" class="form-control" name="description" placeholder="Brand Description">{!! $brand->description !!}</textarea>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Brand Image</label>
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
                                                <input class="form-check-input" type="checkbox" value="1" @if($brand->status == 1) checked @endif name="status" />
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