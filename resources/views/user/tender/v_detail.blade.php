@extends('user.v_template', ['body_class' => 'paper-background'])

@section('main')
  <div class="container container__tender_detail mb-5">
    <div class="container__paper">
      <div class="row">
        @if (!empty($tender['logo']))
          <div class="col-lg-2">
            <img src="{{ cdnUrl($tender['logo']) }}" alt="logo" style="width: 100%; max-width: 100px;">
          </div>
        @endif
        <div class="{{ !empty($tender['logo']) ? 'col-lg-10' : 'col-lg-12' }}">
          <h1>
            {{ $tender['title'] }}
          </h1>
          <h2>{{ strtoupper($tender['company_name']) }}</h2>
        </div>
      </div>
      <div class="mb-4"></div>
      <div class="wysiwyg">{!! $tender['description'] !!}</div>
    </div>
    <div class="mb-4"></div>
    <div class="text-center">
      <a href="{{ route('tender.tenderContact', ['id' => $tender['id']]) }}" class="btn btn-warning shadow"><b>JOIN TENDER</b></a>
    </div>
  </div>
@endsection

@section('topSlot')
@endsection

@section('btmSlot')
@endsection
