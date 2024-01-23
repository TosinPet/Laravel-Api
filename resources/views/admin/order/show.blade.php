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
            <a href="{{ route('admin.order.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                View all Orders
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
                                    <a href="#" style="text-decoration: none;" class="text-dark font-size-h3 font-weight-bolder mr-4">@yield('page_title')</a>
                                    <a href="#" class="text-dark font-size-h3 font-weight-bolder">
                                        {{ $order->order_number }}
                                        {{-- <i class="flaticon2-correct text-success font-size-h5"></i> --}}
                                    </a>
                                </div>
                                <div class="my-lg-0 my-3">
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
                                    {{-- <a href="#" class="btn btn-sm btn-light-success font-weight-bolder text-uppercase mr-3">ask</a> --}}
                                    {{-- <a href="#" class="btn btn-sm btn-info font-weight-bolder text-uppercase">hire</a> --}}
                                </div>
                            </div>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap justify-content-between mt-3">
                                <div class="d-flex flex-column flex-grow-1 pr-8">
                                    <div class="d-flex flex-wrap">
                                        <a href="" style="text-decoration: none;" class="text-dark-75 h5 font-weight-bolder mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon2-user mr-2 font-size-lg"></i>{{ $order->full_name }}</a>
                                        <a href="#" style="text-decoration: none;" class="text-dark-75 h5 font-weight-bolder mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon2-phone mr-2 font-size-lg"></i>{{ "+" .$order->phone }}</a>
                                        <a href="#" style="text-decoration: none;" class="text-dark-75 h5 font-weight-bolder mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon-money mr-2 font-size-lg"></i>&#x20A6;{{ $order->total_amount }}</a>

                                        @if($order->status == "Pending" )
                                        <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-danger font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                        @elseif($order->status == "Approved" )
                                        <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-primary font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                        @elseif($order->status == "Paid" )
                                        <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-success font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                        @elseif($order->status == "Delivered" )
                                        <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-secondary font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                        @elseif($order->status == "Cancelled" )
                                        <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-dark font-weight-bolder font-size-sm mr-3 mb-8">{{ $order->status }}</a>
                                    @endif
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
                    <div class="d-flex align-items-center flex-wrap mt-8">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-lg">Utilized Credit</span>
                                <span class="font-weight-bolder font-size-h5">
                                <span class="text-dark-50 font-weight-bold"></span>{{ $customer->utilized_credit ?? 'null'}}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-lg">Credit Limit</span>
                                <span class="font-weight-bolder font-size-h5">
                                <span class="text-dark-50 font-weight-bold"></span>{{ $customer->credit_limit ?? 'null'}}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
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
                        <!--end::Item-->
                        <!--begin::Item-->
                        <a href="{{ route('admin.order.edit', $order->id) }}" class="btn btn-success font-weight-bolder font-size-sm mr-3"><i class="flaticon2-pen"></i>Edit Order</a>
                        <!--end::Item-->
                    </div>
                    
                    

                    <!--begin::Items-->
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-12 col-md-12 order-2 order-xxl-1">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-body p-lg-10">

                            <!--begin::Section-->
                            <div class="mb-17">

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