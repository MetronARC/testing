@extends('user.v_template')

@section('main')
  <div class="container">
    <div class="container__header">
      <h1>Tender</h1>
      <div class="menu__description">
        <p>Our comprehensive listing of tenders</p>
      </div>
    </div>
    <div>
      <table id="datatable" class="table table-condensed">
        <thead>
          <tr>
            <th>NO TENDER</th>
            <th>NAMA PERUSAHAAN</th>
            <th>STATUS</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@section('topSlot')
@endsection

@section('btmSlot')
  <script>
    $(document).ready(function() {
      let table = $('#datatable').DataTable({
        order: [],
        processing: true,
        serverSide: true,
        ajax: '{{ route('tender.tenderDatatable') }}',
        columns: [{
          data: 'tender_number',
          render: function(data, type, row, meta) {
            return `<a href="{{ route('tender.tenderDetail') }}/${row.id}/${row.tender_number}" target="_blank"><b>${data}</b></a>`;
          }
        }, {
          render: function(data, type, row, meta) {
            return `
              <a href="{{ route('tender.tenderDetail') }}/${row.id}/${row.tender_number}" target="_blank">
                <div><b>${row.company_name.toUpperCase()}</b></div>
                ${row.title ? '<div style="color: #212529;">'+row.title+'</div>' : ''}
              </a>
            `;
          }
        }, {
          data: 'tender_status',
          render: function(data, type, row, meta) {
            if (data) {
              return `<a href="{{ route('tender.tenderDetail') }}/${row.id}/${row.tender_number}" target="_blank"><b>${data.toUpperCase()}</b></a>`;
            } else {
              return `-`;
            }
          }
        }, ]
      });
    });
  </script>
@endsection
