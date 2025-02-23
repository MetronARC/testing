@extends('admin/v_template')

@section('main')
  <div class="main__header">
    <h1 class="h3"><strong>Shipyard</strong> List</h1>
    <div class="main__option">
      <a href="{{ route('shipyard.shipyardAdd') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New
        Shipyard</a>
    </div>
  </div>
  <div class="main__body">
    <div class="card">
      <div class="card-body">
        <table class="table table-striped table-hover" id="table-shipyard">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">TYPE</th>
              <th scope="col">SHIPYARD NAME</th>
              <th scope="col">LOCATION</th>
              <th scope="col">SERVICE TYPE</th>
              <th scope="col">LISTING</th>
              <th scope="col">STATUS</th>
              <th scope="col">ACTION</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('topSlot')
@endsection

@section('btmSlot')
  <script>
    $('#table-shipyard').DataTable({
      order: [],
      processing: true,
      serverSide: true,
      ajax: '{{ route('shipyard.shipyardDatatable') }}',
      columns: [{
        // Add this render function to display the index in the first column
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
          return meta.row + 1; // meta.row starts from 0, so add 1 to display a proper index
        }
      }, {
        data: 'type',
        render: function(data, type, row, meta) {
          return `${data.toUpperCase()}`;
        }
      }, {
        data: 'name',
        render: function(data, type, row, meta) {
          return `${data.toUpperCase()}`;
        }
      }, {
        data: 'location',
        render: function(data, type, row, meta) {
          return `${data.toUpperCase()}`;
        }
      }, {
        data: 'category',
        render: function(data, type, row, meta) {
          if (data) {
            return `${data.toUpperCase()}`;
          } else {
            return `-`;
          }
        }
      }, {
        data: 'listing_status',
        render: function(data, type, row, meta) {
          // if (data == 'pro_member') {
          //   return `<div class="btn btn-sm btn-primary w-100">${ucwords(data.replace(/_/g, ' '))}</div>`;
          // } else {
          //   return `<div class="btn btn-sm btn-info w-100">${ucwords(data.replace(/_/g, ' '))}</div>`;
          // }
          return '&ndash;';
        }
      }, {
        data: 'status',
        render: function(data, type, row, meta) {
          if (data == 'publish') {
            return `<div class="btn btn-sm btn-success w-100">${ucwords(data)}</div>`;
          } else {
            return `<div class="btn btn-sm btn-warning w-100">${ucwords(data)}</div>`;
          }
        }
      }, {
        // Add Edit button column
        data: null,
        render: function(data, type, row, meta) {
          return `
            <a href="{{ route('shipyard.shipyardDetail') }}/${row.id}" class="btn btn-warning btn-sm"><i class="fas fa-edit" title="Edit"></i></a>
            <a href="{{ route('shipyard.shipyardDelete') }}/${row.id}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fas fa-trash-alt" title="Delete"></i></a>
          `;
        }
      }, ]
    });
  </script>
@endsection
