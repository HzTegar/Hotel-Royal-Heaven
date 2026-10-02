<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Status Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #ffb833; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .booking-details { background-color: white; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .status-change { background-color: #e8f5e8; padding: 10px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #4caf50; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Royal Heaven Hotel</h1>
            <h2>Booking Status Update</h2>
        </div>

        <div class="content">
            <p>Dear {{ $user->name }},</p>

            <p>We would like to inform you about an update to your booking status at Royal Heaven Hotel.</p>

            <div class="status-change">
                <h3>Status Change</h3>
                <p><strong>From:</strong> {{ ucfirst($oldStatus) }}</p>
                <p><strong>To:</strong> {{ ucfirst($newStatus) }}</p>
            </div>

            <div class="booking-details">
                <h3>Booking Details</h3>
                <p><strong>Booking Code:</strong> {{ $pemesanan->kode_pemesanan }}</p>
                <p><strong>Room:</strong> {{ $kamar->nomor_kamar }} - {{ $kamar->tipe->nama_tipe }}</p>
                <p><strong>Check-in:</strong> {{ $pemesanan->tgl_check_in ? \Carbon\Carbon::parse($pemesanan->tgl_check_in)->format('d M Y') : 'N/A' }}</p>
                <p><strong>Check-out:</strong> {{ $pemesanan->tgl_check_out ? \Carbon\Carbon::parse($pemesanan->tgl_check_out)->format('d M Y') : 'N/A' }}</p>
                <p><strong>Total Price:</strong> Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>
            </div>

            @if($newStatus == 'confirmed')
                <p>Great news! Your booking has been confirmed. We look forward to welcoming you to Royal Heaven Hotel.</p>
            @elseif($newStatus == 'cancelled')
                <p>We regret to inform you that your booking has been cancelled. If you have any questions, please contact us.</p>
            @elseif($newStatus == 'completed')
                <p>Your stay at Royal Heaven Hotel has been completed. Thank you for choosing us. We hope to see you again soon!</p>
            @endif

            <p>You can check your booking details anytime in your member dashboard.</p>

            <p>If you have any questions, please don't hesitate to contact us.</p>

            <p>Best regards,<br>Royal Heaven Hotel Team</p>
        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>
