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
                  <p class="text-center ">Shipyards, marine equipment or service providers, ship owners and marine
                    professionals can sign up
                    for free membership, but our <b>pro membership</b> is very affordable, while giving highly valuable
                    resources for your business.</p>
                  <div class="pb-2"></div>
                  <div class="text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                      data-bs-target="#business_category">
                      Choose your business category
                    </button>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade" id="business_category" tabindex="-1" aria-labelledby="business_category"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-body">
                          <p class="text-center py-4 h5">Please choose your business category from option below:</p>
                          <div class="row">
                            @foreach ($registerCategories as $_cat => $_val)
                              <div class="col">
                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                  data-bs-target="#business_category_{{ Str::slug($_cat) }}" data-bs-dismiss="modal">
                                  {{ $_cat }}
                                </button>
                              </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  @foreach ($registerCategories as $_cat => $_val)
                    <div class="modal fade" id="business_category_{{ Str::slug($_cat) }}" tabindex="-1"
                      aria-labelledby="business_category_{{ Str::slug($_cat) }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                          <div class="modal-body">
                            <p class="text-center py-4 h5 fw-bold">MEMBERSHIPS FOR {{ $_cat }}</p>
                            <table class="table table-primary">
                              <thead>
                                <tr>
                                  <th>BENEFITS</th>
                                  <th class="text-center">FREE MEMBERSHIP</th>
                                  <th class="text-center">PRO MEMBERSHIP</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($_val as $_v)
                                  <tr>
                                    <td>{{ $_v['benefit'] }}</td>
                                    <td class="text-center">{!! $_v['free'] !!}</td>
                                    <td class="text-center">{!! $_v['pro'] !!}</td>
                                  </tr>
                                @endforeach
                                <tr>
                                  <td>&nbsp;</td>
                                  <td class="text-center"><a
                                      href="{{ route('registerCategory', ['category' => Str::slug($_cat), 'type' => 'free']) }}"
                                      class="btn btn-secondary w-100">SIGN UP FOR
                                      FREE</a></td>
                                  <td class="text-center"><a
                                      href="{{ route('registerCategory', ['category' => Str::slug($_cat), 'type' => 'pro']) }}"
                                      class="btn btn-primary w-100">GET PRO
                                      MEMBERSHIP</a></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach

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
