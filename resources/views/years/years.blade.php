@extends('layouts.master')
@section('title','إدارة السنين')

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Owl Carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
<!---Internal  Multislider css-->
<link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
<!--- Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">إعدادات الوقت</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة السنين</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    @include('layouts.maseg')

    <div class="col-xl-12">
        <div class="card mg-b-20">
            @can('اضافة سنة')
            <div class="card-header pb-0">

                <div class="d-flex justify-content-between">
                   <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20 mg-xl-t-0">
										<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-newspaper" data-toggle="modal" href="#modaldemo8">  اضافة سنة جديدة </a>
									</div>
                  
                       
                </div>
            </div>
            @endcan

            <div class="card-body">
                <div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>السنة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($years as $year)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="javascript:void(0)" onclick="editYear('{{ $year->id }}','{{ $year->year }}')">
                                        {{ $year->year }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Add Year Modal -->
    		<div class="modal" id="modaldemo8">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
                        <h6 class="modal-title">اضافة سنة جديدة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                <form action="{{ route('years.store') }}" method="POST">
                    @csrf
                   
                    <div class="modal-body">
                        <input type="text" class="form-control" name="year" placeholder="أدخل السنة">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">حفظ</button>
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">رجوع</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <!-- Edit Year Modal -->
    <div class="modal fade" id="editYearModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editYearForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل السنة</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="editYearName" name="year">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">حفظ التعديلات</button>
                        @can('حذف سنة')
                        <button class="btn btn-danger" type="button" id="deleteYearBtn">حذف</button>
                        @endcan
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">رجوع</button>
                    </div>
                </form>
<!-- مربع تأكيد الحذف -->
<div id="deleteYearConfirmBox"class="p-2 border rounded bg-light text-center d-none" 
     style="position:absolute; bottom:50px; right:100px; width:220px; box-shadow:0 3px 10px rgba(0,0,0,0.2);">
    <small class="d-block mb-2 text-muted">هل تريد التأكيد؟</small>
    <form id="deleteYearForm" method="POST">
        @csrf
        @method('DELETE') 
        <button class="btn btn-sm btn-danger mx-1" type="submit">نعم</button>
        <button class="btn btn-sm btn-secondary mx-1" type="button" id="cancelDelete">لا</button>
    </form>
</div>
                
            </div>
        </div>
    </div>

</div>
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
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
function editYear(id, year) {
    document.getElementById('editYearName').value = year;
    const editForm = document.getElementById('editYearForm');
    editForm.action = '/years/' + id;
    document.getElementById('deleteYearForm').action = '/years/' + id;
    document.getElementById('deleteYearConfirmBox').classList.add('d-none');
    $('#editYearModal').modal('show');
}

// Delete buttons
const deleteBtn = document.getElementById('deleteYearBtn');
if(deleteBtn){
    deleteBtn.addEventListener('click', ()=> document.getElementById('deleteYearConfirmBox').classList.remove('d-none'));
}
document.getElementById('cancelDeleteYear')?.addEventListener('click', ()=>{
    document.getElementById('deleteYearConfirmBox').classList.add('d-none');
});
</script>
@endsection
