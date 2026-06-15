<header class="topbar">
  <div class="topbar-left">
    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
  </div>
  <div class="topbar-right">
    <span>{{ Auth::user()->name }}</span>
  </div>
</header>