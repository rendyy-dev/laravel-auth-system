@if ($paginator->hasPages())
    <nav class="flex items-center justify-between text-sm">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-500">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-1 rounded bg-gray-800 hover:bg-gray-700">
                Prev
            </a>
        @endif

        {{-- Pages --}}
        <div class="flex gap-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-1 text-gray-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1 rounded bg-indigo-600 text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="px-3 py-1 rounded bg-gray-800 hover:bg-gray-700">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-1 rounded bg-gray-800 hover:bg-gray-700">
                Next
            </a>
        @else
            <span class="px-3 py-1 text-gray-500">Next</span>
        @endif
    </nav>
@endif
