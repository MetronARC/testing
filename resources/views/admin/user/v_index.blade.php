@extends('admin/v_template')

@section('main')
  <div class="main__header">
    <h1 class="h3"><strong>User</strong> List</h1>
  </div>
  <div class="main__body">
    <div class="card">
      <div class="card-body">
        <table class="table table-striped table-hover" id="table-shipyard">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Business</th>
              <th scope="col">Contact</th>
              <th scope="col text-center">Status</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  @include('admin.user.v_modal_verify')
@endsection

@section('topSlot')
@endsection

@section('btmSlot')
  <script>
    $('#table-shipyard').DataTable({
      order: [],
      processing: true,
      serverSide: true,
      ajax: '{{ route('user.userDatatable') }}',
      columns: [{
        // Add this render function to display the index in the first column
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
          return `<a href="{{ route('user.userDetail') }}/${row.id}">${meta.row + 1}</a>`; // meta.row starts from 0, so add 1 to display a proper index
        }
      }, {
        data: 'name',
        render: function(data, type, row, meta) {
          return `
            <a href="{{ route('user.userDetail') }}/${row.id}">
              <div class="small">${data}</div>
              <div><span class="badge ${row.role == 'SHIPYARD' ? 'text-bg-primary' : row.role == 'VENDOR' ? 'text-bg-info' : 'text-bg-warning'}"><small>${row.role}</small></span></div>
              <div><span class="badge ${row.member_type == 'PRO MEMBERSHIP' ? 'text-bg-success' : 'text-bg-secondary'}"><small>${row.member_type}</small></span></div>
            </a>
          `;
        }
      }, {
        render: function(data, type, row, meta) {
          return `
            <a href="{{ route('user.userDetail') }}/${row.id}">
              <small>${row.company ? row.company : row.shipyard ? row.shipyard : '&ndash;'}</small>
            </a>
          `;
        }
      }, {
        render: function(data, type, row, meta) {
          return `
            <a href="{{ route('user.userDetail') }}/${row.id}">
              <div>
                Email:<br />
                <small>${row.email ? row.email : '&ndash;'}</small>
              </div>
              <div>
                Phone:<br />
                <small>${row.phone ? row.phone : '&ndash;'}</small>
              </div>
            </a>
          `;
        }
      }, {
        data: 'status',
        className: 'text-center',
        render: function(data, type, row, meta) {
          if (data == 'VERIFIED') {
            return `<div class="badge text-bg-success w-100">${data}</div>`;
          } else {
            return `<button class="btn btn-sm btn-warning w-100" onclick="verifyUser(${row.id}, '${row.name}')">${data}</button>`;
          }
        }
      }]
    });
  </script>
@endsection
