@extends('user.v_template')

@section('main')
  <div class="container">
    <div class="container__header">
      <h1>Shipyard Job Vacancies</h1>
    </div>
    <div>
      <table id="datatable" class="table table-condensed">
        <thead>
          <tr>
            <th>Position</th>
            <th>Company</th>
            <th>Posted Date</th>
            <th>Closing Date</th>
            <th>Status</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@section('btmSlot')
  <script>
    $('#datatable').DataTable({
      order: [],
      processing: true,
      serverSide: true,
      ajax: '{{ route('job.jobDatatable') }}',
      columns: [{
          data: 'position',
          render: function(data, type, row, meta) {
            return `<a href="{{ route('job.jobDetail') }}/${row.id}/${row.slug}" target="_blank">${data}</a>`;
          }
        },
        {
          data: 'company',
          render: function(data, type, row, meta) {
            return `${data}`;
          }
        },
        {
          data: 'posted_start_at',
          render: function(data, type, row, meta) {
            return `${data ? data : '&ndash;'}`;
          }
        },
        {
          data: 'posted_end_at',
          render: function(data, type, row, meta) {
            return `${data ? data : '&ndash;'}`;
          }
        },
        {
          data: 'status',
          render: function(data, type, row, meta) {
            return `${data}`;
          }
        },
      ]
    });
  </script>
@endsection
