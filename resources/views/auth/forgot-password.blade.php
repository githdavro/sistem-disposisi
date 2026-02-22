<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | Sistem Disposisi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              jakarta: ['Plus Jakarta Sans', 'sans-serif'],
              mono: ['JetBrains Mono', 'monospace'],
            }
          }
        }
      }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow: hidden; }
    </style>
</head>
<body class="bg-[#f8fafc] flex items-center justify-center min-h-screen p-6">

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-green-50 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-50 rounded-full blur-[120px]"></div>
    </div>

    <div class="w-full max-w-md">
        <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] p-10 border border-gray-100 relative overflow-hidden">
            
            <div class="flex justify-center mb-8">
                <div class="w-20 h-20 bg-green-50 rounded-3xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl text-green-600">lock_reset</span>
                </div>
            </div>

            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Lupa Password?</h2>
                <p class="text-gray-500 mt-2 text-sm leading-relaxed">
                    Jangan khawatir, tim IT kami siap membantu Anda mendapatkan akses kembali.
                </p>
            </div>

            @if (session('status'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 rounded-2xl mb-6 text-sm font-medium flex items-center gap-3">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    {{ session('status') }}
                </div>
            @endif

            <div class="space-y-4">
                <div class="p-5 bg-gray-50 rounded-[2rem] border border-gray-100">
                    <p class="text-[13px] text-gray-600 text-center font-medium leading-relaxed">
                        Silakan klik tombol di bawah untuk terhubung dengan <span class="font-bold text-gray-900">TI Pusat</span> melalui WhatsApp:
                    </p>
                </div>

                <a href="https://wa.me/6287850906774" target="_blank"
                   class="flex items-center justify-center gap-3 bg-[#25D366] hover:bg-[#20ba59] text-white font-bold py-4 px-6 rounded-2xl shadow-xl shadow-green-100 transition-all transform active:scale-95 w-full group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                        <path d="M20.52 3.48a11.76 11.76 0 0 0-16.64 0A11.76 11.76 0 0 0 0 14c0 2.08.54 4.13 1.57 5.94L0 24l4.14-1.58A11.85 11.85 0 0 0 12 24c6.49 0 11.85-5.36 11.85-11.85 0-3.17-1.23-6.15-3.33-8.67ZM12 22a10 10 0 0 1-5.17-1.42l-.37-.22-2.46.94.93-2.38-.24-.38A10 10 0 1 1 22 12 10 10 0 0 1 12 22Zm5.4-7.68c-.24-.12-1.42-.7-1.64-.78s-.38-.12-.54.12-.62.78-.76.94-.28.18-.52.06a6.29 6.29 0 0 1-1.84-1.14 6.93 6.93 0 0 1-1.28-1.6c-.14-.24 0-.36.1-.48.1-.1.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.28-.74-1.74-.2-.46-.4-.4-.54-.4-.14 0-.3-.02-.46-.02s-.42.06-.64.3a2.63 2.63 0 0 0-.96 2.24c0 1.24.62 2.44 1.4 3.3.78.86 1.76 1.76 3.28 2.28a3.29 3.29 0 0 0 2.46.06c.38-.16 1.42-.58 1.62-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28Z"/>
                    </svg>
                    WhatsApp TI Pusat
                </a>

                <a href="{{ route('login') }}"
                   class="flex items-center justify-center gap-2 bg-white text-gray-500 font-bold py-4 px-6 rounded-2xl border border-gray-100 hover:bg-gray-50 hover:text-gray-700 transition-all w-full text-sm">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Kembali ke Login
                </a>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-50 text-center">
                <p class="text-[11px] font-bold text-gray-300 uppercase tracking-[0.2em]">
                    Sistem Disposisi PT. GPM
                </p>
            </div>
        </div>
    </div>

</body>
</html>