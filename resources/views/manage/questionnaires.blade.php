@extends('layouts.app')
@section('title', 'Manage Questionnaire - TeckQuiz')
@section('content')
<style>
    body {
        padding-top: 90px;
    }
</style>
<section class="container">
    <h1>Manage Quiz</h1>
    <b>
        <p>{{ $q->questionnaire_name }}</p>
    </b>
    <hr>
    <div class="row">
        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="questions" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <h5>Questions</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Question Type</th>
                                <th>Choices</th>
                                <th>Controls</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($q->question as $qe)
                                <tr>
                                    <td>{{ $qe->question_name }}</td>
                                    <td>
                                        @if($qe->question_type == 1) Identification
                                        @elseif($qe->question_type == 2) Multiple choice
                                        @elseif($qe->question_type == 3) True or False 
                                        @else <b>Invalid Type</b>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $a = explode(';', $qe->choices);
                                            foreach ($a as $ch){ echo $ch . '<br>'; }
                                        @endphp
                                    </td>
                                    <td>
                                        @if($qe->question_type == 1)
                                            <button class="btn btn-primary btn-sm" data-qid="{{ $qe->question_id }}" data-question="{{ $qe->question_name }}" data-question-type="{{ $qe->question_type }}"
                                                data-correct-ans="{{ $qe->answer }}" data-points="{{ $qe->points }}" data-toggle="modal"
                                                data-target="#editQuestion">Edit
                                            </button>
                                        @elseif($qe->question_type == 2)
                                            <button class="btn btn-primary btn-sm" data-qid="{{ $qe->question_id }}" data-question="{{ $qe->question_name }}" data-question-type="{{ $qe->question_type }}"
                                                data-choices="{{ $qe->choices }}" data-correct-ans="{{ $qe->answer }}" data-points="{{ $qe->points }}"
                                                data-toggle="modal" data-target="#editQuestion">Edit
                                            </button>
                                        @elseif($qe->question_type == 3)
                                            <button class="btn btn-primary btn-sm" data-qid="{{ $qe->question_id }}" data-question="{{ $qe->question_name }}" data-question-type="{{ $qe->question_type }}"
                                                data-correct-ans="{{ $qe->answer }}" data-points="{{ $qe->points }}" data-toggle="modal"
                                                data-target="#editQuestion">Edit
                                            </button>
                                        @endif
                                        <button class="btn btn-primary btn-sm btn-danger" data-qid="{{ $qe->question_id }}" data-toggle="modal" data-target="#deleteQuestion">Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createQuestion">Add new question</button>
                </div>
                <div class="tab-pane fade " id="basic-info" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, inventore.
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                <a class="nav-link active" id="questions-tab" data-toggle="pill" href="#questions" role="tab" aria-controls="v-pills-profile" aria-expanded="true">Questions</a>
                {{--  <a class="nav-link" id="basic-info-tab" data-toggle="pill" href="#basic-info" role="tab" aria-controls="v-pills-home"
                    aria-expanded="true">Basic Information</a>  --}}
            </div>
        </div>


    </div>

