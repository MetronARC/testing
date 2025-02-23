<!-- resources/views/emails/my_custom_email.blade.php -->
<html>

<body>
  <p>Hello, {{ $data->name }},</p>
  <p>Your account already verified at <a href="{{ env('DOMAIN_USER_URL') }}">Dockyard.ID</a></p>
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
  <p>Password for your account is: <b>{{ $data->temp_password }}</b>.</p>
  <p>Password above will expired after 30 days.</p>
  <p>Please login and change your password.</p>
  <p>&nbsp;</p>
  <p>Thank you.</p>
</body>

</html>
