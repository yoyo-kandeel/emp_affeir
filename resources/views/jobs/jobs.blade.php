@extends('layouts.master')
@section('title',' الوظائف')

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
					<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الأقسام و الوظائف</h4>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الوظائف </span>
						</div>
					</div>
			
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">

				@include('layouts.maseg')


					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							@can('اضافة وظيفة')
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<div class="col-sm-6 col-md-4 col-xl-3 mg-t-20 mg-xl-t-0">
										<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-newspaper" data-toggle="modal" href="#modaldemo8">اضافة وظيفة جديد</a>
									</div>
							</div>
                            </div>
                            @endcan

							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">اسم الوظيفة</th>		
                                                <th class="border-bottom-0">اسم الادارة</th>		
												<th class="border-bottom-0">الملاحظات</th>
											</tr>
										</thead>
										<tbody>
											@foreach($jobs as $job)
											<tr> 
												<td>{{ $loop->iteration }}</td>
												<td>
												   <a href="javascript:void(0)" onclick="editjob('{{ $job->id }}','{{ $job->job_name }}','{{ $job->description }}','{{ $job->department_id }}')">
                                                    {{ $job->job_name }}</a>

												</td>
                                               <td>{{ $job->department->department_name ?? 'الاداره محذوف' }}</td>
												<td>{{ $job->description }}</td>
											</tr>
											@endforeach
											 
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->

<!-- Modal effects -->
		<div class="modal" id="modaldemo8">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة وظيفة جديدة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<form  action="{{ route('jobs.store') }}" method="post">
						{{ csrf_field() }}
					<div class="modal-body">
					
                    <div class="form-group">
							<label for="departmentName">اسم الادارة</label>
							<select class="form-control" id="departmentName" name="department_id">
								@foreach($departments as $department)
									<option value="{{ $department->id }}">{{ $department->department_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="jobName">اسم الوظيفة</label>
							<input type="text" class="form-control" id="jobName" placeholder="أدخل اسم الوظيفة" name="job_name" >
						</div>
						<div class="form-group">
							<label for="jobNotes">الملاحظات</label>
							<textarea class="form-control" id="jobNotes" placeholder="أدخل الملاحظات" rows="3" name="description"></textarea>
						</div>
					
				</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="submit">حفظ </button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">رجوع</button>
					</div>
					</form>
				</div>
                 
			</div>
		</div>
		<!-- End Modal effects-->
				
			
			<!-- Edit Modal -->
			 @can('تعديل وظيفة')
<div class="modal" id="editModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل الوظيفة</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="editForm" method="post" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-body">
                    <div class="form-group">
                      <label>اسم الادارة</label>
            <select class="form-control select2" id="editdepartmentId" name="department_id" >
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                </select>

                    </div>
                    <div class="form-group">
                        <label for="editjobName">اسم الوظيفة</label>
                        <input type="text" class="form-control" id="editjobName" name="job_name">
                    </div>
                    <div class="form-group">
                        <label for="editjobNotes">الملاحظات</label>
                        <textarea class="form-control" id="editjobNotes" rows="3" name="description"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer" style="position:relative;">
                    <button class="btn ripple btn-primary" type="submit">حفظ التعديلات</button>
                        

                    </form>
                       @can('حذف وظيفة')
                    <!-- زر الحذف -->
                 <button class="btn ripple btn-danger" id="deleteBtn" type="button">حذف</button>
                        @endcan
<!-- مربع تأكيد الحذف -->
 <div id="deleteConfirmBox" class="p-2 border rounded bg-light text-center d-none" 
     style="position:absolute; bottom:50px; right:100px; width:220px; box-shadow:0 3px 10px rgba(0,0,0,0.2);">
    <small class="d-block mb-2 text-muted">هل تريد التأكيد؟</small>
    <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE') 
        <button class="btn btn-sm btn-danger mx-1" type="submit">نعم</button>
        <button class="btn btn-sm btn-secondary mx-1" type="button" id="cancelDelete">لا</button>
    </form>
</div>


                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">رجوع</button>
                </div>
            
        </div>
    </div>
	@endcan
  </div>
</div>
				<!-- row closed -->	


		 
		
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

		
<!-- JS -->
<script>
let jobId;

function editjob(id, name, description) {
    jobId = id;
    document.getElementById('editjobName').value = name;
    document.getElementById('editjobNotes').value = description;

    // فورم التعديل
    document.getElementById('editForm').action = '/jobs/' + id;

    // فورم الحذف
    document.getElementById('deleteForm').action = '/jobs/' + id;

    // إخفاء مربع التأكيد عند فتح المودال
    document.getElementById('deleteConfirmBox').classList.add('d-none');

    $('#editModal').modal('show');
}


// إظهار مربع التأكيد
document.getElementById('deleteBtn').addEventListener('click', function() {
    document.getElementById('deleteConfirmBox').classList.remove('d-none');
});

// إخفاء مربع التأكيد
document.getElementById('cancelDelete').addEventListener('click', function() {
    document.getElementById('deleteConfirmBox').classList.add('d-none');
});


</script>
@endsection