</section>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestion" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Question</label>
                    <textarea id="question" id="" cols="30" rows="3" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Type</label>
                    <select name="" id="opt" class="form-control" required>
                        <option value="1">Identification</option>
                        <option value="2">Multiple Choice</option>
                        <option value="3">True or False</option>
                    </select>
                </div>
                <div id="f-multiple-choice" style="display: none;">
                    <div class="form-group form-inline">
                        <input type="text" id="mc0" name="mc[]" class="form-control col-5 mr-auto" placeholder="Choice 1">
                        <input type="text" id="mc1" name="mc[]" class="form-control col-5 ml-auto" placeholder="Choice 2">
                    </div>
                    <div class="form-group form-inline">
                        <input type="text" id="mc2" name="mc[]" class="form-control col-5 mr-auto" placeholder="Choice 3">
                        <input type="text" id="mc3" name="mc[]" class="form-control col-5 ml-auto" placeholder="Choice 4">
                    </div>
                </div>

                <div class="form-group" id="cf-identify" style="display: none">
                    <label for="">Correct answer</label>
                    <input type="text" class="form-control" id="c-identify" name="c-identify" placeholder="Correct answer here...">
                </div>

                <div class="form-group" id="cf-tf" style="display: none">
                    <label for="">Correct choice</label>
                    <select id="c-tf" class="form-control" name="c-tf">
                        <option value="1">True</option>
                        <option value="0">False</option>
                    </select>
                </div>

                <div class="form-group" id="cf-mc" style="display: none">
                    <label for="">Correct choice</label>
                    <select name="c-mc" id="c-mc" class="form-control">
                        <option value="1">Choice 1</option>
                        <option value="2">Choice 2</option>
                        <option value="3">Choice 3</option>
                        <option value="4">Choice 4</option>
                    </select>
                </div>
                <input type="hidden" id="_qid" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="UpdateQuestion()" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Question Modal -->
<div class="modal fade" id="createQuestion" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Question</label>
                    <textarea id="a_question" id="" cols="30" rows="3" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Type</label>
                    <select name="" id="a_opt" class="form-control" required>
                        <option value="1">Identification</option>
                        <option value="2">Multiple Choice</option>
                        <option value="3">True or False</option>
                    </select>
                </div>
                <div id="a_f-multiple-choice" style="display: none;">
                    <div class="form-group form-inline">
                        <input type="text" id="a_mc0" name="mc[]" class="form-control col-5 mr-auto" placeholder="Choice 1">
                        <input type="text" id="a_mc1" name="mc[]" class="form-control col-5 ml-auto" placeholder="Choice 2">
                    </div>
                    <div class="form-group form-inline">
                        <input type="text" id="a_mc2" name="mc[]" class="form-control col-5 mr-auto" placeholder="Choice 3">
                        <input type="text" id="a_mc3" name="mc[]" class="form-control col-5 ml-auto" placeholder="Choice 4">
                    </div>
                </div>

                <div class="form-group" id="a_cf-identify" style="display: none">
                    <label for="">Correct answer</label>
                    <input type="text" class="form-control" id="c-identify" name="c-identify" placeholder="Correct answer here...">
                </div>

                <div class="form-group" id="a_cf-tf" style="display: none">
                    <label for="">Correct choice</label>
                    <select id="c-tf" class="form-control" name="c-tf">
                        <option value="1">True</option>
                        <option value="0">False</option>
                    </select>
                </div>

                <div class="form-group" id="a_cf-mc" style="display: none">
                    <label for="">Correct choice</label>
                    <select name="c-mc" id="c-mc" class="form-control">
                        <option value="1">Choice 1</option>
                        <option value="2">Choice 2</option>
                        <option value="3">Choice 3</option>
                        <option value="4">Choice 4</option>
                    </select>
                </div>
                <input type="hidden" id="a_qid" value="{{ $q->questionnaire_id }}">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="AddQuestion()" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Question Confirmation Modal -->
