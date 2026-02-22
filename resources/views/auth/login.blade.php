<x-guest-layout>
    {{-- Sisi Kiri: Branding & Visual --}}
    <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-brandTeal via-teal-600 to-brandDark p-12 flex-col justify-between relative overflow-hidden">
        {{-- Dekorasi Abstract --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-brandOrange/20 rounded-full blur-3xl -ml-20 -mb-20"></div>

        <div class="z-10">
            {{-- Logo GPM --}}
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl">
                    <a href="/">
                    <x-application-logo class="w-10 h-10 fill-current text-white" />
                    </a>
                </div>
            </div>
        </div>

        <div class="z-10 text-white">
            <h2 class="text-4xl font-black leading-tight tracking-tight">
                Sistem<br>
                <span class="text-brandOrange">Disposisi Surat</span>
            </h2>
            <p class="mt-4 text-teal-50/70 font-medium text-sm leading-relaxed max-w-xs">
                Kelola, distribusikan, dan pantau disposisi surat secara digital dengan sistem yang aman dan terintegrasi.
            </p>
        </div>

        <div class="z-10">
            <p class="text-teal-100/30 text-[10px] font-bold tracking-[0.2em] uppercase">
                &copy; 2026 Sistem Disposisi 
            </p>
        </div>
    </div>

    {{-- Sisi Kanan: Form Login --}}
    <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center bg-white relative">
        <div class="mb-10">
            <h3 class="text-3xl font-black text-brandDark tracking-tight">Masuk ke Akun</h3>
            <p class="text-slate-400 mt-2 text-sm font-medium leading-relaxed">
                Selamat datang. Mohon masukkan username dan password Anda untuk mengakses sistem.
            </p>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Username / Email --}}
            <div class="space-y-2">
                <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">Username / Email</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-brandTeal transition-colors">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                        class="block w-full pl-12 pr-4 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:border-brandTeal/20 focus:ring-4 focus:ring-brandTeal/5 focus:bg-white transition-all text-sm font-bold text-slate-700 placeholder:text-slate-300"
                        placeholder="Masukkan email anda"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
            </div>

            {{-- Password dengan Fitur Show/Hide --}}
            <div class="space-y-2">
                <div class="flex justify-between items-center ml-1">
                    <label for="password" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Password</label>
                </div>
                <div class="relative group border-none">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-brandTeal transition-colors">
                        <span class="material-symbols-outlined text-xl">lock</span>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                        class="block w-full pl-12 pr-12 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:border-brandTeal/20 focus:ring-4 focus:ring-brandTeal/5 focus:bg-white transition-all text-sm font-bold text-slate-700 placeholder:text-slate-300"
                        placeholder="••••••••"
                    />
                    {{-- Tombol Toggle Visibility --}}
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-300 hover:text-brandTeal transition-colors focus:outline-none">
                        <span id="passwordIcon" class="material-symbols-outlined text-xl">visibility</span>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between px-1">
               <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    {{-- Menggunakan Komponen Baru --}}
                    <x-checkbox id="remember_me" name="remember" />
                    
                    <span class="ms-2 text-xs font-bold text-slate-500 group-hover:text-slate-700 transition-colors italic">
                        {{ __('Ingat Saya') }}
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black text-brandTeal uppercase  tracking-[0.2em] hover:text-brandOrange transition-colors underline decoration-2 underline-offset-4" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-brandTeal hover:bg-brandDark text-white font-black py-4 rounded-2xl shadow-xl shadow-teal-900/20 transition-all transform active:scale-[0.98] flex items-center justify-center gap-3 uppercase tracking-[0.2em] text-xs">
                    Login ke Akun
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Scripts --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- 1. Logika Show/Hide Password ---
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const passwordIcon = document.getElementById('passwordIcon');

        if (toggleButton) {
            toggleButton.addEventListener('click', function () {
                // Toggle tipe input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                passwordIcon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
            });
        }

        // --- 2. SweetAlert2: Success Message ---
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false,
                customClass: { popup: 'rounded-[2rem]' }
            });
        @endif

        // --- 3. SweetAlert2: Error Message ---
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                html: `<div class="text-sm font-medium">@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>`,
                showCloseButton: true,
                confirmButtonColor: '#14b8a6',
                customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl px-6 py-3 font-bold' }
            });
        @endif
    });
    </script>
</x-guest-layout>