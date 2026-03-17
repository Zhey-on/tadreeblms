@extends('backend.layouts.app')
@section('title', __('labels.backend.questions.title').' | '.app_name())

@section('content')
<form method="POST" action="{{ route('admin.test_questions.store') }}" enctype="multipart/form-data">
@csrf
@push('after-styles')
<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #858796;
        --success-color: #1cc88a;
        --info-color: #36b9cc;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --light-color: #f8f9fc;
        --dark-color: #5a5c69;
        --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .question-builder-container {
        padding: 20px 0;
    }
 

    .card-header {
        background-color: #fff !important;
        border-bottom: 1px solid #f2f4f9 !important;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.25rem !important;
    }

    .card-header h5 {
        color: #4e73df;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
    }

    /* Options Builder Styling */
    .option-item {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 14px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .option-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: transparent;
        transition: background 0.2s;
    }

    .option-item:hover {
        border-color: #cbd5e0;
        background: #f8fafc;
        transform: translateX(4px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
    }

    .option-item .option-number {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        width: 40px;
        height: 40px;
        background: #e2e8f0;
        border-radius: 50%;
        font-weight: 700;
        color: #4a5568;
        font-size: 0.9rem;
    }

    .option-item .option-content {
        flex-grow: 1;
        font-size: 0.95rem;
        color: #2d3748;
        line-height: 1.5;
        word-break: break-word;
    }

    .option-item .option-content img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
    }

    .option-item .option-actions {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    .option-item .option-actions .btn {
        padding: 6px 10px;
        font-size: 0.8rem;
        border-radius: 6px;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .option-item .option-actions .btn:hover {
        transform: scale(1.05);
    }

    .option-item .correct-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
        padding: 0 8px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        user-select: none;
    }

    .option-item .correct-indicator input {
        margin: 0;
        cursor: pointer;
    }

    .option-item.correct {
        border-color: #1cc88a;
        background: #f0fff4;
        border-left: 4px solid #1cc88a;
    }

    .option-item.correct::before {
        background: #1cc88a;
    }

    .option-item.correct .option-number {
        background: #1cc88a;
        color: white;
    }

    .option-item.correct .correct-indicator {
        background: #d1f5e8;
        color: #1cc88a;
        font-weight: 700;
    }

    .option-area-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding: 12px 0;
        border-bottom: 2px solid #e2e8f0;
    }

    .option-area-header .title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        color: #2d3748;
        font-size: 1rem;
    }

    .option-area-header .option-count {
        background: #4e73df;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .option-item.empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 20px;
        border: 2px dashed #cbd5e0;
        background: #f8fafc;
        margin-bottom: 0;
        color: #718096;
    }

    .option-item.empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        opacity: 0.6;
    }

    .option-item.empty-state p {
        margin: 0;
        font-size: 0.9rem;
    }

    .addoptbtn {
        margin-top: 16px;
    }

    .addoptbtn .btn-lg {
        font-size: 1rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(78, 115, 223, 0.2);
        transition: all 0.3s ease;
    }

    .addoptbtn .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
    }

    .addoptbtn .btn-lg:active {
        transform: translateY(0);
    }

    .addoptiontable {
        background: #ffffff;
        border-radius: 8px;
        padding: 16px;
        border: 1px solid #e2e8f0;
    }

    /* Floating Preview Styling */
    .preview-panel {
        position: sticky;
        top: 20px;
        z-index: 100;
    }

    .preview-card {
        background: #fff;
        border-top: 4px solid #4e73df;
    }

    .preview-header {
        background: #f8fafc;
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 700;
        color: #2d3748;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
    }

    .preview-body {
        padding: 24px;
        max-height: 80vh;
        overflow-y: auto;
    }

    .badge-difficulty {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-easy { background: #def7ec; color: #03543f; }
    .badge-medium { background: #fef3c7; color: #92400e; }
    .badge-hard { background: #fde8e8; color: #9b1c1c; }

    /* Sticky Footer */
    .sticky-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 15px 30px;
        box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
        z-index: 1000;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #e2e8f0;
    }

    .main {
        padding-bottom: 80px !important; /* Space for footer */
    }

    /* Custom Radio/Checkbox */
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    /* Helper spacing */
    .gap-10 { gap: 10px; }
    .mt-auto { margin-top: auto; }

</style>
@endpush




@include('backend.includes.partials.course-steps', ['step' => 3, 'course_id' => $course_id, 'course' => $course ?? null ])


 <div class="pb-3 d-flex justify-content-between align-items-center addcourseheader">
       <h4>
           @lang('labels.backend.questions.create')
       </h4>
         <div class="">
       <a href="{{ route('admin.test_questions.index') }}" class="btn btn-primary">@lang('labels.backend.questions.view')</a>
   </div>
     
   </div>
<div class="card">
    <!-- <div class="card-header">
        <h3 class="page-title float-left mb-0">@lang('labels.backend.questions.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.test_questions.index') }}" class="btn btn-success">@lang('labels.backend.questions.view')</a>
        </div>
    </div> -->
    <div class="card-body">
        <input type="hidden" id="temp_id" name="temp_id" value="{{ $temp_id }}">
        <input type="hidden" id="action_btn" name="action_btn" value="">
        <input type="hidden" id="course_id" name="course_id" value="{{ $course_id }}">
        <input type="hidden" id="test_id" name="test_id" value="{{ $legacy_test_id ?? '' }}">
        <input type="hidden" name="lesson_id" id="lesson_id" value="{{ $lesson_id_preselect ?? '' }}">
        <input type="hidden" id="last_lesson_id" value="{{ $last_lesson_id ?? '' }}">

        @if($course_id)
            @if(isset($lessons) && $lessons->count() > 0)
                <!-- If lesson is pre-selected, show it as display (read-only) -->
                @if(($lock_lesson_selection ?? false) && $lesson_id_preselect)
                    @if($selected_lesson_preselect)
                    <div class="alert mt-3" style="background-color: #233e74; border-color: #233e74; color: #ffffff;">
                        <strong style="color: #ffffff;">Selected Lesson:</strong> {{ $selected_lesson_preselect->title }}
                        <br>
                        <small class="d-block mt-2">Quiz questions will be added to this lesson.</small>
                    </div>

                    @if($is_last_lesson_preselect)
                    <div class="row mt-3" id="assessment-type-row-last-lesson">
                        <div class="col-12 col-md-6">
                            <label>Assessment Type <span class="text-danger">*</span></label>
                            <div class="custom-select-wrapper">
                                <select class="form-control custom-select-box" id="assessment_type_select" required>
                                    <option value="final">Final Assessment</option>
                                    <option value="lesson" selected>Lesson Quiz</option>
                                </select>
                                <span class="custom-select-icon"><i class="fa fa-chevron-down"></i></span>
                            </div>
                            <small class="form-text text-muted mt-1">
                                This is the last lesson of the course. You can add the final assessment quiz now, or switch back to lesson quiz.
                            </small>
                        </div>
                    </div>
                    @endif
                    @endif

                <!-- If lesson is NOT pre-selected, show dropdown to select -->
                @else
                    <!-- QUESTIONS SECTION MODE: lesson is optional -->
                    <div class="alert alert-info mt-3">
                        <strong><i class="fa fa-info-circle mr-2"></i>Question Mapping</strong><br>
                        Select a lesson to map this question to a lesson quiz, or leave it empty to map it to the final assessment.
                    </div>

                    <div class="row mt-3" id="lesson-select-row">
                        <div class="col-12 col-md-6">
                            <label>Select Lesson (optional)</label>
                            <div class="custom-select-wrapper">
                                <select class="form-control custom-select-box" id="lesson_id_select">
                                    <option value="">-- Final Assessment (No Lesson) --</option>
                                    @foreach($lessons as $lsn)
                                        <option value="{{ $lsn->id }}" @if((int)($lesson_id_preselect ?? 0) === (int)$lsn->id) selected @endif>
                                            {{ $lsn->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="custom-select-icon"><i class="fa fa-chevron-down"></i></span>
                            </div>
                            <small class="form-text text-muted mt-1">
                                If a lesson is selected, students will answer this question in that lesson quiz. If empty, the question goes to final assessment.
                            </small>
                        </div>
                    </div>
                @endif
            @else
                <div class="alert alert-info mt-3">
                    <strong><i class="fa fa-info-circle mr-2"></i>No Published Lessons Found</strong><br>
                    Questions added from this form will be mapped to the course final assessment.
                </div>
            @endif

        @else
            <div class="alert alert-warning mt-3">
                <strong><i class="fa fa-exclamation-triangle mr-2"></i>Select Course First</strong><br>
                Open this form from the Questions section after selecting a course to get the optional lesson dropdown.
            </div>
        @endif

        <div class="row mt-3" id="question-type-row">
            <div class="col-12 col-md-6">
                <label>Question Type</label>
                <div class="custom-select-wrapper">

                    <select class="form-control custom-select-box" name="question_type" id="question_type">
                        <option value="1"> Single Choice </option>
                        {{-- <option value="2"> Multiple Choice </option>
                        <option value="3"> Short Answer </option> --}}
                    </select>
                     <span class="custom-select-icon">
        <i class="fa fa-chevron-down"></i>
    </span>
                </div>
            </div>
        </div>
        {{-- /question-type-row --}}


        <div class="row">
          <div class="col-12 col-md-6 mt-3 notextarea"> 
                <label>Question</label>
                <textarea class="form-control editor" rows="3" name="question" id="question" required="required" data-collapsible-toolbar="1"></textarea>
            </div>
         
                <div class="col-12 col-md-6"> 
                     <div class="mt-3 notextarea">
                    <label><i class="fa fa-check-square-o mr-2" style="color: #4e73df;"></i>Opzioni</label>
                    <textarea class="form-control editor" rows="3" name="option" id="option" required="required" data-collapsible-toolbar="1" placeholder="Scrivi l'opzione di risposta qui..."></textarea>
                    <div class="addoptbtn mt-3">
                        <button type="button" id="add_option" class="btn btn-primary btn-lg w-100" style="font-weight: 600; padding: 12px;">
                            <i class="fa fa-plus-circle mr-2"></i>Aggiungi Opzione
                        </button>
                    </div>
              <div class="addoptiontable mt-4">
                    <div id="option-area" class=""></div>
                </div>
               </div>
            </div>
</div>


            <div class="row">
                 <div class="col-12 col-md-5 notextarea">
                    <label>Solution</label>
                    <textarea class="form-control textarea-col editor" rows="3" name="solution" id="solution" data-collapsible-toolbar="1"></textarea>
                </div>
             
             <div class="col-12 col-md-2">
                    <label>Marks</label>
                    <input type="number" class="form-control" name="marks" id="marks" placeholder="Enter Marks" required />
                </div>
             
                <div class="col-12 col-md-5 notextarea">
                    <label>Comment</label>
                    <textarea class="form-control textarea-col editor" rows="3" name="comment" id="comment" data-collapsible-toolbar="1"></textarea>

         

         
        </div>
        </div>

<!--
<div class="row">
        <div class="col-md-6">
     Options Builder Card  
            <div class="" id="options-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fa fa-list-ul"></i> Options Builder</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="add_option_btn">
                        <i class="fa fa-plus"></i> Add Option
                    </button>
                </div>
                <div class="card-body">
                   New Option Input (Floating)  
                    <div id="option-input-wrapper" class="mb-4 bg-light p-3 rounded shadow-sm" style="display:none;">
                        <label>New Option Content</label>
                        <textarea class="form-control editor" name="option_editor" id="option_editor"></textarea>
                        <div class="mt-2 text-right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cancel_option">Cancel</button>
                            <button type="button" class="btn btn-primary btn-sm" id="confirm_add_option">Add this Option</button>
                        </div>
                    </div>

                    <div id="option-area" class="mt-3">
                        <div class="text-center py-4 text-muted">
                            <i class="fa fa-info-circle fa-2x mb-2"></i>
                            <p>No options added yet. Click "Add Option" to begin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
     Solution & Comments Card  
            <div class=" ">
                <div class="card-header">
                    <h5><i class="fa fa-check-circle"></i> Explanation & Feedback</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Correct Solution / Explanation</label>
                        <textarea class="form-control editor" rows="3" name="solution" id="solution"></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label>Admin Comments (Internal)</label>
                        <textarea class="form-control editor" rows="3" name="comment" id="comment"></textarea>
                    </div>
                </div>
            </div>
        </div>
</div>
-->
<!--
<div class="row">
         Right Panel: Live Preview  
        <div class="col-lg-12">
            <div class="preview-panel">
                <div class="card preview-card">
                    <div class="preview-header">
                        <i class="fa fa-eye"></i> Learner Preview
                    </div>
                    <div class="preview-body" id="live-preview-content">
                        <div class="preview-meta mb-3 d-flex justify-content-between align-items-center">
                            <span id="preview-marks" class="badge badge-info">0 Marks</span>
                            <span id="preview-difficulty" class="badge-difficulty badge-easy">Easy</span>
                        </div>
                        <div id="preview-tags" class="mb-3"></div>
                        <div id="preview-question" class="question-text mb-4" style="font-size: 1.1rem; font-weight: 500;">
                            <span class="text-muted italic">Question content will appear here...</span>
                        </div>
                        <div id="preview-options" class="options-preview">
                            Preview options will appear here  
                        </div>
                        <div id="preview-hint" class="mt-3 d-none">
                            <div class="alert alert-warning py-2 small">
                                <strong>Hint:</strong> <span id="preview-hint-text"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white py-3">
                        <small class="text-muted"><i class="fa fa-mobile-alt"></i> Optimized for all devices</small>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
-->


     <div class="btmbtns">
        <div class="row">
    <div class="col-12 mt-5 buttons">
        
     <button type="button" class="frm_submit add-btn" id="save_and_add_more" value="save_and_add_more">Save & Add More</button>
    
     <span class="text-right pull-right">
        <button
            type="button"
            class="frm_submit cancel-btn"
            id="save_as_draft"
            value="Save As Draft">
            Save As Draft
        </button>

        <button
            type="button"
            class="frm_submit add-btn"
            id="save"
            value="Next">
            Next
        </button>
</span>
    </div>
    
</div>
</div>



</form>
<script type="text/javascript">

    $('.frm_submit').on('click', function (){
        $('#action_btn').val($(this).val());
    });

</script>
@stop
@push('after-scripts')

<script type="text/javascript">
    var options = [];
    var flag = 0;

    function removeOptions(pos) {
        options.splice(pos, 1);
        showOptions();
    }

    function markAsCorrectOption(pos, show_remove_options = true) {
        for (var i = 0; i < options.length; ++i) {
            if ($('#question_type').val() == 1) {
                if (i === pos) {
                    options[i][1] = 1;
                } else {
                    options[i][1] = 0;
                }
            } else {
                if (i === pos) {
                    if (options[i][1] == 1) {
                        options[i][1] = 0;
                    } else {
                        options[i][1] = 1;
                    }
                } else {
                    options[i][1] = options[i][1];
                }
            }
        }
        showOptions(show_remove_options);
    }

    function showOptions(show_remove_options = true) {
        const container = document.getElementById('option-area');
        
        if (options.length === 0) {
            container.innerHTML = `
                <div class="option-item empty-state">
                    <i class="fa fa-inbox"></i>
                    <p><strong>Nessuna opzione aggiunta</strong></p>
                    <small>Compila il campo "Option" e fai clic su "Add Option" per iniziare</small>
                </div>
            `;
            return;
        }

        let html = `
            <div class="option-area-header">
                <div class="title">
                    <i class="fa fa-list-ol" style="color: #4e73df;"></i>
                    Opzioni della domanda
                </div>
                <div class="option-count">${options.length} Opzioni</div>
            </div>
        `;

        options.forEach((option, i) => {
            const isCorrect = option[1] === 1;
            const inputType = parseInt($('#question_type').val()) === 1 ? 'radio' : 'checkbox';
            const correctClass = isCorrect ? 'correct' : '';
            const correctIcon = isCorrect ? '<i class="fa fa-check-circle" style="color: #1cc88a;"></i>' : '<i class="fa fa-circle-o" style="color: #cbd5e0;"></i>';
            
            html += `
                <div class="option-item ${correctClass}">
                    <div class="option-number">${i + 1}</div>
                    <div class="option-content">
                        ${option[0]}
                    </div>
                    <div class="correct-indicator" onclick="markAsCorrectOption(${i}${show_remove_options ? '' : ', false'})">
                        <input type="${inputType}" ${isCorrect ? 'checked="checked"' : ''} class="option-checkbox" style="cursor: pointer;">
                        <label style="margin-left: 6px; margin-bottom: 0; cursor: pointer; font-size: 0.75rem; color: #4a5568; font-weight: 600;">Corretta</label>
                    </div>
                    ${show_remove_options ? `
                    <div class="option-actions">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOptions(${i})" title="Rimuovi questa opzione">
                            <i class="fa fa-trash"></i> Rimuovi
                        </button>
                    </div>
                    ` : ''}
                </div>
            `;
        });

        container.innerHTML = html;
        addImgClass();
    }

    function addOptions() {
        var option = getEditorContent("option");
        options_length = (options != null && options != undefined) ? options.length : 0;
        options.push([option.trim(), 0]);
        // Visual feedback
        const btn = document.getElementById('add_option');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-check mr-2"></i>Opzione Aggiunta!';
        btn.style.background = '#1cc88a';
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = '';
        }, 1500);
        setEditorContent("option", '');
    }

    $(document).on('click', "#add_option", function() {
        if (getEditorContent("option") != "") {
            addOptions();
        } else {
            alert('Per favore, compila il campo opzione prima di aggiungerla.');
        }
        showOptions();
    });

    function addImgClass() {
        $('#option-area').each(function() {
            $(this).find('img').addClass('img-fluid');
        });
    }

    function getEditorContent(editorId) {
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances[editorId]) {
            return CKEDITOR.instances[editorId].getData();
        }

        const textarea = document.getElementById(editorId);
        return textarea ? textarea.value : '';
    }

    function setEditorContent(editorId, value) {
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances[editorId]) {
            CKEDITOR.instances[editorId].setData(value);
            return;
        }

        const textarea = document.getElementById(editorId);
        if (textarea) {
            textarea.value = value;
        }
    }

    function dataCollection() {
        var temp_id = $("#temp_id").val();
        var test_id = $("#test_id").val();
        var lesson_id = $("#lesson_id").val();
        var question_type = $("#question_type").val();
        var question = getEditorContent("question");
        var solution = getEditorContent("solution");
        var comment = getEditorContent("comment");
        var marks = $("#marks").val();
        return {
            temp_id,
            test_id,
            lesson_id,
            question_type,
            question,
            options: JSON.stringify(options),
            solution,
            comment,
            marks
        }
    }

    $(document).on('click', ".frm_submit", function() {
        $('#action_btn').val($(this).val());
        flag = 0;
        sendData();
        /*
        if (CKEDITOR.instances["question"].getData() != "" && $('#marks').val() != "" && $('#test_id').val() != "") {
            if ($('#question_type').val() == 1) {
                if ($('input:radio:checked').length > 0) {
                    sendData();
                } else {
                    alert('Please Select The Right Answer.');
                }
            } else if ($('#question_type').val() == 2) {
                if ($('input:checkbox:checked').length > 0) {
                    sendData();
                } else {
                    alert('Please Select at least one right Answer.');
                }
            } else {
                sendData();
            }
        } else {
            alert("Please fill all the details.");
        }
        */
    });

    var question_submit_url = "{{route('admin.test_questions.store')}}";

    function sendData(data) {
        var data = dataCollection();

        if (!data.question || data.question.trim() === '') {
            alert('Question field is required.');
            return;
        }

        if (!data.marks || data.marks === '') {
            alert('Marks field is required.');
            return;
        }

        // Get form context
        const assessmentType = document.getElementById('assessment_type_select');
        const courseId = document.getElementById('course_id').value;
        const lessonId = document.getElementById('lesson_id').value;
        const lessonSelect = document.getElementById('lesson_id_select');
        const testId = document.getElementById('test_id').value;

        if (!courseId && !testId) {
            alert('Please select a course from the Questions section before creating questions.');
            return;
        }

        if (assessmentType) {
            // STANDALONE MODE: Assessment type is required
            if (!assessmentType.value) {
                alert('Please select assessment type (Lesson Quiz or Final Assessment).');
                return;
            }
            // If lesson quiz in standalone, lesson must be selected
            if (assessmentType.value === 'lesson' && !lessonId) {
                alert('Please select a lesson for this quiz question.');
                return;
            }
        }

        data['_token'] = "{{ csrf_token() }}";
        data['action_btn'] = $('#action_btn').val();
        data['course_id'] = $('#course_id').val();
        const redirect = "{{ request()->redirect }}";
        $.ajax({
            url: question_submit_url,
            type: 'post',
            data: data,
            success: function(response) {
                let payload = response;
                if (typeof response === 'string') {
                    try {
                        payload = JSON.parse(response);
                    } catch (e) {
                        alert('Unexpected server response. Please reload and try again.');
                        return;
                    }
                }

                if (payload.code == 200) {
                    // if (data['action_btn'] == 'save_and_add_more') {
                    //     window.location.replace(response.redirect_url);
                    // }else{
                    //     window.location.replace(redirect);
                    // }
                    window.location.replace(payload.redirect_url);
                } else {
                    alert(payload.message || 'Unable to save the question.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    alert(res.message); // Show the error message
                    console.log('Validation errors:', res.errors);
                } else {
                    alert('Request failed. Please reload and try again.');
                }
            }
        });
    }

    $(document).on('change', '#question_type', function() {
        var question_type = $(this).val();
        $.ajax({
            url: "{{route('admin.test_questions.question_setup')}}",
            type: 'post',
            data: ({
                question_type: question_type,
                _token: "{{ csrf_token() }}"
            }),
            success: function(response) {
                $('.cb_question_setup').html(response);
                // if (response.code == 200) {
                //     $('.cb_question_setup').html(response.question_setup);
                // } else {
                //     alert(response.message);
                // }
                // console.log(response);
            },
        });
    });

    @if($course_id && isset($lessons) && $lessons->count() > 0)
    <!-- Course Creation Flow: Lesson selection handling -->
    (function () {
        const lessonIdInput = document.getElementById('lesson_id');
        const lessonSelect = document.getElementById('lesson_id_select');
        const assessmentTypeSelect = document.getElementById('assessment_type_select');
        const preselectedLessonId = "{{ (int) ($lesson_id_preselect ?? 0) }}";

        // Only setup listener if selector exists (lesson not pre-selected)
        if (lessonSelect) {
            lessonSelect.addEventListener('change', function () {
                if (lessonIdInput) {
                    lessonIdInput.value = this.value;
                }
            });
        }

        // If assessment selector is visible (last lesson case), switch between final/lesson modes
        if (assessmentTypeSelect && lessonIdInput) {
            const syncAssessmentMode = function () {
                if (assessmentTypeSelect.value === 'final') {
                    lessonIdInput.value = '';
                } else {
                    lessonIdInput.value = preselectedLessonId || lessonIdInput.value;
                }
            };

            assessmentTypeSelect.addEventListener('change', syncAssessmentMode);
            syncAssessmentMode();
        }

        // Initialize: if lesson_id_input already has a value, don't show selector
        if (lessonIdInput && lessonIdInput.value && lessonSelect) {
            // Lesson is pre-selected, selector should be hidden by blade
            lessonSelect.value = lessonIdInput.value;
        }
    })();
    @elseif(!$course_id && isset($lessons) && $lessons->count() > 0)
    <!-- Standalone Admin Mode: keep hidden lesson_id in sync if used -->
    (function () {
        const assessmentTypeSelect = document.getElementById('assessment_type_select');
        const lessonSelectContainer = document.getElementById('lesson-select-container');
        const lessonIdInput = document.getElementById('lesson_id');
        const lessonSelect = document.getElementById('lesson_id_select');

        function updateAssessmentUI() {
            if (assessmentTypeSelect && lessonSelectContainer) {
                if (assessmentTypeSelect.value === 'lesson') {
                    lessonSelectContainer.style.display = 'block';
                } else {
                    lessonSelectContainer.style.display = 'none';
                    if (lessonIdInput) {
                        lessonIdInput.value = '';
                    }
                }
            }
        }

        if (lessonSelect) {
            lessonSelect.addEventListener('change', function () {
                if (lessonIdInput) {
                    lessonIdInput.value = this.value;
                }
            });
        }

        if (assessmentTypeSelect) {
            assessmentTypeSelect.addEventListener('change', updateAssessmentUI);
        }

        if (lessonIdInput && lessonIdInput.value) {
            if (assessmentTypeSelect) {
                assessmentTypeSelect.value = 'lesson';
            }
            if (lessonSelect) {
                lessonSelect.value = lessonIdInput.value;
            }
        }

        updateAssessmentUI();
    })();
    @endif
</script>
<!-- <script type="text/javascript">
    var options = [];
    var currentOptionId = null;

function removeOptions(pos) {
        options.splice(pos, 1);
        showOptions();
    }

    $(document).ready(function() {
        // Initialize CKEditors
        const editorIds = ['question', 'solution', 'comment', 'option_editor'];
        editorIds.forEach(id => {
            if (CKEDITOR.instances[id]) {
                CKEDITOR.instances[id].on('change', function() {
                    updatePreview();
                });
            }
        });

        // Event listeners for preview updates
        $('#marks, #difficulty, #tags, #hint, #question_type').on('input change', function() {
            updatePreview();
        });

        // Initial preview
        updatePreview();
    });

    function updatePreview() {
        // Update Marks
        $('#preview-marks').text(($('#marks').val() || 0) + ' Marks');

        // Update Difficulty
        const diff = $('#difficulty').val();
        $('#preview-difficulty').text(diff.charAt(0).toUpperCase() + diff.slice(1))
            .removeClass('badge-easy badge-medium badge-hard')
            .addClass('badge-' + diff);

        // Update Tags
        const tags = $('#tags').val();
        if (tags) {
            let tagHtml = tags.split(',').map(t => `<span class="badge badge-secondary mr-1">${t.trim()}</span>`).join('');
            $('#preview-tags').html(tagHtml);
        } else {
            $('#preview-tags').empty();
        }

        // Update Question Text
        const questionText = CKEDITOR.instances['question'].getData();
        if (questionText) {
            $('#preview-question').html(questionText);
        } else {
            $('#preview-question').html('<span class="text-muted italic">Question content will appear here...</span>');
        }

        // Update Hint
        const hint = $('#hint').val();
        if (hint) {
            $('#preview-hint').removeClass('d-none');
            $('#preview-hint-text').text(hint);
        } else {
            $('#preview-hint').addClass('d-none');
        }

        renderOptionsPreview();
    }

    function renderOptionsPreview() {
        const type = $('#question_type').val();
        let html = '';
        
        if (type == 3) {
            html = '<div class="alert alert-light border text-muted px-4 py-3">Learners will provide a descriptive answer here.</div>';
        } else {
            options.forEach((opt, index) => {
                const inputType = type == 1 ? 'radio' : 'checkbox';
                html += `
                    <div class="custom-control custom-${inputType} mb-2">
                        <input type="${inputType}" class="custom-control-input" id="prev_opt_${index}" name="prev_opt" value="${index}">
                        <label class="custom-control-label" for="prev_opt_${index}">${opt[0]}</label>
                    </div>
                `;
            });
        }
        $('#preview-options').html(html || '<span class="text-muted small italic">Options will appear here...</span>');
    }

    // Options Management
    $(document).on('click', '#add_option_btn', function() {
        $('#option-input-wrapper').slideDown();
        CKEDITOR.instances['option_editor'].setData('');
        $(this).hide();
    });

    $(document).on('click', '#cancel_option', function() {
        $('#option-input-wrapper').slideUp();
        $('#add_option_btn').show();
    });

    $(document).on('click', '#confirm_add_option', function() {
        const content = CKEDITOR.instances['option_editor'].getData().trim();
        if (!content) {
            alert('Please enter option content');
            return;
        }

        options.push([content, 0]); // [content, is_right]
        renderOptionsList();
        updatePreview();
        
        $('#option-input-wrapper').slideUp();
        $('#add_option_btn').show();
    });

    function removeOption(index) {
        options.splice(index, 1);
        renderOptionsList();
        updatePreview();
    }

     function showOptions(show_remove_options = true) {
        if (show_remove_options == true) {
            var option_text = '<table class="table table-bordered table-striped"><tbody><tr><th>Option</th>';
            var drag_drop_question_type = $('#question_type').val();
            option_text += '<th>Is Right</th></tr>';
            for (var i = 0; i < options.length; ++i) {
                option = options[i];
                option_text += '<tr>';
                option_text += '<td>' + option[0] + '</td>';
                if (parseInt($('#question_type').val()) == 1) {
                    option_text += '<td><input type="radio" ';
                } else {
                    option_text += '<td><input type="checkbox" class="cb_checkbox_mark" ';
                }
                if (option[1] === 1) {
                    option_text += 'checked="checked"';
                }
                option_text += ' onclick="markAsCorrectOption(' + i + ')"></td>';
                option_text += '<td><a href="javascript:void(0);"  onclick="removeOptions(' + i + ')" class="btn btn-danger remove"><i class="la la-trash"></i>Remove</a>';
                option_text += '</tr>'
            }
            option_text += '</tbody></table>';
            $('#option-area').html(option_text);
        } else {
            var option_text = '<table class="table table-bordered table-striped"><tbody><tr><th>Option</th><th>Is Right</th></tr>';
            for (var i = 0; i < options.length; ++i) {
                option = options[i];
                option_text += '<tr>';
                option_text += '<td>' + option[0] + '</td>';
                option_text += '<td><input type="radio" ';
                if (option[1] === 1) {
                    option_text += 'checked="checked"';
                }
                option_text += ' onclick="markAsCorrectOption(' + i + ',false)"></td>';
                option_text += '</tr>'
            }
            option_text += '</tbody></table>';
            document.getElementById('option-area').innerHTML = option_text;
        }
        addImgClass();
    }
    function addOptions() {
        var option = CKEDITOR.instances["option"].getData();
        options_length = (options != null && options != undefined) ? options.length : 0;
        options.push([option.trim(), 0]);
        CKEDITOR.instances["option"].setData('');
    }

    //$(document).on('click', "#add_option", function() {
        //if (CKEDITOR.instances["option"].getData() != "") {
            // if ((options.length + 1) <= 4) {
                //addOptions();
            // } else {
            //     alert('You can use only 4 Options.');
            // }
       // }
       // showOptions();
   // });

 $(document).on('click', "#add_option", function() {
    // 1. Get data from CKEditor
    var rawContent = CKEDITOR.instances["option"].getData();

    // 2. Strip HTML tags to see if there is actually any text
    // This removes <p>, <br>, and converts &nbsp; to empty space
    var plainText = rawContent.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, '').trim();

    // 3. Validation Check
    if (plainText === "") {
        alert("Please enter text for the option before adding it.");
        CKEDITOR.instances["option"].focus();
        return false; // STOP the execution here
    }

    // 4. If it's NOT empty, proceed
    addOptions();
    showOptions();
    
    // 5. Clear the editor for the next one
    CKEDITOR.instances["option"].setData('');
});
    @if(isset($lesson_id_preselect) && $lesson_id_preselect)
    // Auto-activate lesson quiz scope when opening from a lesson action button
    document.addEventListener('DOMContentLoaded', function () {
        var btnLesson    = document.getElementById('scope-lesson-btn');
        var btnAssess    = document.getElementById('scope-assessment-btn');
        var testRow      = document.getElementById('test-row');
        var lessonRow    = document.getElementById('lesson-select-row');
        var lessonSel    = document.getElementById('lesson_id_select');
        var lessonIdInp  = document.getElementById('lesson_id');
        var testSelect   = document.getElementById('test_id');
        if (btnLesson) {
            btnLesson.classList.add('active');
            if (btnAssess) btnAssess.classList.remove('active');
        }
        if (testRow)  testRow.style.display   = 'none';
        if (lessonRow) lessonRow.style.display = 'flex';
        if (testSelect) testSelect.removeAttribute('required');
        if (lessonSel) {
            lessonSel.value = '{{ $lesson_id_preselect }}';
        }
        if (lessonIdInp) {
            lessonIdInp.value = '{{ $lesson_id_preselect }}';
        }
    });
    @endif

    function markCorrect(index) {
        const type = $('#question_type').val();
        if (type == 1) {
            // Single choice: only one can be correct
            options.forEach((opt, i) => opt[1] = (i === index ? 1 : 0));
        } else {
            // Multiple choice: toggle
            options[index][1] = options[index][1] === 1 ? 0 : 1;
        }
        renderOptionsList();
        updatePreview();
    }

    function renderOptionsList() {
        const container = $('#option-area');
        const type = $('#question_type').val();

        if (options.length === 0) {
            container.html(`
                <div class="text-center py-4 text-muted">
                    <i class="fa fa-info-circle fa-2x mb-2"></i>
                    <p>No options added yet. Click "Add Option" to begin.</p>
                </div>
            `);
            return;
        }

        let html = '';
        options.forEach((opt, index) => {
            const isCorrect = opt[1] === 1;
            const inputType = type == 1 ? 'radio' : 'checkbox';
            
            html += `
                <div class="option-item ${isCorrect ? 'correct' : ''}">
                    <div class="drag-handle"><i class="fa fa-grip-vertical"></i></div>
                    <div class="option-check">
                        <div class="custom-control custom-${inputType}">
                            <input type="${inputType}" class="custom-control-input" id="opt_check_${index}" 
                                ${isCorrect ? 'checked' : ''} onclick="markCorrect(${index})">
                            <label class="custom-control-label" for="opt_check_${index}"></label>
                        </div>
                    </div>
                    <div class="option-content">${opt[0]}</div>
                    <div class="option-actions">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOption(${index})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>{{-- /card-body --}}
                    </div>{{-- /card --}}
            `;
        });
        container.html(html);
    }

    // Submit Handling
    $(document).on('click', '.frm_submit', function() {
        $('#action_btn').val($(this).val());
        sendData();
    });

    function sendData() {
        const type = $('#question_type').val();
        
        // Basic Validation
        if (!CKEDITOR.instances['question'].getData().trim()) {
            alert('Question text is required');
            return;
        }
        if (!$('#marks').val()) {
            alert('Marks field is required');
            return;
        }
        if (type != 3 && options.length < 2) {
            alert('Please add at least 2 options');
            return;
        }
       

        const data = {
            _token: "{{ csrf_token() }}",
            temp_id: $("#temp_id").val(),
            test_id: $("#test_id").val(),
            course_id: $('#course_id').val(),
            action_btn: $('#action_btn').val(),
            question_type: type,
            question: CKEDITOR.instances["question"].getData(),
            options: JSON.stringify(options),
            solution: CKEDITOR.instances["solution"].getData(),
            comment: CKEDITOR.instances["comment"].getData(),
            marks: $("#marks").val(),
            difficulty: $('#difficulty').val(),
            tags: $('#tags').val(),
            hint: $('#hint').val()
        };

        $.ajax({
            url: "{{route('admin.test_questions.store')}}",
            type: 'post',
            data: data,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.code == 200) {
                    window.location.replace(res.redirect_url);
                } else {
                    alert(res.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const res = xhr.responseJSON;
                    alert(res.message);
                } else {
                    alert('An error occurred while saving.');
                }
            }
        });
    }

    // Handle Type change
    $('#question_type').on('change', function() {
        const type = $(this).val();
        if (type == 3) {
            $('#options-card').fadeOut();
        } else {
            $('#options-card').fadeIn();
        }
        options = []; // Reset options when type changes for simplicity or we can convert them
        renderOptionsList();
        updatePreview();
    });

</script> -->
@endpush
