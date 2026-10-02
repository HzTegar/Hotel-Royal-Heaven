<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Message from Royal Heaven Hotel Website</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #f59e0b; text-align: center;">New Contact Message</h1>

        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h2 style="color: #333; margin-top: 0;">Message Details:</h2>

            <p><strong>Name:</strong> {{ $data['name'] }}</p>
            <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
            <p><strong>Message:</strong></p>
            <div style="background-color: white; padding: 15px; border-radius: 4px; border-left: 4px solid #f59e0b;">
                {{ $data['message'] }}
            </div>

            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                This message was sent from the Royal Heaven Hotel website contact form.
            </p>
        </div>

        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="color: #666; font-size: 12px;">
                Royal Heaven Hotel<br>
                Jl. Raya Bogor KM 47, Cibinong, Bogor<br>
                Jawa Barat 16911, Indonesia
            </p>
        </div>
    </div>
</body>
</html>
