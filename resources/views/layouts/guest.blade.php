<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GPM - Digital Office') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <script src="https://cdn.tailwindcss.com"></script>
        
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brandTeal: '#14b8a6',    // Hijau Toska PGM
                            brandOrange: '#f97316',  // Oranye PGM
                            brandDark: '#0f172a',    // Navy Dark
                        },
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <style type="text/tailwindcss">
            @layer base {
                body { @apply antialiased text-slate-900 font-sans; }
            }
            @layer utilities {
                .bg-dots {
                    background-color: #f8fafc;
                    background-image: radial-gradient(#14b8a615 1px, transparent 1px);
                    background-size: 24px 24px;
                }
                .no-scrollbar::-webkit-scrollbar { display: none; }
                .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
            }
        </style>
    </head>
    <body class="bg-dots">
        <div class="min-h-screen flex flex-col justify-center items-center p-4 md:p-8 relative overflow-hidden">
            
            {{-- Background Decorative Orbs --}}
            <div class="absolute top-0 left-0 w-96 h-96 bg-brandTeal/10 rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-brandOrange/10 rounded-full blur-[100px] translate-x-1/2 translate-y-1/2"></div>

            {{-- Main Container --}}
            <div class="w-full max-w-5xl z-10 transition-all duration-500">
                <div class="bg-white rounded-[2.5rem] shadow-[0_32px_64px_-16px_rgba(20,184,166,0.15)] border border-white overflow-hidden flex flex-col md:flex-row min-h-[600px]">
                    
                    {{-- Slot content (Isi dari login.blade.php) --}}
                    {{ $slot }}

                </div>

                {{-- Footer Login --}}
                <div class="mt-8 flex flex-col md:flex-row items-center justify-between px-6 gap-4">
                    <div class="flex items-center gap-6">
                        <a href="#" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-brandTeal transition-colors">Bantuan</a>
                        <a href="#" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-brandTeal transition-colors">Kebijakan Privasi</a>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                        &copy; 2026 <span class="text-brandTeal">PT GRAHA PERDANA MEDIKA</span> • DISPO
                    </p>
                </div>
            </div>

        </div>

        {{-- SweetAlert2 JS --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>