@extends("layouts.overall")
@section("page_title", "Incoming Orders")
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
            <a href="{{ route('admin.order.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                Raise an Order
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
                                    <i class="la la-download"></i> Export Orders List
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
                                        <th>Status</th>
                                        <th>Details</th>
                                        {{-- <th></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                {{ $cnt++ }}
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">Name</span> --}}
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg" href="#">
                                                        {{ $order->full_name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder d-block font-size-lger">Phone</span> --}}
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg" href="#">
                                                        {{ "+" .$order->phone }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder d-block font-size-lger">Email</span> --}}
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg" href="#">
                                                        {{ $order->order_number }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder d-block font-size-lger">admin Reference</span> --}}
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg" href="#">
                                                        {{ $order->order_date }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder d-block font-size-lger">admin Reference</span> --}}
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg sku_id" href="#">
                                                        {{ $order->total_amount }}
                                                    </span>
                                                </div>
                                            </td>
                                            
                                            <td>
                                                @if($order->status == "Pending" )
                                                    <span href="#" style="font-size: 12px" class="badge badge-danger">{{ $order->status }}</span>
                                                    @elseif($order->status == "Approved" )
                                                    <span href="#" style="font-size: 12px" class="badge badge-primary">{{ $order->status }}</span>
                                                    @elseif($order->status == "Paid" )
                                                    <span href="#" style="font-size: 12px" class="badge badge-success">{{ $order->status }}</span>
                                                    @elseif($order->status == "Delivered" )
                                                    <span href="#" style="font-size: 12px" class="badge badge-info">{{ $order->status }}</span>
                                                    @elseif($order->status == "Cancelled" )
                                                    <span href="#" style="font-size: 12px" class="badge badge-dark">{{ $order->status }}</span>
                                                @endif

                                            </td>
                                            <td>
                                                <a href="{{ route('admin.order.show', $order->id) }}" style="font-size: 12px" class="btn btn-primary btn-sm">View</a>
                                            </td>
                                            @if(!checkPermission('edit_order_status'))
                                            {

                                            }
                                            @else
                                            @endif

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