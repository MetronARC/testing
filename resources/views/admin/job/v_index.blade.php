@extends('admin/v_template')

@section('main')
    <div class="main__header">
        <h1 class="h3"><strong>Job</strong> List</h1>
        <div class="main__option">
            <a href="{{ route('job.jobAdd') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New
                Job</a>
        </div>
    </div>
    <div class="main__body">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover" id="table-job">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">POSITION</th>
                            <th scope="col">COMPANY</th>
                            <th scope="col">RESPONSIBLE</th>
                            <th scope="col">REQUIREMENT</th>
                            <th scope="col">DATE START</th>
                            <th scope="col">DATE END</th>
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
        $('#table-job').DataTable({
            order: [],
            processing: true,
            serverSide: true,
            ajax: '{{ route('job.jobDatatable') }}',
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
                data: 'position',
                render: function(data, type, row, meta) {
                    return `${data.toUpperCase()}`;
                }
            }, {
                data: 'company',
                render: function(data, type, row, meta) {
                    return `${data.toUpperCase()}`;
                }
            }, {
                data: 'responsible',
                render: function(data, type, row, meta) {
                    console.log(data);
                    console.log(row);
                    return `${data}`;
                }
            }, {
                data: 'requirement',
                render: function(data, type, row, meta) {
                    return `${data}`;
                }
            }, {
                data: 'posted_start_at',
                render: function(data, type, row, meta) {
                    if (data) {
                        return `${data}`;
                    } else {
                        return `-`;
                    }
                }
            }, {
                data: 'posted_end_at',
                render: function(data, type, row, meta) {
                    if (data) {
                        return `${data}`;
                    } else {
                        return `-`;
                    }
                }
            }, {
                data: 'status',
                render: function(data, type, row, meta) {
                    if (data.toLowerCase() == 'publish') {
                        return `<div class="btn btn-sm btn-success w-100">${data}</div>`;
                    } else if (data.toLowerCase() == 'expired') {
                        return `<div class="btn btn-sm btn-danger w-100">${data}</div>`;
                    } else {
                        return `<div class="btn btn-sm btn-warning w-100">${data}</div>`;
                    }
                }
            }, {
                // Add Edit button column
                data: null,
                render: function(data, type, row, meta) {
                    return `
            <a href="{{ route('job.jobDetail') }}/${row.id}" class="btn btn-warning btn-sm"><i class="fas fa-edit" title="Edit"></i></a>
            <a href="{{ route('job.jobDelete') }}/${row.id}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fas fa-trash-alt" title="Delete"></i></a>
          `;
                }
            }, ]
        });
    </script>
@endsection
