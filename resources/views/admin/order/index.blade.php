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
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
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
                            <table class="table table-separate table-head-custom table-checkable" id="">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Customer's Name</th>
                                        <th>Phone No</th>
                                        <th>Order No</th>
                                        <th>Shipping Address</th>
                                        <th>Total Amount</th>
                                        <th>Approval Status</th>
                                        <th>Payment Status</th>
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
                                                    <a class="text-muted font-weight-bold text-hover-primary" href="#">
                                                        {{ $order->full_name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">Phone</span> --}}
                                                    <a class="text-muted font-weight-bold text-hover-primary" href="#">
                                                        {{ $order->phone }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">Email</span> --}}
                                                    <a class="text-muted font-weight-bold text-hover-primary" href="#">
                                                        {{ $order->order_number }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">admin Reference</span> --}}
                                                    <a class="text-muted font-weight-bold text-hover-primary" href="#">
                                                        {{ $order->shipping_address }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{-- <span class="font-weight-bolder">admin Reference</span> --}}
                                                    <a class="text-muted font-weight-bold text-hover-primary" href="#">
                                                        {{ $order->total_amount }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($order->is_approved == true)
                                                    <a href="#" class="badge badge-primary">Aproved</a>
                                                @else
                                                    <a href="#" class="badge badge-danger">Pending Approval</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->payment_status == "Paid")
                                                    <a href="#" class="badge badge-success">{{ $order->status }}</a>
                                                @else
                                                    <a href="#" class="badge badge-danger">{{ $order->status }}</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->status == "Pending" )
                                                    <a href="{{ route('admin.order.show', $order->id) }}" class="badge badge-danger">{{ $order->status }}</a>
                                                    @elseif($order->status == "Paid" )
                                                    <a href="{{ route('admin.order.show', $order->id) }}" class="badge badge-primary">{{ $order->status }}</a>
                                                    @elseif($order->status == "Delivered" )
                                                    <a href="{{ route('admin.order.show', $order->id) }}" class="badge badge-success">{{ $order->status }}</a>
                                                    @elseif($order->status == "Cancelled" )
                                                    <a href="{{ route('admin.order.show', $order->id) }}" class="badge badge-secondary">{{ $order->status }}</a>
                                                    @elseif($order->status == "Closed" )
                                                    <a href="{{ route('admin.order.show', $order->id) }}" class="badge badge-dark">{{ $order->status }}</a>
                                                @endif

                                            </td>
                                            <td>
                                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-primary btn-sm">View</a>
                                            </td>
                                            <td><a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{ $order->id }}">Edit</a>
                                                <div class="modal fade" id="exampleModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Order</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-select" method="POST" enctype="multipart/form-data" action="{{ route('admin.order.update', $order->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-5">
                                                                    <label for="status">Status</label>

                                                                    <select id="status" name="status"  class="form-control">
                                                                    <option value="Pending">Pending</option>
                                                                    <option value="Paid">Paid</option>
                                                                    <option value="Delivered">Delivered</option>
                                                                    <option value="Cancelled">Cancelled</option>
                                                                    <option value="Closed">Closed</option>                                                          
                                                                    </select> 
                                                                </div>
                                                                
                                                                <div class="">
                                                                    <label for="payment-status">Payment Status</label>

                                                                    <select id="payment-status" name="payment_status" class="form-control">
                                                                    <option value="Unpaid">Unpaid</option>
                                                                    <option value="Unpaid">Partly Paid</option>
                                                                    <option value="Paid">Paid</option>
                                                                    </select> 
                                                                </div>
                                                                

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                            
                                                        </div>
                                                    
                                                    </div>
                                                    </div>
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

{{-- @foreach($admins as $admin)
    <div class="modal fade" id="edit-admin{{ $admin->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Customer's Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">

                        <!--begin::Form-->
                        <form action="{{ route('admin.customer.edit', $customer->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input name="target" value="{{ $admin->id }}" type="hidden" readonly>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" value="{{ $admin->first_name }}" class="form-control" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <input type="text" name="last_name" value="{{ $admin->last_name }}" class="form-control" required="required">
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

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                        <span class="required">Password</span>
        
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" class="form-control form-control-solid" placeholder="This is optional" name="password">
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

@endforeach --}}

@endsection