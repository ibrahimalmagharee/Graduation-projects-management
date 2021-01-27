@extends('layouts.main')
@section('title')
    ٍStudent
    @endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Students
                        <a class="btn btn-primary float-right" href="javascript:void(0)" id="addNewStudent"><i class="now-ui-icons ui-1_simple-add"></i>Add New Student</a>
                    </h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped data-table" id="student-table">
                            <thead class="text-primary">
                            <tr>
                                <th class="width">ID</th>

                                <th class="width">Student-ID</th>

                                <th class="width">Name</th>

                                <th class="width">Email</th>

                                <th class="width">Specialization</th>

                                <th class="width">Level</th>

                                <th class="width">Action</th>



                            </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="studentmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalheader"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="studentForm" name="studentForm" class="form-horizontal">
                    {{csrf_field()}}

                    <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label class="col-form-label">Student-ID</label>
                            <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Student-ID" value="" required="">
                            <div class="is-valid"></div>
                            <div class="is-invalid"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="">
                            <div class="is-valid"></div>
                            <div class="is-invalid"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="student@gmail.com" value="">
                            <div class="is-valid"></div>
                            <div class="is-invalid"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Specialization</label>
                            <select class="form-control" name="specialization" id="specialization">
                                <option value="Computer System Engineerin">Computer System Engineering</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Mechatronics Engineering">Mechatronics Engineering</option>
                                <option value="Communications Engineering">Communications Engineering</option>
                                <option value="Medical Equipment Engineering">Medical Equipment Engineering</option>
                            </select>
                            <div class="is-valid"></div>
                            <div class="is-invalid"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Level</label>
                            <div class="form-check">
                                <input class="form-check-input level" type="radio" name="level" id="level_four" value="Level Four" {{ (old('level') == 'Level Four') ? 'checked' : '' }} required>
                                <label class="form-check-label">Level Four</label>
                                <div class="is-valid"></div>
                                <div class="is-invalid"></div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input level" type="radio" name="level" id="level_five" value="Level Five" {{ (old('level') == 'Level Five') ? 'checked' : '' }} required>
                                <label class="form-check-label">Level Five</label>
                                <div class="is-valid"></div>
                                <div class="is-invalid"></div>
                            </div>
                        </div>



                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="addStudent">Add Student</button>
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
                        <input type="hidden" id="delete_student_id">
                        <h5>Are You Sure ? To Delete This Student !!</h5>
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
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route("view_student")}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'student_id', name: 'student_id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'specialization', name: 'specialization'},
                    {data: 'level', name: 'level'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#addNewStudent').click(function () {
                $('#addStudent').val('Add Student');
                $('#id').val('');
                $('#studentForm').trigger('reset');
                $('#modalheader').html('Add New Student');
                $('#studentmodal').modal('show');

            });


            $(document).on('click', '.editStudent', function () {
                var id = $(this).data('id');

                $.get("{{route('student.index')}}"+'/'+id+'/edit', function (data) {
                    $('#modalheader').html('Edit Student');
                    $('#addStudent').html('Edit Student');
                    $('#studentmodal').modal('show');
                    $('#id').val(data.id);
                    $('#student_id').val(data.student_id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#specialization').val(data.specialization);
                    $('.level:checked').val(data.level);


                })
            });

            $('#addStudent').click(function (e) {
                e.preventDefault();

                $.ajax({
                    data: $('#studentForm').serialize(),
                    url: "{{ route('student.store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        $('#studentForm').trigger('reset');
                        $('#addStudent').val('Add Student');
                        $('#studentmodal').modal('hide');
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

                $('#delete').click(function(e){
                    e.preventDefault();
                    $.ajax({

                        url: "student/destroy/"+id,

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
