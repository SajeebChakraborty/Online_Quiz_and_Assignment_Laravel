@extends('layouts.app')
@section('title', 'Subjects - TeckQuiz')
@section('content')
<style>
    body {
        padding-top: 70px;
    }
</style>
<div class="container">
    <h1>Subjects</h1>
    <div class="row">
        <div class="col-9">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject Code</th>
                        <th>Description</th>
                        <th>Classes</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $s)
                    <tr>
                        <th scope="row">{{ $s->subject_id }}</th>
                        <td>{{$s->subject_code}}</td>
                        <td>{{$s->subject_desc}}</td>
                        <td>{{$s->classe->count()}}</td>
                        <td>
                            <button href="" class="btn btn-primary btn-sm" type="button" class="btn btn-primary btn-sm"
                                data-toggle="modal" data-target="#editSubject"
                                data-subid="{{ $s->subject_id }}"
                                data-code="{{ $s->subject_code }}"
                                data-dscr="{{ $s->subject_desc }}">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm" data-subid="{{ $s->subject_id }}" data-toggle="modal" data-target="#deleteSubject" {{ $s->classe->count() > 0 ? 'disabled' : '' }}>Delete</button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-3">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSubject">Add new subject</button>
        </div>
    </div>
</div>
<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubject" tabindex="-1" role="dialog" aria-labelledby="EditSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form">
                    <input type="hidden" id="usrid" value="-1">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">Subject Code</label>
                            <input id="sub_code" type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Subject Description</label>
                            <input id="sub_des" type="text" class="form-control" placeholder="">
                        </div>
                        <input type="hidden" id="sub_id">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="UpdateSubject()">Update Subject</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-labelledby="AddSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form">
                    <input type="hidden" id="usrid" value="-1">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">Subject Code</label>
                            <input id="s_code_new" type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Subject Description</label>
                            <input id="s_desc_new" type="text" class="form-control" placeholder="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="AddSubject()">Add Subject</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Subject Confirmation Modal -->
<div class="modal fade" id="deleteSubject" tabindex="-1" role="dialog" aria-labelledby="DeleteSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Warning!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this subject? This is irreversible!
                <input type="hidden" id="sub_id_del" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="DeleteSubject()">Delete Subject</button>
            </div>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#editSubject').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var s_id = button.data('subid')
        var s_code = button.data('code')
        var s_des = button.data('dscr')
        

        var modal = $(this)
        modal.find('#sub_code').val(s_code)
        modal.find('#sub_des').val(s_des)
        modal.find('#sub_id').val(s_id);
    });

    $('#deleteSubject').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var s_id = button.data('subid')

        var modal = $(this)
        modal.find('#sub_id_del').val(s_id)
    });

    function UpdateSubject() {
        var s_id = $('#sub_id').val();
        var s_code = $('#sub_code').val();
        var s_des = $('#sub_des').val();


        $.ajax({
            url: '/subjects/' + s_id,
            type: 'PUT', //type is any HTTP method
            data: {
                s_code, s_des
            }, //Data as js object
            success: function () {
                window.location.reload(true);
            }
        });
    }

    function AddSubject() {
        var s_code = $('#s_code_new').val();
        var s_des = $('#s_desc_new').val();


        $.ajax({
            url: '/subjects/',
            type: 'POST', //type is any HTTP method
            data: {
                s_code, s_des
            }, //Data as js object
            success: function () {
                window.location.reload(true);
            }
        });
    }

    function DeleteSubject() {
        var s_id = $('#sub_id_del').val();

        $.ajax({
            url: '/subjects/' + s_id,
            type: 'DELETE', //type is any HTTP method
            success: function () {
                window.location.reload(true);
            }
        });
    }
</script>

@endsection