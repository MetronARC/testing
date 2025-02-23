@extends('admin/v_template')

@section('main')
  <div class="row">
    <div class="col-lg-12">
      <div class="main__header d-flex justify-content-between">
        <h1 class="h3"><strong>Vendor</strong> Detail</h1>
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
                        <option value="{{ $_key }}" {{ $vendor['type'] == $_key ? 'selected' : '' }}>
                          {{ strtoupper($_val) }}
                        </option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__name" class="form-label">Vendor Name</label>
                    <input type="text" class="form-control" name="name" id="vendor__name"
                      placeholder="Input Vendor Name" value="{{ $vendor['name'] }}">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 mb-3">
                  <label for="vendor__logo" class="form-label">Vendor Logo</label>
                  <div class="row">
                    @if (!empty($vendor['logo']))
                      <div class="col-3">
                        <img src="{{ cdnUrl($vendor['logo']) }}" class="w-100" alt="logo" />
                      </div>
                    @endif
                    <div class="{{ !empty($vendor['logo']) ? 'col-9' : 'col-12' }}">
                      <input type="file" class="form-control {{ !empty($errors['logo']) ? 'is-invalid' : '' }}"
                        name="logo" id="vendor__logo" placeholder="">
                      @if (!empty($errors['logo']))
                        <div class="invalid-feedback">{{ $errors['logo'] }}</div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__vendor_status" class="form-label">Vendor Status</label>
                    <select class="form-select select2-select" name="vendor_status" id="vendor__vendor_status">
                      <option value="">Select Vendor Status</option>
                      @foreach (config('custom')['vendor_status'] as $_key => $_val)
                        <option value="{{ $_key }}" {{ $vendor['vendor_status'] == $_key ? 'selected' : '' }}>
                          {{ $_val }}</option>
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
                      placeholder="Input Listing Number" value="{{ $vendor['listing_number'] }}">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__listing_status" class="form-label">Listing Status</label>
                    <select class="form-select select2-select" name="listing_status" id="vendor__listing_status">
                      <option value="">Select Listing Status</option>
                      @foreach (config('custom')['listing_status'] as $_key => $_val)
                        <option value="{{ $_key }}" {{ $vendor['listing_status'] == $_key ? 'selected' : '' }}>
                          {{ $_val }}</option>
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
                        <option value="{{ $_val }}" {{ $vendor['location'] == $_val ? 'selected' : '' }}>
                          {{ strtoupper($_val) }}
                        </option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div id="newAddressLocation"></div>

              <div class="mb-3">
                <label for="vendor__website" class="form-label">Website URL</label>
                <input type="tel" class="form-control" name="website_url" id="vendor__website"
                  placeholder="Input Website URL" value="{{ $vendor['website_url'] }}">
                <div class="invalid-feedback"></div>
              </div>

                            <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__latitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control" name="latitude" id="shipyard__latitude"
                      placeholder="Input Latitude" value="{{ $vendor['latitude'] ?? '' }}">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__longitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control" name="longitude" id="shipyard__longitude"
                      placeholder="Input longitude" value="{{ $vendor['longitude'] ?? '' }}">
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
                      placeholder="Input Establish Year" value="{{ $vendor['established_year'] }}">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="vendor__group" class="form-label">Coorporate Group</label>
                    <input type="text" class="form-control" name="group" id="vendor__group"
                      placeholder="Input Group" value="{{ $vendor['group'] }}">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="pb-3"></div>
              <div class="mb-3"><b>SERVICES / PRODUCTS</b></div>

              <div class="mb-3">
                <textarea class="form-control" name="service" id="vendor__certificate" placeholder="Input Service / Product"
                  rows="4">{{ $vendor['service'] }}</textarea>
              </div>

              <div class="pb-3"></div>
              <div class="mb-3"><b>CERTIFICATES</b></div>

              <div class="mb-3">
                <textarea class="form-control" name="certificate" id="vendor__certificate" placeholder="Input Certificates"
                  rows="4">{{ $vendor['certificate'] }}</textarea>
              </div>

              <div class="pb-4"></div>
              <div class="mb-3 d-flex justify-content-between">
                <div><b>IMAGE</b></div>
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
                <button type="submit" class="btn btn-warning btn__save" onclick="changeStatus('draft');">Save to Draft</button>
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
    let addressLocationArr = {!! !empty($vendor['addressLocation_location']) ? $vendor['addressLocation_location'] : '[]' !!};
    let contactArr = {!! !empty($vendor['contact']) ? $vendor['contact'] : '[]' !!};
    let gravingArr = {!! !empty($vendor['graving_dock']) ? $vendor['graving_dock'] : '[]' !!};
    let floatingArr = {!! !empty($vendor['floating_dock']) ? $vendor['floating_dock'] : '[]' !!};
    let shipRepairArr = {!! !empty($vendor['ship_repair']) ? $vendor['ship_repair'] : '[]' !!};
    let newBuildingArr = {!! !empty($vendor['new_building']) ? $vendor['new_building'] : '[]' !!};
    let imageArr = {!! !empty($vendor['image']) ? $vendor['image'] : '[]' !!};
    let videoArr = {!! !empty($vendor['video']) ? $vendor['video'] : '[]' !!};

    if (addressLocationArr.length == 0) {
      addAddressLocation();
    } else {
      generateAddressLocationHtml();
    }

    generateContactHtml();
    generateGravingHtml();
    generateFloatingHtml();
    generateShipRepairHtml();
    generateNewBuildingHtml();
    generateImageHtml();
    generateVideoHtml();

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
        let addressLocationIndex = parseInt(key) + 1;

        html += `
          <div class="addressLocation__new">
            <div class="pb-3"></div>
            <div class="mb-3 d-flex justify-content-between">
              <div><b>YARD ${addressLocationIndex > 1 ? '('+addressLocationIndex+')' : ''}</b></div>
              <div>
                ${ key == 0 ? '<button type="button" class="btn btn-sm btn-info" onclick="addAddressLocation();"><i class="fas fa-plus"></i>Add AddressLocation</button>' : '<button type="button" class="btn btn-sm btn-danger" onclick="removeAddressLocation('+key+');"><i class="fas fa-minus"></i> Remove AddressLocation</button>' }
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="vendor__addressLocation_address_${addressLocationIndex}" class="form-label">Address</label>
                  <textarea class="form-control" name="addressLocation_address[]"
                    id="vendor__addressLocation_address_${addressLocationIndex}" placeholder="Input AddressLocation Address" rows="4" onkeyup="changeAddressLocationValue(${key}, 'address', this);">${addressLocationArr[key].address}</textarea>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="vendor__addressLocation_phone_${addressLocationIndex}" class="form-label">Phone</label>
                  <input type="tel" class="form-control"
                    name="addressLocation_phone[]" id="vendor__addressLocation_phone_${addressLocationIndex}" placeholder="Input AddressLocation Phone"
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

    function addGravingDock() {
      gravingArr.push({
        "label": "",
        "value": ""
      });

      generateGravingHtml();
    }

    function generateGravingHtml() {
      let html = '';

      for (let key in gravingArr) {
        let index = parseInt(key) + 1;

        html += `
          <div class="row mb-3">
            <div class="col-lg-11">
              <div class="row">
                <div class="col-lg-6">
                  <input type="text" class="form-control" name="graving_dock_label[]" id="vendor__graving_dock_label_${index}"
                    placeholder="Input Label" value="${gravingArr[key].label}" onkeyup="changeGravingValue(${key}, 'label', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="form-control" name="graving_dock_value[]" id="vendor__graving_dock_value_${index}"
                    placeholder="Input Value" value="${gravingArr[key].value}" onkeyup="changeGravingValue(${key}, 'value', this);">
                  <div class="invalid-feedback"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-1">
              <button type="button" class="btn btn-danger" onclick="removeGraving(${key});"><i class="fas fa-minus"></i></button>
            </div>
          </div>
        `;
      }

      $('#newGravingDock').html(html);
    }

    function changeGravingValue(key, label, base) {
      gravingArr[key][label] = $(base).val();
    }

    function removeGraving(key) {
      gravingArr.splice(key, 1);
      generateGravingHtml();
    }

    function addFloatingDock() {
      floatingArr.push({
        "label": "",
        "value": ""
      });

      generateFloatingHtml();
    }

    function generateFloatingHtml() {
      let html = '';

      for (let key in floatingArr) {
        let index = parseInt(key) + 1;

        html += `
          <div class="row mb-3">
            <div class="col-lg-11">
              <div class="row">
                <div class="col-lg-6">
                  <input type="text" class="form-control" name="floating_dock_label[]" id="vendor__floating_dock_label_${index}"
                    placeholder="Input Label" value="${floatingArr[key].label}" onkeyup="changeFloatingValue(${key}, 'label', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="form-control" name="floating_dock_value[]" id="vendor__floating_dock_value_${index}"
                    placeholder="Input Value" value="${floatingArr[key].value}" onkeyup="changeFloatingValue(${key}, 'value', this);">
                  <div class="invalid-feedback"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-1">
              <button type="button" class="btn btn-danger" onclick="removeFloating(${key});"><i class="fas fa-minus"></i></button>
            </div>
          </div>
        `;
      }

      $('#newFloatingDock').html(html);
    }

    function changeFloatingValue(key, label, base) {
      floatingArr[key][label] = $(base).val();
    }

    function removeFloating(key) {
      floatingArr.splice(key, 1);
      generateFloatingHtml();
    }

    function addShipRepair() {
      shipRepairArr.push({
        "hull": "",
        "owner": "",
        "type": "",
        "dimension": "",
        "date": ""
      });

      generateShipRepairHtml();
    }

    function generateShipRepairHtml() {
      let html = '';

      for (let key in shipRepairArr) {
        let index = parseInt(key) + 1;

        html += `
      <div class="row mb-3">
        <div class="col-lg-11">
          <div class="row">
            <div class="col-lg">
              <input type="text" class="form-control" name="ship_repair_hull[]" id="vendor__ship_repair_hull_${index}"
                placeholder="Input Hull No" value="${shipRepairArr[key].hull}"
                onkeyup="changeShipRepairValue(${key}, 'hull', this);">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg">
              <input type="text" class="form-control" name="ship_repair_owner[]" id="vendor__ship_repair_owner_${index}"
                placeholder="Input Owner" value="${shipRepairArr[key].owner}"
                onkeyup="changeShipRepairValue(${key}, 'owner', this);">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg">
              <input type="text" class="form-control" name="ship_repair_type[]" id="vendor__ship_repair_type_${index}"
                placeholder="Input Ship Type" value="${shipRepairArr[key].type}"
                onkeyup="changeShipRepairValue(${key}, 'type', this);">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg">
              <input type="text" class="form-control" name="ship_repair_dimension[]" id="vendor__ship_repair_dimension_${index}"
                placeholder="Input Dimension" value="${shipRepairArr[key].dimension}"
                onkeyup="changeShipRepairValue(${key}, 'dimension', this);">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg">
              <input type="text" class="form-control" name="ship_repair_date[]" id="vendor__ship_repair_date_${index}"
                placeholder="Input Date" value="${shipRepairArr[key].date}"
                onkeyup="changeShipRepairValue(${key}, 'date', this);">
              <div class="invalid-feedback"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-1">
          <button type="button" class="btn btn-danger" onclick="removeShipRepair(${key});"><i class="fas fa-minus"></i></button>
        </div>
      </div>
    `;
      }

      $('#newShipRepair').html(html);
    }

    function changeShipRepairValue(key, label, base) {
      shipRepairArr[key][label] = $(base).val();
    }

    function removeShipRepair(key) {
      shipRepairArr.splice(key, 1);
      generateShipRepairHtml();
    }

    function addNewBuilding() {
      newBuildingArr.push({
        "ship_name": "",
        "ship_type": "",
        "owner": "",
        "date": "",
        "work_type": ""
      });

      generateNewBuildingHtml();
    }

    function generateNewBuildingHtml() {
      let html = '';

      for (let key in newBuildingArr) {
        let index = parseInt(key) + 1;

        html += `
          <div class="row mb-3">
            <div class="col-lg-11">
              <div class="row">
                <div class="col-lg">
                  <input type="text" class="form-control" name="new_building_ship_name[]" id="vendor__new_building_ship_name_${index}"
                    placeholder="Input Ship Name" value="${newBuildingArr[key].ship_name}"
                    onkeyup="changeNewBuildingValue(${key}, 'ship_name', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg">
                  <input type="text" class="form-control" name="new_building_ship_type[]" id="vendor__new_building_ship_type_${index}"
                    placeholder="Input Ship Type" value="${newBuildingArr[key].ship_type}"
                    onkeyup="changeNewBuildingValue(${key}, 'ship_type', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg">
                  <input type="text" class="form-control" name="new_building_owner[]" id="vendor__new_building_owner_${index}"
                    placeholder="Input Owner" value="${newBuildingArr[key].owner}"
                    onkeyup="changeNewBuildingValue(${key}, 'owner', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg">
                  <input type="text" class="form-control" name="new_building_date[]" id="vendor__new_building_date_${index}"
                    placeholder="Input Completed Date" value="${newBuildingArr[key].date}"
                    onkeyup="changeNewBuildingValue(${key}, 'date', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg">
                  <input type="text" class="form-control" name="new_building_work_type[]" id="vendor__new_building_work_type_${index}"
                    placeholder="Input Work Type" value="${newBuildingArr[key].work_type}"
                    onkeyup="changeNewBuildingValue(${key}, 'work_type', this);">
                  <div class="invalid-feedback"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-1">
              <button type="button" class="btn btn-danger" onclick="removeNewBuilding(${key});"><i class="fas fa-minus"></i></button>
            </div>
          </div>
        `;
      }

      $('#newNewBuilding').html(html);
    }

    function changeNewBuildingValue(key, label, base) {
      newBuildingArr[key][label] = $(base).val();
    }

    function removeNewBuilding(key) {
      newBuildingArr.splice(key, 1);
      generateNewBuildingHtml();
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
            ${ imageArr[key].length > 0 ? '<div class="col-lg-2"><img src="{{ cdnUrl() }}'+imageArr[key]+'" alt="" class="w-100" /></div>' : '' }
            ${ imageArr[key].length > 0 ? '<div class="col-lg-9">' : '<div class="col-lg-11">' }
              <input type="file" name="image[]" class="form-control" id="shipyard__image_${index}">
              <input type="hidden" name="image_filename[]" value="${imageArr[key]}">
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
                placeholder="Input Youtube Video URL" value="${ videoArr[key] ? 'https://www.youtube.com/watch?v='+videoArr[key] : '' }" onkeyup="changeVideoValue(${key}, 'url', this);">
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
