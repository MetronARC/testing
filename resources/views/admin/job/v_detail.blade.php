@extends('admin/v_template')

@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="main__header d-flex justify-content-between">
                <h1 class="h3"><strong>Job</strong> Detail</h1>
                <a href="{{ route('job.jobIndex') }}" class="btn btn-outline-secondary">Back to list</a>
            </div>
            <div class="main__body">

                <div class="card">
                    <div class="card-body">
                        <form action="{{ url()->current() }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="form__position" class="form-label">Position</label>
                                <input type="text"
                                    class="form-control {{ !empty($errors['position']) ? 'is-invalid' : '' }}"
                                    name="position" id="form__position" placeholder="Input Position"
                                    value="{{ Request::post('position', $job['position']) }}" />
                                <div class="invalid-feedback">{{ !empty($errors['position']) ? $errors['position'] : '' }}
                                </div>
                            </div>
                            <div class="pb-3"></div>

                            <div class="mb-3">
                                <label for="form__company" class="form-label">Company</label>
                                <input type="text"
                                    class="form-control {{ !empty($errors['company']) ? 'is-invalid' : '' }}" name="company"
                                    id="form__company" placeholder="Input Company"
                                    value="{{ Request::post('company', $job['company']) }}" />
                                <div class="invalid-feedback">{{ !empty($errors['company']) ? $errors['company'] : '' }}
                                </div>
                            </div>
                            <div class="pb-3"></div>

                            <div class="mb-3">
                                <label for="form__responsible" class="form-label">Responsible</label>
                                <textarea class="form-control {{ !empty($errors['responsible']) ? 'is-invalid' : '' }}" name="responsible"
                                    id="form__responsible" placeholder="Input Responsible" rows="4">{{ Request::post('responsible', $job['responsible']) }}</textarea>
                                <div class="invalid-feedback">
                                    {{ !empty($errors['responsible']) ? $errors['responsible'] : '' }}</div>
                            </div>
                            <div class="pb-3"></div>

                            <div class="mb-3">
                                <label for="form__requirement" class="form-label">Requirement</label>
                                <textarea class="form-control {{ !empty($errors['requirement']) ? 'is-invalid' : '' }}" name="requirement"
                                    id="form__requirement" placeholder="Input Requirement" rows="4">{{ Request::post('requirement', $job['requirement']) }}</textarea>
                                <div class="invalid-feedback">
                                    {{ !empty($errors['requirement']) ? $errors['requirement'] : '' }}</div>
                            </div>
                            <div class="pb-3"></div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="form__posted_start_at" class="form-label">Start Date</label>
                                        <div class="input-group date">
                                            <input
                                                class="form-control {{ !empty($errors['posted_start_at']) ? 'is-invalid' : '' }}"
                                                id="form__posted_start_at" type="text" name="posted_start_at" readonly
                                                data-date-format="yyyy-mm-dd" placeholder="Input Start Date (Optional)"
                                                value="{{ Request::post('posted_start_at', $job['posted_start_at']) }}" />
                                            <span class="input-group-text" for="form__posted_start_at">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <div class="invalid-feedback">
                                                {{ !empty($errors['posted_start_at']) ? $errors['posted_start_at'] : '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pb-3"></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="form__posted_end_at" class="form-label">End Date</label>
                                        <div class="input-group date">
                                            <input
                                                class="form-control {{ !empty($errors['posted_end_at']) ? 'is-invalid' : '' }}"
                                                id="form__posted_end_at" type="text" name="posted_end_at" readonly
                                                data-date-format="yyyy-mm-dd" placeholder="Input End Date (Optional)"
                                                value="{{ Request::post('posted_end_at', $job['posted_end_at']) }}" />
                                            <span class="input-group-text" for="form__posted_end_at">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <div class="invalid-feedback">
                                                {{ !empty($errors['posted_end_at']) ? $errors['posted_end_at'] : '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pb-3"></div>
                                </div>
                            </div>


                            <div class="pb-5"></div>

                            <div class="d-flex justify-content-between">
                                <input type="hidden" name="status" value="">
                                <button type="submit" class="btn btn-warning btn__save" name="status" value="draft">Save
                                    to
                                    Draft</button>
                                <button type="submit" class="btn btn-primary btn__save" name="status"
                                    value="publish">Save &amp;
                                    Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('topSlot')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <style>
        .input-daterange input {
            text-align: left;
        }
    </style>
@endsection

@section('btmSlot')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $(function() {
            $("#form__posted_start_at").datepicker({
                autoclose: true,
                todayHighlight: true,
                todayBtn: "linked",
                clearBtn: true,
            });

            $("#form__posted_end_at").datepicker({
                autoclose: true,
                todayHighlight: true,
                todayBtn: "linked",
                clearBtn: true,
            });

            $('#form__responsible').summernote({
                placeholder: 'Input Responsible',
                height: 300,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                ]
            });

            $('#form__requirement').summernote({
                placeholder: 'Input Requirement',
                height: 300,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                ]
            });
        });
    </script>
@endsection
