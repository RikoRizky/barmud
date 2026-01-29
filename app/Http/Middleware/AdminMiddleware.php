<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    //menangani permintaan masuk
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login dan role adalah admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika tidak, redirect ke login admin
        return redirect()->route('admin.login')
            ->withErrors(['access' => 'Anda harus login sebagai admin.']);
    }
}