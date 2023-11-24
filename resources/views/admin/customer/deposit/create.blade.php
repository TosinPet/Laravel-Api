@extends("layouts.overall")
@section("page_title", "Customer Deposit Form")
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
                                <span class="card-label font-weight-bolder text-dark">@yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>
                        </div>

                        <form class="form" action="{{ route('admin.customer.deposit.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Select Customer Account <span class="text-danger"><b>*</b></span> </label>
                                        <select id="customer" name="customer_id" class="form-control">
                                            <option value="none" selected="" disabled="">Choose a Customer Account</option>
                                            @foreach($customers_account as $customer_account)
                                                <option value="{{ $customer_account->customer_id }}" onclick="customer_deposit({{ $customer_account->utilized_credit }}, {{ $customer_account->credit_limit }}, {{ $customer_account->credit_allowance }})">{{ $customer_account->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Deposit Date <span class="text-danger"><b>*</b></span> </label>
                                        <input type="date" class="form-control" name="deposit_date" placeholder="Deposit Date" value="{{ old('date') }}" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Description (optional) <span class="text-danger"><b>*</b></span></label>
                                        <textarea rows="1" class="form-control" name="description" placeholder="Description">{!! old('description') !!}</textarea>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Amount <span class="text-danger"><b>*</b></span> </label>
                                        <input type="text" class="form-control" name="amount" placeholder="Amount" value="{{ old('amount') }}" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Mode of Payment <span class="text-danger"><b>*</b></span> </label>
                                        <select id="projectinput3" name="mode_of_payment" class="form-control" required>
                                            <option value="none" selected="" disabled="">Choose mode of payment</option>
                                            <option value="Cash">Cash</option>
                                            <option value="POS">POS</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Credit Utilized : </label>
                                        <div id="utilized_credit" name="utilized_credit">

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Credit Limit :</label>
                                        <div id="credit_limit" name="credit_limit">

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Credit Allowance :</label>
                                        <div id="credit_allowance" name="credit_allowance">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <script>
                        </script>

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