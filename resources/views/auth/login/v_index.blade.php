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

  <title>Sign In | Dockyard.id</title>

  <link href="{{ url('admin/assets/css/app.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
  <main class="d-flex w-100">
    <div class="container-fluid p-0 d-flex flex-column">
      <div class="row m-0 vh-100">
        <div class="col-lg-8" style="background-image: url({{ url('assets/images/dockyard.jpg') }}); background-size: cover; background-position: center center;"></div>
        <div class="col-lg-4 d-table h-100">
          <div class="d-table-cell align-middle">

            <div class="text-center mt-4">
              <h1 class="h2">Welcome back!</h1>
              <p class="lead">
                Sign in to your account to continue
              </p>
            </div>

            <div class="card">
              <div class="card-body">
                <div class="m-sm-3">
                  <form action="{{ url()->full() }}" method="post">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input class="form-control form-control-lg" type="email" name="email"
                        placeholder="Enter your email" value="{{ Request::post('email') }}" />
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input class="form-control form-control-lg" type="password" name="password"
                        placeholder="Enter your password" value="{{ Request::post('password') }}" />
                    </div>
                    <div>
                      <div class="form-check align-items-center">
                        <input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me"
                          name="remember-me" checked>
                        <label class="form-check-label text-small" for="customControlInline">Remember me</label>
                      </div>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                      <input type="hidden" name="current" value="{{ Request::input('current') }}" />
                      <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="text-center mb-3">
              <div class="mb-3">Don't have an account? <a href="{{ route('registerIndex') }}">Register</a></div>
              <div>Go back to <a href="{{ env('DOMAIN_USER_URL') }}">Homepage</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
