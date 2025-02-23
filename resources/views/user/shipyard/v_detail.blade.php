@extends('user.v_template', ['body_class' => 'paper-background'])

@section('main')
  <div class="container container__shipyard_detail mb-5">
    <div class="container__paper">
      <div class="row">
        @if (!empty($shipyard['logo']))
          <div class="col-lg-2">
            <img src="{{ cdnUrl($shipyard['logo']) }}" alt="logo" style="width: 100%; max-width: 100px;">
          </div>
        @endif
        <div class="{{ !empty($shipyard['logo']) ? 'col-lg-10' : 'col-lg-12' }}">
          <h1>{{ strtoupper($shipyard['type']) }} {{ strtoupper($shipyard['name']) }}</h1>
          <table style="font-size: 70%;">
            <tr>
              <th>OTHER NAMES</th>
              <td>{{ $shipyard['other_name'] ? $shipyard['other_name'] : '-' }}</td>
            </tr>
            <tr>
              <th>LISTING NO.</th>
              <td>{{ $shipyard['listing_number'] ? $shipyard['listing_number'] : '-' }}</td>
            </tr>
          </table>
        </div>
      </div>

      <div class="mb-4"></div>

      @if (!empty($shipyard['office_address']))
        <div>
          <div class="fw-bold">HEAD QUARTER</div>
          @if (!empty($shipyard['office_address']))
            {{ $shipyard['office_address'] ?? '-' }}<br />
          @endif
          @if (!empty($shipyard['office_phone']))
            TEL {{ $shipyard['office_phone'] ? ucwords($shipyard['office_phone']) : '-' }}
          @endif
        </div>
        <div class="mb-4"></div>
      @endif

      @if ($_yardLocation = json_decode($shipyard['yard_location'], true))
        @foreach ($_yardLocation as $_key => $_val)
          <div>
            <div class="fw-bold">YARD LOCATION {{ $_key > 0 ? $_key + 1 : '' }}</div>
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

      @if (!empty($shipyardBranchs))
        <div class=""><span class="fw-bold d-inline-block">SHIPYARD BRANCH</div>
        @foreach ($shipyardBranchs as $_val)
          <a href="{{ route('shipyard.shipyardDetail', [
              'id' => $_val['id'],
              'slug' => $_val['slug'],
          ]) }} }}"
            target="_blank">{{ strtoupper($_val['type']) }} {{ $_val['name'] }}</a><br />
        @endforeach
        <div class="mb-4"></div>
      @endif

      @if (!empty($shipyard['website_url']))
        <a href="https://{{ $shipyard['website_url'] }}" rel="nofollow"
          target="_blank">{{ $shipyard['website_url'] }}</a>
        <div class="mb-4"></div>
      @endif

      @php($_service = json_decode($shipyard['service'], true))
      @php($_construction = json_decode($shipyard['construction'], true))

      <div class="row">
        @if ($_service)
          <div class="col-lg-6">
            <div class="angle__down"><i class="fas fa-angle-down"></i><span
                class="fw-bold d-inline-block ms-3">SERVICES</span>
            </div>
            <div class="ps-4">
              <table>
                <tr>
                  <td class="pe-3">Ship Repair/Conversion/Retrofit</td>
                  <td>{!! !empty($_service['ship_repair'])
                      ? '<i class="fas fa-check-circle text-success"></i>'
                      : '<i class="fas fa-times-circle text-danger"></i>' !!}</td>
                </tr>
                <tr>
                  <td class="pe-3">Ship Building</td>
                  <td>{!! !empty($_service['ship_building'])
                      ? '<i class="fas fa-check-circle text-success"></i>'
                      : '<i class="fas fa-times-circle text-danger"></i>' !!}</td>
                </tr>
              </table>
            </div>
          </div>
        @endif
        @if ($_construction)
          <div class="col-lg-6">
            <div class="angle__down"><i class="fas fa-angle-down"></i><span
                class="fw-bold d-inline-block ms-3">CONSTRUCTION MATERIAL</span></div>
            <div class="ps-4">
              <table>
                <tr>
                  <td class="pe-3">Steel</td>
                  <td>{!! !empty($_construction['steel'])
                      ? '<i class="fas fa-check-circle text-success"></i>'
                      : '<i class="fas fa-times-circle text-danger"></i>' !!}</td>
                </tr>
                <tr>
                  <td class="pe-3">Aluminium</td>
                  <td>{!! !empty($_construction['aluminium'])
                      ? '<i class="fas fa-check-circle text-success"></i>'
                      : '<i class="fas fa-times-circle text-danger"></i>' !!}</td>
                </tr>
                <tr>
                  <td class="pe-3">Wood, FRP, Fiberglass, others</td>
                  <td>{!! !empty($_construction['other'])
                      ? '<i class="fas fa-check-circle text-success"></i>'
                      : '<i class="fas fa-times-circle text-danger"></i>' !!}</td>
                </tr>
              </table>
            </div>
          </div>
        @endif
      </div>
      <div class="mb-4"></div>

      <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">GENERAL</span>
      </div>
      <div class="not__angle">
        <table>
          <tr>
            <td class="pe-3">Established Year</td>
            <td>{!! $shipyard['established_year'] ?? '&ndash;' !!}</td>
          </tr>
          <tr>
            <td class="pe-3">Corporate Group</td>
            <td>{!! $shipyard['group'] ?? '&ndash;' !!}</td>
          </tr>
        </table>
      </div>
      <div class="mb-4"></div>

      <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">MAIN
          FACILITIES</span></div>
      <div class="ps-4">
        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">AREA</span>
        </div>
        <div class="not__angle">
          <table>
            <tr>
              <td class="pe-3">Total Area</td>
              <td>{!! $shipyard['total_area'] ?? '&ndash;' !!}</td>
            </tr>
            <tr>
              <td class="pe-3">Water Depth</td>
              <td>{!! $shipyard['water_depth'] ?? '&ndash;' !!}</td>
            </tr>
          </table>
        </div>
        <div class="mb-4"></div>

        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">GRAVING
            DOCK</span></div>
        <div class="not__angle">
          @php($_gravingDock = json_decode($shipyard['graving_dock'], true))
          @if ($_gravingDock)
            <table>
              @foreach ($_gravingDock as $_val)
                <tr>
                  <td class="pe-3">{{ $_val['label'] }}</td>
                  <td>{{ $_val['value'] }}</td>
                </tr>
              @endforeach
            </table>
          @else
            &ndash;
          @endif
        </div>
        <div class="mb-4"></div>

        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">FLOATING
            DOCK</span></div>
        <div class="not__angle">
          @php($_floatingDock = json_decode($shipyard['floating_dock'], true))
          @if ($_floatingDock)
            <table>
              @foreach ($_floatingDock as $_val)
                <tr>
                  <td class="pe-3">{{ $_val['label'] }}</td>
                  <td>{{ $_val['value'] }}</td>
                </tr>
              @endforeach
            </table>
          @else
            &ndash;
          @endif
        </div>
        <div class="mb-4"></div>

        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">SLIPWAY</span>
        </div>
        <div class="not__angle">
          {!! $shipyard['slipway'] ? nl2br($shipyard['slipway']) : '&ndash;' !!}
        </div>
        <div class="mb-4"></div>
        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">JETTY / REPAIR
            BERTH</span>
        </div>
        <div class="not__angle">
          {{ !empty($shipyard['berthing_jetty']) ? strtoupper($shipyard['berthing_jetty']) : 'NO' }}
        </div>
        <div class="mb-4"></div>
        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">CRANES</span>
        </div>
        <div class="not__angle">
          {!! $shipyard['crane'] ? nl2br($shipyard['crane']) : '&ndash;' !!}
        </div>
      </div>
      <div class="mb-4"></div>

      <div class="angle__down"><i class="fas fa-angle-down"></i><span
          class="fw-bold d-inline-block ms-3">CERTIFICATES</span></div>
      <div class="not__angle">
        {!! $shipyard['certificate'] ? nl2br($shipyard['certificate']) : '&ndash;' !!}
      </div>
      <div class="mb-4"></div>

      <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">ORDER
          BOOK</span></div>
      <div class="ps-4">
        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">SHIP REPAIR
            / SHIP CONVERSION</span>
        </div>
        <div class="not__angle">
          @php($newBuilding = json_decode($shipyard['new_building'], true))
          @if ($newBuilding)
            <table class="table table-bordered">
              <tr>
                <th>No</th>
                <th>Ship Name</th>
                <th>Ship Type</th>
                <th>Owner</th>
                <th>Completed Date</th>
                <th>Type of Work</th>
              </tr>
              @php($i = 1)
              @foreach ($newBuilding as $_val)
                <tr>
                  <td>{{ $i }}</td>
                  <td>{{ $_val['ship_name'] }}</td>
                  <td>{{ $_val['ship_type'] }}</td>
                  <td>{{ $_val['owner'] }}</td>
                  <td>{{ $_val['date'] }}</td>
                  <td>{{ $_val['work_type'] }}</td>
                </tr>
                @php($i++)
              @endforeach
            </table>
          @else
            &ndash;
          @endif
        </div>
        <div class="mb-4"></div>

        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">NEW
            BUILDING</span></div>
        <div class="not__angle">
          @php($shipRepair = json_decode($shipyard['ship_repair'], true))
          @if ($shipRepair)
            <table class="table table-bordered">
              <tr>
                <th>No</th>
                <th>Hull No.</th>
                <th>Owner</th>
                <th>Ship Type</th>
                <th>Dimensions</th>
                <th>Delivery Date</th>
              </tr>
              @php($i = 1)
              @foreach ($shipRepair as $_val)
                <tr>
                  <td>{{ $i }}</td>
                  <td>{{ $_val['hull'] }}</td>
                  <td>{{ $_val['owner'] }}</td>
                  <td>{{ $_val['type'] }}</td>
                  <td>{{ $_val['dimension'] }}</td>
                  <td>{{ $_val['date'] }}</td>
                </tr>
                @php($i++)
              @endforeach
            </table>
          @else
            &ndash;
          @endif
        </div>
        <div class="mb-5"></div>
      </div>

      @if ($_shipyardImage = json_decode($shipyard['image'], true))
        <div class="angle__down"><i class="fas fa-angle-down"></i><span
            class="fw-bold d-inline-block ms-3">PHOTOS</span></div>
        <div class="not__angle">
          <div id="shipyardImage" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              @php($i = 0)
              @foreach ($_shipyardImage as $_image)
                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                  <img src="{{ cdnUrl($_image) }}" class="d-block w-100" alt="{{ $shipyard['name'] }}">
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

      @if ($_shipyardVideo = json_decode($shipyard['video'], true))
        <div class="angle__down"><i class="fas fa-angle-down"></i><span
            class="fw-bold d-inline-block ms-3">VIDEOS</span></div>
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

      @if (!empty($shipyard['latitude']) && !empty($shipyard['longitude']))
        <div class="angle__down"><i class="fas fa-angle-down"></i><span class="fw-bold d-inline-block ms-3">MAP</span>
        </div>
        <div class="not__angle">
          <iframe width="100%" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d{{ $shipyard['latitude'] }}!2d{{ $shipyard['longitude'] }}!3d15.0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDA1JzE4LjQiTiAxMDXCsDI0JzIxLjUiRQ!5e0!3m2!1sen!2sus!4v1631041465024!5m2!1sen!2sus"></iframe>
        </div>
      @endif
    </div>
    <div class="text-center mt-5">
      <div class="d-inline-block">
        <a href="{{ route('shipyard.shipyardPdf', ['id' => $shipyard['id']]) }}"
          class="btn btn-sm btn-primary">PRINT</a>
        {{-- <div class="text-center small">&nbsp;</div> --}}
      </div>
      @if (
          (!empty($shipyard['rfq_email']) || !empty($shipyard['rfq_phone'])) &&
              !empty($auth_data['member_type']) &&
              $auth_data['member_type'] == 'premium')
        &nbsp; &nbsp; &nbsp;
        <div class="d-inline-block">
          <a href="{{ route('shipyard.shipyardContact', ['id' => $shipyard['id']]) }}" type="button"
            class="btn btn-sm btn-primary">Contact or Send RFQ</a>
          {{-- <div class="text-center small">Need Login</div> --}}
        </div>
      @endif
    </div>
  </div>
@endsection

@section('topSlot')
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
