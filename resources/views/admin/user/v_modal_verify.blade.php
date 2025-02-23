<div class="modal fade" id="userVerify" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ url()->route('user.userVerify') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="text-center py-5">
            Are you sure you want to verify &quot;<span id="userVerifyName"></span>&quot;?
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <input type="hidden" name="user_id" value="">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Verify</button>
        </div>
      </form>
    </div>
  </div>
</div>

@section('btmSlot2')
  <script>
    function verifyUser(id, name) {
      $('#userVerify').find('[name="user_id"]').val(id)
      $('#userVerifyName').text(name);
      $('#userVerify').modal('show');
    }
  </script>
@endsection
