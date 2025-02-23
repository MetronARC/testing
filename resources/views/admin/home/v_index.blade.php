@extends('admin/v_template')

@section('main')
  <h1 class="h3 mb-3">Welcome To <strong>DockyardID</strong></h1>

  @if ($auth_data['temp_password'])
  <div class="alert alert-warning" role="alert">
    You still used temporary password for login. Click <a href="{{ route('user.userChangePassword') }}" style="text-decoration: underline; font-weight: 700;">here</a> to reset your password.<br />
    <i>You have {{ $intervalInDays }} day(s) before password expired.</i>
  </div>
  @endif
@endsection

@section('topSlot')
@endsection

@section('btmSlot')
@endsection
