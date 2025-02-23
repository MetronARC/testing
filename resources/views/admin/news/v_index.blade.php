@extends('admin/v_template')

@section('main')
  <div class="main__header">
    <h1 class="h3"><strong>News</strong> List</h1>
    <div class="main__option">
      <a href="{{ route('news.newsAdd') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New
        News</a>
    </div>
  </div>
  <div class="main__body">
    <div class="card">
      <div class="card-body">
        <table class="table table-striped table-hover" id="table-vendor">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">TITLE</th>
              <th scope="col">DESCRIPTION</th>
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
      ajax: '{{ route('news.newsDatatable') }}',
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
        data: 'title',
        render: function(data, type, row, meta) {
          return `${data.toUpperCase()}`;
        }
      }, {
        data: 'description',
        render: function(data, type, row, meta) {
          return `${data.toUpperCase()}`;
        }
      }, {
        data: 'status',
        render: function(data, type, row, meta) {
          let returnData = '';

          if (row.status == 'publish') {
            returnData += `<span class="btn btn-sm btn-success me-2">${ucwords(row.status)}</span>`;
          } else {
            returnData += `<span class="btn btn-sm btn-warning me-2">${ucwords(row.status)}</span>`;
          }

          return returnData;
        }
      }, {
        // Add Edit button column
        data: null,
        render: function(data, type, row, meta) {
          return `
            <a href="{{ route('news.newsDetail') }}/${row.id}" class="btn btn-warning btn-sm"><i class="fas fa-edit" title="Edit"></i></a>
            <a href="{{ route('news.newsDelete') }}/${row.id}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fas fa-trash-alt" title="Delete"></i></a>
          `;
        }
      }, ]
    });
  </script>
@endsection
