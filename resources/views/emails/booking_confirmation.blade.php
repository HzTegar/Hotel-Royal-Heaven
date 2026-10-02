<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #ffb833; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .booking-details { background-color: white; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Royal Heaven Hotel</h1>
            <h2>Booking Confirmation</h2>
        </div>

        <div class="content">
            <p>Dear {{ $user->name }},</p>

            <p>Thank you for choosing Royal Heaven Hotel. Your booking has been successfully created with the following details:</p>

            <div class="booking-details">
                <h3>Booking Details</h3>
                <p><strong>Booking Code:</strong> {{ $pemesanan->kode_pemesanan }}</p>
                <p><strong>Room:</strong> {{ $kamar->nomor_kamar }} - {{ $kamar->tipe->nama_tipe }}</p>
                <p><strong>Check-in:</strong> {{ $pemesanan->tgl_check_in ? \Carbon\Carbon::parse($pemesanan->tgl_check_in)->format('d M Y') : 'N/A' }}</p>
                <p><strong>Check-out:</strong> {{ $pemesanan->tgl_check_out ? \Carbon\Carbon::parse($pemesanan->tgl_check_out)->format('d M Y') : 'N/A' }}</p>
                <p><strong>Total Nights:</strong> {{ $pemesanan->total_malam }}</p>
                <p><strong>Total Price:</strong> Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($pemesanan->pilihan_pembayaran) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($pemesanan->status_pemesanan) }}</p>
                @if($pemesanan->catatan)
                <p><strong>Notes:</strong> {{ $pemesanan->catatan }}</p>
                @endif
            </div>

            <p>Please keep this booking code for your reference. You can check your booking status anytime in your member dashboard.</p>

            <p>If you have any questions, please don't hesitate to contact us.</p>

            <p>Best regards,<br>Royal Heaven Hotel Team</p>
        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>
