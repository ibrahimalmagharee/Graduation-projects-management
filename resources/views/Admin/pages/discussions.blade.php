@extends('layouts.main')
@section('title')
    Discussions
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Discussions
                        <a class="btn btn-primary float-right" href="javascript:void(0)" id="addNewDiscussion"><i class="now-ui-icons ui-1_simple-add"></i>Add New Discussion</a>
                    </h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped data-table">
                            <thead class=" text-primary">
                            <th class="width">ID</th>

                            <th class="width">Group Number</th>

                            <th class="width">Discussions Date</th>

                            <th class="width">Discussion Time</th>

                            <th class="width">Discussion Place</th>

                            <th class="width">Discussant</th>

                            <th class="width">Action</th>

                            </thead>

                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="discussionmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalheader"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="discussionForm" name="discussionForm" class="form-horizontal">
                    {{csrf_field()}}
                    <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label class="col-form-label">Group Number</label>
                            <select id="group" name="group" class="form-control">
                                @foreach(\App\Admin\Group::all() as $group)
                                <option value="{{$group->group_number}}">{{$group->group_number}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Discussions Date</label>
                            <input type="date" name="discussion_date" id="discussion_date"  class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Discussion Time</label>
                            <input type="time" name="discussion_time" id="discussion_time"  class="form-control" placeholder="Discussion Time" value="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Discussion Place</label>
                            <input type="text" name="discussion_place" id="discussion_place"  class="form-control" placeholder="Discussion Place" value="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Discussant</label>
                            <select id="discussant" name="discussant[]" multiple="multiple" class="form-control" style="width:100%; ">
                                <option value="Discussant 1">Discussant 1</option>
                                <option value="Discussant 2">Discussant 2</option>
                                <option value="Discussant 3">Discussant 3</option>
                            </select>
                        </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="addDiscussion">Add Discussion</button>
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
                        <h5>Are You Sure ? To Delete This Discussion !!</h5>
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
            $('#discussant').select2();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route("view_discussion")}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'group', name: 'group'},
                    {data: 'discussion_date', name: 'discussion_date'},
                    {data: 'discussion_time', name: 'discussion_time'},
                    {data: 'discussion_place', name: 'discussion_place'},
                    {data: 'discussant', name: 'discussant'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#addNewDiscussion').click(function () {
                $('#addDiscussion').val('Add Discussion');
                $('#id').val('');
                $('#discussionForm').trigger('reset');
                $('#modalheader').html('Add New Discussion');
                $('#discussionmodal').modal('show');

            });


            $(document).on('click', '.editDiscussion', function () {
                var id = $(this).data('id');

                $.get("{{route('discussion.index')}}"+'/'+id+'/edit', function (data) {
                    $('#modalheader').html('Edit Discussion');
                    $('#addDiscussion').html('Edit Discussion');
                    $('#discussionmodal').modal('show');
                    $('#id').val(data.id);
                    $('#group').val(data.group);
                    $('#discussion_date').val(data.discussion_date);
                    $('#discussion_time').val(data.discussion_time);
                    $('#discussion_place').val(data.discussion_place);
                    $('#discussant').val(data.discussant);


                })
            });

            $('#addDiscussion').click(function (e) {
                e.preventDefault();

                $.ajax({
                    data: $('#discussionForm').serialize(),
                    url: "{{ route('discussion.store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        $('#discussionForm').trigger('reset');
                        $('#addDiscussion').val('Add Discussion');
                        $('#discussionmodal').modal('hide');
                        table.draw();
                        console.log('success: added', data);
                    },

                    error: function (data) {
                        console.log('Error: not added', data);
                        $('#addDiscussion').html('Add Discussion');
                    }

                });
            });



            $('body').on('click', '.delete', function () {
                var id = $(this).data('id');
                $('#deletemodal').modal('show');

                $('#delete').click(function(e){
                    e.preventDefault();
                    $.ajax({

                        url: "discussion/destroy/"+id,

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
