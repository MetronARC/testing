@extends('admin/v_template')

@section('main')
  <div class="row">
    <div class="col-lg-12">
      <div class="main__header d-flex justify-content-between">
        <h1 class="h3">Add New <strong>Shipyard</strong></h1>
        <a href="{{ route('shipyard.shipyardIndex') }}" class="btn btn-outline-secondary">Back to list</a>
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
                    <label for="shipyard__type" class="form-label">Shipyard Type</label>
                    <select class="form-select select2-select" name="type" id="shipyard__type">
                      <option value="">Select Shipyard Type</option>
                      @foreach (config('custom')['type'] as $_key => $_val)
                        <option value="{{ $_key }}">{{ strtoupper($_val) }}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__name" class="form-label">Shipyard Name</label>
                    <input type="text" class="form-control" name="name" id="shipyard__name"
                      placeholder="Input Shipyard Name" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__logo" class="form-label">Shipyard Logo</label>
                    <input type="file" class="form-control" name="logo" id="shipyard__logo" placeholder="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__other_name" class="form-label">Other Name</label>
                    <input type="text" class="form-control" name="other_name" id="shipyard__other_name"
                      placeholder="Input Other Name" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__listing_number" class="form-label">Listing Number</label>
                    <input type="text" class="form-control" name="listing_number" id="shipyard__listing_number"
                      placeholder="Input Listing Number" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__location" class="form-label" data-bs-toggle="tooltip"
                      data-bs-original-title="To add new city location you just need to type the new city location."
                      data-bs-custom-class="custom-tooltip">City Location <i class="fas fa-question-circle"></i></label>
                    <select class="form-select select2-input" name="location" id="shipyard__location">
                      <option value="">Select City Location</option>
                      @foreach ($shipyardLocations as $_val)
                        <option value="{{ $_val }}">{{ strtoupper($_val) }}
                        </option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__category" class="form-label">Shipyard Service Types</label>
                    <select class="form-select select2-multiples-notag" name="category[]" id="shipyard__category"
                      multiple="multiple">
                      @foreach (config('custom')['category'] as $_val)
                        <option value="{{ strtolower($_val) }}">{{ strtolower($_val) }}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="pb-3"></div>
              <div class="mb-3"><b>HEAD QUARTER</b></div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__office_address" class="form-label">Address</label>
                    <textarea class="form-control" name="office_address" id="shipyard__office_address"
                      placeholder="Input Office Address" rows="4"></textarea>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__office_phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" name="office_phone" id="shipyard__office_phone"
                      placeholder="Input Office Phone" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="pb-3"></div>
              <div class="mb-3 d-flex justify-content-between">
                <div><b>YARD</b></div>
                <div>
                  <button type="button" class="btn btn-sm btn-info" onclick="addYard();"><i class="fas fa-plus"></i>
                    Add Yard</button>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__yard_address" class="form-label">Address</label>
                    <textarea class="form-control" name="yard_address[]" id="shipyard__yard_address" placeholder="Input Yard Address"
                      rows="4"></textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__yard_phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" name="yard_phone[]" id="shipyard__yard_phone"
                      placeholder="Input Yard Phone" value="">
                  </div>
                </div>
              </div>

              <div id="newYard"></div>

              <div class="mb-3">
                <label for="shipyard__website" class="form-label">SHIPYARD BRANCH</label>
                <select class="form-select select2-multiples-notag" name="branch[]" id="shipyard__branch"
                  multiple="multiple">
                  @foreach ($shipyards as $_val)
                    <option value="{{ $_val['id'] }}">
                      {{ strtoupper($_val['type']) }} {{ $_val['name'] }}
                    </option>
                  @endforeach
                </select>
                <div class="invalid-feedback"></div>
              </div>

              <div class="mb-3">
                <label for="shipyard__website" class="form-label">Website URL</label>
                <input type="tel" class="form-control" name="website_url" id="shipyard__website"
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

              <div class="pb-3"></div>
              <div class="mb-3"><b>RFQ</b></div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="rfq_email" class="form-label">RFQ Email</label>
                    <input type="email" class="form-control" name="rfq_email" id="rfq_email"
                      placeholder="Input RFQ Email" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="rfq_phone" class="form-label">RFQ Phone</label>
                    <input type="tel" class="form-control" name="rfq_phone" id="rfq_phone"
                      placeholder="Input RFQ Phone" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="pb-3"></div>
                  <div class="mb-3"><b>SERVICES</b></div>

                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="service_shiprepair" value="1"
                      id="service_shiprepair">
                    <label class="form-check-label" for="service_shiprepair">
                      Ship Repair/Conversion/Retrofit
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="service_building" value="1"
                      id="service_building">
                    <label class="form-check-label" for="service_building">
                      Ship Building
                    </label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="pb-3"></div>
                  <div class="mb-3"><b>CONSTRUCTION MATERIAL</b></div>

                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="construction_steel" value="1"
                      id="construction_steel">
                    <label class="form-check-label" for="construction_steel">
                      Steel
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="construction_aluminium" value="1"
                      id="construction_aluminium">
                    <label class="form-check-label" for="construction_aluminium">
                      Aluminum
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="construction_other" value="1"
                      id="construction_other">
                    <label class="form-check-label" for="construction_other">
                      Wood, FRP, Fiberglass, others
                    </label>
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
                    <label for="shipyard__establish_year" class="form-label">Established Year</label>
                    <input type="number" class="form-control" name="established_year" id="shipyard__establish_year"
                      placeholder="Input Establish Year" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__group" class="form-label">Coorporate Group</label>
                    <input type="text" class="form-control" name="group" id="shipyard__group"
                      placeholder="Input Group" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__total_area" class="form-label">Total Area</label>
                    <input type="text" class="form-control" name="total_area" id="shipyard__total_area"
                      placeholder="Input Total Area" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="shipyard__waterdepth" class="form-label">Water Depth</label>
                    <input type="text" class="form-control" name="water_depth" id="shipyard__waterdepth"
                      placeholder="Input Water Depth" value="">
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <div class="pb-3"></div>

              <div class="mb-3 d-flex justify-content-between">
                <div><b>GRAVING DOCK</b></div>
                <div>
                  <button type="button" class="btn btn-sm btn-info" onclick="addGravingDock();"><i
                      class="fas fa-plus"></i>
                    Add Graving Dock</button>
                </div>
              </div>

              <div class="mb-3" id="newGravingDock"></div>

              <div class="pb-3"></div>
              <div class="mb-3 d-flex justify-content-between">
                <div><b>FLOATING DOCK</b></div>
                <div>
                  <button type="button" class="btn btn-sm btn-info" onclick="addFloatingDock();"><i
                      class="fas fa-plus"></i>
                    Add Floating Dock</button>
                </div>
              </div>

              <div class="mb-3" id="newFloatingDock"></div>

              <div class="pb-3"></div>
              <div class="mb-3"><b>SLIPWAY</b></div>

              <div class="mb-3">
                <textarea class="form-control" name="slipway" id="shipyard__slipway" placeholder="Input Slipway" rows="4"></textarea>
              </div>

              <div class="pb-3"></div>
              <div class="mb-3"><b>JETTY / REPAIR BERTH</b></div>

              <div class="mb-3">
                <textarea class="form-control" name="jetty" id="shipyard__jetty" placeholder="Input Jetty" rows="4"></textarea>
              </div>

              <div class="pb-3"></div>
              <div class="mb-3"><b>CRANES</b></div>

              <div class="mb-3">
                <textarea class="form-control" name="crane" id="shipyard__crane" placeholder="Input Cranes" rows="4"></textarea>
              </div>

              <div class="pb-3"></div>
              <div class="mb-3"><b>CERTIFICATES</b></div>

              <div class="mb-3">
                <textarea class="form-control" name="certificate" id="shipyard__certificate" placeholder="Input Certificates"
                  rows="4"></textarea>
              </div>

              <div class="pb-4"></div>
              <div class="mb-3 d-flex justify-content-between">
                <div><b>SHIP REPAIR / SHIP CONVERSION</b></div>
                <div>
                  <button type="button" class="btn btn-sm btn-info" onclick="addNewBuilding();"><i
                      class="fas fa-plus"></i>

                    Add Ship Repair</button>
                </div>
              </div>
              <div class="mb-3" id="newNewBuilding"></div>

              <div class="pb-4"></div>
              <div class="mb-3 d-flex justify-content-between">
                <div><b>NEW BUILDING</b></div>
                <div>
                  <button type="button" class="btn btn-sm btn-info" onclick="addShipRepair();"><i
                      class="fas fa-plus"></i>
                    Add New Building</button>
                </div>
              </div>
              <div class="mb-3" id="newShipRepair"></div>

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
    let yardArr = [];
    let contactArr = [];
    let gravingArr = [];
    let floatingArr = [];
    let shipRepairArr = [];
    let newBuildingArr = [];
    let imageArr = [];
    let videoArr = [];

    function addYard() {
      yardArr.push({
        "address": "",
        "phone": ""
      });

      generateYardHtml();
    }

    function generateYardHtml() {
      let html = '';

      for (let key in yardArr) {
        let yardIndex = parseInt(key) + 2;

        html += `
          <div class="yard__new">
            <div class="pb-3"></div>
            <div class="mb-3 d-flex justify-content-between">
              <div><b>YARD (${yardIndex})</b></div>
              <div>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeYard(${key});"><i class="fas fa-minus"></i> Remove Yard</button>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="shipyard__yard_address_${yardIndex}" class="form-label">Address</label>
                  <textarea class="form-control" name="yard_address[]"
                    id="shipyard__yard_address_${yardIndex}" placeholder="Input Yard Address" rows="4" onkeyup="changeYardValue(${key}, 'address', this);">${yardArr[key].address}</textarea>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="shipyard__yard_phone_${yardIndex}" class="form-label">Phone</label>
                  <input type="tel" class="form-control"
                    name="yard_phone[]" id="shipyard__yard_phone_${yardIndex}" placeholder="Input Yard Phone"
                    value="${yardArr[key].phone}" onkeyup="changeYardValue(${key}, 'phone', this);">
                </div>
              </div>
            </div>
          </div>
        `;
      }

      $('#newYard').html(html);
    }

    function changeYardValue(key, label, base) {
      yardArr[key][label] = $(base).val();
    }

    function removeYard(key) {
      yardArr.splice(key, 1);
      generateYardHtml();
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
                  <input type="text" class="form-control" name="contact_name[]" id="shipyard__contact_name_${index}"
                    placeholder="Input Name" value="${contactArr[key].name}" onkeyup="changeContactValue(${key}, 'name', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-3">
                  <input type="text" class="form-control" name="contact_position[]" id="shipyard__contact_position_${index}"
                    placeholder="Input Position" value="${contactArr[key].position}"
                    onkeyup="changeContactValue(${key}, 'position', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-3">
                  <input type="text" class="form-control" name="contact_phone[]" id="shipyard__contact_phone_${index}"
                    placeholder="Input Phone" value="${contactArr[key].phone}"
                    onkeyup="changeContactValue(${key}, 'phone', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-3">
                  <input type="text" class="form-control" name="contact_email[]" id="shipyard__contact_email_${index}"
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
                  <input type="text" class="form-control" name="graving_dock_label[]" id="shipyard__graving_dock_label_${index}"
                    placeholder="Input Label" value="${gravingArr[key].label}"
                    onkeyup="changeGravingValue(${key}, 'label', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="form-control" name="graving_dock_value[]" id="shipyard__graving_dock_value_${index}"
                    placeholder="Input Value" value="${gravingArr[key].value}"
                    onkeyup="changeGravingValue(${key}, 'value', this);">
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
                  <input type="text" class="form-control" name="floating_dock_label[]" id="shipyard__floating_dock_label_${index}"
                    placeholder="Input Label" value="${floatingArr[key].label}" onkeyup="changeFloatingValue(${key}, 'label', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="form-control" name="floating_dock_value[]" id="shipyard__floating_dock_value_${index}"
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
              <input type="text" class="form-control" name="ship_repair_hull[]" id="shipyard__ship_repair_hull_${index}"
                placeholder="Input Hull No" value="${shipRepairArr[key].hull}"
                onkeyup="changeShipRepairValue(${key}, 'hull', this);">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg">
              <input type="text" class="form-control" name="ship_repair_owner[]" id="shipyard__ship_repair_owner_${index}"
                placeholder="Input Owner" value="${shipRepairArr[key].owner}"
                onkeyup="changeShipRepairValue(${key}, 'owner', this);">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg">
              <input type="text" class="form-control" name="ship_repair_type[]" id="shipyard__ship_repair_type_${index}"
                placeholder="Input Ship Type" value="${shipRepairArr[key].type}"
                onkeyup="changeShipRepairValue(${key}, 'type', this);">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg">
              <input type="text" class="form-control" name="ship_repair_dimension[]" id="shipyard__ship_repair_dimension_${index}"
                placeholder="Input Dimension" value="${shipRepairArr[key].dimension}"
                onkeyup="changeShipRepairValue(${key}, 'dimension', this);">
              <div class="invalid-feedback"></div>
            </div>
            <div class="col-lg">
              <input type="text" class="form-control" name="ship_repair_date[]" id="shipyard__ship_repair_date_${index}"
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
                  <input type="text" class="form-control" name="new_building_ship_name[]" id="shipyard__new_building_ship_name_${index}"
                    placeholder="Input Ship Name" value="${newBuildingArr[key].ship_name}"
                    onkeyup="changeNewBuildingValue(${key}, 'ship_name', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg">
                  <input type="text" class="form-control" name="new_building_ship_type[]" id="shipyard__new_building_ship_type_${index}"
                    placeholder="Input Ship Type" value="${newBuildingArr[key].ship_type}"
                    onkeyup="changeNewBuildingValue(${key}, 'ship_type', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg">
                  <input type="text" class="form-control" name="new_building_owner[]" id="shipyard__new_building_owner_${index}"
                    placeholder="Input Owner" value="${newBuildingArr[key].owner}"
                    onkeyup="changeNewBuildingValue(${key}, 'owner', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg">
                  <input type="text" class="form-control" name="new_building_date[]" id="shipyard__new_building_date_${index}"
                    placeholder="Input Completed Date" value="${newBuildingArr[key].date}"
                    onkeyup="changeNewBuildingValue(${key}, 'date', this);">
                  <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg">
                  <input type="text" class="form-control" name="new_building_work_type[]" id="shipyard__new_building_work_type_${index}"
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

      // Get the keys and values
      // for (const [key, value] of formData.entries()) {
      //  console.log(`Key: ${key}, Value: ${value}`);
      // }

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
              $(`#shipyard__${key}`).addClass('is-invalid');
              $(`#shipyard__${key}`).siblings('.invalid-feedback').text(response[key]);
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
