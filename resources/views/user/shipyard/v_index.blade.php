@extends('user.v_template')

@section('main')
  <div class="container">
    <div class="container__header">
      <h1>Shipyard</h1>
      <div class="menu__description">
        <p>Our comprehensive listing of shipyards in Indonesia, provides information about different shipyards, including
          their locations, contact details, facilities, capabilities, and types of vessels they specialize in
          constructing,
          repairing, or maintaining.</p>
        <p>DOCKYARD.ID makes it easier for you to identify suitable shipyards for specific projects or requirements,
          whether
          it's building a new vessel, carrying out repairs and maintenance, or retrofitting existing ships.</p>
      </div>
    </div>
    <div>
      <table id="datatable" class="table table-condensed">
        <thead>
          <tr>
            <th>
              SHIPYARD NAME
              <div>
                <select class="form-control form-control-sm chosen-select" id="name-filter" multiple>
                  <option value="">All</option>
                  @foreach ($shipyards as $_val)
                    <option value="{{ $_val['name'] }}">{{ $_val['name'] }}</option>
                  @endforeach
                  <!-- Add options for specific values -->
                </select>
              </div>
            </th>
            <th>
              LOCATION
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
            <th>
              SHIPYARD SERVICE TYPE
              <div>
                <select class="form-control form-control-sm chosen-select" id="category-filter" multiple>
                  <option value="">All</option>
                  @foreach ($categories as $_val)
                    <option value="{{ $_val }}">{{ $_val }}</option>
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
        ajax: '{{ route('shipyard.shipyardDatatable') }}',
        columns: [{
          data: 'name',
          render: function(data, type, row, meta) {
            return `<a href="{{ route('shipyard.shipyardDetail') }}/${row.id}/${row.slug}" target="_blank">${data}</a>`;
          }
        }, {
          data: 'location',
          render: function(data, type, row, meta) {
            return `<a href="{{ route('shipyard.shipyardDetail') }}/${row.id}/${row.slug}" target="_blank">${data}</a>`;
          }
        }, {
          data: 'category',
          render: function(data, type, row, meta) {
            if (data) {
              return `<a href="{{ route('shipyard.shipyardDetail') }}/${row.id}/${row.slug}" target="_blank">${data}</a>`;
            } else {
              return `-`;
            }
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
