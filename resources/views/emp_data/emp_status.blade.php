@extends('layouts.master')
@section('title','حالات الموظفين ')

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
                 <h4 class="content-title mb-0 my-auto">إدارة الموظفين</h4>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/  حالات الموظفين </span>
						</div>
					</div>
			
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">

				@include('layouts.maseg')
    <div class="col-xl-12">

        <!-- فلترة -->
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4">
                        <label>الإدارة</label>
                        <select name="department_id" id="department_id" class="form-control">
                            <option value="">اختر الإدارة</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>الوظيفة</label>
                        <select name="job_id" id="job_id" class="form-control">
                            <option value="">اختر الوظيفة</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

					<!--div-->
					<div class="col-xl-12">


						<div class="card mg-b-20">
						
							<div class="card-body">
								<div class="table-responsive">
                                    <table id="emp_status_table" class="table key-buttons text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">اسم الموظف</th>										
                                                <th class="border-bottom-0">الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                             
                                        </tbody>
                                    </table>
								</div>
							</div>
						
					</div>
					<!--/div-->


				

<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title">تعديل حالة الموظف</h6>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم الموظف</label>
                        <input type="text" id="edit_full_name" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                    <label>الحالة</label>
                    <select name="status" id="edit_status" class="form-control">
                        <option value="نشط">نشط</option>
                        <option value="غير نشط">غير نشط</option>
                        <option value="تم استقالته">تم استقالته</option>
                        <option value="على المعاش">على المعاش</option>
                        <option value="إجازة طويلة">إجازة طويلة</option>
                        <option value="إيقاف مؤقت">إيقاف مؤقت</option>
                    </select>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">حفظ</button>
                    <button class="btn btn-secondary" data-dismiss="modal">رجوع</button>
                </div>
            </form>

        </div>
    </div>
</div>

  </div>

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

<script>$(document).ready(function () {

    let savedDepartment = localStorage.getItem('filter_department');
    let savedJob = localStorage.getItem('filter_job');

    let table = $('#emp_status_table').DataTable({
        processing: true,
        paging: true,
        searching: false,
        ordering: true,
        info: true,
        ajax: {
            url: '/employees_status/filter',
            type: 'GET',
            data: function (d) {
                d.department_id = $('#department_id').val();
                d.job_id = $('#job_id').val();
            },
            dataSrc: function (json) {
                // الجدول فارغ إذا لم يتم اختيار الإدارة أو الوظيفة
                if (!$('#department_id').val() || !$('#job_id').val()) return [];
                return json || [];
            }
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { 
                data: 'full_name',
                render: function (data, type, row) {
                    return `<a href="javascript:void(0)" onclick="openEditModal(${row.id}, '${row.full_name}', '${row.status}')">${data}</a>`;
                }
            },
            {
                data: 'status',
                render: function (data, type, row) {
                    let badge = data === 'نشط' ? 'badge-success' : 'badge-danger';
                    return `<span class="badge ${badge}" style="cursor:pointer" onclick="openEditModal(${row.id}, '${row.full_name}', '${data}')">${data}</span>`;
                }
            }
        ],
        language: { emptyTable: 'يرجى اختيار الإدارة والوظيفة أولاً' }
    });

    // --- وظيفة تحميل الوظائف عند اختيار الإدارة ---
    function loadJobs(departmentId, callback) {
        $('#job_id').html('<option value="">اختر الوظيفة</option>');
        if (departmentId) {
            $.get('/department/' + departmentId + '/jobs', function (data) {
                $.each(data, function (i, job) {
                    $('#job_id').append(`<option value="${job.id}">${job.job_name}</option>`);
                });
                if (callback) callback();
            });
        }
    }

    // --- تطبيق الفلاتر المحفوظة عند التحميل ---
    if (savedDepartment) {
        $('#department_id').val(savedDepartment);
        loadJobs(savedDepartment, function() {
            if (savedJob) {
                $('#job_id').val(savedJob);
                table.ajax.reload();
            }
        });
    }

    // --- تغيير الإدارة ---
    $('#department_id').on('change', function () {
        let departmentId = $(this).val();
        localStorage.setItem('filter_department', departmentId);
        localStorage.setItem('filter_job', '');

        loadJobs(departmentId, function() {
            table.clear().draw();
        });
    });

    // --- تغيير الوظيفة ---
    $('#job_id').on('change', function () {
        localStorage.setItem('filter_job', $(this).val());
        table.ajax.reload();
    });

});

// --- فتح المودال لتعديل الحالة ---
function openEditModal(id, name, status) {
    $('#edit_full_name').val(name);
    $('#edit_status').val(status);
    $('#editForm').attr('action', '/employees/' + id + '/status');
    $('#editModal').modal('show');
}

</script>

		
<script>
function openEditModal(id, name, status) {
    $('#edit_full_name').val(name);
    $('#edit_status').val(status);

    $('#editForm').attr('action', '/employees/' + id + '/status');

    $('#editModal').modal('show');
}
</script>

@endsection