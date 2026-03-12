<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salonkita - Belajar Beauty Skill Profesional dari Rumah</title>
    <link rel="icon" href="{{ asset('assets/images/logos/wmm-logo-noteks.png') }}">
    <meta name="description"
        content="Salonkita adalah platform pembelajaran online yang menyediakan kelas-kelas kecantikan profesional untuk membantu Anda mengembangkan keterampilan di bidang kecantikan. Temukan berbagai kelas makeup, skincare, hair styling, dan banyak lagi yang diajarkan oleh para ahli di industri kecantikan. Belajar dengan mudah dari rumah dan tingkatkan keahlian Anda bersama Salonkita.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50">
    {{ $slot }}
</body>

</html>