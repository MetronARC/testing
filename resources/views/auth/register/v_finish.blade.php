<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
  <meta name="author" content="AdminKit">
  <meta name="keywords"
    content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="{{ url('admin/assets/img/icons/icon-48x48.png') }}" />

  <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

  <title>Register | Dockyard.id</title>

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
          style="background-image: url({{ url('assets/images/dockyard.jpg') }}); background-size: cover; background-position: center center;">
        </div>
        <div class="col-lg-4 d-table h-100">
          <div class="d-table-cell align-middle">
            <div class="card">
              <div class="card-body">
                <div class="m-sm-3">
                  <div class="text-center mb-4">
                    <h1 class="h2">MEMBERSHIPS ON DOCKYARD.ID</h1>
                  </div>
                  
                  <div class="alert alert-warning" role="alert">
                    <p class="text-center">We already sent an email to {{ $user->email }}. Please check your inbox or spam.</p>
                    <p class="text-center">Your data will be verified first before you can login into dashboard page.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center mb-3">
              <div>Go back to <a href="{{ env('DOMAIN_USER_URL') }}">Homepage</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ url('/vendor/fontawesome/js/all.js') }}?v={{ date('YmdHis') }}"></script>
  <script src="{{ url('admin/assets/js/app.js') }}"></script>

  @if (!empty($errors))
    <script>
      Swal.fire({
        title: 'Error!',
        text: '{{ $errors }}',
        icon: 'error',
        confirmButtonText: 'Ok'
      })
    </script>
  @endif

</body>

</html>
