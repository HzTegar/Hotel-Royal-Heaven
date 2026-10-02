<div class="sidebar w-64 flex-shrink-0 text-gray-800 shadow-xl flex flex-col h-full bg-white select-none">
    <div class="p-6 flex-grow overflow-y-auto">
        <div class="flex flex-col items-center mb-10">
            <div class="w-24 h-24 rounded-full bg-white border-4 border-gray-100 overflow-hidden shadow-lg mb-3">
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-400 to-yellow-600 text-white text-2xl font-bold">
                    ♛
                </div>
            </div>
            <div class="text-lg font-semibold text-gray-800">{{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</div>
            <div class="text-xs text-gray-600 mt-1">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Member' }}</div>
        </div>

        <nav class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard.index') }}"
                class="flex items-center p-3 text-sm font-medium rounded-lg transition-all duration-150 ease-in-out transform
                    @if(request()->routeIs('admin.dashboard.index'))
                        bg-yellow-100/50 text-gray-900 font-bold shadow-sm
                    @else
                        text-gray-600 hover:bg-yellow-50 hover:text-gray-900 hover:shadow-sm hover:scale-[1.02] active:scale-95 active:bg-yellow-100/70
                    @endif">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.tipe-kamar.index') }}" class="nav-item @if(request()->routeIs('admin.tipe-kamar.*')) active @endif">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                Manajemen Tipe Kamar
            </a>

            <a href="{{ route('admin.kamar.index') }}" class="nav-item @if(request()->routeIs('admin.kamar.*')) active @endif">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 14V6a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2zM6 8h8v6H6V8z"></path></svg>
                Manajemen Kamar
            </a>

            <a href="{{ route('admin.pemesanan.index') }}" class="nav-item @if(request()->routeIs('admin.pemesanan.*')) active @endif">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-8a1 1 0 112 0v3a1 1 0 11-2 0v-3z" clip-rule="evenodd"></path></svg>
                Riwayat Pemesanan
            </a>

            <a href="{{ route('admin.reviews.index') }}" class="nav-item @if(request()->routeIs('admin.reviews.*')) active @endif">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Kelola Review
            </a>

            <a href="{{ route('admin.calendar.index') }}" class="nav-item @if(request()->routeIs('admin.calendar.*')) active @endif">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h12a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                Calendar
            </a>

            <a href="{{ route('admin.profile.show') }}" class="nav-item @if(request()->routeIs('admin.profile.*')) active @endif">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                Profil Admin
            </a>

        </nav>
    </div>

    @if(Auth::check())
        <a href="#"
            class="p-4 text-sm font-semibold text-red-600 hover:bg-red-50/50 active:bg-red-100/70 active:scale-95 transition-all duration-150 ease-in-out transform border-t border-gray-100"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h5a1 1 0 000-2H4V4h4a1 1 0 100-2H3zm13 9a1 1 0 00.293-.707l-3-3a1 1 0 00-1.414 1.414L13.586 11H9a1 1 0 100 2h4.586l-1.293 1.293a1 1 0 001.414 1.414l3-3A1 1 0 0016 12z" clip-rule="evenodd"></path>
            </svg>
            Logout
        </a>
    @endif

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
