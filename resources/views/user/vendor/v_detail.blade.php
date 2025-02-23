@extends('user.v_template', ['body_class' => 'paper-background'])

@section('main')
  <div class="container container__shipyard_detail mb-5">
    <div class="container__paper">
      <div class="row">
        @if (!empty($vendor['logo']))
          <div class="col-lg-2">
            <img src="{{ cdnUrl($vendor['logo']) }}" alt="logo" style="width: 100%; max-width: 100px;">
          </div>
        @endif
        <div class="{{ !empty($vendor['logo']) ? 'col-lg-10' : 'col-lg-12' }}">
          <h1>{{ strtoupper($vendor['type']) }} {{ strtoupper($vendor['name']) }}</h1>
          <table style="font-size: 70%;">
            <tr>
              <th>LISTING NO.</th>
              <td>{{ $vendor['listing_number'] ? $vendor['listing_number'] : '-' }}</td>
            </tr>
            <tr>
              <th>LISTING STATUS</th>
              <td>{{ $vendor['listing_status'] ? ucwords(str_replace('_', ' ', $vendor['listing_status'])) : '-' }}
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="mb-4"></div>

      @if ($_yardLocation = json_decode($vendor['address_location'], true))
        @foreach ($_yardLocation as $_key => $_val)
          <div>
            <div class="fw-bold text-decoration-underline">ADDRESS {{ $_key > 0 ? $_key + 1 : '' }}</div>
            @if (!empty($_val['address']))
              {{ $_val['address'] ? ucwords($_val['address']) : '-' }}<br />
            @endif
            @if (!empty($_val['phone']))
              TEL {{ $_val['phone'] ? ucwords($_val['phone']) : '-' }}
            @endif
          </div>
        @endforeach

        <div class="mb-4"></div>
      @endif

      @if (!empty($vendor['website_url']))
        <a href="https://{{ $vendor['website_url'] }}" rel="nofollow" target="_blank">{{ $vendor['website_url'] }}</a>
        <div class="mb-4"></div>
      @endif

      <div class="angle__down"><i class="fas fa-angle-down"></i><span
          class="fw-bold text-decoration-underline d-inline-block ms-3">GENERAL</div>
      <div class="not__angle">
        <table>
          <tr>
            <td class="pe-3">Established Year</td>
            <td>{!! $vendor['established_year'] ?? '&ndash;' !!}</td>
          </tr>
          <tr>
            <td class="pe-3">Corporate Group</td>
            <td>{!! $vendor['group'] ?? '&ndash;' !!}</td>
          </tr>
          <tr>
            <td class="pe-3">Vendor Status</td>
            <td>{!! $vendor['vendor_status'] ? str_replace('_', ' ', ucwords($vendor['vendor_status'])) : '&ndash;' !!}</td>
          </tr>
        </table>
      </div>
      <div class="mb-4"></div>

      <div class="angle__down"><i class="fas fa-angle-down"></i><span
          class="fw-bold text-decoration-underline d-inline-block ms-3">SERVICES / PRODUCTS</span></div>
      <div class="not__angle">
        {!! $vendor['service'] ? nl2br($vendor['service']) : '&ndash;' !!}
      </div>
      <div class="mb-4"></div>

      <div class="angle__down"><i class="fas fa-angle-down"></i><span
          class="fw-bold text-decoration-underline d-inline-block ms-3">CERTIFICATES</span></div>
      <div class="not__angle">
        {!! $vendor['certificate'] ? nl2br($vendor['certificate']) : '&ndash;' !!}
      </div>
      <div class="mb-4"></div>

      @if ($_shipyardImage = json_decode($vendor['image'], true))
        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">PHOTOS</span>
        </div>
        <div class="not__angle">
          <div id="shipyardImage" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              @php($i = 0)
              @foreach ($_shipyardImage as $_image)
                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                  <img src="{{ cdnUrl($_image) }}" class="d-block w-100" alt="{{ $vendor['name'] }}">
                </div>
                @php($i = $i + 1)
              @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#shipyardImage" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#shipyardImage" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <div class="mb-5"></div>
      @endif

      @if ($_shipyardVideo = json_decode($vendor['video'], true))
        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">VIDEOS</span>
        </div>
        <div class="not__angle">
          <div id="shipyardVideo" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              @php($i = 0)
              @foreach ($_shipyardVideo as $_video)
                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                  <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{ $_video }}"
                    frameborder="0" allowfullscreen></iframe>
                </div>
                @php($i = $i + 1)
              @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#shipyardVideo" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#shipyardVideo" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <div class="mb-5"></div>
      @endif

      @if (!empty($vendor['latitude']) && !empty($vendor['longitude']))
        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">MAP</span>
        </div>
        <div class="not__angle">
          <iframe width="100%" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d{{ $vendor['latitude'] }}!2d{{ $vendor['longitude'] }}!3d15.0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDA1JzE4LjQiTiAxMDXCsDI0JzIxLjUiRQ!5e0!3m2!1sen!2sus!4v1631041465024!5m2!1sen!2sus"></iframe>
        </div>
      @endif
    </div>
    <div class="text-center mt-5">
      <div class="d-inline-block">
        <button type="button" class="btn btn-sm btn-primary"
          onclick="return alert('UNDER CONSTRUCTION');">PRINT</button>
        <div class="text-center small">&nbsp;</div>
      </div>
      @if (!empty($shipyard['rfq_email']))
        &nbsp; &nbsp; &nbsp;
        <div class="d-inline-block">
          <button type="button" class="btn btn-sm btn-primary" onclick="return alert('UNDER CONSTRUCTION');">Contact
            or
            Send RFQ</button>
          <div class="text-center small">Need Login</div>
        </div>
      @endif
    </div>
  </div>
@endsection

@section('btmSlot')
  <script>
    $('.angle__down').on('click', function() {
      $angle = $(this);
      $fas = $(this).find('.svg-inline--fa');

      if (!$angle.hasClass('up')) {
        $angle.next('div').hide(500);
        $angle.addClass('up');
        $fas.removeClass('fa-angle-down');
        $fas.addClass('fa-angle-up');
      } else {
        $angle.next('div').show(500);
        $angle.removeClass('up');
        $fas.removeClass('fa-angle-up');
        $fas.addClass('fa-angle-down');
      }
    });
  </script>
@endsection
