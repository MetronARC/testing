@extends('admin/v_template')

@section('main')
  <div class="row">
    <div class="col-lg-12">
      <div class="main__header d-flex justify-content-between">
        <h1 class="h3">Add New <strong>Vendor</strong></h1>
        <a href="{{ route('vendor.vendorIndex') }}" class="btn btn-outline-secondary">Back to list</a>
      </div>
      <div class="main__body">

        <div class="card">
          <div class="card-body">
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data"
              onsubmit="submitForm(this, event)">
              @csrf
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__type" class="form-label">Vendor Type</label>
                    <select class="form-select select2-select" name="type" id="vendor__type">
                      <option value="">Select Vendor Type</option>
                      @foreach (config('custom')['type'] as $_key => $_val)
                        <option value="{{ $_key }}">{{ strtoupper($_val) }}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__name" class="form-label">Vendor Name</label>
                    <input type="text" class="form-control" name="name" id="vendor__name"
                      placeholder="Input Vendor Name" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__logo" class="form-label">Vendor Logo</label>
                    <input type="file" class="form-control" name="logo" id="vendor__logo" placeholder="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__vendor_status" class="form-label">Vendor Status</label>
                    <select class="form-select select2-select" name="vendor_status" id="vendor__vendor_status">
                      <option value="">Select Vendor Status</option>
                      @foreach (config('custom')['vendor_status'] as $_key => $_val)
                        <option value="{{ $_key }}">{{ $_val }}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__listing_number" class="form-label">Listing Number</label>
                    <input type="text" class="form-control" name="listing_number" id="vendor__listing_number"
                      placeholder="Input Listing Number" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__listing_status" class="form-label">Listing Status</label>
                    <select class="form-select select2-select" name="listing_status" id="vendor__listing_status">
                      <option value="">Select Listing Status</option>
                      @foreach (config('custom')['listing_status'] as $_key => $_val)
                        <option value="{{ $_key }}">{{ $_val }}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__location" class="form-label" data-bs-toggle="tooltip"
                      data-bs-original-title="To add new location you just need to type the new location."
                      data-bs-custom-class="custom-tooltip">Location <i class="fas fa-question-circle"></i></label>
                    <select class="form-select select2-input" name="location" id="vendor__location">
                      <option value="">Select Location</option>
                      @foreach ($vendorLocations as $_val)
                        <option value="{{ $_val }}">{{ strtoupper($_val) }}
                        </option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="pb-3"></div>
              <div class="mb-3 d-flex justify-content-between">
                <div><b>ADDRESS</b></div>
                <div>
                  <button type="button" class="btn btn-sm btn-info" onclick="addAddressLocation();"><i
                      class="fas fa-plus"></i>
                    Add Address</button>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__address_location_address" class="form-label">Address</label>
                    <textarea class="form-control" name="address_location_address[]" id="vendor__address_location_address"
                      placeholder="Input Location Address " rows="4"></textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__address_location_phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" name="address_location_phone[]"
                      id="vendor__address_location_phone" placeholder="Input Location Phone" value="">
                  </div>
                </div>
              </div>

              <div id="newAddressLocation"></div>

              <div class="mb-3">
                <label for="vendor__website" class="form-label">Website URL</label>
                <input type="tel" class="form-control" name="website_url" id="vendor__website"
                  placeholder="Input Website URL" value="">
                <div class="invalid-feedback"></div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__latitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control" name="latitude" id="shipyard__latitude"
                      placeholder="Input Latitude" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__longitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control" name="longitude" id="shipyard__longitude"
                      placeholder="Input longitude" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="pb-4"></div>
              <div class="mb-3 d-flex justify-content-between">
                <div><b>CONTACT</b></div>
                <div>
                  <button type="button" class="btn btn-sm btn-info" onclick="addContact();"><i
                      class="fas fa-plus"></i>
                    Add Contact</button>
                </div>
              </div>
              <div class="mb-3" id="newContact"></div>

              <div class="pb-4"></div>
              <div class="mb-3"><b>GENERAL</b></div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__establish_year" class="form-label">Established Year</label>
                    <input type="number" class="form-control" name="established_year" id="vendor__establish_year"
                      placeholder="Input Establish Year" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__group" class="form-label">Coorporate Group</label>
                    <input type="text" class="form-control" name="group" id="vendor__group"
                      placeholder="Input Group" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="pb-3"></div>
              <div class="mb-3"><b>SERVICES / PRODUCTS</b></div>

              <div class="mb-3">
                <textarea class="form-control" name="service" id="vendor__certificate" placeholder="Input Service / Product"
                  rows="4"></textarea>
              </div>

              <div class="pb-3"></div>
              <div class="mb-3"><b>CERTIFICATES</b></div>

              <div class="mb-3">
                <textarea class="form-control" name="certificate" id="vendor__certificate" placeholder="Input Certificates"
                  rows="4"></textarea>
              </div>

              <div class="pb-4"></div>
              <div class="mb-3 d-flex justify-content-between">
                <div data-bs-toggle="tooltip" data-bs-original-title="If error happen you need to add image again."
                  data-bs-custom-class="custom-tooltip"><b>IMAGES</b> <i class="fas fa-question-circle"></i></div>
                <div>
                  <button type="button" class="btn btn-sm btn-info" onclick="addImage();"><i class="fas fa-plus"></i>
                    Add Image</button>
                </div>
              </div>
              <div class="mb-3" id="newImage"></div>

              <div class="pb-4"></div>
              <div class="mb-3 d-flex justify-content-between">
                <div><b>YOUTUBE URL VIDEO</b></div>
                <div>
                  <button type="button" class="btn btn-sm btn-info" onclick="addVideo();"><i class="fas fa-plus"></i>
                    Add Video URL</button>
                </div>
              </div>
              <div class="mb-3" id="newVideo"></div>

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
@endsection

