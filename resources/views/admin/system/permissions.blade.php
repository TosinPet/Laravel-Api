@extends("layouts.overall")
@section("page_title", "Permissions")
@section('module', 'System')
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
            @if(checkPermission('add_permission'))
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#addCustomer">
                    <i class="flaticon2-pen"></i> Create Permissions
                </a>
            @endif
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
                                <span class="card-label font-weight-bolder text-dark">List of @yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                                @php
                                    $permissions = fetchPermissions();
                                @endphp
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                
                            </div>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table class="table align-middle gs-0 gy-4" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold text-white bg-warning">
                                        <th>Name</th>
                                        {{-- <th>Slug</th> --}}
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                               
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span href="#" class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $permission->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <span href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">{{ $permission->slug }}</span>
                                        </td> --}}
                                        <td>
                                            @if($permission->status == 1)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Active</span>
                                            @endif
                                            @if($permission->status == 0)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(checkPermission('edit_permission'))
                                                <button href="#" class="btn btn-icon btn-warning" data-toggle="modal" data-target="#edit-customer{{ $permission->id }}">
                                                    <i class="flaticon2-edit"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                                <!--end::Table body-->
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

<div class="modal fade" id="addCustomer" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-custom">

                    <!--begin::Form-->
                    <form action="{{ route('admin.permissions.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="card-body">
                            <div class="d-flex flex-column mb-7 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Name</span>
                                    
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" placeholder="" name="name" />
                            </div>
                            <!--end::Input group-->
                           
                            <!--begin::Input group-->
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="d-flex flex-stack custom_switch">
                                    
                                        <!--begin::Switch-->
                                        <label class="form-check switch form-check-custom">
                                            <input class="form-check-input" type="checkbox" value="1" checked="checked" name="status" />
                                            <span class="form-check-label fw-semibold text-muted">Active</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="col-md-12 mb-2">
                                    <div class="text-center pt-15">
                                        <button data-dismiss="modal" type="button" class="btn btn-light me-3">Discard</button>
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Save</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                    <!--end::Form-->
                </div>


            </div>

        </div>
    </div>
</div>

@foreach ($permissions as $permission)
<div class="modal fade" id="edit-customer{{ $permission->id }}" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Edit Permission</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form class="form" action="{{ route('admin.permissions.edit', ['permission_id' => $permission->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                            <span class="required">Name</span>
                            
                        </label>
                        <!--end::Label-->
                        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{ $permission->name }}">
                    </div>
                    <!--end::Input group-->
                   
                    <!--begin::Input group-->
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="d-flex flex-stack custom_switch">
                        
                            <!--begin::Switch-->
                                <label class="form-check switch form-check-custom">
                                    <input class="form-check-input" type="checkbox" value="1" @if($permission->status == 1) checked @endif name="status" />
                                    <span class="form-check-label fw-semibold text-muted">Active</span>
                                </label>
                            <!--end::Switch-->
                            </div>
                        </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                        <div class="col-md-12 mb-2">
                            <div class="text-center pt-15">
                                <button data-dismiss="modal" type="button" class="btn btn-light me-3">Discard</button>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endforeach
@endsection