<div class="modal fade" id="deleteQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm deletion of question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this question? This is irreversible!
                <input type="hidden" id="q_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="DeleteQuestion()">Delete Question</button>
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

    $("#opt").change(function () {
        $("#f-multiple-choice").css("display", "none"); //Multiple Choice
        $("#cf-mc").css("display", "none"); //correct choice
        $("#cf-tf").css("display", "none"); //True or False
        $("#cf-identify").css("display", "none"); //Identification

        if ($("#opt").val() == 1) { //Identification
            // console.log("Identify");
            $("#cf-identify").css("display", "inline"); //Identification
        } else if ($("#opt").val() == 2) { //Multiple choice
            // console.log("Multiple Choice");
            $("#f-multiple-choice").css("display", "inline"); //Multiple Choice
            $("#cf-mc").css("display", "inline"); //correct choice
        } else if ($("#opt").val() == 3) { //True or false
            // console.log("True or False");
            $("#cf-tf").css("display", "inline"); //True or False
        }
    });

    $("#a_opt").change(function () {
        $("#a_f-multiple-choice").css("display", "none"); //Multiple Choice
        $("#a_cf-mc").css("display", "none"); //correct choice
        $("#a_cf-tf").css("display", "none"); //True or False
        $("#a_cf-identify").css("display", "none"); //Identification

        if ($("#a_opt").val() == 1) { //Identification
            // console.log("Identify");
            $("#a_cf-identify").css("display", "inline"); //Identification
        } else if ($("#a_opt").val() == 2) { //Multiple choice
            // console.log("Multiple Choice");
            $("#a_f-multiple-choice").css("display", "inline"); //Multiple Choice
            $("#a_cf-mc").css("display", "inline"); //correct choice
        } else if ($("#a_opt").val() == 3) { //True or false
            // console.log("True or False");
            $("#a_cf-tf").css("display", "inline"); //True or False
        }
    });

    $('#editQuestion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var qid = button.data('qid')
        var question = button.data('question')
        var qtype = button.data('question-type')
        var choices = button.data('choices')
        var ans = button.data('correct-ans')

        var modal = $(this)
        modal.find('#question').val(question)
        modal.find('#opt').val(qtype)
        modal.find('#_qid').val(qid);
        $("#opt").trigger("change")

        if ($("#opt").val() == 1) { //Identification
            console.log("Identify")
            modal.find("#c-identify").val(ans)
        } else if ($("#opt").val() == 2) { //Multiple Choice
            console.log("MC")
            var ch = choices.split(";");
            $("#mc0").val(ch[0])
            $("#mc1").val(ch[1])
            $("#mc2").val(ch[2])
            $("#mc3").val(ch[3])
            modal.find("#c-mc").val(ans)
        } else if ($("#opt").val() == 3) { //True or False
            
            modal.find("#c-tf").val(ans)
        }
    });

    $('#deleteQuestion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var qid = button.data('qid')

        var modal = $(this)
        modal.find('#q_id').val(qid)
    });

    function UpdateQuestion() {
        var q_name = $('#question').val();
        var q_type = $('#opt').val();
        var q_id = $('#_qid').val();
        var q_ans = "";

        var choices = "";
        if(q_type == 1){
            q_ans = $('#c-identify').val();
        }
        else if(q_type == 2){
            q_ans = $('#c-mc').val();
            choices = $('#mc0').val() + ";" + $('#mc1').val() + ";" + $('#mc2').val() + ";" + $('#mc3').val();
        }
        else if(q_type = 3){
            q_ans = $('#c-tf').val();
        }

        $.ajax({
            url: '/question/' + q_id,
            type: 'PUT', //type is any HTTP method
            data: {
                q_name, q_type, choices, q_ans
            }, //Data as js object
            success: function () {
                window.location.reload(true);
            }
        });
    }

    function AddQuestion() {
        var q_name = $('#a_question').val();
        var q_type = $('#a_opt').val();
        var q_id = $('#a_qid').val();
        var q_ans = "";

        var choices = "";
        if(q_type == 1){
            q_ans = $('#a_c-identify').val();
        }
        else if(q_type == 2){
            q_ans = $('#a_c-mc').val();
            choices = $('#a_mc0').val() + ";" + $('#a_mc1').val() + ";" + $('#a_mc2').val() + ";" + $('#a_mc3').val();
        }
        else if(q_type = 3){
            q_ans = $('#a_c-tf').val();
        }

        $.ajax({
            url: '/question/',
            type: 'POST', //type is any HTTP method
            data: {
                q_id, q_name, q_type, choices, q_ans
            }, //Data as js object
            success: function () {
                window.location.reload(true);
            }
        });
    }

    function DeleteQuestion() {
        var q_id = $('#q_id').val();

        $.ajax({
            url: '/question/' + q_id,
            type: 'DELETE', //type is any HTTP method
            data: {
                q_id
            }, //Data as js object
            success: function () {
                window.location.reload(true);
            }
        });
        
    }
</script>

@endsection