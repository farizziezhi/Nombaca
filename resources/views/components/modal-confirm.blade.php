{{-- Modal Konfirmasi Alpine.js --}}
{{-- Penggunaan: --}}
{{-- <x-modal-confirm title="Hapus?" body="Yakin?"> --}}
{{--     <x-slot name="trigger"> --}}
{{--         <button type="button" x-on:click="open = true">Hapus</button> --}}
{{--     </x-slot> --}}
{{--     <form method="POST" action="..."> @csrf <button type="submit">Ya</button> </form> --}}
{{-- </x-modal-confirm> --}}

@props(['title' => 'Konfirmasi', 'body' => 'Apakah Anda yakin?'])

<div x-data="{ open: false }">
    {{-- Trigger button (dari slot "trigger") --}}
    {{ $trigger }}

    {{-- Modal Overlay --}}
    <template x-teleport="body">
        <div x-show="open"
             x-cloak
             @keydown.escape.window="open = false"
             class="fixed inset-0 z-50 flex items-center justify-center">

            {{-- Backdrop --}}
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="open = false"
                 class="fixed inset-0 bg-black/50"></div>

            {{-- Panel --}}
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative z-10 w-full max-w-md rounded-xl bg-white p-6 shadow-xl">

                <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ $body }}</p>

                <div class="mt-6 flex justify-end gap-3">
                    <button @click="open = false"
                            type="button"
                            class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>
</div>
