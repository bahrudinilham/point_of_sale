<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- PWA -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#0f172a">
        <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen flex">
            <!-- Left Side - Brand & Features (Desktop Only) -->
            <div class="hidden lg:flex lg:w-1/2 bg-[#5D5FEF] text-white flex-col justify-center items-center p-12 relative overflow-hidden">
                <!-- Decorative Circles -->
                <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full translate-x-1/3 translate-y-1/3"></div>

                <div class="relative z-10 max-w-lg text-center">
                    <!-- Logo Icon -->
                    <div class="bg-white/20 p-6 rounded-3xl inline-block mb-8 backdrop-blur-sm shadow-xl">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>

                    <h1 class="text-4xl font-bold mb-4">MukitCell POS</h1>
                    <p class="text-indigo-100 text-lg mb-12">Sistem Point of Sale Modern & Terintegrasi</p>

                    <!-- Feature List -->
                    <div class="space-y-6 text-left inline-block">
                        <div class="flex items-center gap-4 bg-white/10 p-4 rounded-xl border border-white/10 hover:bg-white/20 transition-colors backdrop-blur-sm">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Manajemen Stok</h3>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-white/10 p-4 rounded-xl border border-white/10 hover:bg-white/20 transition-colors backdrop-blur-sm">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Transaksi Cepat</h3>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-white/10 p-4 rounded-xl border border-white/10 hover:bg-white/20 transition-colors backdrop-blur-sm">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Laporan Lengkap</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-white dark:bg-gray-800">
                <div class="w-full max-w-md space-y-8">
                    <!-- Mobile Logo (Visible only on small screens) -->
                    <div class="lg:hidden text-center mb-8">
                        <div class="inline-flex bg-[#5D5FEF] p-3 rounded-2xl mb-4">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">MukitCell POS</h2>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
        
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    })
                    .catch((err) => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
    </body>
</html>
