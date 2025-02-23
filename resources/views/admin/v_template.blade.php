<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Admin Page :: DockyardID">
  <meta name="author" content="Sakarioka.com">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

  <title>{{ $title }} :: Admin :: DockyardID</title>

  <link href="{{ url('admin/assets/css/app.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
  <link href="{{ url('/admin/vendor/fontawesome/css/all.css') }}?v={{ date('YmdHis') }}" rel="stylesheet">
  <link href="{{ url('/admin/css/main.css') }}?v={{ date('YmdHis') }}" rel="stylesheet">

  <style>
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
      border: 1px solid var(--bs-border-color);
    }

    .select2-container--default .select2-selection--single {
      padding: 0.3rem 2.55rem 0.3rem 0.85rem;
      height: auto;
    }

    .select2-container--default .select2-selection--multiple {
      padding: 0 2.55rem 0 0.85rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered,
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
      line-height: inherit;
      padding-left: 0;
    }

    /* Custom CSS for dark background tooltip */
    .custom-tooltip .tooltip-inner {
      background-color: #343a40;
      /* Replace this with your desired dark background color */
      color: #ffffff;
      /* Replace this with the desired text color */
      padding: .25rem .5rem;
      border-radius: 10px;
    }

    .is-invalid+.select2 .select2-selection--single,
    .is-invalid+.select2 .select2-selection--multiple {
      border-color: var(--bs-form-invalid-border-color);
    }

    .table>tbody>tr>td {
      vertical-align: top;
    }

    a,
    a:focus,
    a:hover,
    a:active {
      color: inherit;
      text-decoration: none;
    }
  </style>

  @yield('topSlot')
</head>

