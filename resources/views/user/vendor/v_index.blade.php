@extends('user.v_template')

@section('main')
  <div class="container">
    <div class="container__header">
      <h1>Marine Vendor</h1>
      <div class="menu__description">
        <p>Our comprehensive listing of vendors in Indonesia, provides information about different vendors, including
          their locations, contact details, facilities, capabilities, and types of vessels they specialize in
          constructing,
          repairing, or maintaining.</p>
        <p>DOCKYARD.ID makes it easier for you to identify suitable vendors for specific projects or requirements,
          whether
          it's building a new vessel, carrying out repairs and maintenance, or retrofitting existing ships.</p>
      </div>
    </div>
    <div>
      <table id="datatable" class="table table-condensed">
        <thead>
          <tr>
            <th>
              Vendor Name
              <div>
                <select class="form-control form-control-sm chosen-select" id="name-filter" multiple>
                  <option value="">All</option>
                  @foreach ($vendors as $_val)
                    <option value="{{ $_val['name'] }}">{{ $_val['name'] }}</option>
                  @endforeach
                  <!-- Add options for specific values -->
                </select>
              </div>
            </th>
            <th>
              Location
              <div>
                <select class="form-control form-control-sm chosen-select" id="location-filter" multiple>
                  <option value="">All</option>
                  @foreach ($locations as $_val)
                    <option value="{{ $_val['location'] }}">{{ $_val['location'] }}</option>
                  @endforeach
                  <!-- Add options for specific values -->
                </select>
              </div>
            </th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@section('topSlot')
  <!-- Add Chosen CSS link for multiple select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
@endsection

@section('btmSlot')
  <!-- Add Chosen JS for multiple select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      let table = $('#datatable').DataTable({
        order: [],
        processing: true,
        serverSide: true,
        ajax: '{{ route('vendor.vendorDatatable') }}',
        columns: [{
          data: 'name',
          render: function(data, type, row, meta) {
            return `<a href="{{ route('vendor.vendorDetail') }}/${row.id}/${row.slug}" target="_blank">${data}</a>`;
          }
        }, {
          data: 'location',
          render: function(data, type, row, meta) {
            return `<a href="{{ route('vendor.vendorDetail') }}/${row.id}/${row.slug}" target="_blank">${data}</a>`;
          }
        }, ]
      });

      // Apply column-specific multiple selection filtering
      $('.chosen-select').change(function() {
        var val = $(this).val();
        val = val ? val.join('|') : '';

        table.column($(this).parents('th'))
          .search(val, true, false)
          .draw();
      });

      // Prevent default sorting on select dropdown change
      $('#datatable thead div').on('click', function(e) {
        e.stopPropagation();
      });

      // Initialize Chosen plugin for better UI in multiple select dropdowns
      $('.chosen-select').chosen();
    });
  </script>
@endsection
