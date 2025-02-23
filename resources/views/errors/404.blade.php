<!doctype html>
<html lang="en_ID">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Dockyard ID</title>

  <meta name="description" content="">

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
  <link href="/vendor/fontawesome/css/all.css?v=20230916204929" rel="stylesheet">
  <link href="/css/main.css?v=20230916204929" rel="stylesheet">

  <!-- Add Chosen CSS link for multiple select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
</head>

<body class="">
  <header class="not-homepage">
    <div class="header__img" style="background-image: url(/assets/images/dockyard.jpg);"></div>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container">
        <a class="navbar-brand" href="{{ env('DOMAIN_USER_URL') }}">
          <img src="/assets/images/logo.png" alt="logo" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item nav-item__menu">
              <a href="{{ env('DOMAIN_USER_URL') }}/shipyard" class="hover-underline-animation ">SHIPYARD</a>
            </li>
            <li class="nav-item nav-item__menu">
              <a href="{{ env('DOMAIN_USER_URL') }}/marine-vendor" class="hover-underline-animation ">MARINE VENDOR</a>
            </li>
            <li class="nav-item nav-item__menu">
              <a href="{{ env('DOMAIN_USER_URL') }}/tender" class="hover-underline-animation ">TENDER</a>
            </li>
            <li class="nav-item nav-item__menu">
              <a href="{{ env('DOMAIN_USER_URL') }}/for-sale" class="hover-underline-animation ">FOR SALE</a>
            </li>
            <li class="nav-item nav-item__menu">
              <a href="{{ env('DOMAIN_USER_URL') }}/news" class="hover-underline-animation ">NEWS</a>
            </li>
            <li class="nav-item nav-item__menu" style="margin-left: 0;">
              <a href="{{ env('DOMAIN_USER_URL') }}/shipyard-job-vacancy" class="hover-underline-animation ">JOB
                VACANCY</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container position-relative header__menu">
      <div class="row">
        <div class="col"><a href="{{ env('DOMAIN_USER_URL') }}/shipyard"
            class="btn btn-outline-secondary w-100">SHIPYARD</a></div>
        <div class="col"><a href="{{ env('DOMAIN_USER_URL') }}/marine-vendor" class="btn btn-outline-secondary w-100">MARINE
            VENDOR</a></div>
        <div class="col"><a href="{{ env('DOMAIN_USER_URL') }}/tender" class="btn btn-outline-secondary w-100">TENDER</a>
        </div>
        <div class="col"><a href="{{ env('DOMAIN_USER_URL') }}/for-sale" class="btn btn-outline-secondary w-100">FOR
            SALE</a></div>
        <div class="col"><a href="{{ env('DOMAIN_USER_URL') }}/news" class="btn btn-outline-secondary w-100">NEWS</a></div>
        <div class="col"><a href="{{ env('DOMAIN_USER_URL') }}/shipyard-job-vacancy"
            class="btn btn-outline-secondary w-100">SHIPYARD JOB VACANCY</a></div>
      </div>
    </div>
    <div class="row">
      <div class="container position-relative header__quote col-12 order-lg-2">
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
      <div class="container position-relative header__search col-12 order-lg-1">
        <form action="" method="get">
          <input type="hidden" name="_token" value="xVKeujbzaFbUFcEug5qnAUaS8FAVbd8HqlMOjg2U">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="TYPE SHIPYARD, SERVICE, SUPPLIER...">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
        </form>
      </div>
    </div>
  </header>
<main style="min-height: 85vh;">
    <div class="container">
      <div class="container">
        <div class="text-center pt-5">
          <img src="{{ url('assets/images/500.png') }}" alt="Error Page" style="max-width: 500px; width: 100%;">
          <div>Go back to <a href="{{ env('DOMAIN_USER_URL') }}">Homepage</a></div>
        </div>
      </div>
    </div>
  </main>
  <footer style="padding-top: 5rem;">
      <div
        style="background: linear-gradient(to right, #004AAD, #5DE0E6) !important;
    height: 56px; display: flex; width: 100%; justify-content: center; align-items: center; color: #fff;">
        Copyright &copy; {{ date('Y') }} Dockyard.id
      </div>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

  <script src="/vendor/fontawesome/js/all.js?v=20230916204929"></script>

  <!-- Add Chosen JS for multiple select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
</body>

</html>
