@props([
    'title' => 'Filter & Search',
    'showSearch' => true,
    'showTypeFilter' => true,
    'showPriceFilter' => true,
    'showDateFilter' => true,
    'showCapacityFilter' => true,
    'showSortFilter' => true,
    'searchPlaceholder' => 'Search rooms...',
    'tipeKamars' => []
])

<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
        {{-- Active Filters Count --}}
        <div class="text-xs text-gray-600">
            <span id="activeFiltersCount" class="hidden">0 active filters</span>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ url()->current() }}" class="space-y-3">
        {{-- Primary Filters Row (Always Visible) --}}
        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search Input --}}
            @if($showSearch)
                <div class="flex-1">
                    <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="search" name="search"
                               placeholder="{{ $searchPlaceholder }}"
                               class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>
                </div>
            @endif

            {{-- Room Type Filter --}}
            @if($showTypeFilter)
                <div class="sm:w-48">
                    <label for="tipe_kamar" class="block text-xs font-medium text-gray-700 mb-1">Room Type</label>
                    <div class="relative">
                        <select id="tipe_kamar" name="tipe_kamar"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                            <option value="">All Types</option>
                            @foreach($tipeKamars as $tipe)
                                <option value="{{ $tipe->id_tipe }}">{{ $tipe->nama_tipe }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Sort Filter --}}
            @if($showSortFilter)
                <div class="sm:w-48">
                    <label for="sort" class="block text-xs font-medium text-gray-700 mb-1">Sort By</label>
                    <div class="relative">
                        <select id="sort" name="sort"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                            <option value="recommendation">Recommendation</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="rating">Top Rated</option>
                            <option value="newest">Newest</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Expand/Collapse Toggle --}}
        <div class="flex justify-center">
            <button type="button" id="toggleFilters" class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800 transition-colors duration-200">
                <span id="toggleText">Show More Filters</span>
                <svg id="toggleIcon" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        {{-- Advanced Filters (Collapsible) --}}
        <div id="advancedFilters" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0 opacity-0">
            <div class="space-y-3 pt-3 border-t border-gray-100">
                {{-- Price Range Filters --}}
                @if($showPriceFilter)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label for="harga_min" class="block text-xs font-medium text-gray-700 mb-1">Min Price</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 font-medium text-sm">Rp</span>
                                </div>
                                <input type="number" id="harga_min" name="harga_min"
                                       placeholder="0"
                                       class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                            </div>
                        </div>
                        <div>
                            <label for="harga_max" class="block text-xs font-medium text-gray-700 mb-1">Max Price</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 font-medium text-sm">Rp</span>
                                </div>
                                <input type="number" id="harga_max" name="harga_max"
                                       placeholder="9999999"
                                       class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Date Range Filters --}}
                @if($showDateFilter)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label for="check_in" class="block text-xs font-medium text-gray-700 mb-1">Check-in Date</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" id="check_in" name="check_in"
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                            </div>
                        </div>
                        <div>
                            <label for="check_out" class="block text-xs font-medium text-gray-700 mb-1">Check-out Date</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" id="check_out" name="check_out"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Capacity and Facilities Filters --}}
                @if($showCapacityFilter)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label for="capacity" class="block text-xs font-medium text-gray-700 mb-1">Minimum Capacity</label>
                            <div class="relative">
                                <select id="capacity" name="capacity"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                                    <option value="">Any Capacity</option>
                                    <option value="1">1 Person</option>
                                    <option value="2">2 People</option>
                                    <option value="3">3 People</option>
                                    <option value="4">4 People</option>
                                    <option value="5">5+ People</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="facilities" class="block text-xs font-medium text-gray-700 mb-1">Facilities</label>
                            <div class="relative">
                                <select id="facilities" name="facilities"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                                    <option value="">All Facilities</option>
                                    <option value="wifi">WiFi</option>
                                    <option value="ac">Air Conditioning</option>
                                    <option value="tv">TV</option>
                                    <option value="bathroom">Private Bathroom</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-2 pt-3 border-t border-gray-100">
            <button type="submit"
                    class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded transition-all duration-200">
                Apply
            </button>

            <button type="button"
                    onclick="resetFilters()"
                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded transition-all duration-200">
                Reset
            </button>

            {{-- Results Count --}}
            <div class="flex items-center text-xs text-gray-600 ml-auto">
                <span id="resultsCount" class="hidden">0 results found</span>
            </div>
        </div>
    </form>
</div>

<script>
let isExpanded = false;

function toggleFilters() {
    const advancedFilters = document.getElementById('advancedFilters');
    const toggleText = document.getElementById('toggleText');
    const toggleIcon = document.getElementById('toggleIcon');

    isExpanded = !isExpanded;

    if (isExpanded) {
        advancedFilters.style.maxHeight = advancedFilters.scrollHeight + 'px';
        advancedFilters.style.opacity = '1';
        toggleText.textContent = 'Show Less Filters';
        toggleIcon.style.transform = 'rotate(180deg)';
    } else {
        advancedFilters.style.maxHeight = '0px';
        advancedFilters.style.opacity = '0';
        toggleText.textContent = 'Show More Filters';
        toggleIcon.style.transform = 'rotate(0deg)';
    }
}

function resetFilters() {
    // Reset all form inputs
    const form = event.target.closest('form');
    form.reset();

    // Reset select elements to default values
    const selects = form.querySelectorAll('select');
    selects.forEach(select => {
        select.selectedIndex = 0;
    });

    // Submit form to refresh results
    form.submit();
}

function updateActiveFiltersCount() {
    const form = document.querySelector('.filter-section form');
    if (!form) return;

    const inputs = form.querySelectorAll('input, select');
    let activeCount = 0;

    inputs.forEach(input => {
        if (input.type === 'text' || input.type === 'number') {
            if (input.value.trim() !== '') activeCount++;
        } else if (input.tagName === 'SELECT') {
            if (input.selectedIndex > 0) activeCount++;
        }
    });

    const counter = document.getElementById('activeFiltersCount');
    if (activeCount > 0) {
        counter.textContent = `${activeCount} active filter${activeCount > 1 ? 's' : ''}`;
        counter.classList.remove('hidden');
    } else {
        counter.classList.add('hidden');
    }
}

// Update counter on input changes
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleFilters');
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleFilters);
    }

    const form = document.querySelector('.filter-section form');
    if (form) {
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('change', updateActiveFiltersCount);
            input.addEventListener('input', updateActiveFiltersCount);
        });
        updateActiveFiltersCount(); // Initial count
    }
});
</script>
