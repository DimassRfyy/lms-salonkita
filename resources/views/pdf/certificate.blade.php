<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sertifikat Kelulusan - {{ $user->name }}</title>
    <style>
        @page {
            size: a4 landscape;
            margin: 0;
        }
        * {
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 842pt;
            height: 595pt;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #ffffff;
            color: #1f2937;
        }
        .outer-border-box {
            width: 792pt;
            height: 542pt;
            margin: 26.5pt auto 0 auto;
            border: 4pt solid #db2777;
            border-radius: 16pt;
            background-color: #fff1f2;
            padding: 5pt;
        }
        .inner-border-box {
            width: 774pt;
            height: 524pt;
            border: 1.5pt dashed #f472b6;
            border-radius: 12pt;
            background-color: #ffffff;
            padding: 0;
            margin: 0;
            position: relative;
        }
        .corner-tl {
            position: absolute;
            top: 4pt;
            left: 4pt;
            width: 22pt;
            height: 22pt;
            border-top: 4pt solid #be185d;
            border-left: 4pt solid #be185d;
        }
        .corner-tr {
            position: absolute;
            top: 4pt;
            right: 4pt;
            width: 22pt;
            height: 22pt;
            border-top: 4pt solid #be185d;
            border-right: 4pt solid #be185d;
        }
        .corner-bl {
            position: absolute;
            bottom: 4pt;
            left: 4pt;
            width: 22pt;
            height: 22pt;
            border-bottom: 4pt solid #be185d;
            border-left: 4pt solid #be185d;
        }
        .corner-br {
            position: absolute;
            bottom: 4pt;
            right: 4pt;
            width: 22pt;
            height: 22pt;
            border-bottom: 4pt solid #be185d;
            border-right: 4pt solid #be185d;
        }
        .table-layout {
            width: 774pt;
            height: 524pt;
            border-collapse: collapse;
            text-align: center;
        }
        .logo-img {
            height: 50pt;
            margin: 0 auto 4pt auto;
            display: block;
        }
        .main-title {
            font-size: 26pt;
            font-weight: 800;
            color: #111827;
            letter-spacing: 4pt;
            text-transform: uppercase;
            margin: 0;
            padding: 0;
            line-height: 1.1;
        }
        .subtitle {
            font-size: 10.5pt;
            color: #db2777;
            font-weight: bold;
            letter-spacing: 2.5pt;
            text-transform: uppercase;
            margin: 4pt 0 0 0;
            padding: 0;
        }
        .recipient-intro {
            font-size: 13pt;
            color: #6b7280;
            font-style: italic;
            margin-bottom: 6pt;
        }
        .student-name {
            font-size: 36pt;
            font-weight: 800;
            color: #db2777;
            margin: 0 auto;
            display: inline-block;
            border-bottom: 2.5pt solid #fbcfe8;
            padding: 0 20pt 4pt 20pt;
            line-height: 1.15;
        }
        .statement {
            font-size: 13pt;
            color: #4b5563;
            max-width: 580pt;
            margin: 14pt auto 5pt auto;
            line-height: 1.4;
        }
        .course-title {
            font-size: 23pt;
            font-weight: 800;
            color: #111827;
            margin: 4pt auto 0 auto;
            line-height: 1.25;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-pill {
            background-color: #fdf2f8;
            border: 1pt solid #fbcfe8;
            border-radius: 8pt;
            padding: 6pt 16pt;
            display: inline-block;
            text-align: center;
        }
        .meta-label {
            font-size: 8.5pt;
            color: #9d174d;
            text-transform: uppercase;
            letter-spacing: 1pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }
        .meta-val {
            font-size: 12pt;
            color: #1f2937;
            font-weight: bold;
            margin-top: 2pt;
        }
        .meta-code {
            font-family: 'Courier', monospace;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            width: 150pt;
        }
        .signature-img {
            height: 50pt;
            display: block;
            margin: 0 auto -4pt auto;
        }
        .sig-line {
            width: 130pt;
            border-top: 1.5pt solid #9ca3af;
            margin: 2pt auto;
        }
        .sig-name {
            font-size: 12pt;
            font-weight: bold;
            color: #111827;
            margin: 0;
        }
        .sig-title {
            font-size: 9pt;
            color: #db2777;
            font-weight: 600;
            margin: 0;
        }
    </style>
</head>
<body>
    @php
        $logoPath = public_path('assets/images/logos/logo_skid new.png');
        if (! file_exists($logoPath)) {
            $logoPath = public_path('assets/images/logos/logo_skid.png');
        }
        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;

        $sigPath = public_path('assets/images/logos/signature_example.png');
        $sigBase64 = file_exists($sigPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($sigPath)) : null;

        $certCode = $certificate->certificate_code ?? ('SLN-' . date('Ym') . '-ABC123');
        $issueDate = $certificate->issued_at ? \Carbon\Carbon::parse($certificate->issued_at)->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
    @endphp

    <div class="outer-border-box">
        <div class="inner-border-box">
            <!-- Corner Brackets -->
            <div class="corner-tl"></div>
            <div class="corner-tr"></div>
            <div class="corner-bl"></div>
            <div class="corner-br"></div>

            <table class="table-layout">
                <!-- Top Section -->
                <tr>
                    <td style="vertical-align: top; text-align: center; height: 115pt; padding: 14pt 24pt 0 24pt;">
                        @if ($logoBase64)
                            <img src="{{ $logoBase64 }}" class="logo-img" alt="Salonkita Logo">
                        @endif
                        <h1 class="main-title">SERTIFIKAT KELULUSAN</h1>
                        <p class="subtitle">CERTIFICATE OF COMPLETION</p>
                    </td>
                </tr>

                <!-- Middle Section (Centered) -->
                <tr>
                    <td style="vertical-align: middle; text-align: center; height: 260pt; padding: 0 30pt;">
                        <div class="recipient-intro">Diberikan dengan bangga kepada:</div>
                        <div class="student-name">{{ $user->name }}</div>

                        <p class="statement">
                            Atas keberhasilannya dalam menyelesaikan seluruh rangkaian materi modul, praktik, dan evaluasi pada kursus:
                        </p>
                        <div class="course-title">"{{ $course->name }}"</div>
                    </td>
                </tr>

                <!-- Bottom Section -->
                <tr>
                    <td style="vertical-align: bottom; height: 125pt; padding: 0 28pt 16pt 28pt;">
                        <table class="footer-table">
                            <tr>
                                <td style="width: 33.33%; text-align: left; vertical-align: bottom;">
                                    <div class="meta-pill">
                                        <div class="meta-label">Nomor Kredensial</div>
                                        <div class="meta-val meta-code">{{ $certCode }}</div>
                                    </div>
                                </td>
                                <td style="width: 33.33%; text-align: center; vertical-align: bottom;">
                                    <div class="meta-pill">
                                        <div class="meta-label">Tanggal Terbit</div>
                                        <div class="meta-val">{{ $issueDate }}</div>
                                    </div>
                                </td>
                                <td style="width: 33.33%; text-align: right; vertical-align: bottom;">
                                    <div class="signature-box">
                                        @if ($sigBase64)
                                            <img src="{{ $sigBase64 }}" class="signature-img" alt="Tanda Tangan Founder">
                                        @endif
                                        <div class="sig-line"></div>
                                        <div class="sig-name">Hertauli Harianja</div>
                                        <div class="sig-title">Founder Salonkita</div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
