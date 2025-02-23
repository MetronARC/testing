@extends('user.v_template', ['body_class' => 'paper-background'])

@section('main')
  <div class="container container__shipyard_detail mb-5">
    <div class="container__header" style="max-width: 768px; margin: 0 auto;">
      <h2 class="h1">Shipyard Job Vacancies</h2>
    </div>
    <div class="container__paper mt-0">
      <h1>
        {{ $job['position'] }}<br>
        <small>{{ $job['company'] }}</small>
      </h1>
      <div class="mb-3"></div>
      <div><b>Job Responsibilities</b></div>
      <div class="wysiwyg">
        {!! $job['responsible'] !!}
      </div>
      <div><b>Job Requirements</b></div>
      <div class="wysiwyg">
        {!! $job['requirement'] !!}
      </div>
      <div class="text-end mt-5">
        <a href="" class="btn btn-primary px-5" style="border-radius: 25px;">APPLY</a>
      </div>
    </div>
  </div>
@endsection

@section('btmSlot')
@endsection
