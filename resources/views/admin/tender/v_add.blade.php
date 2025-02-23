@extends('admin/v_template')

@section('main')
  <div class="row">
    <div class="col-lg-12">
      <div class="main__header d-flex justify-content-between">
        <h1 class="h3">Add New <strong>Tender</strong></h1>
        <a href="{{ route('tender.tenderIndex') }}" class="btn btn-outline-secondary">Back to list</a>
      </div>
      <div class="main__body">

        <div class="card">
          <div class="card-body">
            <form action="{{ url()->current() }}" method="post" onsubmit="submitForm(this, event)">
              @csrf
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label for="tender__shipyard_id" class="form-label">Company Name</label>
                    <select class="form-select select2-select" name="shipyard_id" id="tender__shipyard_id">
                      <option value="">Select Shipyard Company</option>
                      @if (!empty($shipyards))
                        @foreach ($shipyards as $_val)
                          <option value="{{ $_val['id'] }}">{{ strtoupper($_val['name']) }}</option>
                        @endforeach
                      @endif
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="tender__phone" class="form-label">Whatsapp Number</label>
                    <input type="text" class="form-control" name="phone" id="tender__phone"
                      placeholder="Input Whatsapp Number" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="tender__email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="tender__email" placeholder="Input Email"
                      value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="tender__status" class="form-label">Status</label>
                    <select class="form-select select2-input" name="tender_status" id="tender__status">
                      @foreach (config('custom')['tender_status'] as $_val)
                        <option value="{{ $_val }}">{{ strtoupper($_val) }}
                        </option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="tender__closed_date" class="form-label">Auto Closed Date</label>
                    <input type="text" class="form-control" name="closed_date" id="tender__closed_date"
                      placeholder="Input Closed Date" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label for="tender__title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="tender__title" placeholder="Input Title"
                      value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label for="tender__description" class="form-label">Description</label>
                    <textarea type="text" class="form-control" name="description" id="tender__description"
                      placeholder="Input Description"></textarea>
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
      $("#tender__closed_date").datepicker({
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        clearBtn: true,
      });

      $('#tender__description').summernote({
        placeholder: 'Input Tender Description',
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
              $(`#tender__${key}`).addClass('is-invalid');
              $(`#tender__${key}`).siblings('.invalid-feedback').text(response[key]);
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
