@if ($paginator->hasPages())
@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $startPage = max(1, $currentPage - 1);
    $endPage = min($lastPage, $currentPage + 1);
@endphp
<nav class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between" role="navigation" aria-label="Pagination Navigation">
    <p class="text-[11px] sm:text-xs font-bold text-slate-400 uppercase tracking-wide">
        Menampilkan {{ $paginator->firstItem() ?? 0 }}-{{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} data
    </p>

    <div class="w-full md:w-auto overflow-x-auto">
        <div class="inline-flex items-center gap-1 whitespace-nowrap self-start md:self-auto">
        @if ($paginator->onFirstPage())
            <span class="px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-slate-300 bg-slate-100 rounded-md sm:rounded-lg cursor-not-allowed">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-slate-600 bg-white border border-slate-200 rounded-md sm:rounded-lg hover:bg-slate-50 transition-colors">Prev</a>
        @endif

        @if ($startPage > 1)
            <a href="{{ $paginator->url(1) }}" class="hidden sm:inline-flex px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-slate-600 bg-white border border-slate-200 rounded-md sm:rounded-lg hover:bg-slate-50 transition-colors">1</a>
            @if ($startPage > 2)
                <span class="hidden sm:inline-flex px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-slate-300 bg-slate-100 rounded-md sm:rounded-lg">...</span>
            @endif
        @endif

        @for ($page = $startPage; $page <= $endPage; $page++)
            @if ($page === $currentPage)
                <span class="inline-flex px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-white bg-blue-600 rounded-md sm:rounded-lg shadow-sm">{{ $page }}</span>
            @else
                <a href="{{ $paginator->url($page) }}" class="inline-flex px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-slate-600 bg-white border border-slate-200 rounded-md sm:rounded-lg hover:bg-slate-50 transition-colors">{{ $page }}</a>
            @endif
        @endfor

        @if ($endPage < $lastPage)
            @if ($endPage < $lastPage - 1)
                <span class="hidden sm:inline-flex px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-slate-300 bg-slate-100 rounded-md sm:rounded-lg">...</span>
            @endif
            <a href="{{ $paginator->url($lastPage) }}" class="hidden sm:inline-flex px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-slate-600 bg-white border border-slate-200 rounded-md sm:rounded-lg hover:bg-slate-50 transition-colors">{{ $lastPage }}</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-slate-600 bg-white border border-slate-200 rounded-md sm:rounded-lg hover:bg-slate-50 transition-colors">Next</a>
        @else
            <span class="px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs font-black text-slate-300 bg-slate-100 rounded-md sm:rounded-lg cursor-not-allowed">Next</span>
        @endif
        </div>
    </div>
</nav>
@endif
