@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-card border-t border-border shadow-[0_-4px_20px_rgba(0,0,0,0.15)] p-3 flex flex-col gap-3 sm:hidden transition-all duration-300" 
             x-data="{ showJumpInput: false, jumpPage: {{ $paginator->currentPage() }}, menuOpen: false }" 
             x-init="window.addEventListener('mobile-menu-toggle', (e) => menuOpen = e.detail.open)"
             :class="{ 'blur-sm opacity-50 pointer-events-none': menuOpen }">
            <!-- Navigation Buttons Row -->
            <div class="flex justify-center items-center gap-2">
                {{-- Previous Page Button --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center justify-center w-11 h-11 text-sm font-medium text-gray-400 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 cursor-default rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center justify-center w-11 h-11 text-sm font-medium text-[#5D5FEF] bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-900/30 rounded-xl hover:bg-[#5D5FEF] hover:text-white active:scale-95 transition-all duration-200" aria-label="Previous page">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                @endif

                {{-- Page Indicator (Tappable for Jump) --}}
                <button 
                    @click="showJumpInput = !showJumpInput" 
                    class="inline-flex items-center justify-center min-w-[100px] h-11 px-4 text-sm font-bold text-[#5D5FEF] bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-900/30 rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/30 active:scale-95 transition-all duration-200"
                    aria-label="Jump to page"
                >
                    <span class="text-foreground">{{ $paginator->currentPage() }}</span>
                    <span class="mx-1 text-gray-400">/</span>
                    <span class="text-muted">{{ $paginator->lastPage() }}</span>
                </button>

                {{-- Next Page Button --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center justify-center w-11 h-11 text-sm font-medium text-[#5D5FEF] bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-900/30 rounded-xl hover:bg-[#5D5FEF] hover:text-white active:scale-95 transition-all duration-200" aria-label="Next page">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                @else
                    <span class="relative inline-flex items-center justify-center w-11 h-11 text-sm font-medium text-gray-400 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 cursor-default rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                @endif
            </div>

            {{-- Page Jump Input (Hidden by default) --}}
            <div x-show="showJumpInput" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="flex items-center justify-center gap-2 px-2">
                <span class="text-sm text-muted">Ke halaman:</span>
                <input 
                    type="number" 
                    x-model="jumpPage" 
                    min="1" 
                    max="{{ $paginator->lastPage() }}" 
                    class="w-20 h-10 text-center text-sm font-medium bg-background border border-border rounded-lg focus:ring-2 focus:ring-[#5D5FEF] focus:border-[#5D5FEF] transition-colors"
                    @keydown.enter="if(jumpPage >= 1 && jumpPage <= {{ $paginator->lastPage() }}) window.location.href = '{{ $paginator->url(1) }}'.replace('page=1', 'page=' + jumpPage)"
                >
                <button 
                    @click="if(jumpPage >= 1 && jumpPage <= {{ $paginator->lastPage() }}) window.location.href = '{{ $paginator->url(1) }}'.replace('page=1', 'page=' + jumpPage)"
                    class="inline-flex items-center justify-center h-10 px-4 text-sm font-medium text-white bg-[#5D5FEF] rounded-lg hover:bg-[#4b4ddb] active:scale-95 transition-all duration-200"
                >
                    Pergi
                </button>
            </div>
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    Showing
                    <span class="font-medium text-gray-900 dark:text-white">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium text-gray-900 dark:text-white">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium text-gray-900 dark:text-white">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <span class="flex items-center gap-2">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-600 bg-gray-100 dark:bg-[#0B1120] border border-gray-300 dark:border-gray-800 cursor-default rounded-lg" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-[#151B28] border border-gray-300 dark:border-gray-700 rounded-lg hover:text-gray-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $start = 1;
                        $end = $paginator->lastPage();
                        $current = $paginator->currentPage();
                    @endphp

                    {{-- Page 1 --}}
                    @if ($current == 1)
                        <span aria-current="page">
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-[#5D5FEF] border border-[#5D5FEF] rounded-lg shadow-[0_0_15px_rgba(93,95,239,0.5)]">1</span>
                        </span>
                    @else
                        <a href="{{ $paginator->url(1) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-400 bg-white dark:bg-[#151B28] border border-gray-300 dark:border-gray-700 rounded-lg hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => 1]) }}">
                            1
                        </a>
                    @endif

                    {{-- Page 2 --}}
                    @if ($end >= 2)
                        @if ($current == 2)
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-[#5D5FEF] border border-[#5D5FEF] rounded-lg shadow-[0_0_15px_rgba(93,95,239,0.5)]">2</span>
                            </span>
                        @else
                            <a href="{{ $paginator->url(2) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-400 bg-white dark:bg-[#151B28] border border-gray-300 dark:border-gray-700 rounded-lg hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => 2]) }}">
                                2
                            </a>
                        @endif
                    @endif

                    {{-- Page 3 --}}
                    @if ($end >= 3)
                        @if ($current == 3)
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-[#5D5FEF] border border-[#5D5FEF] rounded-lg shadow-[0_0_15px_rgba(93,95,239,0.5)]">3</span>
                            </span>
                        @else
                            <a href="{{ $paginator->url(3) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-400 bg-white dark:bg-[#151B28] border border-gray-300 dark:border-gray-700 rounded-lg hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => 3]) }}">
                                3
                            </a>
                        @endif
                    @endif

                    {{-- Separator and Current Page (if > 3 and < last) --}}
                    @if ($end > 4)
                        @if ($current > 3 && $current < $end)
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 dark:text-gray-600">...</span>
                            </span>
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-[#5D5FEF] border border-[#5D5FEF] rounded-lg shadow-[0_0_15px_rgba(93,95,239,0.5)]">{{ $current }}</span>
                            </span>
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 dark:text-gray-600">...</span>
                            </span>
                        @else
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 dark:text-gray-600">...</span>
                            </span>
                        @endif
                    @endif

                    {{-- Last Page --}}
                    @if ($end >= 4)
                        @if ($current == $end)
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-[#5D5FEF] border border-[#5D5FEF] rounded-lg shadow-[0_0_15px_rgba(93,95,239,0.5)]">{{ $end }}</span>
                            </span>
                        @else
                            <a href="{{ $paginator->url($end) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-400 bg-white dark:bg-[#151B28] border border-gray-300 dark:border-gray-700 rounded-lg hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $end]) }}">
                                {{ $end }}
                            </a>
                        @endif
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-[#151B28] border border-gray-300 dark:border-gray-700 rounded-lg hover:text-gray-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-600 bg-gray-100 dark:bg-[#0B1120] border border-gray-300 dark:border-gray-800 cursor-default rounded-lg" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
