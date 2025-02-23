@extends('admin/v_template')

@section('main')
  <div class="main__header">
    <h1 class="h3"><strong>Vendor</strong> List</h1>
    <div class="main__option">
      <a href="{{ route('vendor.vendorAdd') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New
        Vendor</a>
    </div>
  </div>
  <div class="main__body">
    <div class="card">
      <div class="card-body">
        <table class="table table-striped table-hover" id="table-vendor">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">TYPE</th>
              <th scope="col">VENDOR NAME</th>
              <th scope="col">LOCATION</th>
              <th scope="col">LOCATION</th>
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
    $('#table-vendor').DataTable({
      order: [],
      processing: true,
      serverSide: true,
      ajax: '{{ route('vendor.vendorDatatable') }}',
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
        data: 'listing_status',
        render: function(data, type, row, meta) {
          if (data == 'pro_member') {
            return `<div class="btn btn-sm btn-primary w-100">${ucwords(data.replace(/_/g, ' '))}</div>`;
          } else {
            return `<div class="btn btn-sm btn-info w-100">${ucwords(data.replace(/_/g, ' '))}</div>`;
          }
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
            <a href="{{ route('vendor.vendorDetail') }}/${row.id}" class="btn btn-warning btn-sm"><i class="fas fa-edit" title="Edit"></i></a>
            <a href="{{ route('vendor.vendorDelete') }}/${row.id}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fas fa-trash-alt" title="Delete"></i></a>
          `;
        }
      }, ]
    });
  </script>
@endsection
