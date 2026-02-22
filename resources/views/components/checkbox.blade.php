@props(['disabled' => false])

<div class="inline-flex items-center justify-center relative group">
    <input 
        {{ $disabled ? 'disabled' : '' }} 
        {!! $attributes->merge([
            'class' => '
                peer appearance-none w-5 h-5 rounded-lg border-2 border-slate-200 
                bg-white checked:bg-brandTeal checked:border-brandTeal
                focus:ring-4 focus:ring-brandTeal/10 focus:outline-none
                disabled:bg-slate-100 disabled:border-slate-200 disabled:cursor-not-allowed
                cursor-pointer transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]
                hover:border-brandTeal/50 transform active:scale-90
            '
        ]) !!} 
        type="checkbox"
    >
    
    {{-- Ikon Centang - Sekarang di-center dengan Flexbox --}}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-0 peer-checked:opacity-100 peer-checked:scale-100 scale-50 transition-all duration-300 ease-out">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
    </div>

    {{-- Layer Efek Glow saat Hover --}}
    <div class="absolute inset-0 rounded-lg bg-brandTeal/20 scale-0 group-hover:scale-150 transition-transform duration-500 blur-xl opacity-0 peer-checked:group-hover:opacity-100 pointer-events-none"></div>
</div>