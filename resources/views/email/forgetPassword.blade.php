<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body style="font-family: Arial, sans-serif;">

    <table style="width: 100%; max-width: 600px; margin: 0 auto; padding: 20px;">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <h1 style="font-size: 24px; margin: 0;">Forget Password Email</h1>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin-bottom: 20px;">You can reset your password by clicking the link below:</p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <a href="{{ route('password.reset', $token) }}"
                    style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold;">Reset
                    Password</a>
            </td>
        </tr>
    </table>

</body>

</html>
