<!doctype html>
<html lang="en_ID">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ $metaTitle }}</title>

  <meta name="description" content="{{ $metaDescription }}">

  <link rel="shortcut icon" href="">

  <!-- Font -->

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
    rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Datatable CSS -->
  <link href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ url('/vendor/fontawesome/css/all.css') }}?v={{ date('YmdHis') }}" rel="stylesheet">
  <link href="{{ url('/css/main.css') }}?v={{ date('YmdHis') }}" rel="stylesheet">

  @yield('topSlot')
</head>

<body class="{{ $body_class ?? '' }}">
  @if (empty($TEMPLATE) || (!empty($TEMPLATE) && $TEMPLATE != 'off'))
    <header class="{{ !empty(Request::segment(1)) ? 'not-homepage' : '' }}">
      <div class="header__img" style="background-image: url({{ url('assets/images/dockyard.jpg') }});"></div>
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand" href="{{ route('homeIndex') }}">
            <img src="{{ url('assets/images/logo.png') }}" alt="logo" />
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              @foreach ($menuArr as $_key => $_val)
                <li class="nav-item nav-item__menu">
                  <a href="{{ $_val }}"
                    class="hover-underline-animation {{ Request::segment(1) == Str::slug($_key) ? 'active' : '' }}">{{ $_key }}</a>
                </li>
              @endforeach
              @if (!empty(Request::segment(1)))
                <li class="nav-item">
                  <a href="javascript:void();" onclick="showSearchInput();" id="search__header_button"><i
                      class="fas fa-search"></i></a>
                  <form action="{{ route('search.searchIndex') }}" method="get" id="search__header_input"
                    style="display: none;">
                    @csrf
                    <div class="input-group">
                      <input type="text" name="s" class="form-control form-control-sm"
                        style="border-top-left-radius: 25px; border-bottom-left-radius: 25px; border: 0;"
                        placeholder="Search" />
                      <button class="btn btn-sm btn-secondary" type="submit"
                        style="border-top-right-radius: 25px; border-bottom-right-radius: 25px; background-color: #fff; border: 0;"><i
                          class="fas fa-search"></i></button>
                    </div>
                  </form>
                </li>
              @endif
              <li class="nav-item">

                @if (!empty($auth_data))
                  <a class="btn btn-sm btn-secondary btn__signin" href="{{ env('DOMAIN_ADMIN_URL') }}">
                    @if ($auth_data['role'] == 'ship_manager')
                      USER PROFILE
                    @else
                      DASHBOARD
                    @endif
                  </a>
                  <a class="btn btn-sm btn-danger btn__signin"
                    href="{{ env('DOMAIN_AUTH_LOGOUT_URL') }}?current={{ urlencode(url()->current()) }}">LOG OUT</a>
                @else
                  <a class="btn btn-sm btn-secondary btn__signin"
                    href="{{ env('DOMAIN_AUTH_LOGIN_URL') }}?current={{ urlencode(url()->current()) }}">LOG IN</a>
                  <a class="btn btn-sm btn-warning btn__signup"
                    href="{{ env('DOMAIN_AUTH_REGISTER_URL') }}">MEMBERSHIP</a>
                @endif
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="container position-relative header__menu">
        <div class="row">
          @foreach ($menuArr as $_key => $_val)
            <div class="col"><a href="{{ $_val }}"
                class="btn btn-outline-secondary w-100">{{ $_key }}</a></div>
          @endforeach
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="position-relative header__quote col-12 order-lg-2">
            <div class="header__quote_about">
              DOCKYARD.ID is a tailor made platform to promote Indonesian shipyards and marine businesses national-wide
              and
              to the World.
            </div>
            <div class="header__quote_text">
              <span>With DOCKYARD.ID you will connected with shipyards, marine vendors, ship owners and marine
                professionals.</span>
            </div>
            <div class="header__quote_text">
              <span>We are committed to make DOCKYARD.ID as 100% neutral ground for all.</span>
            </div>
          </div>
          <div class="position-relative header__search col-12 order-lg-1">
            <form action="{{ route('search.searchIndex') }}" method="get">
              @csrf
              <div class="input-group">
                <input type="text" class="form-control" name="s"
                  placeholder="TYPE SHIPYARD, SERVICE, SUPPLIER...">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </header>
  @endif
  <main style="min-height: 85vh;">
    @yield('main')
    <a href="https://wa.me/6281275459875" target="_blank">
      <div class="wa-float"><i class="fab fa-whatsapp"></i></div>
    </a>
  </main>
  @if (empty($TEMPLATE) || (!empty($TEMPLATE) && $TEMPLATE != 'off'))
    <footer style="padding-top: 5rem;">
      <div
        style="background: linear-gradient(to right, #004AAD, #5DE0E6) !important;
    height: 56px; display: flex; width: 100%; justify-content: center; align-items: center; color: #fff;">
        Copyright &copy; {{ date('Y') }} Dockyard.id
      </div>
    </footer>
  @endif

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="{{ url('/vendor/fontawesome/js/all.js') }}?v={{ date('YmdHis') }}"></script>

  <script>
    function showSearchInput() {
      $('#search__header_button').hide();
      $('#search__header_input').show(300);
    }

    @if (session('__login_success'))
      $(function() {
        Swal.fire({
          icon: 'success',
          title: 'Login Successfuly!',
          text: 'You have successfully logged in.',
          confirmButtonText: 'Ok'
        });
      });
    @endif

    @if (session('__logout_success'))
      $(function() {
        Swal.fire({
          icon: 'success',
          title: 'Logout Successfuly!',
          text: 'You have successfully logged out.',
          confirmButtonText: 'Ok'
        });
      });
    @endif
  </script>

  @yield('btmSlot')
</body>

</html>
