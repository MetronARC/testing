<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <style>
    body {
      margin: 0;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #212529;
      background-color: #fff;
      -webkit-text-size-adjust: 100%;
      -webkit-tap-highlight-color: transparent;
    }

    table {
      width: 100%;
    }

    th {
      text-align: left;
    }

    td {
      vertical-align: top;
      padding: 0;
    }

    h1 {
      font-size: 24px;
      font-weight: 700;
      margin-top: 0;
      margin-bottom: 0.5rem;
      display: block;
    }

    .mb-4 {
      margin-bottom: 24px;
    }

    .ms-3 {
      margin-left: 16px;
    }

    .pe-3 {
      padding-right: 16px;
    }

    .fw-bold {
      font-weight: 700;
    }

    .d-inline-block {
      display: inline-block;
    }

    .text-danger {
      color: #dc3545;
    }

    .text-success {
      color: #198754;
    }
  </style>
</head>

<body>
  <table>
    <tbody>
      <tr>
        @if (!empty($shipyard['logo']))
          <td>
            <img src="{{ cdnUrl($shipyard['logo']) }}" alt="logo" style="width: 100%; max-width: 100px;">
          </td>
        @endif
        <td>
          <h1>{{ strtoupper($shipyard['type']) }} {{ strtoupper($shipyard['name']) }}</h1>
        </td>
      </tr>
    </tbody>
  </table>
  <table style="">
    <tbody>
      <tr>
        <th style="width: 150px;">OTHER NAMES</th>
        <td>{{ $shipyard['other_name'] ? $shipyard['other_name'] : '-' }}</td>
      </tr>
      <tr>
        <th style="width: 150px;">LISTING NO.</th>
        <td>{{ $shipyard['listing_number'] ? $shipyard['listing_number'] : '-' }}</td>
      </tr>
      <tr>
        <th style="width: 150px;">LISTING STATUS</th>
        <td>
          {{ $shipyard['listing_status'] ? ucwords(str_replace('_', ' ', $shipyard['listing_status'])) : '-' }}
        </td>
      </tr>
    </tbody>
  </table>
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
      {{ strtoupper($_val['type']) }} {{ $_val['name'] }}<br />
    @endforeach
    <div class="mb-4"></div>
  @endif

  @if (!empty($shipyard['website_url']))
    {{ $shipyard['website_url'] }}
    <div class="mb-4"></div>
  @endif

  @php($_service = json_decode($shipyard['service'], true))
  @php($_construction = json_decode($shipyard['construction'], true))

  <table>
    <tr>
      <td>
        @if ($_service)
          <div><span class="fw-bold d-inline-block">SERVICES</span></div>
          <table>
            <tr>
              <td class="pe-3">Ship Repair/Conversion/Retrofit</td>
              <td>{!! !empty($_service['ship_repair'])
                  ? '<span class="text-success">Yes</span>'
                  : '<span class="text-danger">No</span>' !!}</td>
            </tr>
            <tr>
              <td class="pe-3">Ship Building</td>
              <td>{!! !empty($_service['ship_building'])
                  ? '<span class="text-success">Yes</span>'
                  : '<span class="text-danger">No</span>' !!}</td>
            </tr>
          </table>
        @endif
      </td>
      <td>&nbsp; &nbsp;</td>
      <td>
        @if ($_construction)
          <div><span class="fw-bold d-inline-block">CONSTRUCTION
              MATERIAL</span></div>
          <table>
            <tr>
              <td class="pe-3">Steel</td>
              <td>{!! !empty($_construction['steel'])
                  ? '<span class="text-success">Yes</span>'
                  : '<span class="text-danger">No</span>' !!}</td>
            </tr>
            <tr>
              <td class="pe-3">Aluminium</td>
              <td>{!! !empty($_construction['aluminium'])
                  ? '<span class="text-success">Yes</span>'
                  : '<span class="text-danger">No</span>' !!}</td>
            </tr>
            <tr>
              <td class="pe-3">Wood, FRP, Fiberglass, others</td>
              <td>{!! !empty($_construction['other'])
                  ? '<span class="text-success">Yes</span>'
                  : '<span class="text-danger">No</span>' !!}</td>
            </tr>
          </table>
        @endif
      </td>
    </tr>
  </table>
  <div class="mb-4"></div>

  <div><span class="fw-bold d-inline-block">GENERAL</span>
  </div>
  <div class="not__angle">
    <table>
      <tr>
        <td class="pe-3" style="width: 150px;">Established Year</td>
        <td>{!! $shipyard['established_year'] ?? '&ndash;' !!}</td>
      </tr>
      <tr>
        <td class="pe-3">Corporate Group</td>
        <td>{!! $shipyard['group'] ?? '&ndash;' !!}</td>
      </tr>
    </table>
  </div>
  <div class="mb-4"></div>

  <div class="angle__down"><span class="fw-bold d-inline-block">MAIN
      FACILITIES</span></div>
  <div class="ps-4">
    <div class="angle__down"><span class="fw-bold d-inline-block">AREA</span>
    </div>
    <div class="not__angle">
      <table>
        <tr>
          <td class="pe-3" style="width: 150px;">Total Area</td>
          <td>{!! $shipyard['total_area'] ?? '&ndash;' !!}</td>
        </tr>
        <tr>
          <td class="pe-3">Water Depth</td>
          <td>{!! $shipyard['water_depth'] ?? '&ndash;' !!}</td>
        </tr>
      </table>
    </div>
    <div class="mb-4"></div>

    <div class="angle__down"><span class="fw-bold d-inline-block">GRAVING
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

    <div class="angle__down"><span class="fw-bold d-inline-block">FLOATING
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

    <div class="angle__down"><span class="fw-bold d-inline-block">SLIPWAY</span>
    </div>
    <div class="not__angle">
      {!! $shipyard['slipway'] ? nl2br($shipyard['slipway']) : '&ndash;' !!}
    </div>
    <div class="mb-4"></div>
    <div class="angle__down"><span class="fw-bold d-inline-block">JETTY / REPAIR
        BERTH</span>
    </div>
    <div class="not__angle">
      {{ !empty($shipyard['berthing_jetty']) ? strtoupper($shipyard['berthing_jetty']) : 'NO' }}
    </div>
    <div class="mb-4"></div>
    <div class="angle__down"><span class="fw-bold d-inline-block">CRANES</span>
    </div>
    <div class="not__angle">
      {!! $shipyard['crane'] ? nl2br($shipyard['crane']) : '&ndash;' !!}
    </div>
  </div>
  <div class="mb-4"></div>

  <div class="angle__down"><span
      class="fw-bold d-inline-block">CERTIFICATES</span></div>
  <div class="not__angle">
    {!! $shipyard['certificate'] ? nl2br($shipyard['certificate']) : '&ndash;' !!}
  </div>
  <div class="mb-4"></div>

  <div class="angle__down"><span class="fw-bold d-inline-block">ORDER
      BOOK</span></div>
  <div class="ps-4">
    <div class="angle__down"><span class="fw-bold d-inline-block">SHIP REPAIR
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

    <div class="angle__down"><span class="fw-bold d-inline-block">NEW
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
</body>

</html>
