@extends("layouts.overall")
@section("page_title", "Admins")
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
                                <a href="#" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#add-admin">
                                    <i class="ki-duotone ki-add-folder"></i> Create Admin
                                </a>

                            </div>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table class="table table-separate table-head-custom table-checkable" id="">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Admin Reference</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($admins as $admin)
                                    <tr>
                                        <td>
                                            {{ $cnt++ }}
                                        </td>
                                        <td>
                                            <div>
                                                {{-- <span class="font-weight-bolder">Name</span> --}}
                                                <a class="text-muted font-weight-bold text-hover-primary" href="#">
                                                    {{ $admin->last_name." ".$admin->first_name }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{-- <span class="font-weight-bolder">Phone</span> --}}
                                                <a class="text-muted font-weight-bold text-hover-primary" href="#">
                                                    {{ $admin->phone }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{-- <span class="font-weight-bolder">Email</span> --}}
                                                <a class="text-muted font-weight-bold text-hover-primary" href="#">
                                                    {{ $admin->email }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{-- <span class="font-weight-bolder">admin Reference</span> --}}
                                                <a class="text-muted font-weight-bold text-hover-primary" href="#">
                                                    {{ $admin->reference }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($admin->active == 1)
                                                <span
                                                    class="badge badge-light-primary fs-7 fw-bold">Active</span>
                                            @endif
                                            @if ($admin->active == 0)
                                                <span
                                                    class="badge badge-light-danger fs-7 fw-bold">Inactive</span>
                                            @endif

                                            @if ($admin->suspend == 1)
                                                <span
                                                    class="badge badge-light-danger fs-7 fw-bold">Suspended</span>
                                            @endif
                                            @if ($admin->suspend == 0)
                                                <span class="badge badge-light-success fs-7 fw-bold">Not
                                                    Suspended</span>
                                            @endif
                                        </td>
                                        <td>

                                            <button href="#" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#edit-admin{{ $admin->id }}">
                                                <i class="flaticon-edit"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $admin->render() }} --}}
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
@foreach($admins as $admin)
    <div class="modal fade" id="edit-admin{{ $admin->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">

                        <!--begin::Form-->
                        <form action="{{ route('admin.admins.edit', $admin->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input name="target" value="{{ $admin->id }}" type="hidden" readonly>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Admin Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ $admin->name }}" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Admin Email<span class="text-danger">*</span></label>
                                            <input type="email" name="email" value="{{ $admin->email }}" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Admin Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" value="{{ $admin->phone }}" class="form-control" required="required">
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
                                                    @if ($admin->active == 1) checked @endif
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
                                                    @if ($admin->suspend == 1) checked @endif
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
<div class="modal fade" id="add-admin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-custom">

                    <!--begin::Form-->
                    <form class="form" action="{{ route('admin.admins.create') }}" method="POST">
                        @csrf
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                <span class="required">Admin Name</span>

                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="" name="name"
                                value="{{ old('name') }}">
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                <span class="required">Admin Email</span>

                            </label>
                            <!--end::Label-->
                            <input type="email" class="form-control form-control-solid" placeholder="" name="email"
                                value="{{ old('email') }}">
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                <span class="required">Admin Phone</span>

                            </label>
                            <!--end::Label-->
                            <input type="phone" class="form-control form-control-solid" placeholder="" name="phone"
                                value="{{ old('phone') }}">
                        </div>

                        <!--end::Input group-->



                        <!--begin::Input group-->
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <div class="d-flex flex-stack mt-5">
                                    <!--begin::Switch-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" checked
                                            name="is_approved" />
                                        <span class="form-check-label fw-semibold text-muted">Approved</span>
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
                        </div>
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button data-bs-dismiss="modal" type="button" class="btn btn-light me-3">Discard</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>


            </div>

        </div>
    </div>
</div>


@endsection