@php
    $templateUrl = \App\Filament\Resources\Mentoring\Templates\MentorAvailabilityTemplateResource::getUrl('index');
    $slotUrl = \App\Filament\Resources\Mentoring\Slots\MentorAvailabilitySlotResource::getUrl('index');
    $bookingUrl = \App\Filament\Resources\Mentoring\Bookings\MentoringBookingResource::getUrl('index');
@endphp

<div style="display: flex; flex-direction: column; gap: 20px; font-family: inherit; color: #374151;">
    {{-- Summary Pipeline Banner --}}
    <div style="background: linear-gradient(135deg, #FFF1F7 0%, #FDF2F8 100%); border: 1px solid #FCE7F3; border-radius: 16px; padding: 18px 20px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: #FF4D9E; color: #ffffff; border-radius: 8px; font-size: 14px;">✨</span>
                <span style="font-weight: 700; font-size: 15px; color: #9D174D;">Alur Cepat Mentoring</span>
            </div>
            <span style="background: #FCE7F3; color: #BE185D; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px;">4 Langkah Sederhana</span>
        </div>

        {{-- Mini Stepper Pipeline --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 8px;">
            <div style="background: #ffffff; border: 1px solid #FBCFE8; border-radius: 10px; padding: 8px 12px; text-align: center;">
                <div style="font-size: 11px; font-weight: 700; color: #DB2777;">1. BUAT POLA</div>
                <div style="font-size: 12px; color: #4B5563; margin-top: 2px;">Hari & Jam Rutin</div>
            </div>
            <div style="background: #ffffff; border: 1px solid #BFDBFE; border-radius: 10px; padding: 8px 12px; text-align: center;">
                <div style="font-size: 11px; font-weight: 700; color: #2563EB;">2. BUKA SLOT</div>
                <div style="font-size: 12px; color: #4B5563; margin-top: 2px;">1 Bulan ke Depan</div>
            </div>
            <div style="background: #ffffff; border: 1px solid #DDD6FE; border-radius: 10px; padding: 8px 12px; text-align: center;">
                <div style="font-size: 11px; font-weight: 700; color: #7C3AED;">3. SISWA BOOKING</div>
                <div style="font-size: 12px; color: #4B5563; margin-top: 2px;">Pilih Jadwal Anda</div>
            </div>
            <div style="background: #ffffff; border: 1px solid #A7F3D0; border-radius: 10px; padding: 8px 12px; text-align: center;">
                <div style="font-size: 11px; font-weight: 700; color: #059669;">4. MEET & SELESAI</div>
                <div style="font-size: 12px; color: #4B5563; margin-top: 2px;">Google Meet / Zoom</div>
            </div>
        </div>
    </div>

    {{-- 4 Detailed Interactive Step Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
        {{-- Card 1 --}}
        <div style="background: #ffffff; border: 1px solid #E5E7EB; border-radius: 14px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #FCE7F3; color: #DB2777; font-weight: 800; font-size: 14px; border-radius: 10px;">1</span>
                    <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 6px;">Pola Mingguan</span>
                </div>
                <h4 style="margin: 0 0 6px 0; font-size: 15px; font-weight: 700; color: #111827;">Tentukan Pola Jadwal Rutin</h4>
                <p style="margin: 0 0 14px 0; font-size: 13px; line-height: 1.5; color: #6B7280;">
                    Atur hari apa saja dan jam berapa Anda bersedia membuka sesi bimbingan rutin (misal: <strong>Setiap Senin 09:00 - 10:00 WIB</strong>).
                </p>
            </div>
            <a href="{{ $templateUrl }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: #FFF1F7; color: #DB2777; border: 1px solid #FBCFE8; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;">
                <span>📅 Atur Pola Rutin</span> &rarr;
            </a>
        </div>

        {{-- Card 2 --}}
        <div style="background: #ffffff; border: 1px solid #E5E7EB; border-radius: 14px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #DBEAFE; color: #2563EB; font-weight: 800; font-size: 14px; border-radius: 10px;">2</span>
                    <span style="background: #EFF6FF; color: #1D4ED8; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 6px;">Buka Slot Kalender</span>
                </div>
                <h4 style="margin: 0 0 6px 0; font-size: 15px; font-weight: 700; color: #111827;">Terapkan ke Kalender</h4>
                <p style="margin: 0 0 14px 0; font-size: 13px; line-height: 1.5; color: #6B7280;">
                    Klik tombol hijau <strong>"Terapkan Jadwal ke Kalender"</strong>. Pilih periode (misal: 1 Bulan) agar tanggal-tanggal nyata dibuat otomatis.
                </p>
            </div>
            <a href="{{ $slotUrl }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;">
                <span>⚡ Cek Slot Kalender</span> &rarr;
            </a>
        </div>

        {{-- Card 3 --}}
        <div style="background: #ffffff; border: 1px solid #E5E7EB; border-radius: 14px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #EDE9FE; color: #7C3AED; font-weight: 800; font-size: 14px; border-radius: 10px;">3</span>
                    <span style="background: #F5F3FF; color: #6D28D9; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 6px;">Booking Masuk</span>
                </div>
                <h4 style="margin: 0 0 6px 0; font-size: 15px; font-weight: 700; color: #111827;">Siswa Booking Jadwal</h4>
                <p style="margin: 0 0 14px 0; font-size: 13px; line-height: 1.5; color: #6B7280;">
                    Siswa yang memiliki hak bimbingan akan memilih jadwal Anda. Data siswa & nomor WhatsApp akan langsung muncul di daftar booking.
                </p>
            </div>
            <a href="{{ $bookingUrl }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: #F5F3FF; color: #7C3AED; border: 1px solid #DDD6FE; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;">
                <span>👥 Pantau Booking</span> &rarr;
            </a>
        </div>

        {{-- Card 4 --}}
        <div style="background: #ffffff; border: 1px solid #E5E7EB; border-radius: 14px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #D1FAE5; color: #059669; font-weight: 800; font-size: 14px; border-radius: 10px;">4</span>
                    <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 6px;">Selesai</span>
                </div>
                <h4 style="margin: 0 0 6px 0; font-size: 15px; font-weight: 700; color: #111827;">Isi Link & Mulai Bimbingan</h4>
                <p style="margin: 0 0 14px 0; font-size: 13px; line-height: 1.5; color: #6B7280;">
                    Masukkan link <strong>Google Meet / Zoom</strong> pada booking siswa. Lakukan sesi tatap muka online, lalu tandai status <strong>Selesai</strong>.
                </p>
            </div>
            <div style="background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 8px; padding: 8px 12px; font-size: 12px; font-weight: 600; color: #047857; text-align: center;">
                ✅ Alur Mentoring Tuntas
            </div>
        </div>
    </div>
</div>
