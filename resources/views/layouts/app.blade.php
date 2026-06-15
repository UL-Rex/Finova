<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Finova')</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <!-- Your CSS -->
  {{-- <link rel="stylesheet" href="{{ asset('assets/style.css') }}"> --}}

  @stack('styles')
</head>
<body>

<div class="app">

  {{-- Sidebar --}}
  @include('layouts.sidebar')

  {{-- Main Content --}}
  <div class="main-wrap">
    
      @include('layouts.topbar')
      
      <main class="content">
          @yield('content')
    </main>
  </div>

</div>

<script src="{{ asset('assets/script.js') }}"></script>
@stack('scripts')

</body>
</html>