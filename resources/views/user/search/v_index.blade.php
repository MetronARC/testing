@extends('user.v_template')

@section('main')
  <div class="container">
    <div class="container__header">
      <h1>Search</h1>
      <div class="menu__description">
        <p>Result searching for keywords: &quot;{{ Request::get('s') }}&quot;</p>
      </div>
      <hr />

      @if (!empty($shipyards))
        <h5>Shipyards</h5>
        @foreach ($shipyards as $val)
          <a href="{{ route('shipyard.shipyardDetail') }}/{{ $val['id'] }}/{{ $val['slug'] }}">
            <div>
              {{ $val['name'] }}
            </div>
          </a>
        @endforeach
        <hr />
      @endif

      @if (!empty($vendors))
        <h5>Marine Vendors</h5>
        @foreach ($vendors as $val)
          <a href="{{ route('vendor.vendorDetail') }}/{{ $val['id'] }}/{{ $val['slug'] }}">
            <div>
              {{ $val['name'] }}
            </div>
          </a>
        @endforeach
        <hr />
      @endif

      @if (!empty($jobs))
        <h5>Job Vacancy</h5>
        @foreach ($jobs as $val)
          <a href="{{ route('job.jobDetail') }}/{{ $val['id'] }}/{{ Str::slug($val['company'].' '.$val['position']) }}">
            <div>
              {{ $val['company'] }}
              {{ $val['position'] }}
            </div>
          </a>
        @endforeach
        <hr />
      @endif
    </div>
    <div>
    </div>
  </div>
@endsection

@section('topSlot')
@endsection

@section('btmSlot')
@endsection
