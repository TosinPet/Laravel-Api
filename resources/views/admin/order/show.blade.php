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
                                <span class="card-label font-weight-bolder text-dark">@yield('page_title') - {{ $order->order_number }}</span><span></span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>

                            <div class="card-toolbar">

                                <form method="post" action="{{ route('admin.order.update', $order->id) }}">
                                    @csrf
                                    @method('put')
                                
                                    @if($order->status === 'Pending')
                                        <button type="submit" name="Approve" class="btn btn-primary font-weight-bolder font-size-sm mr-3"><i class="flaticon2-checkmark"></i>Approve Order</button>
                                        <button type="submit" name="Cancel" class="btn btn-dark font-weight-bolder font-size-sm mr-3"><i class="flaticon-circle"></i>Cancel Order</button>
                                    @elseif($order->status === 'Approved')
                                        <button type="submit" name="Paid" class="btn btn-success font-weight-bolder font-size-sm mr-3"><i class="flaticon-interface-5"></i>Confirm Payment</button>
                                        <button type="submit" name="Cancel" class="btn btn-dark font-weight-bolder font-size-sm mr-3"><i class="flaticon-circle"></i>Cancel Order</button>
                                    @elseif($order->status === 'Paid')
                                        <button type="submit" name="Delivered" class="btn btn-secondary font-weight-bolder font-size-sm mr-3"><i class="flaticon-shopping-basket"></i>Deliver Order</button>
                                        <button type="submit" name="Cancel" class="btn btn-dark font-weight-bolder font-size-sm mr-3"><i class="flaticon-circle"></i>Cancel Order</button>
                                    {{-- @else
                                        <button name="Delivered" class="btn btn-secondary font-weight-bolder font-size-sm mr-3">Delivered</button> --}}
                                    @endif
                                </form>
                                
                                <a href="{{ route('admin.order.edit', $order->id) }}" class="btn btn-success font-weight-bolder font-size-sm mr-3"><i class="flaticon2-pen"></i>Edit Order</a>
                                @if(checkPermission('edit_order_status'))
                                <a href="#" class="btn btn-primary font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#exampleModal{{ $order->id }}"><i class="flaticon-refresh"></i>Update Order Status</a>
                                @endif
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
                                                <form class="form-select" method="POST" enctype="multipart/form-data" action="{{ route('admin.order.editStatus', $order->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-5">
                                                        <label for="status">Status</label>

                                                        <select id="status" name="status"  class="form-control">
                                                        <option value="Pending">Pending</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Paid">Paid</option>
                                                        <option value="Delivered">Delivered</option>
                                                        <option value="Cancelled">Cancelled</option>                                                          
                                                        </select> 
                                                    </div>
                                                    
                                                    <div class="">
                                                        <label for="payment-status">Payment Status</label>

                                                        <select id="payment-status" name="payment_status" class="form-control">
                                                        <option value="Unpaid">Unpaid</option>
                                                        <option value="Partly Paid">Partly Paid</option>
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
                                    <a href="{{ route('admin.order.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                        View all Orders
                                    </a>

                                
                            </div>
                        </div>

                        <div class="card-body p-lg-10">

                            <!--begin::Section-->
                            <div class="mb-17">
                                <!--begin::Content-->
                                <!--begin::Row-->
                                <div class="col g-10">
                                    <!--begin::Col-->
                                    
                                    <h4 class="card-title">Order Details  </h4>
                                    <h6 class="pb-2">Name: {{ $order->full_name }}</h6>
                                    {{-- <h6 class="pb-2">Name: {{ $order->order_number }}</h6> --}}
                                    <h6 class="pb-2">Phone Number: {{ "+" .$order->phone_number }}</h6>
                                    <h6 class="pb-2">Total Amount:  &#x20A6;{{ $order->total_amount }}</h6>
                                    @if($order->status == "Pending" )
                                        <a href="#" class="badge badge-danger font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                        @elseif($order->status == "Approved" )
                                        <a href="#" class="badge badge-primary font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                        @elseif($order->status == "Paid" )
                                        <a href="#" class="badge badge-success font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                        @elseif($order->status == "Delivered" )
                                        <a href="#" class="badge badge-secondary font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                        @elseif($order->status == "Cancelled" )
                                        <a href="#" class="badge badge-dark font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                    @endif
                                    {{-- <h6 class="pb-2">Payment Status: {{ $order->payment_status }}</h6> --}}
                                    {{-- <h6 class="pb-2">Utilized Credit: {{ $customer_account->utilized_credit }}</h6>
                                    <h6 class="pb-2">Credit Limit: {{ $customer_account->credit_limit }}</h6>
                                    <h6 class="pb-2">Credit Allowance: {{ $customer_account->credit_allowance }}</h6> --}}
                                   
                                </div>

                                <table class="table table-striped table-bordered base-style">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            {{-- <th>Order Number</th> --}}
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price per unit</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @foreach ($order_items as $order_item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            {{-- <td>{{ $order->order_number }}</td> --}}
                                            <td>{{ $order_item->product_name }}</td>
                                            <td>{{ $order_item->quantity }}</td>  
                                            <td>{{ $order_item->unit_price }}</td>                                        
                                            <td>{{ $order_item->total_price }}</td>                                        
                                        </tr>
                                        @endforeach
                                    
                                    </tbody>
                                </table>
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