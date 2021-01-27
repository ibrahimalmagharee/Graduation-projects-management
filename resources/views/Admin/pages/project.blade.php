@extends('layouts.main')
@section('title')
    Projects
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Projects
                        <a class="btn btn-primary float-right" href="javascript:void(0)" id="addNewProject"><i class="now-ui-icons ui-1_simple-add"></i>Add New Project</a>
                    </h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped data-table">
                            <thead class=" text-primary">
                            <th width="5">ID</th>

                            <th width="20">Project Title</th>

                            <th width="20">Programming Type</th>

                            <th width="20">Project Suggester</th>

                            <th width="30">Description</th>

                            <th width="15">Publish Date</th>

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


    <div class="modal fade" id="projectmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalheader"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="projectForm" name="projectForm" class="form-horizontal">
                    {{csrf_field()}}

                    <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label class="col-form-label">Project Title</label>
                            <input type="text" name="title" id="title"  class="form-control" placeholder="Project Title" value="">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Programming Type</label>
                            <select id="programming_type" class="form-control" name="programming_type">
                                <option value="Web">web</option>
                                <option value="Android">Android</option>
                                <option value="DeskTop"> DeskTop</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Project Suggester</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input suggester" id="student_suggester" name="suggester" value="Student">
                                <label class="form-check-label">Student</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input suggester" id="doctor_suggester" name="suggester" value="Doctor">
                                <label class="form-check-label">Doctor</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Description</label>
                            <textarea class="form-control" id="description" rows="5" placeholder="Description ..." name="description"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Publish Date</label><br>
                            <input type="date" name="publish_date" id="publish_date" class="form-control">
                        </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="addProject">Add Project</button>
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
                        <input type="hidden" id="delete_project_id">
                        <h5>Are You Sure ? To Delete This Project !!</h5>
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
                ajax: "{{route("view_project")}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'programming_type', name: 'programming_type'},
                    {data: 'suggester', name: 'suggester'},
                    {data: 'description', name: 'description'},
                    {data: 'publish_date', name: 'publish_date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#addNewProject').click(function () {
                $('#addProject').val('Add Project');
                $('#id').val('');
                $('#projectForm').trigger('reset');
                $('#modalheader').html('Add New Project');
                $('#projectmodal').modal('show');

            });


            $(document).on('click', '.editProject', function () {
                var id = $(this).data('id');

                $.get("{{route('project.index')}}"+'/'+id+'/edit', function (data) {
                    $('#modalheader').html('Edit Project');
                    $('#addProject').html('Edit Project');
                    $('#projectmodal').modal('show');
                    $('#id').val(data.id);
                    $('#title').val(data.title);
                    $('#programming_type').val(data.programming_type);
                    $('.suggester:checked').val(data.suggester);
                    $('#description').val(data.description);
                    $('#publish_date').val(data.publish_date);


                })

            });

            $('#addProject').click(function (e) {
                e.preventDefault();

                $.ajax({
                    data: $('#projectForm').serialize(),
                    url: "{{ route('project.store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        $('#projectForm').trigger('reset');
                        $('#addProject').val('Add Project');
                        $('#projectmodal').modal('hide');
                        table.draw();
                    },

                    error: function (data) {
                        console.log('Error: not added', data);
                        $('#addProject').html('Add Project');
                    }

                });
            });


            $('body').on('click', '.delete', function () {
                var id = $(this).data('id');
                $('#deletemodal').modal('show');

                $('#delete').click(function(e){
                    e.preventDefault();
                    $.ajax({

                        url: "project/destroy/"+id,

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
