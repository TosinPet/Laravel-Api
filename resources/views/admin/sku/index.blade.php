@extends("layouts.overall2")
@section("page_title", "SKUS")
@section('module', 'CMS')
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
                                <a href="#" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#addCustomer">
                                    <i class="la la-upload"></i> Import SKUs
                                </a>
                                <a href="{{ asset('sample/customers/customers.csv') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3" download>
                                    <i class="la la-download"></i> Sample
                                </a>
                                <a href="{{ route('admin.customer.export') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="la la-download"></i> Download SKU List
                                </a>
                                <a href="{{ route('admin.sku.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                    <i class="ki-duotone ki-add-folder"></i> Create SKU
                                </a>
                            </div>

                            

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table id="example" class="table table-separate table-head-custom table-checkable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Internal Reference</th>
                                        <th>Price</th>
                                        <th>Quantity on Hand</th>
                                        <th>Unit of Measure</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($skus as $sku)
                                    <tr>
                                        <td>
                                            {{ $cnt++ }}
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $sku->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $sku->reference_number }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    ₦{{ $sku->price }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $sku->quantity }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $sku->cases }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($sku->active == 1)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Active</span>
                                            @endif
                                            @if ($sku->active == 0)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Inactive</span>
                                            @endif

                                            @if ($sku->suspend == 1)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Suspended</span>
                                            @endif
                                            @if ($sku->suspend == 0)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Not Suspended</span>
                                            @endif
                                        </td>
                                        <td>

                                            <button href="#" class="btn btn-icon btn-warning" data-toggle="modal" data-target="#edit-customer{{ $sku->id }}">
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

@endsection
