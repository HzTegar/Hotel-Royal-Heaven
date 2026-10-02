@extends('layouts.app')

@section('content')

    {{-- Hero Section --}}
    @include('components.hero-riwayat')

    {{-- Search + Tabs --}}
    <section class="px-6 sm:px-10 lg:px-24 -mt-8 relative z-10">
        <div class="bg-white p-4 md:p-5 rounded-xl shadow-md border">

            {{-- Search Input --}}
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 12.65z" />
                </svg>
                <input type="text" placeholder="Search by guest name..." class="w-full outline-none text-sm"
                    value="{{ request('search') }}">
            </div>
         
            {{-- Tabs --}}
            <div class="grid grid-cols-4 text-center text-sm font-medium bg-[#F8F5EE] rounded-lg overflow-hidden">
                <button class="py-2 bg-[#FFC83D] text-black">All Order History</button>
                <button class="py-2 text-gray-500 hover:text-black">Will come</button>
                <button class="py-2 text-gray-500 hover:text-black">Finished</button>
                <button class="py-2 text-gray-500 hover:text-black">Canceled</button>
            </div>
        </div>
    </section>

    {{-- Order List --}}
    <section class="px-6 sm:px-10 lg:px-24 py-10 space-y-6">

        @foreach ([1,2,3,4,5] as $item)
            <div class="flex bg-white border-2 border-[#FFC83D] rounded-xl overflow-hidden shadow-sm">

                {{-- Img Placeholder --}}
                <div class="bg-gray-200 w-48 md:w-60 min-h-[160px]"></div>

                {{-- Content --}}
                <div class="flex-1 p-5 flex flex-col">
                    <h3 class="font-semibold text-lg mb-1">Guest Name</h3>
                    <p class="text-sm text-gray-600 mb-4">Room Name, <span class="text-gray-500 text-xs">Type Room</span></p>

                    <div class="grid grid-cols-2 text-sm text-gray-700 mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Check-in date
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Check-out date
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-auto border-t pt-3">
                        <span class="text-sm text-gray-600">Total payment</span>
                        <div class="flex items-center gap-4">
                            <span class="text-[#FFC83D] font-semibold text-sm">Rp XXXXXX</span>
                            <a href="#" class="px-5 py-2 bg-[#FFC83D] text-black text-sm rounded-lg hover:opacity-80">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </section>

@endsection
