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
                                    <a href="{{ route('admin.customer.show', $customer->id) }}" style="text-decoration: none;" class="text-dark font-size-h3 font-weight-bolder mr-4">{{ $order->full_name }}</a>
                                    
                                </div>
                                <div class="my-lg-0 my-3">
                                    <form method="post" action="{{ route('admin.order.update', $order->id) }}">
                                        @csrf
                                        @method('put')
                                    
                                        @if($order->status === 'Pending')
                                            <button type="submit" name="Approve" class="btn btn-light-primary font-weight-bolder font-size-sm mr-3"><i class="flaticon2-checkmark"></i>Approve Order</button>
                                            <button type="submit" name="Cancel" class="btn btn-dark font-weight-bolder font-size-sm mr-3"><i class="flaticon-circle"></i>Cancel Order</button>
                                        @elseif($order->status === 'Approved')
                                            <button type="submit" name="Paid" class="btn btn-success font-weight-bolder font-size-sm mr-3"><i class="flaticon-interface-5"></i>Confirm Payment</button>
                                            <button type="submit" name="Cancel" class="btn btn-dark font-weight-bolder font-size-sm mr-3"><i class="flaticon-circle"></i>Cancel Order</button>
                                        @elseif($order->status === 'Paid')
                                            <button type="submit" name="Delivered" class="btn btn-info font-weight-bolder font-size-sm mr-3"><i class="flaticon-shopping-basket"></i>Deliver Order</button>
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
                                        <a href="#" style="text-decoration: none;" class="text-dark-75 h5 font-weight-bolder mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon2-phone mr-2 font-size-lg"></i>{{ "+" .$order->phone }}</a>
                                        <a href="#" style="text-decoration: none;" class="text-dark-75 h5 font-weight-bolder mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon2-phone mr-2 font-size-lg"></i>&#x20A6;{{ $order->total_amount }}</a>
                                        <a href="#" style="text-decoration: none;" class="text-dark-75 h5 font-weight-bolder mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon-money mr-2 font-size-lg"></i>
                                        @if($order->status == "Pending" )
                                            <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-danger font-weight-bolder font-size-sm mr-3 mb-4">{{ $order->status }}</a>
                                            @elseif($order->status == "Approved" )
                                            <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-primary font-weight-bolder font-size-sm mr-3 mb-4">{{ $order->status }}</a>
                                            @elseif($order->status == "Paid" )
                                            <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-success font-weight-bolder font-size-sm mr-3 mb-4">{{ $order->status }}</a>
                                            @elseif($order->status == "Delivered" )
                                            <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-info font-weight-bolder font-size-sm mr-3 mb-4">{{ $order->status }}</a>
                                            @elseif($order->status == "Cancelled" )
                                            <a href="#" style="font-size: 15px; text-decoration: none;" class="badge badge-dark font-weight-bolder font-size-sm mr-3 mb-4">{{ $order->status }}</a>
                                        @endif</a>
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
                                <span class="font-weight-bolder font-size-h5 sku_id">
                                <span class="text-dark-50 font-weight-bold"></span>{{ $customer->utilized_credit ?? '0'}}</span>
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
                                <span class="font-weight-bolder font-size-h5 sku_id">
                                <span class="text-dark-50 font-weight-bold"></span>{{ $customer->credit_limit ?? '0'}}</span>
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
                                <span class="font-weight-bolder font-size-h5 sku_id">
                                <span class="text-dark-50 font-weight-bold"></span>{{ $customer->credit_allowance ?? '0'}}</span>
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
                        @if($order->status == "Pending" )
                            <a href="{{ route('admin.order.edit', $order->id) }}" class="btn btn-light-success font-weight-bolder font-size-sm mr-3"><i class="flaticon2-pen"></i>Edit Order</a>
                        @else
                        @endif
                        <!--end::Item-->
                    </div>
                    
                    

                    <!--begin::Items-->
                </div>
            </div>

            <div class="row">

                <div class="col-xxl-8 col-md-12 order-2 order-xxl-1">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom gutter-b">
                        <!--begin::Header-->
                        <div class="card-body p-lg-10">

                            <!--begin::Section-->
                            <div class="mb-17">
                                <a href="#" style="text-decoration: none;" class="text-dark font-size-h3 font-weight-bolder">
                                    {{ $order->order_number }}
                                </a>
                                <table class="table table-striped table-bordered base-style mt-3">
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

                <div class="col-xxl-4 col-md-12 order-2 order-xxl-1">
                    <!--begin::List Widget 9-->
                    <div class="card card-custom gutter-b">
											<div class="card-header">
												<div class="card-title">
													<h3 class="card-label">Order Activity</h3>
												</div>
											</div>
											<div class="card-body">
												<!--begin::Example-->
												<div class="example example-basic">
													<div class="example-preview">
														<!--begin::Timeline-->
														<div class="timeline timeline-5">
															<div class="timeline-items">
																<!--begin::Item-->
																<div class="timeline-item">
																	<!--begin::Icon-->
																	<div class="timeline-media bg-light-primary">
																		<span class="svg-icon svg-icon-primary svg-icon-md">
																			<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000" />
																					<path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3" />
																				</g>
																			</svg>
																			<!--end::Svg Icon-->
																		</span>
																	</div>
																	<!--end::Icon-->
																	<!--begin::Info-->
																	<div class="timeline-desc timeline-desc-light-primary">
                                                                        @if ($order_logs->isEmpty())
                                                                            <p class="font-weight-normal text-dark-50 pb-2">No activity on this Order yet</p>
                                                                        @else
                                                                            @foreach ($order_logs as $order_log)
                                                                                @php
                                                                                    $timestamp = $order_log->created_at;
                                                                                    $carbonDate = \Carbon\Carbon::parse($timestamp);
                                                                                    $formattedDate = $carbonDate->format('H:i, jS \of F Y');
                                                                                @endphp
                                                                                <span class="font-weight-bolder text-primary">{{ $formattedDate }}</span>
                                                                                <p class="font-weight-normal text-dark-50 pb-2">{{ $order_log->name }}</p>
                                                                            @endforeach
                                                                        @endif
																	</div>
																	<!--end::Info-->
																</div>
																<!--end::Item-->
															</div>
														</div>
														<!--end::Timeline-->
													</div>
												</div>
												<!--end::Example-->
												<!--begin::Code example-->
												<!--end::Code example-->
											</div>
										</div>
                    <!--end: List Widget 9-->
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