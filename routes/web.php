<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/dashboard', function() {
    return view('pages.dashboard');
});

Route::get('/kelas', function() {
    return view('pages.kelas');
});

Route::get('/profile', function() {
    return view('pages.profile');
});

Route::get('/kelas-tersimpan', function() {
    return view('pages.kelas_tersimpan');
});

Route::get('/semua-kelas', function() {
    return view('pages.semua_kelas');
});

Route::get('/tugas', function() {
    return view('pages.tugas');
});

Route::get('/login', function() {
    return view('pages.login');
});

Route::get('/register', function() {
    return view('pages.register');
});

Route::get('/pembayaran', function() {
    return view('pages.pembayaran');
});
