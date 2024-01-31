@extends("layouts.overall")
@section("page_title", "Create SKUs")
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
            <a href="{{ route('admin.sku.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="ki-duotone ki-add-folder"></i> View all SKUs
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

                        <form class="form" action="{{ route('admin.sku.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Name <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="name" placeholder="SKUs Name" value="{{ old('name') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Description</label>
                                        <textarea rows="2" class="form-control" name="description" placeholder="SKUs Description">{!! old('description') !!}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Category <span class="text-danger"><b>*</b></span></label>
                                        <select id="category" name="category" class="form-control">
                                            <option value="none" selected="" disabled="">Choose a Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if($category->id == old('category')) selected @endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Brands <span class="text-danger"><b>*</b></span></label>
                                        <select id="brand" name="brand" class="form-control">
                                            <option value="none" selected="" disabled="">Choose a Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" @if($brand->id == old('brand')) selected @endif>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Product Image <span class="text-danger"><b>*</b></span></span> <span class="font-weight-bolder">(95px x 120px)</span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="image" accept="image/png,image/gif,image/jpeg,image/jpg" value="{{ old('brand_image') }}">
                                            <div class="input-group-append">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Size</label>
                                        <input type="text" class="form-control" name="size" placeholder="Size" value="{{ old('size') }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Cases <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="cases" placeholder="Cases" value="{{ old('cases') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Reference Number <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="reference_number" placeholder="Reference Number" value="{{ old('reference_number') }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Units per Case <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="units_per_case" placeholder="Units per Case" value="{{ old('units_per_case') }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Price <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="price" placeholder="Price" value="{{ old('price') }}" />
                                    </div>
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
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <a href="{{ route('admin.sku.index') }}" class="btn btn-secondary">Cancel</a>
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