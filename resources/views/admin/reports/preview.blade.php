<x-admin-layout>
    <x-slot name="title">Preview Laporan PDF</x-slot>
    <x-slot name="header">Preview Laporan PDF</x-slot>

    <div class="mx-auto max-w-5xl space-y-6">
        
        {{-- Header & Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-900 transition mb-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Dasbor Laporan
                </a>
                <h2 class="text-xl font-bold text-slate-900">Document Viewer</h2>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports.export', ['download' => 'true']) }}" 
                   class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        {{-- PDF Viewer Iframe --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden" style="height: 75vh;">
            <iframe 
                src="{{ route('admin.reports.export') }}" 
                class="w-full h-full border-0"
                title="PDF Preview">
            </iframe>
        </div>
    </div>
</x-admin-layout>
