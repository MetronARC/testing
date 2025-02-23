@extends('admin/v_template')

@section('main')
  <div class="main__header">
    <h1 class="h3"><strong>Change</strong> Password</h1>
  </div>
  <div class="main__body">
    <div class="card">
      <div class="card-body">
        <form action="{{ url()->current() }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" class="form-control {{ !empty($errors['current_password']) ? 'is-invalid' : '' }}"
              id="current_password" name="current_password" placeholder="Input current password." value="{{ Request::post('current_password') }}">
            @if (!empty($errors['current_password']))
              <div class="invalid-feedback">
                {{ !empty($errors['current_password']) ? $errors['current_password'] : '' }}
              </div>
            @endif
          </div>
          <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" class="form-control {{ !empty($errors['new_password']) ? 'is-invalid' : '' }}"
              id="new_password" name="new_password" placeholder="Input new password." value="{{ Request::post('new_password') }}">
            @if (!empty($errors['new_password']))
              <div class="invalid-feedback">
                {{ !empty($errors['new_password']) ? $errors['new_password'] : '' }}
              </div>
            @endif
          </div>
          <div class="mb-3">
            <label for="reinput_new_password" class="form-label">Re-input New Password</label>
            <input type="password" class="form-control {{ !empty($errors['reinput_new_password']) ? 'is-invalid' : '' }}"
              id="reinput_new_password" name="reinput_new_password" placeholder="Re-input new password." value="{{ Request::post('reinput_new_password') }}">
            @if (!empty($errors['reinput_new_password']))
              <div class="invalid-feedback">
                {{ !empty($errors['reinput_new_password']) ? $errors['reinput_new_password'] : '' }}
              </div>
            @endif
          </div>
          <div class="pb-3"></div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Change Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('topSlot')
@endsection

@section('btmSlot')
@endsection
