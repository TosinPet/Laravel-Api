@extends("layouts.overall2")
@section("page_title", "Customers Account Statement")
@section('module', 'Customers')
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
                                <span class="card-label font-weight-bolder text-dark"> @yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>                      
                            
                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                <a href="#" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#addCustomerAccount">
                                    <i class="la la-upload"></i> Import Customers Account
                                </a>
                                <a href="{{ asset('sample/customerAccount/customer_account.csv') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3" download>
                                    <i class="la la-download"></i> Sample
                                </a>
                                <a href="{{ route('admin.customer.account.export') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="la la-download"></i> Download Customers Account List
                                </a>
                                
                            </div>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table class="table table-separate table-head-custom table-checkable" id="example" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Customer Name</th>
                                        <th>Utilized Credit</th>
                                        <th>Credit Limit</th>
                                        <th>Credit Allowance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($customers_account as $account)
                                    <tr>
                                        <td>
                                            {{ $cnt++ }}
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $account->full_name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{-- @php
                                                        $utilized_credit = $account->utilized_credit != 0 ? '-' . $account->utilized_credit : $account->utilized_credit;
                                                    @endphp --}}
                                                    {{-- {{ $account->utilized_credit }} --}}
                                                    {{ $account->utilized_credit != 0 ? '-' : '' }}{{ $account->utilized_credit }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $account->credit_limit }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $account->credit_allowance }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>

                                            <button href="#" class="btn btn-icon btn-warning" data-toggle="modal" data-target="#edit-customer-account{{ $account->id }}">
                                                <i class="flaticon-edit"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $customer->render() }} --}}
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
<div class="modal fade" id="addCustomerAccount" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Customers Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-custom">

                    <!--begin::Form-->
                    <form action="{{ route('admin.customer.account.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="card-body">

                            <div class="form-group">
                                <label>Select CSV File <span class="text-danger">*</span></label>
                                <input type="file" name="csv_file" class="form-control" required="required">
                            </div>
                            <div class="form-group mb-1">
                                <button type="submit" class="btn btn-warning mr-2">Import</button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>


            </div>

        </div>
    </div>
</div>
@foreach($customers_account as $account)
    <div class="modal fade" id="edit-customer-account{{ $account->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Customer's Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">

                        <!--begin::Form-->
                        <form action="{{ route('admin.customer.account.edit', $account->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input name="target" value="{{ $account->id }}" type="hidden" readonly>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Customer Name </label>
                                            <input type="text" name="full_name" value="{{ $account->full_name }}" class="form-control" required="required" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Utilized Credit </label>
                                            <input type="text" name="utilized_credit" value="{{ $account->utilized_credit }}" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Credit Limit </label>
                                            <input type="text" name="credit_limit" value="{{ $account->credit_limit }}" class="form-control" required="required" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Credit Allowance </label>
                                            <input type="text" name="credit_allowance" value="{{ $account->credit_allowance }}" class="form-control" required="required">
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

@endsection