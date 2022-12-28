@extends('layouts.master')
@section('title','لوحة التحكم-الفواتير')
@section('css')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <a class="btn ripple btn-primary" href="{{route('invoices.create')}}">إضافة فاتورة</a>
                </div>
                <div style="margin: 0 auto;" class="col-md-3 mt-1 text-center">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                        @if ($errors->any())
                            <div class="alert alert-danger text-right">
                                @foreach ($errors->all() as $error)
                                    - {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table" data-page-length='50'>
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">الموظف</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الإجمالي</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($invoices as $invoice)
                            <tr class="text-center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$invoice->user->name}}</td>
                                <td>{{$invoice->invoice_number}}</td>
                                <td>{{$invoice->invoice_Date}}</td>
                                <td>{{$invoice->due_date}}</td>
                                <td>{{$invoice->section->name}}</td>
                                <td>{{$invoice->amount_collection}}</td>
                                <td>{{$invoice->note}}</td>
                                <td>{{$invoice->status == 1 ? 'غير مدفوعة' : 'مدفوعة'}}</td>
                                <td>

                                    <div class="d-flex">

                                        <a class="btn btn-sm btn-success"
                                           data-invoice_number="{{$invoice->invoice_number}}"
                                           data-invoice_date="{{$invoice->invoice_Date}}"
                                           data-due_date="{{$invoice->due_date}}"
                                           data-product_name="{{$invoice->section->products()->where('id',$invoice->product_id)->first()->name}}"
                                           data-amount_collection="{{$invoice->amount_collection}}"
                                           data-amount_commission="{{$invoice->amount_commission}}"
                                           data-discount="{{$invoice->discount}}"
                                           data-rate_vat="{{$invoice->rate_vat}}"
                                           data-value_vat="{{$invoice->value_vat}}"
                                           data-total="{{$invoice->total}}"
                                           data-note="{{$invoice->note}}"
                                           data-image="{{$invoice->image}}"
                                           data-target="#modaldemo1" data-toggle="modal" href=""
                                           title="تفاصيل"><i class="las la-eye"></i></a>

                                        <a class="btn btn-sm btn-info mx-1"
                                           href="{{route('invoices.edit',['model' => $invoice->id])}}"
                                           title="تعديل"><i class="las la-pen"></i></a>


                                        <form action="{{route('invoices.destroy',['model' => $invoice->id])}}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    title="حذف"
                                                    class="btn btn-sm btn-info btn-danger "
                                                    onClick="return confirm('هل أنت متأكد?');">
                                                <i class="las la-trash"></i></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                                <p>لا يوجد بيانات لعرضها</p>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
        <!-- Add modal -->
        <div class="modal" id="modaldemo1">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> تفاصيل الفاتورة</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            @csrf

                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">رقم الفاتورة</label>
                                    <input type="text" class="form-control" id="invoice_number" disabled>
                                </div>

                                <div class="col">
                                    <label>تاريخ الفاتورة</label>
                                    <input class="form-control fc-datepicker" id="invoice_date" type="text" disabled>
                                </div>

                                <div class="col">
                                    <label>تاريخ الاستحقاق</label>
                                    <input class="form-control fc-datepicker" id="due_date" type="text" disabled>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label class="control-label">التحصيل لصالح</label>
                                    <input type="text" class="form-control" id="product_name" disabled>
                                </div>

                                <div class="col">
                                    <label>قيمة الفاتورة</label>
                                    <input class="form-control fc-datepicker" id="amount_collection" type="text" disabled>
                                </div>

                                <div class="col">
                                    <label>قيمة العمولة</label>
                                    <input class="form-control fc-datepicker" id="amount_commission" type="text" disabled>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label class="control-label">مبلغ الخصم</label>
                                    <input type="text" class="form-control" id="discount" disabled>
                                </div>

                                <div class="col">
                                    <label>نسبة الضريبة</label>
                                    <input class="form-control fc-datepicker" id="rate_vat" type="text" disabled>
                                </div>

                                <div class="col">
                                    <label>قيمة الضريبة</label>
                                    <input class="form-control fc-datepicker" id="value_vat" type="text" disabled>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label>اجمالي المبلغ المستحق</label>
                                    <input class="form-control fc-datepicker" id="total" type="text" disabled>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label>ملاحظات</label>
                                    <textarea class="form-control fc-datepicker" id="note" type="text" disabled></textarea>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label>مرفقات</label>
                                    <img src="" id="imageA" alt="photo">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Add modal -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>

    <script>
        $('#modaldemo1').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            var invoice_number = button.data('invoice_number')
            var invoice_date = button.data('invoice_date')
            var due_date = button.data('due_date')

            var product_name = button.data('product_name')
            var amount_collection = button.data('amount_collection')
            var amount_commission = button.data('amount_commission')

            var discount = button.data('discount')
            var rate_vat = button.data('rate_vat')
            var value_vat = button.data('value_vat')

            var total = button.data('total')

            var note = button.data('note')

            var image = button.data('image')

            var modal = $(this)
            modal.find('.modal-body #invoice_number').val(invoice_number);
            modal.find('.modal-body #invoice_date').val(invoice_date);
            modal.find('.modal-body #due_date').val(due_date);

            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #amount_collection').val(amount_collection);
            modal.find('.modal-body #amount_commission').val(amount_commission);

            modal.find('.modal-body #discount').val(discount);
            modal.find('.modal-body #rate_vat').val(rate_vat);
            modal.find('.modal-body #value_vat').val(value_vat);

            modal.find('.modal-body #total').val(total);

            modal.find('.modal-body #note').val(note);

            modal.find('.modal-body #image').val(image);

            $("#imageA").attr('src', "{{\Illuminate\Support\Facades\Storage::url('')}}"+ image)



        })
    </script>
@endsection