@section('btmSlot')
  <script>
    let addressLocationArr = [];
    let contactArr = [];
    let imageArr = [];
    let videoArr = [];

    function addAddressLocation() {
      addressLocationArr.push({
        "address": "",
        "phone": ""
      });

      generateAddressLocationHtml();
    }

    function generateAddressLocationHtml() {
      let html = '';

      for (let key in addressLocationArr) {
        let index = parseInt(key) + 2;

        html += `
          <div class="address_location__new">
            <div class="pb-3"></div>
            <div class="mb-3 d-flex justify-content-between">
              <div><b>ADDRESS (${index})</b></div>
              <div>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeAddressLocation(${key});"><i class="fas fa-minus"></i> Remove Address</button>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="vendor__address_location_address_${index}" class="form-label">Address</label>
                  <textarea class="form-control" name="address_location_address[]"
                    id="vendor__address_location_address_${index}" placeholder="Input Location Address " rows="4" onkeyup="changeAddressLocationValue(${key}, 'address', this);">${addressLocationArr[key].address}</textarea>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="vendor__address_location_phone_${index}" class="form-label">Phone</label>
                  <input type="tel" class="form-control"
                    name="address_location_phone[]" id="vendor__address_location_phone_${index}" placeholder="Input Location Phone"
                    value="${addressLocationArr[key].phone}" onkeyup="changeAddressLocationValue(${key}, 'phone', this);">
                </div>
              </div>
            </div>
          </div>
        `;
      }

      $('#newAddressLocation').html(html);
    }

    function changeAddressLocationValue(key, label, base) {
      addressLocationArr[key][label] = $(base).val();
    }

    function removeAddressLocation(key) {
      addressLocationArr.splice(key, 1);
      generateAddressLocationHtml();
    }

    function addContact() {
      contactArr.push({
        "name": "",
        "position": "",
        "phone": "",
        "email": ""
      });

      generateContactHtml();
    }

    function generateContactHtml() {
      let html = '';

      for (let key in contactArr) {
        let index = parseInt(key) + 1;

        html += `
          <div class="row mb-3">
            <div class="col-lg-11">
              <div class="row">
                <div class="col-lg-3">
                  <input type="text" class="form-control" name="contact_name[]" id="vendor__contact_name_${index}"
                    placeholder="Input Name" value="${contactArr[key].name}" onkeyup="changeContactValue(${key}, 'name', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-3">
                  <input type="text" class="form-control" name="contact_position[]" id="vendor__contact_position_${index}"
                    placeholder="Input Position" value="${contactArr[key].position}"
                    onkeyup="changeContactValue(${key}, 'position', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-3">
                  <input type="text" class="form-control" name="contact_phone[]" id="vendor__contact_phone_${index}"
                    placeholder="Input Phone" value="${contactArr[key].phone}"
                    onkeyup="changeContactValue(${key}, 'phone', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-3">
                  <input type="text" class="form-control" name="contact_email[]" id="vendor__contact_email_${index}"
                    placeholder="Input Email" value="${contactArr[key].email}"
                    onkeyup="changeContactValue(${key}, 'email', this);">
                  <div class="invalid-feedback"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-1">
              <button type="button" class="btn btn-danger" onclick="removeContact(${key});"><i class="fas fa-minus"></i></button>
            </div>
          </div>
        `;
      }

      $('#newContact').html(html);
    }

    function changeContactValue(key, label, base) {
      contactArr[key][label] = $(base).val();
    }

    function removeContact(key) {
      contactArr.splice(key, 1);
      generateContactHtml();
    }

    function addImage() {
      imageArr.push("");

      generateImageHtml();
    }

    function generateImageHtml() {
      let html = '';

      for (let key in imageArr) {
        let index = parseInt(key) + 1;

        html += `
          <div class="row mb-3">
            <div class="col-lg-11">
              <input type="file" name="image[]" class="form-control" id="shipyard__image_${index}">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg-1">
              <button type="button" class="btn btn-danger" onclick="removeImage(${key});"><i class="fas fa-minus"></i></button>
            </div>
          </div>
        `;
      }

      $('#newImage').html(html);
    }

    function changeImageValue(key, label, base) {
      imageArr[key][label] = $(base).val();
    }

    function removeImage(key) {
      imageArr.splice(key, 1);
      generateImageHtml();
    }

    function addVideo() {
      videoArr.push("");

      generateVideoHtml();
    }

    function generateVideoHtml() {
      let html = '';

      for (let key in videoArr) {
        let index = parseInt(key) + 1;

        html += `
          <div class="row mb-3">
            <div class="col-lg-11">
              <input type="text" class="form-control" name="video_url[]" id="shipyard__video_url_${index}"
                placeholder="Input Youtube Video URL" value="${videoArr[key]}" onkeyup="changeVideoValue(${key}, 'url', this);">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg-1">
              <button type="button" class="btn btn-danger" onclick="removeVideo(${key});"><i class="fas fa-minus"></i></button>
            </div>
          </div>
        `;
      }

      $('#newVideo').html(html);
    }

    function changeVideoValue(key, label, base) {
      videoArr[key][label] = $(base).val();
    }

    function removeVideo(key) {
      videoArr.splice(key, 1);
      generateVideoHtml();
    }

    function changeStatus(status) {
      $('[name="status"]').val(status);
    }

    function submitForm(base, e) {
      e.preventDefault();

      $('.btn__save').prop("disabled", true);

      const formData = new FormData(base);

      formData.delete('image[]');

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
              $(`#vendor__${key}`).addClass('is-invalid');
              $(`#vendor__${key}`).siblings('.invalid-feedback').text(response[key]);
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
