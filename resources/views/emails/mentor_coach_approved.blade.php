<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Anda Telah Disetujui</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; color: #334155;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f8fafc; padding: 30px 15px;">
        <tr>
            <td align="center">
                <!-- Email Container -->
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05); border: 1px solid #f1f5f9;">
                    <!-- Header with Gradient & Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); padding: 36px 30px; text-align: center;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center">
                                        <div style="background-color: #ffffff; width: 64px; height: 64px; border-radius: 16px; margin: 0 auto 16px; display: inline-block; padding: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                            <img src="{{ asset('assets/images/logos/logo_skid.webp') }}" alt="Salonkita Logo" width="52" height="52" style="border-radius: 10px; display: block; object-fit: contain; margin: 0 auto;">
                                        </div>
                                        <h1 style="color: #ffffff; font-size: 22px; font-weight: 800; margin: 0; letter-spacing: -0.5px;">LMS SalonKita</h1>
                                        <p style="color: #fce7f3; font-size: 13px; margin: 4px 0 0 0; font-weight: 500;">Platform Edukasi Kecantikan Profesional</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 36px 32px;">
                            <!-- Status Badge -->
                            <div style="text-align: center; margin-bottom: 24px;">
                                <span style="display: inline-block; background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 6px 16px; border-radius: 9999px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                    ✓ Pendaftaran Disetujui
                                </span>
                            </div>

                            <h2 style="color: #0f172a; font-size: 20px; font-weight: 700; margin: 0 0 14px 0; text-align: center; letter-spacing: -0.3px;">
                                Selamat, {{ $user->name }}! 🎉
                            </h2>

                            <p style="font-size: 15px; line-height: 1.6; color: #475569; margin: 0 0 20px 0; text-align: center;">
                                Kabar gembira! Permohonan pendaftaran akun Anda sebagai <strong style="color: #db2777;">{{ $roleTitle }}</strong> di platform SalonKita telah berhasil ditinjau dan <strong>resmi disetujui</strong> oleh tim kurasi kami.
                            </p>

                            <!-- Feature Box -->
                            <div style="background-color: #fdf2f8; border: 1px solid #fbcfe8; border-radius: 16px; padding: 20px; margin: 24px 0;">
                                <h3 style="color: #9d174d; font-size: 14px; font-weight: 700; margin: 0 0 12px 0;">
                                    Apa yang dapat Anda lakukan sekarang?
                                </h3>
                                <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="padding: 6px 0; vertical-align: top; width: 22px;">
                                            <span style="color: #ec4899; font-weight: bold; font-size: 15px;">✓</span>
                                        </td>
                                        <td style="padding: 6px 0; vertical-align: top; font-size: 13px; color: #475569; line-height: 1.5;">
                                            <strong>Akses Dashboard Mentor:</strong> Masuk ke panel eksklusif untuk mengelola jadwal dan data bimbingan Anda.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; vertical-align: top; width: 22px;">
                                            <span style="color: #ec4899; font-weight: bold; font-size: 15px;">✓</span>
                                        </td>
                                        <td style="padding: 6px 0; vertical-align: top; font-size: 13px; color: #475569; line-height: 1.5;">
                                            <strong>Atur Ketersediaan (Slot Booking):</strong> Tentukan jadwal hari dan jam sesi mentoring 1-on-1 dengan peserta.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; vertical-align: top; width: 22px;">
                                            <span style="color: #ec4899; font-weight: bold; font-size: 15px;">✓</span>
                                        </td>
                                        <td style="padding: 6px 0; vertical-align: top; font-size: 13px; color: #475569; line-height: 1.5;">
                                            <strong>Lengkapi Profil & Portofolio:</strong> Tambahkan keahlian dan pengalaman terbaik Anda agar calon siswa semakin yakin.
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 32px 0 24px 0;">
                                <a href="{{ $dashboardUrl }}" target="_blank" style="display: inline-block; background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 700; padding: 14px 32px; border-radius: 12px; box-shadow: 0 4px 12px rgba(236, 72, 153, 0.35); text-align: center;">
                                    Masuk ke Dashboard Sekarang &rarr;
                                </a>
                            </div>

                            <p style="font-size: 12px; color: #94a3b8; text-align: center; line-height: 1.5; margin: 0 0 16px 0;">
                                Jika tombol di atas tidak dapat diklik, salin dan tempel tautan berikut di peramban (browser) Anda:<br>
                                <a href="{{ $dashboardUrl }}" style="color: #ec4899; word-break: break-all;">{{ $dashboardUrl }}</a>
                            </p>

                            <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 28px 0;">

                            <!-- Help Contact -->
                            <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin: 0; text-align: center;">
                                Memiliki pertanyaan atau butuh bantuan saat memulai? Tim dukungan kami siap membantu melalui email <a href="mailto:info@skid.co.id" style="color: #ec4899; text-decoration: none; font-weight: 600;">info@skid.co.id</a>.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #f1f5f9; padding: 20px 30px; text-align: center;">
                            <p style="font-size: 12px; color: #94a3b8; margin: 0 0 6px 0;">
                                &copy; {{ date('Y') }} SalonKita Indonesia (SKID). All rights reserved.
                            </p>
                            <p style="font-size: 11px; color: #cbd5e1; margin: 0;">
                                Email ini dikirimkan secara otomatis kepada {{ $user->email }} terkait status akun Mentor/Coach Anda.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
