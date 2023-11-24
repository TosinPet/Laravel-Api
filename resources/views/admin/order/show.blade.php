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
                                <span class="card-label font-weight-bolder text-dark">@yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                @if ($order->is_approved == false)
                                    <form method="post" action="{{ route('admin.order.approve', ['id' => $order->id]) }}">
                                        @csrf
                                        @method('post')
                                        <button type="submit" class="btn btn-warning font-weight-bolder font-size-sm mr-3">Approve Order</button>
                                    </form>
                                @else
                                    <a href="#" class="btn btn-primary font-weight-bolder font-size-sm mr-3">
                                        <i class="ki-duotone ki-add-folder"></i> Approved
                                    </a>    
                                @endif
                                
                            </div>
                        </div>

                        <div class="card-body p-lg-10">

                            <!--begin::Section-->
                            <div class="mb-17">
                                <!--begin::Content-->
                                <!--begin::Row-->
                                <div class="col g-10">
                                    <!--begin::Col-->
                                    
                                    <h4 class="card-title">Order Details</h4>
                                    <h6 class="pb-2">Name: {{ $order->full_name }}</h6>
                                    <h6 class="pb-2">Name: {{ $order->order_number }}</h6>
                                    <h6 class="pb-2">Phone Number: {{ $order->phone }}</h6>
                                    <h6 class="pb-2">Total Amount:  &#x20A6;{{ $order->total_amount }}</h6>
                                    <h6 class="pb-2">Status: {{ $order->status }}</h6>
                                    <h6 class="pb-2">Payment Status: {{ $order->payment_status }}</h6>
                                    <h6 class="pb-2">Utilized Credit: {{ $customer_account->utilized_credit }}</h6>
                                    <h6 class="pb-2">Credit Limit: {{ $customer_account->credit_limit }}</h6>
                                    <h6 class="pb-2">Credit Allowance: {{ $customer_account->credit_allowance }}</h6>
                                   
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