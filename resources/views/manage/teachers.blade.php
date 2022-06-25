@extends('layouts.app')
@section('title', 'Teachers - TeckQuiz')
@section('content')
<style>
    body {
        padding-top: 70px;
    }
</style>
<div class="container">
    <h1>Teachers</h1>
    <div class="row">
        <div class="col-9">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Teacher's Name</th>
                        <th>Username</th>
                        <th>Classes</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $t)
                    <tr>
                        <th scope="row">{{ $t->usr_id }}</th>
                        <td>
                            {{ $t->user_profile->family_name }}, {{ $t->user_profile->given_name }} {{ $t->user_profile->ext_name}} {{ $t->user_profile->middle_name
                            }}.
                        </td>
                        <td>{{$t->usr}}</td>
                        <td>{{ $t->classe->count() }}</td>
                        <td>
                            <button href="" class="btn btn-danger btn-sm" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#deleteTeacher"
                                data-tid="{{ $t->usr_id }}">
                                Delete
                            </button>
                            <button href="" class="btn btn-warning btn-sm" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#resetTeacherPassword"
                                data-tid="{{ $t->usr_id }}">
                                Reset Password
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-3">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSubject">Add new teacher</button>
        </div>

    </div>

    <!-- Add Teacher Modal -->
    <div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-labelledby="AddSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/account">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="">Name</label>
                            <div class="form">
                                <input name="n_given" id="n_given" type="text" placeholder="Given name" class="form-control mb-2">
                                <input name="n_middle" id="n_middle" type="text" placeholder="M.I." class="form-control mb-2">
                                <input name="n_family" id="n_family" type="text" placeholder="Family name" class="form-control mb-2">
                                <input name="n_ext" id="n_ext" type="text" placeholder="Ext." class="form-control mb-2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input name="usr" id="usr" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input pattern=".{8,}" name="password" id="password" type="password" class="form-control">
                            <small class="form-text text-muted">At least 8 characters</small>
                        </div>
                        <div class="form-group">
                            <button type="submit" onclick="" class="btn btn-success btn-block">Register</button>
                            <small class="form-text text-muted text-center">By clicking "Register", the teacher agree to our terms of service and privacy policy.</small>
                        </div>
                        <input type="hidden" name="permission" id="permission" value="1">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Teacher password Confirmation Modal -->
    <div class="modal fade" id="resetTeacherPassword" tabindex="-1" role="dialog" aria-labelledby="resetTeacherPassword" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm reset of password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure to reset this teacher's password?
                    <input type="hidden" id="t_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="ResetTeacherPassword()">Reset password</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Teacher password Success Modal -->
    <div class="modal fade" id="resetTeacherPasswordSuccess" tabindex="-1" role="dialog" aria-labelledby="resetTeacherPassword"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Successful reset of password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Success! The password is reseted to:
                    <b>password</b>
                    <input type="hidden" id="t_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Teacher Confirmation Modal -->
    <div class="modal fade" id="deleteTeacher" tabindex="-1" role="dialog" aria-labelledby="DeleteSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm deletion of teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this teacher? Any classes under this teacher will also be deleted. <b>This is irreversible!</b>
                    <input type="hidden" id="tid_del" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="DeleteTeacher()">Delete Question</button>
                </div>
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

    $('#deleteTeacher').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var t_id = button.data('tid')

        var modal = $(this)
        modal.find('#tid_del').val(t_id)
    });

    $('#resetTeacherPassword').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var t_id = button.data('tid')

        var modal = $(this)
        modal.find('#t_id').val(t_id)
    });

    function ResetTeacherPassword() {
        var t_id = $('#t_id').val();
        var password = "password";
        var update_type = 1;
        $.ajax({
            url: '/account/' + t_id,
            type: 'PUT', //type is any HTTP method
            data: {
                update_type, password
            }, //Data as js object
            success: function () {
                $('#resetTeacherPassword').modal('hide')
                $('#resetTeacherPasswordSuccess').modal('show')
            }
        });
    }

    function DeleteTeacher() {
            var t_id = $('#tid_del').val();
            $.ajax({
                url: '/account/' + t_id,
                type: 'DELETE', //type is any HTTP method
                success: function () {
                    window.location.reload(true);
                }
            });
        }
</script>

@endsection