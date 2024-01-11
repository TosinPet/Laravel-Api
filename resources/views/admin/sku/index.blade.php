@extends("layouts.overall")
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
                                <a href="{{ route('admin.sku.export') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
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
                                        <th class="ps-4 min-w-125px rounded-start">SKU Image</th>
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
                                            <img src="{{ asset('uploads/skus') }}/{{ $sku->image }}" style="width: 50px; height: 50px" alt="Icon">
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
                                            @if ($sku->status == 1)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Available</span>
                                            @endif
                                            @if ($sku->status == 0)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Unavilable</span>
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

@foreach($skus as $sku)
    <div class="modal fade" id="edit-customer{{ $sku->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit SKUs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">

                        <!--begin::Form-->
                        <form action="{{ route('admin.sku.edit', $sku->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input name="product" value="{{ $sku->id }}" type="hidden" readonly>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ $sku->name }}" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description </label>
                                            <input type="text" name="description" value="{{ $sku->description }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Category <span class="text-danger">*</span></label>
                                            <select id="category" name="category" class="form-control">
                                                <option value="none" selected="" disabled="">Choose a Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{$category->id == $sku->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="phone" value="{{ $sku->category }}" class="form-control" required="required"> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Brand <span class="text-danger">*</span></label>
                                            <select id="brand" name="brand" class="form-control">
                                                <option value="none" selected="" disabled="">Choose a Brand</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{$brand->id == $sku->brand_id ? 'selected' : ''}}>{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="phone" value="{{ $sku->category }}" class="form-control" required="required"> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Product Image <span class="text-danger"><b>*</b></span></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control form-control-solid" placeholder="" name="image" accept="image/png,image/gif,image/jpeg,image/jpg" value="{{ old('brand_image') }}">
                                                <div class="input-group-append">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Cases </label>
                                            <input type="text" class="form-control" name="cases" placeholder="Cases" value="{{ $sku->cases }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Reference Number </label>
                                            <input type="text" class="form-control" name="reference_number" placeholder="Cases" value="{{ $sku->reference_number }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Quantity </label>
                                            <input type="text" class="form-control" name="quantity" placeholder="Quantity" value="{{ $sku->quantity }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Price </label>
                                            <input type="text" class="form-control" name="price" placeholder="Price" value="{{ $sku->price }}" />
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-md-6 mt-5">
                                    <div class="d-flex flex-stack">
       
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" @if ($sku->status == 1) checked @endif name="status" />
                                            <span class="form-check-label fw-semibold text-muted">Active</span>
                                        </label>
                                        <!--end::Switch-->
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
