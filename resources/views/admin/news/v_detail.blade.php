@extends('admin/v_template')

@section('main')
  <div class="row">
    <div class="col-lg-12">
      <div class="main__header d-flex justify-content-between">
        <h1 class="h3"><strong>News</strong> Detail</h1>
        <a href="{{ route('news.newsIndex') }}" class="btn btn-outline-secondary">Back to list</a>
      </div>
      <div class="main__body">

        <div class="card">
          <div class="card-body">
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data" onsubmit="submitForm(this, event)">
              @csrf
              <div class="row">
                <div class="col-lg-2">
                  <img src="{{ cdnUrl($news['image']) }}" alt="news banner" class="w-100">
                </div>
                <div class="col-lg-10">
                  <div class="mb-3">
                    <label for="news__image" class="form-label">Banner</label>
                    <input type="file" class="form-control" name="image" id="news__image" accept="image/*">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label for="news__title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="news__title"
                      placeholder="Input News Title" value="{{ $news['title'] }}">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label for="news__description" class="form-label">Description</label>
                    <textarea type="text" class="form-control" name="description" id="news__description" rows="4" placeholder="Input Description">{{ $news['description'] }}</textarea>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label for="news__content" class="form-label">Content</label>
                    <textarea type="text" class="form-control" name="content" id="news__content" placeholder="Input Content">{!! $news['content'] !!}</textarea>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
               <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label for="news__category" class="form-label" data-bs-toggle="tooltip"
                      data-bs-original-title="To add new category you just need to type the new categiry."
                      data-bs-custom-class="custom-tooltip">Category <i class="fas fa-question-circle"></i></label>
                    <select class="form-select select2-input" name="category" id="news__category">
                      <option value="">Select Category</option>
                      @foreach ($newsCategories as $_val)
                        <option value="{{ $_val }}" {{ $_val == $news['category'] ? 'selected' : '' }}>{{ $_val }}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label for="news__start_date" class="form-label">Start Date</label>
                    <input type="text" class="form-control" name="start_date" id="news__start_date"
                      placeholder="Input Start Date" value="{{ date('m/d/Y', strtotime($news['start_date'])) }}">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="pb-5"></div>

              <div class="d-flex justify-content-between">
                <input type="hidden" name="status" value="">
                <button type="submit" class="btn btn-warning btn__save" onclick="changeStatus('draft');">Save to
                  Draft</button>
                <button type="submit" class="btn btn-primary btn__save" onclick="changeStatus('publish');">Save &amp;
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
  <!-- include summernote css/js -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('btmSlot')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(function() {
      $("#news__start_date").datepicker({
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        clearBtn: true,
      });

      $('#news__content').summernote({
        placeholder: 'Input News Content',
        height: 500,
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

    function changeStatus(status) {
      $('[name="status"]').val(status);
    }

    function submitForm(base, e) {
      e.preventDefault();

      $('.btn__save').prop("disabled", true);

      const formData = new FormData(base);

      $.ajax({
        type: base.method,
        url: base.action,
        data: formData,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
          console.log(response);
          if (Object.keys(response).length === 0) {
            $(base).append('<input type="hidden" name="is_submit" value="1" />');
            $(base).removeAttr('onsubmit');
            $(base).submit();
          } else {
            for (let key in response) {
              $(`#news__${key}`).addClass('is-invalid');
              $(`#news__${key}`).siblings('.invalid-feedback').text(response[key]);
            }

            $("html, body").animate({
              scrollTop: 0
            }, "slow");

            $('.btn__save').prop('disabled', false);
          }
        },
        error: function(xhr, status, error) {
          // This code runs if the AJAX request encounters an error
          console.log("Request error:", error);

          $('.btn__save').prop('disabled', false);
        },
        complete: function(xhr, status) {
          // This code runs after the AJAX request is complete (success or error)
          console.log("Request complete. Status:", status);
        }
      });
    }
  </script>
@endsection
