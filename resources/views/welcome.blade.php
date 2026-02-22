<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Disposisi | PT. Graha Perdana Medika</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandTeal: '#00A99D',
                        brandOrange: '#F37021',
                        brandDark: '#2D2D2D',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        html, body { height: 100%; overflow: hidden; }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#00A99D 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            background-opacity: 0.1;
        }
    </style>
</head>
<body class="bg-pattern flex flex-col h-screen text-brandDark">

    <nav class="px-8 py-6 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="/">
                    <x-app-logo-small class="w-10 h-10 fill-current text-white" />
                    </a>
            </div>
            
            <div class="flex items-center gap-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-brandDark hover:text-brandTeal transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 bg-brandDark text-white rounded-full text-sm font-bold shadow-lg hover:bg-brandTeal transition-all transform hover:scale-105">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1 flex flex-col items-center justify-center px-6 text-center relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-brandTeal/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-24 w-80 h-80 bg-brandOrange/5 rounded-full blur-3xl"></div>

        {{-- <span class="px-4 py-4 bg-teal-50 text-brandTeal text-[11px] font-extrabold tracking-[0.15em] rounded-full mb-8 border border-teal-100 uppercase inline-flex items-center gap-2">
            <span class="w-2 h-2 bg-brandTeal rounded-full animate-pulse"></span>
            Internal Medical Portal
        </span> --}}

        <h1 class="text-5xl md:text-7xl font-extrabold text-brandDark tracking-tight leading-[1.1]">
            Sistem Disposisi <br> 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brandTeal to-brandOrange">GRAHA PERDANA MEDIKA</span>
        </h1>

        <p class="mt-8 text-gray-500 max-w-xl text-lg leading-relaxed">
            Sistem administrasi internal PT. Graha Perdana Medika untuk percepatan alur surat dan koordinasi antar divisi medis.
        </p>

        <div class="mt-12 flex flex-col sm:flex-row gap-5">
            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" 
               class="px-10 py-4 bg-brandOrange text-white rounded-full font-bold text-md shadow-xl shadow-orange-200 hover:bg-orange-600 hover:-translate-y-1 transition-all duration-300">
                Mulai 
            </a>
            {{-- <a href="#" class="px-10 py-4 bg-white border border-gray-200 text-brandDark rounded-full font-bold text-md hover:bg-gray-50 transition-all">
                Pelajari Alur
            </a> --}}
        </div>

        {{-- <div class="mt-20 w-full max-w-4xl h-40 bg-gradient-to-t from-teal-50/50 to-transparent rounded-t-[4rem] border-x border-t border-teal-50/50 relative overflow-hidden flex justify-center items-end">
             <div class="w-3/4 h-24 bg-white rounded-t-2xl shadow-2xl shadow-teal-900/5 border-x border-t border-gray-100 transform translate-y-4">
                <div class="flex gap-2 p-4">
                    <div class="w-2 h-2 rounded-full bg-red-300"></div>
                    <div class="w-2 h-2 rounded-full bg-yellow-300"></div>
                    <div class="w-2 h-2 rounded-full bg-green-300"></div>
                </div>
             </div>
        </div> --}}
    </main>

    <footer class="py-6 bg-white border-t border-gray-100 z-10">
        <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs font-semibold text-gray-400">
                © {{ date('Y') }} Made With ♥ by IT Intern. All rights reserved..
            </p>
            <div class="flex gap-6">
                <span class="text-[10px] font-bold text-brandTeal uppercase tracking-widest">Aman</span>
                <span class="text-[10px] font-bold text-brandTeal uppercase tracking-widest">Cepat</span>
                <span class="text-[10px] font-bold text-brandTeal uppercase tracking-widest">Terintegrasi</span>
            </div>
        </div>
    </footer>

</body>
</html>