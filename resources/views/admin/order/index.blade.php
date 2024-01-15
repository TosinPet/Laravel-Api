@extends("layouts.overall")
@section("page_title", "Incoming Orders")
@section('module', 'Orders')
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
                                {{-- <span class="text-dark mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                <a href="{{ route('admin.order.export') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="la la-download"></i> Export Orders List
                                </a>
                                <a href="{{ route('admin.order.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    Raise an Order
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
                                        <th>Customer's Name</th>
                                        <th>Phone No</th>
                                        <th>Order No</th>
                                        <th>Order Date</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                        <th></th>
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
                                                    <a class="text-dark font-weight-bold" href="#">
                                                        {{ $order->full_name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">Phone</span> --}}
                                                    <a class="text-dark font-weight-bold" href="#">
                                                        {{ "+" .$order->phone }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">Email</span> --}}
                                                    <a class="text-dark font-weight-bold" href="#">
                                                        {{ $order->order_number }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">admin Reference</span> --}}
                                                    <a class="text-dark font-weight-bold" href="#">
                                                        {{ $order->order_date }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">admin Reference</span> --}}
                                                    <a class="text-dark font-weight-bold" href="#">
                                                        {{ $order->total_amount }}
                                                    </a>
                                                </div>
                                            </td>
                                            
                                            <td>
                                                @if($order->status == "Pending" )
                                                    <a href="#" class="badge badge-danger">{{ $order->status }}</a>
                                                    @elseif($order->status == "Approved" )
                                                    <a href="#" class="badge badge-primary">{{ $order->status }}</a>
                                                    @elseif($order->status == "Paid" )
                                                    <a href="#" class="badge badge-success">{{ $order->status }}</a>
                                                    @elseif($order->status == "Delivered" )
                                                    <a href="#" class="badge badge-secondary">{{ $order->status }}</a>
                                                    @elseif($order->status == "Cancelled" )
                                                    <a href="#" class="badge badge-dark">{{ $order->status }}</a>
                                                @endif

                                            </td>
                                            <td>
                                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-primary btn-sm">View</a>
                                            </td>
                                            @if(!checkPermission('edit_order_status'))
                                            {

                                            }
                                            @else
                                            <td>
                                            </td>  
                                            @endif
                                            <td>
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