@extends('layouts.main')
@section('title')
    Teacher
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Teacher
                        <a class="btn btn-primary float-right" href="javascript:void(0)" id="addNewTeacher"><i class="now-ui-icons ui-1_simple-add"></i>Add New Teacher</a>
                    </h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="" class="table table-striped data-table">
                            <thead class=" text-primary">
                            <th class="width">ID</th>

                            <th class="width">Name</th>

                            <th class="width">Email</th>

                            <th class="width">Job</th>

                            <th class="width">Department</th>

                            <th class="width">Action</th>


                            </thead>

                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="teachermodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalheader"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="teacherForm" name="teacherForm" class="form-horizontal">
                        {{csrf_field()}}
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="teacher@gmail.com" value="">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Job</label>
                            <div class="form-check">
                                <input class="form-check-input job" type="radio" name="job"  value="Lecturer">
                                <label class="form-check-label" >Lecturer</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input job" type="radio" name="job"  value="Doctor">
                                <label class="form-check-label" >Doctor</label>
                            </div>
                            <div class="form-check">

                                <input class="form-check-input job" type="radio" name="job"  value="Assistant Professor">
                                <label class="form-check-label" >Assistant Professor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input job" type="radio" name="job" value="Co-Professor">
                                <label class="form-check-label" >Co-Professor</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Department</label>
                            <select class="form-control" name="department" id="department">
                                <option>Computer System Engineering</option>
                                <option>Computer Science</option>
                                <option>Mechatronics Engineering</option>
                                <option>Communications Engineering</option>
                                <option>Medical Equipment Engineering</option>
                            </select>
                        </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="addTeacher">Add Teacher</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
                </div>
        </div>
    </div>
    </div>

    {{-- Confirmation Modal --}}

       <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="delete_modal_form">
                    {{csrf_field()}}
                    {{method_field('delete')}}

        <div class="modal-body">
            <input type="hidden" id="delete_teacher_id">
            <h5>Are You Sure ? To Delete This Teacher !!</h5>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel">Cancel</button>
            <button type="submit" class="btn btn-danger" id="delete">Delete</button>
        </div>
    </form>
</div>
</div>
</div>
{{-- End Confirmation Modal --}}


@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route("view_teacher")}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'job', name: 'job'},
                    {data: 'department', name: 'department'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#addNewTeacher').click(function () {
                $('#addTeacher').val('Add Teacher');
                $('#id').val('');
                $('#teacherForm').trigger('reset');
                $('#modalheader').html('Add New Teacher');
                $('#teachermodal').modal('show');
            });

            $(document).on('click', '.editTeacher', function () {
                var id = $(this).data('id');

                $.get("{{route('teacher.index')}}"+'/'+id+'/edit', function (data) {
                    $('#addTeacher').html('Edit Teacher');
                    $('#modalheader').html('Edit Teacher');
                    $('#teachermodal').modal('show');
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('.job:checked').val(data.job);
                    $('#department').val(data.department);
                })
            });

            $('#addTeacher').click(function (e) {
                e.preventDefault();

                $.ajax({
                   data: $('#teacherForm').serialize(),
                    url: "{{route('teacher.store')}}",
                    type: 'post',
                    dataType: 'json',

                    success: function (data) {
                        $('#teacherForm').trigger('reset');
                        $('#addTeacher').val('Add Student');
                        $('#teachermodal').modal('hide');
                        table.draw();

                    },

                    error: function (data) {
                        console.log('Error: not added', data);
                        $('#addStudent').html('Add Student');
                    }
                });
            });

            $('body').on('click', '.delete', function () {
                var id = $(this).data('id');

                $('#deletemodal').modal('show');

                $('#delete').click(function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "teacher/destroy/"+id,
                        success: function (data) {
                            console.log('success:', data);
                            $('#deletemodal').modal('hide');
                            table.draw();
                        }
                    });
                });

                $('#cancel').click(function(){
                    $('#deletemodal').modal('hide');
                });

            });


        });
    </script>
@endsection
