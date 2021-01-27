@extends('layouts.main')
@section('title')
    Advertise
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Advertises
                        <a class="btn btn-primary float-right" href="javascript:void(0)" id="addNewAdvertise"><i class="now-ui-icons ui-1_simple-add"></i>Add New Advertise</a>
                    </h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped data-table">
                            <thead class=" text-primary">
                            <th class="width">ID</th>

                            <th class="width">Advertise Title</th>

                            <th class="width">Description</th>

                            <th class="width">Advertise File</th>

                            <th class="width">Publish Date</th>

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


    <div class="modal fade" id="advertisemodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalheader"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="advertiseForm" name="advertiseForm" class="form-horizontal">
                        {{csrf_field()}}

                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label class="col-form-label">Advertise Title</label>
                            <input type="text" name="title" id="title"  class="form-control" placeholder="Advertise Title" value="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="5" cols="4" placeholder="Description ..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Advertise File</label>
                            <input type="text" class="form-control-file" name="advertise_file" id="advertise_file">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Publish Date</label>
                            <input type="date" name="publish_date" id="publish_date" class="form-control">
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="addAdvertise">Add Advertise</button>
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
                        <input type="hidden" id="delete_advertise_id">
                        <h5>Are You Sure ? To Delete This Advertise !!</h5>
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
                ajax: "{{route("view_advertise")}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'advertise_file', name: 'advertise_file'},
                    {data: 'publish_date', name: 'publish_date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#addNewAdvertise').click(function () {
                $('#addAdvertise').val('Add Advertise');
                $('#id').val('');
                $('#advertiseForm').trigger('reset');
                $('#modalheader').html('Add New Advertise');
                $('#advertisemodal').modal('show');

            });


            $(document).on('click', '.editAdvertise', function () {
                var id = $(this).data('id');

                $.get("{{route('advertise.index')}}"+'/'+id+'/edit', function (data) {
                    $('#modalheader').html('Edit Advertise');
                    $('#addAdvertise').html('Edit Advertise');
                    $('#advertisemodal').modal('show');
                    $('#id').val(data.id);
                    $('#title').val(data.title);
                    $('#description').val(data.description);
                    $('#advertise_file').val(data.advertise_file);
                    $('#publish_date').val(data.publish_date);

                })
            });

            $('#addAdvertise').click(function (e) {
                e.preventDefault();

                $.ajax({
                    data: $('#advertiseForm').serialize(),
                    url: "{{ route('advertise.store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        $('#advertiseForm').trigger('reset');
                        $('#addAdvertise').val('Add Advertise');
                        $('#advertisemodal').modal('hide');
                        table.draw();
                    },

                    error: function (data) {
                        console.log('Error: not added', data);
                        $('#addAdvertise').html('Add Advertise');
                    }

                });
            });



            $('body').on('click', '.delete', function () {
                var id = $(this).data('id');
                $('#deletemodal').modal('show');

                $('#delete').click(function(e){
                    e.preventDefault();
                    $.ajax({

                        url: "advertise/destroy/"+id,

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
