@extends("layouts.overall")
@section("page_title", "Banners")
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
            <a href="{{ route('admin.banner.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="flaticon2-pen"></i> Create New Banner
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

                        <div class="card-body p-lg-20">

                            <!--begin::Section-->
                            <div class="mb-17">
                                <!--begin::Content-->
                                <!--begin::Row-->
                                <div class="row g-10">
                                    <!--begin::Col-->
                                    @foreach($banners as $banner)
                                    <div class="col-md-4 mb-5">
                                        <!--begin::Hot sales post-->
                                        <div class="card-xl-stretch me-md-6">
                                            <!--begin::Overlay-->
                                            <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                                href="{{ asset('uploads/banners') }}/{{ $banner->icon }}" target="_blank">
                                                <!--begin::Image-->
                                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                    style="background-image:url('{{ asset('uploads/banners') }}/{{ $banner->banner_image }}')">
                                                </div>
                                                <!--end::Image-->
                                                <!--begin::Action-->
                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                    <i class="ki-duotone ki-eye fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </div>
                                                <!--end::Action-->
                                            </a>
                                            <!--end::Overlay-->
                                            <!--begin::Body-->
                                            <div class="mt-2">
                                                <!--begin::Title-->
                                                <span href="{{ route('admin.banner.edit', $banner->id) }}"
                                                    class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">
                                                    {{ $banner->name }}
                                                </span>
                                                <!--end::Title-->
                                                <div class="fs-6 mt-3 d-flex flex-stack">
                                                    <small>
                                                        @if ($banner->status == 1)
                                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Active</span>
                                                        @endif
                                                        @if ($banner->status == 0)
                                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Not Active</span>
                                                        @endif
                                                    </small>
                                                </div>
                                                <!--end::Text-->
                                                <!--begin::Text-->
                                                <div class="fs-6 fw-bold mt-3 d-flex flex-stack">
                                                    <!--begin::Label-->
                                                    <!--end::Label-->
                                                    <!--begin::Action-->
                                                    <a href="{{ route('admin.banner.edit', $banner->id) }}" style="font-size: 15px" class="btn btn-sm btn-warning">
                                                        {{-- <i class="ki-duotone ki-pencil"> --}}
                                                        {{-- <i class="path1"></i> --}}
                                                        {{-- <i class="path2"></i> --}}
                                                        </i> Edit</a>
                                                    <!--end::Action-->
                                                </div>
                                                
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Hot sales post-->
                                        <br>
                                    </div>
                                    
                                    @endforeach
                                   
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Section-->

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

@endsection
