<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Tender RFQ for {{ $tender->title }}">
  <meta name="author" content="AdminKit">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="{{ url('admin/assets/img/icons/icon-48x48.png') }}" />

  <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

  <title>Tender :: {{ $tender->title }} :: Dockyard.id</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="{{ url('/vendor/fontawesome/css/all.css') }}?v={{ date('YmdHis') }}" rel="stylesheet">
  <link href="{{ url('admin/assets/css/app.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    .table>tbody>tr>td {
      vertical-align: top;
    }
  </style>
</head>

<body>
  <main class="d-flex w-100">
    <div class="container-fluid p-0 d-flex flex-column">
      <div class="row m-0 vh-100">
        <div class="col-lg-8"
          style="background-image: url({{ url('assets/images/rfq.png') }}); background-size: cover; background-position: center center;">
        </div>
        <div class="col-lg-4 d-table h-100">
          <div class="d-table-cell align-middle">
            <div class="card">
              <div class="card-body">
                <div class="m-sm-3">
                  <div class="text-center mb-4">
                    <h1 class="h2">JOIN TENDER</h1>
                  </div>
                  <p class="text-center"></p>
                  <form action="{{ url()->full() }}" method="post">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label">Please fill input below to join tender.</label>
                      <textarea rows="5" class="form-control {{ !empty($errors['message']) ? 'is-invalid' : '' }}" type="text"
                        name="message" placeholder="Input your message">{{ Request::post('message') }}</textarea>
                      <div class="invalid-feedback">{{ !empty($errors['message']) ? $errors['message'] : '' }}
                      </div>
                    </div>
                    <div class="pb-3"></div>
                    <div class="text-center">
                      <input type="hidden" />
                      <button type="submit" name="rfq_type" value="email" class="btn btn-info"><i
                          class="fas fa-envelope-open-text"></i>
                        Send via Email</button>
                      @if (!empty($auth_data['member_type']) && $auth_data['member_type'] == 'premium')
                        &nbsp;
                        &nbsp;
                        <button type="submit" name="rfq_type" value="wa" class="btn btn-success"><i
                            class="fab fa-whatsapp"></i> Send via
                          Whatsapp</button>
                      @endif
                    </div>
                    @if (!empty($auth_data['member_type']) && $auth_data['member_type'] == 'premium')
                      <div class="mb-3"></div>
                      <div>
                        <b>Note:</b><br />
                        Send WhatsApp message using whatsapp application or WhatsApp web in your system.
                      </div>
                    @endif
                  </form>
                </div>
              </div>
            </div>
            <div class="text-center mb-3">
              <div>Go back to <a
                  href="{{ url()->route('tender.tenderDetail', ['id' => $tender->id, 'slug' => Str::slug($tender->title)]) }}">Tender
                  Detail Page</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div id="whatsappRedirect"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ url('/vendor/fontawesome/js/all.js') }}?v={{ date('YmdHis') }}"></script>
  <script src="{{ url('admin/assets/js/app.js') }}"></script>

  <script>
    @if (!empty($errors))
      Swal.fire({
        title: 'Error!',
        html: "{!! is_array($errors) ? implode('<br />', $errors) : $errors !!}",
        icon: 'error',
        confirmButtonText: 'Ok'
      })
    @endif

    @if (!empty(session('success')))
      Swal.fire({
        title: 'Success!',
        html: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'Ok'
      })
    @endif

    @if (!empty($sendMessage))
      @php
        $rfqPhone = $tender->phone;

        if (substr($tender->phone, 0, 1) === '0') {
            $rfqPhone = '62' . substr($rfqPhone, 1);
        }
      @endphp

      $(function() {
        window.open('https://wa.me/{{ $rfqPhone }}?text={{ $sendMessage }}', 'wa', 'width=600,height=400');
      });
    @endif
  </script>

</body>

</html>
