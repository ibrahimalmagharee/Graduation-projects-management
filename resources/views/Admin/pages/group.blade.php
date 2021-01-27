@extends('layouts.main')
@section('title')
    Groups
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Groups
                        <a class="btn btn-primary float-right" href="javascript:void(0)" id="addNewGroup"><i class="now-ui-icons ui-1_simple-add"></i>Add New Group</a>
                    </h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped data-table">
                            <thead class=" text-primary">
                            <th class="width">ID</th>

                            <th class="width">Group Number</th>

                            <th class="width">Students</th>

                            <th class="width">Project</th>

                            <th class="width">ٍٍSupervisor</th>

                            <th class="width">Action</th>


                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="groupmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalheader"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="groupForm" name="groupForm" class="form-horizontal">
                        {{csrf_field()}}

                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label class="col-form-label">Group Number</label>
                            <input type="text" name="group_number"  id="group_number" class="form-control" placeholder="Group Number" value="">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Students</label>
                            <select id="student" name="student[]" multiple="multiple" class="form-control" style="width:100%;">
                                @foreach(\App\Admin\Student::all() as $name_student)
                                <option value="{{$name_student->student_id}}">{{$name_student->name}}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Project</label>
                            <select id="project" name="project" class="form-control">
                                @foreach(\App\Admin\Project::all() as $title_project)
                                <option value="{{$title_project->id}}">{{$title_project->title}}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">ٍٍSupervisor</label>
                            <select id="supervisor" name="supervisor" class="form-control">
                                <option value="supervisor 1">supervisor 1</option>
                                <option value="supervisor 2">supervisor 2</option>
                                <option value="supervisor 3">supervisor 3</option>
                            </select>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="addGroup">Add Group</button>
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
                        <input type="hidden" id="delete_group_id">
                        <h5>Are You Sure ? To Delete This Group !!</h5>
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
            $('#student').select2();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route("view_group")}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'group_number', name: 'group_number'},
                    {data: 'student', name: 'student'},
                    {data: 'project', name: 'project'},
                    {data: 'supervisor', name: 'supervisor'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#addNewGroup').click(function () {
                $('#addGroup').val('Add Group');
                $('#id').val('');
                $('#groupForm').trigger('reset');
                $('#modalheader').html('Add New Group');
                $('#groupmodal').modal('show');

            });


            $(document).on('click', '.editGroup', function () {
                var id = $(this).data('id');

                $.get("{{route('group.index')}}"+'/'+id+'/edit', function (data) {
                    $('#modalheader').html('Edit Group');
                    $('#addGroup').html('Edit Group');
                    $('#groupmodal').modal('show');
                    $('#id').val(data.id);
                    $('#group_number').val(data.group_number);
                    $('#student').val(data.student);
                    $('#project').val(data.project);
                    $('#supervisor').val(data.supervisor);


                })

            });

            $('#addGroup').click(function (e) {
                e.preventDefault();

                $.ajax({
                    data: $('#groupForm').serialize(),
                    url: "{{ route('group.store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        $('#groupForm').trigger('reset');
                        $('#addGroup').val('Add Group');
                        $('#groupmodal').modal('hide');
                        table.draw();
                        console.log('success: added', data);
                    },

                    error: function (data) {
                        console.log('Error: not added', data);
                        $('#addGroup').html('Add Group');
                    }

                });
            });


            $('body').on('click', '.delete', function () {
                var id = $(this).data('id');
                $('#deletemodal').modal('show');

                $('#delete').click(function(e){
                    e.preventDefault();
                    $.ajax({

                        url: "group/destroy/"+id,

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
