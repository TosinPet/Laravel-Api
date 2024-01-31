@extends("layouts.overall")
@section("page_title", "All Purchases")
@section('module', 'Orders')
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
            <a href="{{ route('admin.purchase.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="flaticon2-pen"></i>Create Purchase
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
                                <span class="card-label font-weight-bolder text-dark">List of @yield('page_title')</span>
                                {{-- <span class="text-dark mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                <a href="{{ route('admin.order.export') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="la la-download"></i> Export Purchases List
                                </a>
                            </div>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table id="example" class="table table-separate table-head-custom table-checkable" id="">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Customer's Name</th>
                                        <th>Phone No</th>
                                        <th>Order No</th>
                                        <th>Order Date</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($purchases as $purchase)
                                        <tr>
                                            <td>
                                                {{ $cnt++ }}
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">Name</span> --}}
                                                    <span class="text-dark font-weight-bold" href="#">
                                                        {{ $purchase->full_name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">Phone</span> --}}
                                                    <span class="text-dark font-weight-bold" href="#">
                                                        {{ "+" .$purchase->phone }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">Email</span> --}}
                                                    <span class="text-dark font-weight-bold" href="#">
                                                        {{ $purchase->order_number }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">admin Reference</span> --}}
                                                    <span class="text-dark font-weight-bold" href="#">
                                                        {{ $purchase->order_date }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">admin Reference</span> --}}
                                                    <span class="text-dark font-weight-bold sku_id" href="#">
                                                        {{ $purchase->total_amount }}
                                                    </span>
                                                </div>
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

@endsection