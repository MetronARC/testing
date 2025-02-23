<!-- resources/views/emails/my_custom_email.blade.php -->
<html>

<body>
  <p>Hello, {{ $data->name }},</p>
  <p>We have recently detected that your password was changed. If this change was authorized by you, you can disregard this message. However, if you did not initiate this password change, we recommend taking immediate action to secure your account.</p>
  <p>Here are the steps you should follow:</p>
  <p>&nbsp;</p>  
  <ul>
    <li>Log in to your account using your current credentials.</li>
    <li>If you can't log in, click on the "Forgot Password" link on the login page and follow the instructions to reset your password.</li>
    <li>After regaining access, review your account settings and ensure that your personal information is accurate.</li>
    <li>If you believe your account may have been compromised, change your password again, and consider enabling two-factor authentication for added security.</li>
  </ul>
  <p>&nbsp;</p>  
  <p>If you have any concerns or questions about this recent password change, please contact us immediately at <a href="https://dockyard.id">Dockyard.ID</a>.</p>
  <p>Your account security is important to us, and we take such incidents seriously. Thank you for your prompt attention to this matter.</p>
  <p>&nbsp;</p>  
  <p>Best regards.</p>
</body>

</html>
