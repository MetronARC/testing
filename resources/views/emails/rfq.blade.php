<!-- resources/views/emails/my_custom_email.blade.php -->
<html>

<body>
  @foreach ($user['send_message'] as $_message)
    <p>{{ $_message }}</p>
  @endforeach
</body>

</html>
