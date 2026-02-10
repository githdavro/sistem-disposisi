<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400&family=Rubik:wght@900&display=swap" rel="stylesheet">
    
    <!-- Tailwind Font Config -->
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              rubik: ['Rubik', 'sans-serif'],
              robotoMono: ['Roboto Mono', 'monospace'],
            }
          }
        }
      }
    </script>
</head>
<body class="bg-gradient-to-br from-green-600/10 via-transparent to-gray-900/10 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md flex flex-col items-center">
        <h2 class="text-3xl font-rubik mb-6 text-gray-800 text-center">Lupa Password</h2>

        <!-- Status Session -->
        @if (session('status'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 w-full text-center font-robotoMono">
                {{ session('status') }}
            </div>
        @endif

        <!-- Hubungi TI Pusat -->
        <div class="flex flex-col items-center gap-4 w-full mb-6">
            <p class="text-gray-700 text-center font-robotoMono">Silakan hubungi TI Pusat melalui WhatsApp untuk reset password:</p>

            <!-- Tombol WhatsApp -->
            <a href="https://wa.me/6287850906774" target="_blank"
               class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-rubik py-3 px-6 rounded-full shadow-md transition-all duration-200 transform hover:scale-105 w-full text-center">
                <!-- Icon WhatsApp -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.52 3.48a11.76 11.76 0 0 0-16.64 0A11.76 11.76 0 0 0 0 14c0 2.08.54 4.13 1.57 5.94L0 24l4.14-1.58A11.85 11.85 0 0 0 12 24c6.49 0 11.85-5.36 11.85-11.85 0-3.17-1.23-6.15-3.33-8.67ZM12 22a10 10 0 0 1-5.17-1.42l-.37-.22-2.46.94.93-2.38-.24-.38A10 10 0 1 1 22 12 10 10 0 0 1 12 22Zm5.4-7.68c-.24-.12-1.42-.7-1.64-.78s-.38-.12-.54.12-.62.78-.76.94-.28.18-.52.06a6.29 6.29 0 0 1-1.84-1.14 6.93 6.93 0 0 1-1.28-1.6c-.14-.24 0-.36.1-.48.1-.1.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.28-.74-1.74-.2-.46-.4-.4-.54-.4-.14 0-.3-.02-.46-.02s-.42.06-.64.3a2.63 2.63 0 0 0-.96 2.24c0 1.24.62 2.44 1.4 3.3.78.86 1.76 1.76 3.28 2.28a3.29 3.29 0 0 0 2.46.06c.38-.16 1.42-.58 1.62-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28Z"/>
                </svg>
                WhatsApp TI Pusat
            </a>

            <!-- Tombol Kembali ke Login -->
            <a href="{{ route('login') }}"
               class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-rubik py-3 px-6 rounded-full shadow-md transition-all duration-200 transform hover:scale-105 w-full text-center">
               &larr; Kembali ke Login
            </a>
        </div>

        <!-- Optional: Email Form -->
        <!--
        <form method="POST" action="{{ route('password.email') }}" class="w-full flex flex-col gap-4">
            @csrf
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   placeholder="Email"
                   required autofocus
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400 font-robotoMono" />
            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-rubik py-2 px-4 rounded-lg shadow transition-all duration-200 transform hover:scale-105">
                Kirim Link Reset Password
            </button>
        </form>
        -->

    </div>

</body>
</html>
