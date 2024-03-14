<body style="margin: 0; padding: 0; font-family: Helvetica, Arial, sans-serif; background-color: #fff;">
  <table role="presentation"
    style="width: 100%; border-collapse: collapse; border: 0; font-family: Arial, Helvetica, sans-serif; background-color: #efefef;">
    <tr>
      <td align="center" style="padding: 1rem 2rem; vertical-align: top; width: 100%;">
        <table role="presentation" style="max-width: 600px; border-collapse: collapse; border: 0; text-align: left;">
          <td style="padding: 40px 0 0; text-align: center;">
            <div style="padding-bottom: 20px;">
              <img src="https://i.ibb.co/Jx6v3D9/image.png" alt="Laravel POS"
                style="width: 64px;">
              </div>
            <div style="padding: 20px; background-color: #fff; color: #000; text-align: left;">
              <h1 style="margin: 1rem 0">Verification code</h1>
              <p style="padding-bottom: 16px">Please use the code below to verify your OTP.</p>
              <p style="padding-bottom: 16px; font-size: 130%"><strong>{{ $otp }}</strong></p>
              <p style="padding-bottom: 16px">If you didn't request this, you can ignore this email.</p>
              <p style="padding-bottom: 16px">Thanks,<br>A Laravel Artisan</p>
            </div>
            <div style="padding-top: 20px; color: #555;">
              <p style="padding-bottom: 16px">Made with ♥ in Bangladesh</p>
            </div>
          </td>
        </table>
      </td>
    </tr>
  </table>
</body>