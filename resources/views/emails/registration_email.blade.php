<!-- resources/views/emails/my_custom_email.blade.php -->
<html>

<body>
  <p>Hello, {{ $data->name }},</p>
  <p>Thank you for register up for <a href="{{ env('DOMAIN_USER_URL') }}">Dockyard.ID</a></p>
  <p>Here is data that you registered:</p>
  <table>
    <tr>
      <td>Name</td>
      <td>:</td>
      <td>{{ strtoupper($data->name) }}</td>
    </tr>
    <tr>
      <td>Position</td>
      <td>:</td>
      <td>{{ strtoupper($data->position) }}</td>
    </tr>
    <tr>
      <td>Phone</td>
      <td>:</td>
      <td>{{ strtoupper($data->phone) }}</td>
    </tr>
    <tr>
      <td>Email</td>
      <td>:</td>
      <td>{{ strtoupper($data->email) }}</td>
    </tr>
    <tr>
      <td>Business Category</td>
      <td>:</td>
      <td>
        @if ($data->role == 'shipyard')
          SHIPYARD
        @elseif ($data->role == 'vendor')
          MARINE VENDOR
        @elseif ($data->role == 'ship_manager')
          SHIP OWNER / SHIP MANAGER
        @else
          &ndash;
        @endif
      </td>
    </tr>
    <tr>
      <td>Membership Type</td>
      <td>:</td>
      <td>
        @if ($data->member_type == 'premium')
          PRO MEMBERSHIP
        @else
          FREE MEMBERSHIP
        @endif
      </td>
    </tr>
  </table>
  <p>Please be patient, we still verify your data.</p>
  <p>Password will be sent after we approve your data.</p>
  <p>Thank you.</p>
</body>

</html>
