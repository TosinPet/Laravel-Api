@extends("layouts.overall")
@section("page_title", "View Customer")
@section('module', 'Users')
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
            <a href="{{ route('admin.customer.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                View all Customers
            </a>
        </div>
        
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <!--begin::Details-->
                    <div class="d-flex">
                        <!--begin: Pic-->
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between flex-wrap mt-1">
                                <div class="d-flex mr-3">
                                    <a href="#" style="text-decoration: none;" class="text-dark font-size-h3 font-weight-bolder mr-4">{{ $customer->full_name }}</a>
                                    <a href="#" class="text-dark font-size-h3 font-weight-bolder">
                                        {{-- <i class="flaticon2-correct text-success font-size-h5"></i> --}}
                                    </a>
                                </div>
                            </div>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap justify-content-between mt-3 mb-4">
                                <div class="d-flex flex-column flex-grow-1 pr-8">
                                    <div class="d-flex flex-wrap">
                                        <a href="" style="text-decoration: none;" class="text-dark-75 h5 font-weight-bolder mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon2-user mr-2 font-size-lg"></i>{{ $customer->reference_no }}</a>
                                        <a href="#" style="text-decoration: none;" class="text-dark-75 h5 font-weight-bolder mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon2-phone mr-2 font-size-lg"></i>{{ "+" .$customer->phone_number }}</a>
                                        <a href="#" style="text-decoration: none;" class="text-dark-75 h5 font-weight-bolder mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon-pin mr-2 font-size-lg"></i>{{ $customer->address }}</a>
                                    </div>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <div class="separator separator-solid"></div>
                    <!--begin::Items-->
                    <div class="d-flex align-items-center flex-wrap mt-4">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-piggy-bank display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-lg">Utilized Credit</span>
                                <span class="font-weight-bolder font-size-h5">
                                <span class="text-dark-50 font-weight-bold"></span>{{ $customer->utilized_credit ?? 'null'}}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-confetti display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-lg">Credit Limit</span>
                                <span class="font-weight-bolder font-size-h5">
                                <span class="text-dark-50 font-weight-bold"></span>{{ $customer->credit_limit ?? 'null'}}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-pie-chart display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-lg">Credit Allowance</span>
                                <span class="font-weight-bolder font-size-h5">
                                <span class="text-dark-50 font-weight-bold"></span>{{ $customer->credit_allowance ?? 'null'}}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <!--end::Item-->
                        <!--begin::Item-->
                        <!--end::Item-->
                        <!--begin::Item-->
                        <!--end::Item-->
                    </div>
                    
                    

                    <!--begin::Items-->
                </div>
            </div>

            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Recent Orders</span>
                    </h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-0 pb-3">
                    <div class="tab-content">
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                <thead>
                                    <tr class="text-left text-uppercase">
                                        <th style="min-width: 250px" class="pl-7">
                                            <span class="text-dark-75">Name</span>
                                        </th>
                                        <th style="min-width: 100px">Phone No</th>
                                        <th style="min-width: 100px">Order No</th>
                                        <th style="min-width: 100px">Total Amount</th>
                                        <th style="min-width: 130px">Status</th>
                                        <th style="min-width: 80px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)															
                                    <tr>
                                        <td class="pl-0 py-8">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50 symbol-light mr-4">
                                                </div>
                                                <div>
                                                    <span href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $order->full_name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $order->phone }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${{ $order->order_number }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $order->total_amount }}</span>
                                        </td>
                                        <td>
                                            @if($order->status == "Pending" )
                                                <a href="" class="btn btn-light-danger font-weight-bolder font-size-sm">{{ $order->status }}</a>
                                                @elseif($order->status == "Approved" )
                                                <a href="#" class="btn btn-light-primary font-weight-bolder font-size-sm">{{ $order->status }}</a>
                                                @elseif($order->status == "Paid" )
                                                <a href="#" class="btn btn-light-success font-weight-bolder font-size-sm">{{ $order->status }}</a>
                                                @elseif($order->status == "Delivered" )
                                                <a href="#" class="btn btn-light-info font-weight-bolder font-size-sm">{{ $order->status }}</a>
                                                @elseif($order->status == "Cancelled" )
                                                <a href="#" class="btn btn-light-dark font-weight-bolder font-size-sm">{{ $order->status }}</a>
                                            @endif
                                        </td>
                                        <td class="pr-0 text-right">
                                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-light-success font-weight-bolder font-size-sm">View Order</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Row-->
            <!--end::Dashboard-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>

@endsection