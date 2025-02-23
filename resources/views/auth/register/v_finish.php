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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="{{ url('/vendor/fontawesome/css/all.css') }}?v={{ date('YmdHis') }}" rel="stylesheet">
  <link href="{{ url('admin/assets/css/app.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
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
                    <h1 class="h2">Register</h1>
                    <h2 class="h5">{{ $categoryName }} ACCOUNT</h2>
                  </div>
                  <div class="pb-3"></div>
                  <form action="{{ url()->current() }}" method="post">
                    @csrf
                    @if ($category != 'shipyard')
                      <div class="mb-3">
                        <label class="form-label">Company</label>
                        <input class="form-control {{ !empty($errors['company_name']) ? 'is-invalid' : '' }}"
                          type="text" name="company_name" placeholder="Enter your company name"
                          value="{{ Request::post('company') }}" />
                        <div class="invalid-feedback">
                          {{ !empty($errors['company_name']) ? $errors['company_name'] : '' }}</div>
                      </div>
                    @else
                      <div class="mb-3">
                        <label class="form-label">Shipyard <i class="fas fa-info-circle" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Please contact us if your shipyard not found in the list."></i></label>
                        <select class="form-select selecttwo {{ !empty($errors['shipyard_id']) ? 'is-invalid' : '' }}"
                          name="shipyard_id">
                          <option value="">Select Shipyard</option>
                          @foreach ($shipyards as $_ship)
                            <option value="{{ $_ship['id'] }}" {{ Request::post('shipyard_id') == $_ship['id'] ? 'selected' : '' }}>{{ strtoupper($_ship['name']) }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">
                          {{ !empty($errors['shipyard_id']) ? $errors['shipyard_id'] : '' }}</div>
                      </div>
                    @endif
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input class="form-control {{ !empty($errors['name']) ? 'is-invalid' : '' }}" type="text"
                        name="name" placeholder="Enter your name" value="{{ Request::post('name') }}" />
                      <div class="invalid-feedback">
                        {{ !empty($errors['name']) ? $errors['name'] : '' }}</div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Position</label>
                      <input class="form-control {{ !empty($errors['position']) ? 'is-invalid' : '' }}" type="text"
                        name="position" placeholder="Enter your position" value="{{ Request::post('position') }}" />
                      <div class="invalid-feedback">
                        {{ !empty($errors['position']) ? $errors['position'] : '' }}</div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Phone</label>
                      <input class="form-control {{ !empty($errors['phone']) ? 'is-invalid' : '' }}" type="text"
                        name="phone" placeholder="Enter your phone number" value="{{ Request::post('phone') }}" />
                      <div class="invalid-feedback">
                        {{ !empty($errors['phone']) ? $errors['phone'] : '' }}</div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Email <i class="fas fa-info-circle" data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="Login ID using mobile number or e-mail address, password
                        will be sent to registered email after sign up completed."></i></label>
                      <input class="form-control {{ !empty($errors['email']) ? 'is-invalid' : '' }}" type="email"
                        name="email" placeholder="Enter your email" value="{{ Request::post('email') }}" />
                      <div class="invalid-feedback">
                        {{ !empty($errors['email']) ? $errors['email'] : '' }}</div>
                    </div>
                    <div class="pb-3"></div>
                    <div>
                      <div class="form-check align-items-center">
                        <input id="customControlInline" type="checkbox" class="form-check-input" value="1"
                          name="term" style="opacity: 1;" checked disabled>
                        <label class="form-check-label text-small" for="customControlInline" style="opacity: 1;">By continuing, you
                          agree
                          to the Terms of Use and Privacy Policy of Dockyard.id Company.</label>
                      </div>
                      <div class="pb-3"></div>
                      <div class="d-grid gap-2 mt-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                          data-bs-target="#register">
                          REGISTER {{ strtoupper($type) }} MEMBERSHIP
                        </button>
                      </div>

                      <!-- Modal -->
                      <div class="modal fade" id="register" tabindex="-1" aria-labelledby="register"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <div class="py-4">
                                <p class="text-center h5">Are you sure email address already correct?</p>
                                <p class="text-center h5">Password will be sent to registered email after sign up
                                  completed.</p>
                              </div>
                              <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                  REGISTER {{ strtoupper($type) }} MEMBERSHIP
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="text-center mb-3">
              <div class="mb-3">Already have an account? <a href="{{ route('loginIndex') }}">Sign in</a></div>
              <div>Go back to <a href="{{ env('DOMAIN_USER_URL') }}">Homepage</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="{{ url('/vendor/fontawesome/js/all.js') }}?v={{ date('YmdHis') }}"></script>
  <script src="{{ url('admin/assets/js/app.js') }}"></script>

  <script>
    $(document).ready(function() {
      $('.selecttwo').select2();

      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      });
    });
  </script>

</body>

</html>
