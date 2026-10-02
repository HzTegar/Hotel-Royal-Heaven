<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Admin Dashboard') - Royal Heaven Hotel</title>

    @v<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* CSS Sidebar */
        .sidebar {
            background-color: #ffb833; /* Warna kuning oranye */
        }
        .nav-item {
            padding: 1rem 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding-left: 2rem;
            transition: background-color 0.2s;
            text-decoration: none;
            color: #374151; /* text-gray-700 */
        }
        .nav-item.active {
            background-color: #f7a817; 
            border-right: 5px solid #fff; 
        }
        .nav-item:hover {
            background-color: rgba(247, 168, 23, 0.9);
        }
        .logout-link {
            padding: 1rem 0;
            cursor: pointer;
            display: block;
            padding-left: 2rem;
            color: #b91c1c;
            font-weight: 600;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: auto;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .logout-link:hover {
            background-color: #f7a817; 
            color: #fff;
        }
    </style>
</head>
<body class="bg-gray-50 flex h-screen">

    @include('components.admin-sidebar')

    <div class="flex-grow flex flex-col overflow-hidden">
        <div class="bg-white border-b border-gray-200 px-8 py-6 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-800">
                @yield('page_title', 'Dashboard')
            </h1>
            <p class="text-sm text-gray-500 mt-1">@yield('page_subtitle')</p>
        </div>

        <div class="flex-grow overflow-y-auto p-8">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @yield('scripts')

</body>
</html>