<body>
  <div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
      <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ url('') }}">
          <span class="align-middle">
            @if ($auth_data['role'] == 'ship_manager')
              USER PROFILE
            @elseif ($auth_data['role'] == 'shipyard')
              SHIPYARD PAGE
            @elseif ($auth_data['role'] == 'vendor')
              VENDOR PAGE
            @else
              ADMIN PAGE
            @endif
          </span>
        </a>

        <ul class="sidebar-nav">
          <li class="sidebar-header">
            Pages
          </li>

          <li class="sidebar-item {{ Route::currentRouteName() === 'homeIndex' ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('homeIndex') }}">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
          </li>
          @if (in_array($auth_data['role'], ['developer']))
            <li class="sidebar-item {{ $routeGroup == 'email' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('email.emailIndex') }}">
                <i class="align-middle" data-feather="mail"></i> <span class="align-middle">Email</span>
              </a>
            </li>
          @endif
          @if (in_array($auth_data['role'], ['admin', 'superadmin', 'developer']))
            <li class="sidebar-item {{ $routeGroup == 'user' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('user.userIndex') }}">
                <i class="align-middle" data-feather="users"></i> <span class="align-middle">User</span>
              </a>
            </li>
          @endif
          @if (in_array($auth_data['role'], ['admin', 'superadmin', 'shipyard', 'developer']))
            <li class="sidebar-item {{ $routeGroup == 'shipyard' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('shipyard.shipyardIndex') }}">
                <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Shipyard</span>
              </a>
            </li>
          @endif
          @if (in_array($auth_data['role'], ['admin', 'superadmin', 'vendor', 'developer']))
            <li class="sidebar-item {{ $routeGroup == 'vendor' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('vendor.vendorIndex') }}">
                <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Marine Vendor</span>
              </a>
            </li>
          @endif
          @if (in_array($auth_data['role'], ['developer']))
          <li class="sidebar-item {{ $routeGroup == 'ship' ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('ship.shipIndex') }}">
              <i class="align-middle" data-feather="database"></i> <span class="align-middle">Ship Manager</span>
            </a>
          </li>
          @endif
          @if (in_array($auth_data['role'], ['admin', 'superadmin', 'developer']))
            <li class="sidebar-item {{ $routeGroup == 'tender' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('tender.tenderIndex') }}">
                <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Tender</span>
              </a>
            </li>
          @endif
          @if (in_array($auth_data['role'], ['admin', 'superadmin', 'developer']))
            <li class="sidebar-item {{ $routeGroup == 'job' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('job.jobIndex') }}">
                <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Job Vacancy</span>
              </a>
            </li>
          @endif
          @if (in_array($auth_data['role'], ['developer']))
            <li class="sidebar-item {{ $routeGroup == 'service' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('service.serviceIndex') }}">
                <i class="align-middle" data-feather="airplay"></i> <span class="align-middle">Service &amp;
                  Suppliers</span>
              </a>
            </li>
            @endif
            @if (in_array($auth_data['role'], ['developer']))
            <li class="sidebar-item {{ $routeGroup == 'sale' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('sale.saleIndex') }}">
                <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">For Sale</span>
              </a>
            </li>
            @endif
            @if (in_array($auth_data['role'], ['admin', 'superadmin', 'developer']))
            <li class="sidebar-item {{ $routeGroup == 'news' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('news.newsIndex') }}">
                <i class="align-middle" data-feather="send"></i> <span class="align-middle">News</span>
              </a>
            </li>
            @endif

            @if (in_array($auth_data['role'], ['developer']))
            <li class="sidebar-header">
              Settings
            </li>
            @endif
            @if (in_array($auth_data['role'], ['developer']))
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('homeIndex') }}">
                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Homepage</span>
              </a>
            </li>
            @endif
            @if (in_array($auth_data['role'], ['developer']))
            <li class="sidebar-item {{ $routeGroup == 'faq' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('faq.faqIndex') }}">
                <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">FAQ</span>
              </a>
            </li>
            <li class="sidebar-item {{ $routeGroup == 'term' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('term.termIndex') }}">
                <i class="align-middle" data-feather="command"></i> <span class="align-middle">Terms &amp;
                  Conditions</span>
              </a>
            </li>
            @endif
            @if (in_array($auth_data['role'], ['developer']))
            <li class="sidebar-item {{ $routeGroup == 'archive' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('archive.archiveIndex') }}">
                <i class="align-middle" data-feather="archive"></i> <span class="align-middle">Archive</span>
              </a>
            </li>
            @endif
            @if (in_array($auth_data['role'], ['developer']))
            <li class="sidebar-item {{ $routeGroup == 'log' ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('log.logIndex') }}">
                <i class="align-middle" data-feather="codepen"></i> <span class="align-middle">Logs</span>
              </a>
            </li>
          @endif
        </ul>

      </div>
    </nav>

    <div class="main">
      <nav class="navbar navbar-expand navbar-light navbar-bg">
        <a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

        <div class="navbar-collapse collapse">
          <ul class="navbar-nav navbar-align">
            {{-- <li class="nav-item dropdown">
              <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                <div class="position-relative">
                  <i class="align-middle" data-feather="bell"></i>
                  <span class="indicator">4</span>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                <div class="dropdown-menu-header">
                  4 New Notifications
                </div>
                <div class="list-group">
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <i class="text-danger" data-feather="alert-circle"></i>
                      </div>
                      <div class="col-10">
                        <div class="text-dark">Update completed</div>
                        <div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
                        <div class="text-muted small mt-1">30m ago</div>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <i class="text-warning" data-feather="bell"></i>
                      </div>
                      <div class="col-10">
                        <div class="text-dark">Lorem ipsum</div>
                        <div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
                        <div class="text-muted small mt-1">2h ago</div>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <i class="text-primary" data-feather="home"></i>
                      </div>
                      <div class="col-10">
                        <div class="text-dark">Login from 192.186.1.8</div>
                        <div class="text-muted small mt-1">5h ago</div>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <i class="text-success" data-feather="user-plus"></i>
                      </div>
                      <div class="col-10">
                        <div class="text-dark">New connection</div>
                        <div class="text-muted small mt-1">Christina accepted your request.</div>
                        <div class="text-muted small mt-1">14h ago</div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="dropdown-menu-footer">
                  <a href="#" class="text-muted">Show all notifications</a>
                </div>
              </div>
            </li> --}}
            <li class="nav-item">
              <a class="nav-link" href="{{ env('DOMAIN_USER_URL') }}" style="color: #212529; font-weight: 500; padding-right: 1rem;">
                Go to Dockyard.ID
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

              <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                {{-- <img src="{{ url('admin/assets/img/avatars/avatar.jpg') }}" class="avatar img-fluid rounded me-1"
                  alt="{{ $auth_data['name'] }}" />  --}}
                <span class="text-dark">{{ $auth_data['name'] }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ env('DOMAIN_AUTH_LOGOUT_URL') }}">Log out</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <main class="content">
        <div class="container-fluid p-0">
          @yield('main')
        </div>
      </main>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row text-muted">
            <div class="col-6 text-start">
              <p class="mb-0">
                <a class="text-muted" href="#" target="_blank"><strong>Dockyard.id &copy;
                    {{ date('Y') }}</strong></a>
              </p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="{{ url('admin/assets/js/app.js') }}"></script>

  <!-- Custom JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="{{ url('/admin/vendor/fontawesome/js/all.js') }}?v={{ date('YmdHis') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function ucwords(inputString) {
      return inputString.replace(/\w\S*/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
      });
    }
  </script>

  <script>
    $(document).ready(function() {
      // Initialize Select2 with tags and multiple=false options
      $('.select2-input').select2({
        tags: true,
        multiple: false,
      });

      $('.select2-multiples').select2({
        tags: true,
        multiple: true,
        placeholder: 'Select options',
      });

      $('.select2-select').select2();

      $('.select2-multiples-notag').select2({
        tags: false,
        multiple: true,
        placeholder: 'Select options',
      });
    });
  </script>
  <script>
    // Initialize all tooltips on the page
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  </script>

  @if (session('__success'))
    <script>
      Swal.fire({
        title: 'Success!',
        text: '{{ session('__success') }}',
        icon: 'success',
        confirmButtonText: 'Ok'
      })
    </script>
  @endif

  @yield('btmSlot')
  @yield('btmSlot2')
  @yield('btmSlot3')
</body>

</html>
