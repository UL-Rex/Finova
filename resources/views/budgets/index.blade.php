<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Budgets • Personal Finance Dashboard</title>

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

  <style>
    :root{
      --sidebar-bg:#0b1220;
      --sidebar-bg2:#0a1020;
      --sidebar-text: rgba(255,255,255,.85);
      --sidebar-muted: rgba(255,255,255,.60);

      --content-bg:#f4f7fb;
      --content-bg2:#eef3fb;

      --card-bg:#ffffff;
      --card-stroke: rgba(17,24,39,.08);
      --text:#0f172a;
      --muted:#64748b;

      --brand:#4f46e5;
      --brand-2:#2563eb;
      --success:#10b981;
      --warning:#f59e0b;
      --danger:#ef4444;
      --slate:#94a3b8;

      --radius: 14px;
      --shadow: 0 10px 30px rgba(15,23,42,.08);
      --shadow2: 0 6px 18px rgba(15,23,42,.10);

      --ring: 0 0 0 4px rgba(79,70,229,.18);
      --t: 160ms cubic-bezier(.2,.8,.2,1);

      --sidebar-w: 270px;
    }

    *{ box-sizing: border-box; }
    html, body{ height:100%; }
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color: var(--text);
      background:
        radial-gradient(900px 400px at 25% 0%, rgba(79,70,229,.10), transparent 60%),
        radial-gradient(900px 400px at 85% 10%, rgba(37,99,235,.08), transparent 60%),
        linear-gradient(180deg, var(--content-bg), var(--content-bg2));
      overflow-x:hidden;
    }
    a{ color:inherit; text-decoration:none; }
    button, input, select, textarea{ font: inherit; }
    .sr-only{
      position:absolute; width:1px; height:1px;
      padding:0; margin:-1px; overflow:hidden;
      clip:rect(0,0,0,0); white-space:nowrap; border:0;
    }

    /* Layout */
    .app{ min-height:100vh; display:flex; }

    /* Sidebar */
    .sidebar{
      position:fixed; top:0; left:0;
      width: var(--sidebar-w);
      height:100vh;
      padding: 18px 14px;
      background: linear-gradient(180deg, var(--sidebar-bg), var(--sidebar-bg2));
      border-right: 1px solid rgba(255,255,255,.06);
      z-index:40;
    }
    .brand{
      display:flex; align-items:center; gap:10px;
      padding: 10px 10px 16px 10px;
      margin-bottom: 10px;
    }
    .brand-mark{
      width:38px; height:38px; border-radius: 12px;
      background: linear-gradient(135deg, rgba(79,70,229,1), rgba(37,99,235,1));
      display:grid; place-items:center;
      color:white; font-weight:800;
      box-shadow: 0 14px 30px rgba(79,70,229,.25);
    }
    .brand-text strong{ display:block; color:white; font-size:14px; letter-spacing:-.2px; }
    .brand-text span{ display:block; color:var(--sidebar-muted); font-size:12px; margin-top:2px; }

    .nav{ display:flex; flex-direction:column; gap:6px; padding: 6px; }
    .nav a{
      display:flex; align-items:center; gap:10px;
      padding: 12px 12px;
      border-radius: 12px;
      color: var(--sidebar-text);
      border: 1px solid transparent;
      transition: background var(--t), transform var(--t), border-color var(--t);
    }
    .nav a:hover{
      background: rgba(255,255,255,.06);
      border-color: rgba(255,255,255,.10);
      transform: translateY(-1px);
    }
    .nav a.active{
      background: linear-gradient(135deg, rgba(79,70,229,.22), rgba(37,99,235,.14));
      border-color: rgba(79,70,229,.40);
      color: rgba(255,255,255,.95);
    }
    .nav .icon{
      width:20px; height:20px; display:grid; place-items:center;
      border-radius: 8px;
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.08);
      font-size: 12px;
      flex:0 0 auto;
    }
    .nav .label{ font-size:13px; font-weight:600; }

    .sidebar-footer{
      position:absolute;
      bottom:14px; left:14px; right:14px;
      padding: 12px;
      border-radius: 14px;
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,255,255,.10);
      color: rgba(255,255,255,.85);
    }
    .sidebar-footer .small{
      margin-top:6px;
      font-size: 12px;
      color: var(--sidebar-muted);
      line-height:1.35;
    }

    /* Main */
    .main{
      flex:1;
      margin-left: var(--sidebar-w);
      padding: 22px 22px 36px;
      max-width: 1440px;
      width:100%;
    }

    /* Header */
    .top-header{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap: 14px;
      margin-bottom: 14px;
    }
    .title-block h1{ margin:0; font-size: 22px; letter-spacing:-.3px; }
    .title-block p{ margin: 6px 0 0; color: var(--muted); font-size: 13px; }

    .header-actions{
      display:flex;
      align-items:center;
      gap: 10px;
      flex-wrap: wrap;
      justify-content:flex-end;
    }
    .search{
      position:relative;
      min-width: 280px;
      max-width: 420px;
      width: 40vw;
    }
    .search input{
      width:100%;
      height: 44px;
      padding: 10px 12px 10px 40px;
      border-radius: 12px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.82);
      box-shadow: 0 1px 0 rgba(15,23,42,.03);
      outline:none;
      transition: box-shadow var(--t), border-color var(--t), background var(--t);
    }
    .search input:focus{ border-color: rgba(79,70,229,.35); box-shadow: var(--ring); background:#fff; }
    .search .mag{
      position:absolute; left:12px; top:50%;
      transform: translateY(-50%);
      color: rgba(15,23,42,.55);
      font-size: 14px;
      pointer-events:none;
    }

    .btn{
      height: 44px;
      padding: 0 12px;
      border-radius: 12px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.85);
      color: var(--text);
      cursor:pointer;
      display:inline-flex;
      align-items:center;
      gap: 8px;
      transition: transform var(--t), box-shadow var(--t), background var(--t), border-color var(--t);
      box-shadow: 0 1px 0 rgba(15,23,42,.03);
      user-select:none;
      font-weight: 600;
      font-size: 13px;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow2); }
    .btn:active{ transform: translateY(0); }
    .btn-primary{
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      border-color: rgba(79,70,229,.35);
      color: #fff;
      box-shadow: 0 16px 30px rgba(79,70,229,.18);
    }
    .btn-primary:hover{
      box-shadow: 0 18px 36px rgba(79,70,229,.22);
      border-color: rgba(79,70,229,.45);
    }
    .btn-icon{ width:44px; padding:0; justify-content:center; }

    /* Card / Section */
    .card{
      background: var(--card-bg);
      border: 1px solid var(--card-stroke);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
    }
    .card:hover{ border-color: rgba(15,23,42,.14); }

    .section{ margin-top: 14px; }
    .section-title{
      display:flex; align-items:flex-end; justify-content:space-between; gap:10px;
      margin-bottom: 10px;
    }
    .section-title h2{ margin:0; font-size: 14px; letter-spacing:-.2px; }
    .section-title p{ margin: 4px 0 0; font-size: 12px; color: var(--muted); }

    .chip{
      font-size: 12px;
      color: rgba(15,23,42,.70);
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.03);
      padding: 6px 10px;
      border-radius: 999px;
      white-space: nowrap;
    }

    /* Summary cards */
    .summary-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0,1fr));
      gap: 12px;
    }
    .summary-card{
      padding: 14px;
      display:flex;
      flex-direction:column;
      gap: 10px;
      transition: transform var(--t), box-shadow var(--t);
    }
    .summary-card:hover{ transform: translateY(-2px); box-shadow: 0 18px 40px rgba(15,23,42,.10); }
    .summary-top{ display:flex; align-items:center; justify-content:space-between; gap:10px; }
    .summary-top .meta span{ display:block; font-size: 12px; color: var(--muted); }
    .summary-top .meta strong{ display:block; margin-top: 4px; font-size: 18px; letter-spacing:-.3px; }
    .badge{
      display:inline-flex; align-items:center; gap:6px;
      padding: 6px 10px; border-radius: 999px;
      font-size: 12px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.03);
      color: rgba(15,23,42,.75);
      white-space: nowrap;
    }
    .badge.success{ background: rgba(16,185,129,.10); border-color: rgba(16,185,129,.25); color: rgba(6,95,70,.95); }
    .badge.warning{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.28); color: rgba(120,53,15,.95); }
    .badge.danger{ background: rgba(239,68,68,.10); border-color: rgba(239,68,68,.25); color: rgba(127,29,29,.95); }

    .summary-foot{
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      font-size: 12px; color: var(--muted);
    }

    /* Alerts */
    .alert-grid{
      display:grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 12px;
    }
    .alert-card{
      padding: 14px;
      border-left: 5px solid rgba(245,158,11,.9);
      background: linear-gradient(180deg, rgba(245,158,11,.06), rgba(255,255,255,1));
    }
    .alert-card.danger{
      border-left-color: rgba(239,68,68,.9);
      background: linear-gradient(180deg, rgba(239,68,68,.06), rgba(255,255,255,1));
    }
    .alert-card.ok{
      border-left-color: rgba(16,185,129,.9);
      background: linear-gradient(180deg, rgba(16,185,129,.06), rgba(255,255,255,1));
    }
    .alert-card h4{ margin:0; font-size: 13px; letter-spacing:-.2px; }
    .alert-card p{ margin: 6px 0 0; font-size: 12px; color: var(--muted); line-height: 1.35; }
    .alert-card .row{
      margin-top: 10px;
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      flex-wrap: wrap;
    }

    /* Analytics */
    .analytics-grid{
      display:grid;
      grid-template-columns: 2fr 1fr;
      gap: 12px;
      align-items:stretch;
    }
    .card-head{
      padding: 14px 14px 0;
      display:flex; align-items:flex-end; justify-content:space-between; gap:10px;
    }
    .card-head h3{ margin:0; font-size: 14px; letter-spacing:-.2px; }
    .card-head p{ margin: 4px 0 0; font-size: 12px; color: var(--muted); }
    .canvas-wrap{ padding: 10px 14px 14px; height: 320px; }

    /* Budget cards */
    .budget-grid{
      display:grid;
      grid-template-columns: repeat(5, minmax(0,1fr));
      gap: 12px;
    }
    .budget-card{
      padding: 14px;
      transition: transform var(--t), box-shadow var(--t);
    }
    .budget-card:hover{ transform: translateY(-2px); box-shadow: 0 18px 40px rgba(15,23,42,.10); }
    .budget-top{
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      margin-bottom: 10px;
    }
    .budget-icon{
      width:40px; height:40px;
      border-radius: 14px;
      display:grid; place-items:center;
      background: rgba(79,70,229,.10);
      border: 1px solid rgba(79,70,229,.16);
      color: rgba(79,70,229,1);
      font-weight: 800;
    }
    .budget-name{ margin:0; font-size: 13px; font-weight: 800; }
    .budget-sub{ margin: 4px 0 0; font-size: 12px; color: var(--muted); }
    .progress{
      height: 10px;
      border-radius: 999px;
      background: rgba(15,23,42,.06);
      border: 1px solid rgba(15,23,42,.08);
      overflow:hidden;
    }
    .progress > i{
      display:block; height:100%; width: 0%;
      border-radius: 999px;
      background: linear-gradient(90deg, rgba(79,70,229,1), rgba(37,99,235,1));
      transition: width 560ms cubic-bezier(.2,.8,.2,1);
    }
    .progress.warning > i{ background: linear-gradient(90deg, rgba(245,158,11,1), rgba(37,99,235,1)); }
    .progress.danger > i{ background: linear-gradient(90deg, rgba(239,68,68,1), rgba(245,158,11,1)); }
    .budget-meta{
      margin-top: 10px;
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      font-size: 12px; color: var(--muted);
    }

    /* Table */
    .table-card{ padding: 14px; }
    .table-toolbar{
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      flex-wrap: wrap;
      margin-bottom: 10px;
    }
    .toolbar-left{
      display:flex; align-items:center; gap:10px;
      flex-wrap: wrap;
      flex: 1;
      min-width: 260px;
    }
    .toolbar-right{ display:flex; align-items:center; gap: 10px; flex-wrap: wrap; }

    .filters-panel{
      display:none;
      margin: 10px 0 0;
      padding: 12px;
      border-radius: 14px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.02);
    }
    .filters-panel.open{ display:block; }

    .filter-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 10px;
    }
    .field label{
      display:block;
      font-size: 12px;
      color: rgba(15,23,42,.70);
      margin-bottom: 6px;
      font-weight: 600;
    }
    .control{
      width:100%;
      height: 42px;
      border-radius: 12px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.92);
      padding: 0 10px;
      outline:none;
      transition: box-shadow var(--t), border-color var(--t);
    }
    .control:focus{
      border-color: rgba(79,70,229,.35);
      box-shadow: var(--ring);
      background: #fff;
    }

    .table-wrap{
      overflow:auto;
      border-radius: 14px;
      border: 1px solid rgba(15,23,42,.08);
    }
    table{
      width:100%;
      border-collapse: collapse;
      min-width: 980px;
      background: #fff;
    }
    thead th{
      position: sticky;
      top:0;
      z-index: 1;
      text-align:left;
      font-size: 12px;
      letter-spacing:.2px;
      color: rgba(15,23,42,.70);
      background: rgba(15,23,42,.03);
      border-bottom: 1px solid rgba(15,23,42,.08);
      padding: 12px 10px;
      white-space: nowrap;
      cursor: pointer;
      user-select:none;
    }
    thead th .sort{ margin-left: 6px; font-size: 11px; color: rgba(15,23,42,.45); }
    tbody td{
      font-size: 12.5px;
      color: rgba(15,23,42,.90);
      border-bottom: 1px solid rgba(15,23,42,.06);
      padding: 12px 10px;
      vertical-align: middle;
      white-space: nowrap;
    }
    tbody tr:hover td{ background: rgba(79,70,229,.04); }

    .amount{
      text-align:right;
      font-variant-numeric: tabular-nums;
      font-weight: 800;
    }
    .status{
      display:inline-flex;
      align-items:center;
      gap: 8px;
      padding: 6px 10px;
      border-radius: 999px;
      font-size: 12px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.02);
    }
    .dot{ width:8px; height:8px; border-radius: 50%; background: rgba(15,23,42,.35); }
    .status.ontrack{ background: rgba(16,185,129,.10); border-color: rgba(16,185,129,.22); color: rgba(6,95,70,.95); }
    .status.ontrack .dot{ background: rgba(16,185,129,1); }
    .status.near{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.25); color: rgba(120,53,15,.95); }
    .status.near .dot{ background: rgba(245,158,11,1); }
    .status.over{ background: rgba(239,68,68,.10); border-color: rgba(239,68,68,.25); color: rgba(127,29,29,.95); }
    .status.over .dot{ background: rgba(239,68,68,1); }

    .actions{ display:flex; gap: 8px; justify-content:flex-end; }
    .link-btn{
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.9);
      height: 34px;
      padding: 0 10px;
      border-radius: 10px;
      cursor:pointer;
      font-size: 12px;
      font-weight: 600;
      transition: transform var(--t), box-shadow var(--t), background var(--t), border-color var(--t);
    }
    .link-btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(15,23,42,.10); }
    .link-btn.danger{ border-color: rgba(239,68,68,.25); background: rgba(239,68,68,.06); color: rgba(127,29,29,.95); }

    .pagination{
      margin-top: 12px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 10px;
      flex-wrap: wrap;
    }
    .pager{ display:flex; align-items:center; gap: 8px; flex-wrap: wrap; }
    .page-btn{
      height: 36px;
      padding: 0 10px;
      border-radius: 10px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.9);
      cursor:pointer;
      transition: transform var(--t), box-shadow var(--t);
      font-weight: 600;
      font-size: 12px;
    }
    .page-btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(15,23,42,.10); }
    .page-btn.active{
      border-color: rgba(79,70,229,.35);
      background: rgba(79,70,229,.10);
      color: rgba(49,46,129,.95);
    }
    .page-info{ font-size: 12px; color: var(--muted); }

    /* Empty state */
    .empty{
      display:none;
      padding: 24px;
      text-align:center;
      border-radius: var(--radius);
      border: 1px dashed rgba(15,23,42,.18);
      background: rgba(255,255,255,.70);
    }
    .empty.show{ display:block; }
    .empty svg{
      width: 220px;
      max-width: 70%;
      height: auto;
      margin: 0 auto 10px;
      display:block;
      opacity: .95;
    }
    .empty h3{ margin: 10px 0 0; font-size: 16px; letter-spacing:-.2px; }
    .empty p{ margin: 6px 0 14px; color: var(--muted); font-size: 13px; }

    /* Modal */
    .modal-overlay{
      position: fixed;
      inset: 0;
      background: rgba(2,6,23,.55);
      display:none;
      align-items:center;
      justify-content:center;
      padding: 16px;
      z-index: 90;
    }
    .modal-overlay.open{ display:flex; }
    .modal{
      width: 760px;
      max-width: 100%;
      background: #fff;
      border-radius: 16px;
      border: 1px solid rgba(255,255,255,.25);
      box-shadow: 0 30px 80px rgba(2,6,23,.35);
      overflow:hidden;
    }
    .modal-head{
      padding: 14px 14px 0;
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap: 10px;
    }
    .modal-head h3{ margin:0; font-size: 16px; letter-spacing:-.2px; }
    .modal-head p{ margin: 6px 0 0; color: var(--muted); font-size: 12px; }
    .modal-close{
      width: 40px; height: 40px;
      border-radius: 12px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.03);
      cursor:pointer;
      transition: transform var(--t), box-shadow var(--t);
    }
    .modal-close:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(15,23,42,.12); }
    .modal-body{ padding: 12px 14px 14px; }
    .form-grid{
      display:grid;
      grid-template-columns: repeat(2, minmax(0,1fr));
      gap: 10px;
    }
    .field textarea{ height: 92px; padding: 10px; }
    .field .hint{ margin-top: 6px; font-size: 12px; color: var(--muted); }

    .modal-foot{
      padding: 12px 14px 14px;
      display:flex;
      justify-content:flex-end;
      gap: 10px;
      border-top: 1px solid rgba(15,23,42,.08);
      background: rgba(15,23,42,.02);
    }

    /* Responsive */
    .mobile-bar{
      display:none;
      align-items:center;
      gap: 10px;
      margin-bottom: 12px;
    }
    .hamburger{
      display:none;
      width: 44px; height: 44px;
      border-radius: 12px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.90);
      cursor:pointer;
      transition: transform var(--t), box-shadow var(--t);
    }
    .hamburger:hover{ transform: translateY(-1px); box-shadow: var(--shadow2); }

    .sidebar-overlay{
      position: fixed;
      inset: 0;
      background: rgba(2,6,23,.45);
      display:none;
      z-index: 35;
    }
    body.sidebar-open .sidebar-overlay{ display:block; }

    @media (max-width: 1200px){
      .summary-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
      .analytics-grid{ grid-template-columns: 1fr; }
      .budget-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
      .filter-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
      .search{ width: 52vw; }
    }
    @media (max-width: 900px){
      .main{ margin-left: 0; }
      .sidebar{
        transform: translateX(-110%);
        transition: transform var(--t);
        width: 290px;
      }
      body.sidebar-open .sidebar{ transform: translateX(0); }
      .hamburger{ display:inline-flex; align-items:center; justify-content:center; }
      .mobile-bar{ display:flex; }
      .top-header{ flex-direction: column; align-items: stretch; }
      .header-actions{ justify-content:space-between; }
      .search{ width: 100%; min-width: 0; max-width: none; }
      .alert-grid{ grid-template-columns: 1fr; }
    }
    @media (max-width: 520px){
      .summary-grid{ grid-template-columns: 1fr; }
      .form-grid{ grid-template-columns: 1fr; }
      .filter-grid{ grid-template-columns: 1fr; }
      .budget-grid{ grid-template-columns: 1fr; }
      .btn, .btn-primary{ width: 100%; justify-content:center; }
      .header-actions{ flex-direction: column; align-items: stretch; }
    }
  </style>
</head>

<body>
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="app">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main -->
    <main class="main">

        @if(session('success'))
<div style="padding:12px 16px;background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.25);border-radius:12px;color:rgba(6,95,70,.95);font-size:13px;margin-bottom:14px;">
  ✓ {{ session('success') }}
</div>
@endif

      <!-- Mobile quick bar -->
      <div class="mobile-bar">
        <button class="hamburger" id="hamburger" aria-label="Open sidebar">☰</button>
        <div style="font-weight:800; letter-spacing:-.2px;">Budgets</div>
      </div>

      <!-- Top Header -->
      <header class="top-header">
        <div class="title-block">
          <h1>Budgets</h1>
          <p>Create, track and optimize your category budgets</p>
        </div>

        <div class="header-actions" aria-label="Header actions">
          <div class="search" role="search">
            <span class="mag">⌕</span>
            <label class="sr-only" for="globalSearch">Search budgets</label>
            <input id="globalSearch" type="search" placeholder="Search category, period, status…" />
          </div>

          <button class="btn" id="toggleFilters" type="button" aria-expanded="false">
            <span>⏷</span> Filter
          </button>

          <button class="btn btn-primary" id="openAddModal" type="button">
            <span>＋</span> Add Budget
          </button>
        </div>
      </header>

      <!-- Summary -->
      <section class="section" aria-labelledby="summaryTitle">
        <div class="section-title">
          <div>
            <h2 id="summaryTitle">Budget Summary</h2>
            <p>Current month overview</p>
          </div>
          <span class="chip" id="monthChip">Month</span>
        </div>
        <div class="summary-grid" id="summaryGrid"></div>
      </section>

      <!-- Alerts -->
      <section class="section" aria-labelledby="alertsTitle">
        <div class="section-title">
          <div>
            <h2 id="alertsTitle">Budget Alerts</h2>
            <p>Warnings when spending reaches 80% or exceeds limits</p>
          </div>
        </div>
        <div class="alert-grid" id="alertGrid"></div>
      </section>

      <!-- Analytics -->
      <section class="section" aria-labelledby="analyticsTitle">
        <div class="section-title">
          <div>
            <h2 id="analyticsTitle">Budget Analytics</h2>
            <p>Budget vs spending and allocation</p>
          </div>
        </div>

        <div class="analytics-grid">
          <article class="card" aria-label="Budget vs spent chart">
            <div class="card-head">
              <div>
                <h3>Budget vs Spent</h3>
                <p>Category comparison (this month)</p>
              </div>
              <span class="chip">Bar</span>
            </div>
            <div class="canvas-wrap">
              <canvas id="budgetBarChart"></canvas>
            </div>
          </article>

          <article class="card" aria-label="Budget allocation chart">
            <div class="card-head">
              <div>
                <h3>Allocation</h3>
                <p>Share of total budget</p>
              </div>
              <span class="chip">Doughnut</span>
            </div>
            <div class="canvas-wrap">
              <canvas id="allocationChart"></canvas>
            </div>
          </article>
        </div>
      </section>

      <!-- Category Budget Cards -->
      <section class="section" aria-labelledby="categoryBudgetsTitle">
        <div class="section-title">
          <div>
            <h2 id="categoryBudgetsTitle">Category Budgets</h2>
            <p>Progress indicators per category</p>
          </div>
          <span class="chip">Progress</span>
        </div>
        <div class="budget-grid" id="budgetGrid"></div>
      </section>

      <!-- Table -->
      <section class="section" aria-labelledby="budgetsTableTitle">
        <div class="section-title">
          <div>
            <h2 id="budgetsTableTitle">Budgets</h2>
            <p>Search, filter, sort and manage budgets</p>
          </div>
        </div>

        <article class="card table-card">
          <div class="table-toolbar">
            <div class="toolbar-left">
              <div class="search" style="max-width:420px; width: min(520px, 100%);">
                <span class="mag">⌕</span>
                <label class="sr-only" for="tableSearch">Search in table</label>
                <input id="tableSearch" type="search" placeholder="Search budgets in table…" />
              </div>
              <button class="btn btn-icon" id="clearAll" type="button" title="Clear filters/search">↺</button>
            </div>
            <div class="toolbar-right">
              <span class="chip" id="resultsChip">0 results</span>
            </div>
          </div>

          <div class="filters-panel" id="filtersPanel" aria-label="Filters">
            <div class="filter-grid">
              <div class="field">
                <label for="filterCategory">Category</label>
                <select id="filterCategory" class="control">
                  <option value="">All</option>
                  <option>Food</option>
                  <option>Transport</option>
                  <option>Bills</option>
                  <option>Entertainment</option>
                  <option>Shopping</option>
                  <option>Health</option>
                </select>
              </div>

              <div class="field">
                <label for="filterPeriod">Period</label>
                <select id="filterPeriod" class="control">
                  <option value="">All</option>
                  <option>Monthly</option>
                  <option>Weekly</option>
                  <option>Annual</option>
                </select>
              </div>

              <div class="field">
                <label for="filterStatus">Status</label>
                <select id="filterStatus" class="control">
                  <option value="">All</option>
                  <option>On track</option>
                  <option>Near limit</option>
                  <option>Over budget</option>
                </select>
              </div>

              <div class="field">
                <label for="filterMinLimit">Min limit</label>
                <input id="filterMinLimit" class="control" type="number" min="0" step="0.01" placeholder="0" />
              </div>

              <div class="field">
                <label for="filterMaxLimit">Max limit</label>
                <input id="filterMaxLimit" class="control" type="number" min="0" step="0.01" placeholder="5000" />
              </div>

              <div class="field">
                <label>&nbsp;</label>
                <button class="btn btn-primary" id="applyFilters" type="button">Apply Filters</button>
              </div>
            </div>
          </div>

          <!-- Empty state -->
          <div class="empty" id="emptyState" aria-live="polite">
            <svg viewBox="0 0 520 300" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Empty state illustration">
              <defs>
                <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0" stop-color="#4f46e5" stop-opacity="0.18"/>
                  <stop offset="1" stop-color="#2563eb" stop-opacity="0.12"/>
                </linearGradient>
              </defs>
              <rect x="34" y="28" width="452" height="244" rx="22" fill="url(#g)" stroke="rgba(15,23,42,.10)"/>
              <rect x="70" y="70" width="380" height="30" rx="10" fill="rgba(255,255,255,.85)"/>
              <rect x="70" y="120" width="310" height="24" rx="10" fill="rgba(255,255,255,.78)"/>
              <rect x="70" y="156" width="260" height="24" rx="10" fill="rgba(255,255,255,.72)"/>
              <rect x="70" y="192" width="340" height="24" rx="10" fill="rgba(255,255,255,.68)"/>
              <circle cx="414" cy="146" r="44" fill="rgba(79,70,229,.14)" stroke="rgba(79,70,229,.22)"/>
              <path d="M402 146h24M414 134v24" stroke="rgba(79,70,229,.85)" stroke-width="6" stroke-linecap="round"/>
            </svg>
            <h3>No budgets created yet</h3>
            <p>Create your first budget to start tracking spending limits.</p>
            <button class="btn btn-primary" id="emptyAddBtn" type="button">＋ Add Budget</button>
          </div>

          <div class="table-wrap" id="tableWrap">
            <table aria-label="Budgets table">
              <thead>
                <tr>
                  <th data-sort="category">Category <span class="sort" id="sort-category">↕</span></th>
                  <th data-sort="period">Period <span class="sort" id="sort-period">↕</span></th>
                  <th data-sort="startDate">Start <span class="sort" id="sort-startDate">↕</span></th>
                  <th data-sort="limit" style="text-align:right;">Limit <span class="sort" id="sort-limit">↕</span></th>
                  <th data-sort="spent" style="text-align:right;">Spent <span class="sort" id="sort-spent">↕</span></th>
                  <th data-sort="remaining" style="text-align:right;">Remaining <span class="sort" id="sort-remaining">↕</span></th>
                  <th data-sort="status">Status <span class="sort" id="sort-status">↕</span></th>
                  <th style="text-align:right;">Actions</th>
                </tr>
              </thead>
              <tbody id="budgetsTbody"></tbody>
            </table>
          </div>

          <div class="pagination" aria-label="Pagination">
            <div class="page-info" id="pageInfo">Showing 0–0 of 0</div>
            <div class="pager" id="pager"></div>
          </div>
        </article>
      </section>
    </main>
  </div>

  <!-- Add/Edit/View Budget Modal -->
  <div class="modal-overlay" id="modalOverlay" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
      <div class="modal-head">
        <div>
          <h3 id="modalTitle">Add Budget</h3>
          <p id="modalSubtitle">Create a new budget limit</p>
        </div>
        <button class="modal-close" id="closeModal" type="button" aria-label="Close">✕</button>
      </div>

      <form class="modal-body" id="budgetForm" method="POST">
  @csrf
  <input type="hidden" name="_method" id="formMethod" value="POST">
  <input type="hidden" name="id" id="budgetId">

        <div class="form-grid">
          <div class="field">
            <label for="budgetCategory">Category</label>
            <select id="budgetCategory" name="category" class="control" required>
              <option value="" disabled selected>Select category</option>
              <option>Food</option>
              <option>Transport</option>
              <option>Bills</option>
              <option>Entertainment</option>
              <option>Shopping</option>
              <option>Health</option>
            </select>
          </div>

          <div class="field">
            <label for="budgetPeriod">Period</label>
            <select id="budgetPeriod" name="period" class="control" required>
              <option>Monthly</option>
              <option>Weekly</option>
              <option>Annual</option>
            </select>
          </div>

          <div class="field">
            <label for="budgetLimit">Budget Limit</label>
            <input id="budgetLimit" name="amount" class="control" type="number" min="0" step="0.01" placeholder="0.00" required />
          </div>

          <div class="field">
            <label for="budgetSpent">Spent (dummy)</label>
            <input id="budgetSpent" class="control" type="number" min="0" step="0.01" placeholder="0.00" />
          </div>

          <div class="field">
            <label for="budgetStartDate">Start Date</label>
            <input id="budgetStartDate" name="start_date" class="control" type="date" required />
          </div>

          <div class="field">
            <label for="budgetEndDate">End Date (optional)</label>
            <input id="budgetEndDate" name="end_date" class="control" type="date" />
          </div>

          <div class="field" style="grid-column: 1 / -1;">
            <label for="budgetNotes">Notes</label>
            <textarea id="budgetNotes" class="control" placeholder="Optional notes (rules, exceptions, etc.)"></textarea>
            <div class="hint">Demo only (no backend). Spent value is stored as dummy progress.</div>
          </div>
        </div>
      </form>

      <div class="modal-foot">
        <button class="btn" id="cancelModal" type="button">Cancel</button>
        <button class="btn btn-primary" id="saveBudget" type="button">Save Budget</button>
      </div>
    </div>
  </div>

  <script>
    // ---------------------------
    // Dummy data + state
    // ---------------------------
    const TODAY = new Date("2026-06-06T12:00:00"); // fixed date for consistent UI

    const ICONS = {
      Food: "F",
      Transport: "T",
      Bills: "B",
      Entertainment: "E",
      Shopping: "S",
      Health: "H"
    };

    let budgets = {!! json_encode($budgets->map(fn($b) => [
    'id'        => $b->id,
    'category'  => $b->category,
    'period'    => ucfirst($b->period),
    'limit'     => (float)$b->amount,
    'spent'     => 0,
    'startDate' => $b->start_date,
    'endDate'   => $b->end_date ?? '',
    'notes'     => '',
])) !!};

    const state = {
      searchGlobal: "",
      searchTable: "",
      filters: { category:"", period:"", status:"", minLimit:"", maxLimit:"" },
      sort: { key: "category", dir: "asc" },
      page: 1,
      pageSize: 7
    };

    const fmt = (n) => new Intl.NumberFormat("en-US", { style:"currency", currency:"USD" }).format(n);
    const clamp = (n,a,b) => Math.max(a, Math.min(b,n));
    const parseDate = (s) => new Date(s + "T00:00:00");

    function statusFor(b){
      const pct = b.limit ? (b.spent / b.limit) * 100 : 0;
      if (pct > 100) return "Over budget";
      if (pct >= 80) return "Near limit";
      return "On track";
    }

    function statusClass(label){
      if (label === "Over budget") return "over";
      if (label === "Near limit") return "near";
      return "ontrack";
    }

    function enrich(list){
      return list.map(b => {
        const remaining = b.limit - b.spent;
        const pct = b.limit ? (b.spent / b.limit) * 100 : 0;
        const status = statusFor(b);
        return { ...b, remaining, pct, status };
      });
    }

    // ---------------------------
    // Charts
    // ---------------------------
    let budgetBarChart, allocationChart;

    function buildCharts(){
      // Bar: limit vs spent
      budgetBarChart = new Chart(document.getElementById("budgetBarChart"), {
        type: "bar",
        data: {
          labels: [],
          datasets: [
            {
              label: "Limit",
              data: [],
              backgroundColor: "rgba(79,70,229,.20)",
              borderColor: "rgba(79,70,229,.55)",
              borderWidth: 1,
              borderRadius: 10
            },
            {
              label: "Spent",
              data: [],
              backgroundColor: "rgba(37,99,235,.55)",
              borderColor: "rgba(37,99,235,.80)",
              borderWidth: 1,
              borderRadius: 10
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { labels: { color: "rgba(15,23,42,.70)" } },
            tooltip: {
              backgroundColor: "rgba(15,23,42,.96)",
              borderColor: "rgba(255,255,255,.14)",
              borderWidth: 1,
              padding: 12,
              callbacks: { label: (ctx) => ` ${ctx.dataset.label}: ${fmt(ctx.parsed.y)}` }
            }
          },
          scales: {
            x: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color: "rgba(15,23,42,.65)" } },
            y: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color: "rgba(15,23,42,.65)", callback: (v) => "$" + v } }
          }
        }
      });

      // Doughnut: allocation by limit
      allocationChart = new Chart(document.getElementById("allocationChart"), {
        type: "doughnut",
        data: {
          labels: [],
          datasets: [{
            data: [],
            backgroundColor: [
              "rgba(79,70,229,.88)",
              "rgba(37,99,235,.80)",
              "rgba(16,185,129,.80)",
              "rgba(245,158,11,.84)",
              "rgba(239,68,68,.78)",
              "rgba(100,116,139,.70)"
            ],
            borderColor: "rgba(255,255,255,.95)",
            borderWidth: 2,
            hoverOffset: 6
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: "62%",
          plugins: {
            legend: {
              position: "bottom",
              labels: {
                color: "rgba(15,23,42,.70)",
                padding: 14,
                boxWidth: 10,
                boxHeight: 10,
                usePointStyle: true,
                pointStyle: "circle"
              }
            },
            tooltip: {
              backgroundColor: "rgba(15,23,42,.96)",
              borderColor: "rgba(255,255,255,.14)",
              borderWidth: 1,
              padding: 12,
              callbacks: { label: (ctx) => ` ${ctx.label}: ${fmt(ctx.parsed)}` }
            }
          }
        }
      });
    }

    function renderCharts(){
      const list = enrich(budgets).filter(b => b.period === "Monthly"); // demo focus

      // Bar chart
      budgetBarChart.data.labels = list.map(x => x.category);
      budgetBarChart.data.datasets[0].data = list.map(x => x.limit);
      budgetBarChart.data.datasets[1].data = list.map(x => x.spent);
      budgetBarChart.update();

      // Allocation chart (limits)
      allocationChart.data.labels = list.map(x => x.category);
      allocationChart.data.datasets[0].data = list.map(x => x.limit);
      allocationChart.update();
    }

    // ---------------------------
    // Render blocks
    // ---------------------------
    function renderMonthChip(){
      document.getElementById("monthChip").textContent =
        TODAY.toLocaleString("en-US", { month:"long", year:"numeric" });
    }

    function renderSummary(){
      const list = enrich(budgets).filter(b => b.period === "Monthly");
      const totalLimit = list.reduce((a,b)=>a+b.limit,0);
      const totalSpent = list.reduce((a,b)=>a+b.spent,0);
      const remaining = totalLimit - totalSpent;
      const pctUsed = totalLimit ? (totalSpent/totalLimit)*100 : 0;

      const overCount = list.filter(b => b.pct > 100).length;
      const nearCount = list.filter(b => b.pct >= 80 && b.pct <= 100).length;

      // Simple "trend": compare to a dummy previous month usage
      const prevPctUsed = 71; // dummy
      const delta = pctUsed - prevPctUsed;

      document.getElementById("summaryGrid").innerHTML = `
        <article class="card summary-card" aria-label="Total budget">
          <div class="summary-top">
            <div class="meta">
              <span>Total Budget</span>
              <strong>${fmt(totalLimit)}</strong>
            </div>
            <span class="badge">Monthly</span>
          </div>
          <div class="summary-foot">
            <span>${list.length} categories</span>
            <span class="badge ${delta <= 0 ? "success" : "warning"}">${delta <= 0 ? "↓" : "↑"} ${Math.abs(delta).toFixed(1)}% usage</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Total spent">
          <div class="summary-top">
            <div class="meta">
              <span>Total Spent</span>
              <strong>${fmt(totalSpent)}</strong>
            </div>
            <span class="badge ${pctUsed < 80 ? "success" : (pctUsed <= 100 ? "warning" : "danger")}">${pctUsed.toFixed(0)}% used</span>
          </div>
          <div class="summary-foot">
            <span>Current month</span>
            <span>${fmt(Math.max(0, remaining))} remaining</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Budget remaining">
          <div class="summary-top">
            <div class="meta">
              <span>Remaining</span>
              <strong style="color:${remaining < 0 ? "rgba(127,29,29,.95)" : "rgba(6,95,70,.95)"}">${fmt(remaining)}</strong>
            </div>
            <span class="badge ${remaining < 0 ? "danger" : "success"}">${remaining < 0 ? "Over" : "Safe"}</span>
          </div>
          <div class="summary-foot">
            <span>Buffer</span>
            <span>${fmt(Math.max(0, remaining))}</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Alerts count">
          <div class="summary-top">
            <div class="meta">
              <span>Alerts</span>
              <strong>${nearCount + overCount}</strong>
            </div>
            <span class="badge ${overCount ? "danger" : "warning"}">${overCount ? overCount + " over" : nearCount + " near"}</span>
          </div>
          <div class="summary-foot">
            <span>Near limit</span>
            <span>${nearCount} • Over ${overCount}</span>
          </div>
        </article>
      `;
    }

    function renderAlerts(){
      const list = enrich(budgets).filter(b => b.period === "Monthly");
      const over = list.filter(b => b.pct > 100);
      const near = list.filter(b => b.pct >= 80 && b.pct <= 100);

      const cards = [];

      if (over.length){
        const worst = over.slice().sort((a,b)=>b.pct-a.pct)[0];
        cards.push(`
          <article class="card alert-card danger" aria-label="Overspending warning">
            <h4>Overspending Warning</h4>
            <p><strong>${worst.category}</strong> exceeded its budget by <strong>${fmt(worst.spent - worst.limit)}</strong>. Consider reducing spending or increasing the limit.</p>
            <div class="row">
              <span class="badge danger">${worst.pct.toFixed(0)}% used</span>
              <span class="chip">Limit: ${fmt(worst.limit)} • Spent: ${fmt(worst.spent)}</span>
            </div>
          </article>
        `);
      }

      if (near.length){
        const topNear = near.slice().sort((a,b)=>b.pct-a.pct)[0];
        cards.push(`
          <article class="card alert-card" aria-label="Near limit alert">
            <h4>Budget Alert</h4>
            <p><strong>${topNear.category}</strong> reached <strong>${topNear.pct.toFixed(0)}%</strong> of its budget. Keep an eye on this category.</p>
            <div class="row">
              <span class="badge warning">${fmt(Math.max(0, topNear.limit - topNear.spent))} left</span>
              <span class="chip">Limit: ${fmt(topNear.limit)}</span>
            </div>
          </article>
        `);
      }

      if (!cards.length){
        cards.push(`
          <article class="card alert-card ok" aria-label="All budgets healthy">
            <h4>All Budgets Healthy</h4>
            <p>No categories are near or over limit. Keep tracking spending to stay consistent.</p>
            <div class="row">
              <span class="badge success">No alerts</span>
              <span class="chip">Threshold: 80%</span>
            </div>
          </article>
        `);
        cards.push(`
          <article class="card alert-card ok" aria-label="Recommendation">
            <h4>Recommendation</h4>
            <p>Review budgets weekly and adjust limits for categories that consistently under/over perform.</p>
            <div class="row">
              <span class="badge success">Best practice</span>
              <span class="chip">Weekly review</span>
            </div>
          </article>
        `);
      } else if (cards.length === 1){
        // ensure 2-column grid looks balanced
        cards.push(`
          <article class="card alert-card ok" aria-label="Action tip">
            <h4>Action Tip</h4>
            <p>Move discretionary spend (Entertainment/Shopping) into savings when you are under budget.</p>
            <div class="row">
              <span class="badge success">Optimize</span>
              <span class="chip">Save surplus</span>
            </div>
          </article>
        `);
      }

      document.getElementById("alertGrid").innerHTML = cards.join("");
    }

    function renderBudgetCards(){
      const list = enrich(budgets).filter(b => b.period === "Monthly");
      const grid = document.getElementById("budgetGrid");

      const order = ["Food","Transport","Bills","Shopping","Entertainment","Health"];
      const sorted = list.slice().sort((a,b)=>order.indexOf(a.category)-order.indexOf(b.category));

      grid.innerHTML = sorted.map(b => {
        const pct = b.pct;
        const pctClamped = clamp(pct, 0, 160);
        const barClass = pct > 100 ? "danger" : (pct >= 80 ? "warning" : "");
        const remainingText = b.remaining >= 0 ? `${fmt(b.remaining)} left` : `${fmt(Math.abs(b.remaining))} over`;
        return `
          <article class="card budget-card" aria-label="${b.category} budget">
            <div class="budget-top">
              <div>
                <p class="budget-name">${b.category}</p>
                <p class="budget-sub">${fmt(b.spent)} / ${fmt(b.limit)}</p>
              </div>
              <div class="budget-icon" title="${b.category}">${ICONS[b.category] || "•"}</div>
            </div>

            <div class="progress ${barClass}">
              <i style="width:${pctClamped}%;"></i>
            </div>

            <div class="budget-meta">
              <span>${pct.toFixed(0)}% used</span>
              <span style="color:${b.remaining < 0 ? "rgba(127,29,29,.95)" : "rgba(15,23,42,.70)"}">${remainingText}</span>
            </div>

            <div style="margin-top:10px;">
              <span class="status ${statusClass(b.status)}"><span class="dot"></span>${b.status}</span>
            </div>
          </article>
        `;
      }).join("");
    }

    // ---------------------------
    // Table: filter/sort/pagination
    // ---------------------------
    function escapeHtml(str){
      return String(str)
        .replaceAll("&","&amp;")
        .replaceAll("<","&lt;")
        .replaceAll(">","&gt;")
        .replaceAll('"',"&quot;")
        .replaceAll("'","&#039;");
    }

    function applyAllFilters(list){
      const q = (state.searchGlobal || state.searchTable || "").trim().toLowerCase();
      const f = state.filters;

      return enrich(list).filter(b => {
        if (q){
          const hay = `${b.category} ${b.period} ${b.status}`.toLowerCase();
          if (!hay.includes(q)) return false;
        }
        if (f.category && b.category !== f.category) return false;
        if (f.period && b.period !== f.period) return false;
        if (f.status && b.status !== f.status) return false;

        if (f.minLimit !== "" && b.limit < Number(f.minLimit)) return false;
        if (f.maxLimit !== "" && b.limit > Number(f.maxLimit)) return false;

        return true;
      });
    }

    function sortList(list){
      const { key, dir } = state.sort;
      const sign = dir === "asc" ? 1 : -1;
      const copy = [...list];

      copy.sort((a,b) => {
        let av = a[key], bv = b[key];

        if (key === "startDate"){
          av = parseDate(a.startDate).getTime();
          bv = parseDate(b.startDate).getTime();
        }
        if (["limit","spent","remaining","pct"].includes(key)){
          av = Number(av); bv = Number(bv);
        }

        if (typeof av === "string" && typeof bv === "string") return sign * av.localeCompare(bv);
        return sign * (av - bv);
      });

      return copy;
    }

    function paginate(list){
      const totalItems = list.length;
      const totalPages = Math.max(1, Math.ceil(totalItems / state.pageSize));
      state.page = clamp(state.page, 1, totalPages);
      const start = (state.page - 1) * state.pageSize;
      return { pageItems: list.slice(start, start + state.pageSize), totalItems, totalPages, start };
    }

    function updateSortIndicators(){
      const ids = ["category","period","startDate","limit","spent","remaining","status"];
      for (const id of ids){
        const el = document.getElementById("sort-" + id);
        if (!el) continue;
        if (state.sort.key !== id) el.textContent = "↕";
        else el.textContent = state.sort.dir === "asc" ? "↑" : "↓";
      }
    }

    function renderPager(page, totalPages){
      const pager = document.getElementById("pager");
      const mkBtn = (label, p, disabled=false, active=false) => `
        <button class="page-btn ${active ? "active" : ""}" type="button" data-page="${p}" ${disabled ? "disabled" : ""}>${label}</button>
      `;

      let html = "";
      html += mkBtn("Prev", Math.max(1, page-1), page === 1);

      const windowSize = 5;
      const half = Math.floor(windowSize/2);
      let start = Math.max(1, page - half);
      let end = Math.min(totalPages, start + windowSize - 1);
      start = Math.max(1, end - windowSize + 1);

      if (start > 1) html += mkBtn("1", 1, false, page === 1);
      if (start > 2) html += `<span class="page-info" style="padding:0 4px;">…</span>`;
      for (let p=start; p<=end; p++) html += mkBtn(String(p), p, false, p === page);
      if (end < totalPages - 1) html += `<span class="page-info" style="padding:0 4px;">…</span>`;
      if (end < totalPages) html += mkBtn(String(totalPages), totalPages, false, page === totalPages);

      html += mkBtn("Next", Math.min(totalPages, page+1), page === totalPages);
      pager.innerHTML = html;
    }

    function renderTable(){
      const tbody = document.getElementById("budgetsTbody");
      const empty = document.getElementById("emptyState");
      const tableWrap = document.getElementById("tableWrap");

      const filtered = applyAllFilters(budgets);
      const sorted = sortList(filtered);
      const { pageItems, totalItems, totalPages, start } = paginate(sorted);

      document.getElementById("resultsChip").textContent = `${totalItems} result${totalItems === 1 ? "" : "s"}`;

      if (totalItems === 0){
        tbody.innerHTML = "";
        empty.classList.add("show");
        tableWrap.style.display = "none";
        document.getElementById("pageInfo").textContent = `Showing 0–0 of 0`;
        renderPager(1,1);
        return;
      }

      empty.classList.remove("show");
      tableWrap.style.display = "block";

      tbody.innerHTML = pageItems.map(b => {
        const cls = statusClass(b.status);
        const statusLabel = b.status;
        return `
          <tr>
            <td>${escapeHtml(b.category)}</td>
            <td>${escapeHtml(b.period)}</td>
            <td>${escapeHtml(b.startDate)}</td>
            <td class="amount">${fmt(b.limit)}</td>
            <td class="amount">${fmt(b.spent)}</td>
            <td class="amount" style="color:${b.remaining < 0 ? "rgba(127,29,29,.95)" : "rgba(6,95,70,.95)"}">
              ${fmt(b.remaining)}
            </td>
            <td><span class="status ${cls}"><span class="dot"></span>${escapeHtml(statusLabel)}</span></td>
            <td>
              <div class="actions">
                <button class="link-btn" type="button" data-action="view" data-id="${b.id}">View</button>
                <button class="link-btn" type="button" data-action="edit" data-id="${b.id}">Edit</button>
                <button class="link-btn danger" type="button" data-action="delete" data-id="${b.id}">Delete</button>
              </div>
            </td>
          </tr>
        `;
      }).join("");

      const end = start + pageItems.length;
      document.getElementById("pageInfo").textContent = `Showing ${start+1}–${end} of ${totalItems}`;
      renderPager(state.page, totalPages);
    }

    // ---------------------------
    // Modal (Add/Edit/View)
    // ---------------------------
    let modalMode = "add"; // add|edit|view
    const modalOverlay = document.getElementById("modalOverlay");
    const form = document.getElementById("budgetForm");

    const fields = {
      id: document.getElementById("budgetId"),
      category: document.getElementById("budgetCategory"),
      period: document.getElementById("budgetPeriod"),
      limit: document.getElementById("budgetLimit"),
      spent: document.getElementById("budgetSpent"),
      startDate: document.getElementById("budgetStartDate"),
      endDate: document.getElementById("budgetEndDate"),
      notes: document.getElementById("budgetNotes")
    };

    function setFormDisabled(disabled){
      form.querySelectorAll(".control").forEach(el => el.disabled = disabled);
    }

    function fillForm(b){
      if (!b) return;
      fields.id.value = b.id;
      fields.category.value = b.category;
      fields.period.value = b.period;
      fields.limit.value = b.limit;
      fields.spent.value = b.spent;
      fields.startDate.value = b.startDate;
      fields.endDate.value = b.endDate || "";
      fields.notes.value = b.notes || "";
    }

    function openModal(mode, budget=null){
      modalMode = mode;

      const title = document.getElementById("modalTitle");
      const subtitle = document.getElementById("modalSubtitle");
      const saveBtn = document.getElementById("saveBudget");

      if (mode === "add"){
        title.textContent = "Add Budget";
        subtitle.textContent = "Create a new budget limit";
        saveBtn.style.display = "inline-flex";
        saveBtn.textContent = "Save Budget";
        form.reset();
        fields.id.value = "";
        fields.startDate.value = TODAY.toISOString().slice(0,10);
        fields.endDate.value = "";
      } else if (mode === "edit"){
        title.textContent = "Edit Budget";
        subtitle.textContent = "Update budget details";
        saveBtn.style.display = "inline-flex";
        saveBtn.textContent = "Save Changes";
        fillForm(budget);
      } else {
        title.textContent = "View Budget";
        subtitle.textContent = "Review budget details";
        saveBtn.style.display = "none";
        fillForm(budget);
      }

      setFormDisabled(mode === "view");
      modalOverlay.classList.add("open");
      modalOverlay.setAttribute("aria-hidden", "false");
      setTimeout(() => fields.category.focus(), 50);
    }

    function closeModal(){
      modalOverlay.classList.remove("open");
      modalOverlay.setAttribute("aria-hidden", "true");
    }

    function saveFromModal(){
    if(!form.reportValidity()) return;
    const id = fields.id.value;
    document.getElementById("formMethod").value = id ? "PUT" : "POST";
    form.action = id ? `/budgets/${id}` : "/budgets";
    form.submit();
}

    // ---------------------------
    // Rerender all
    // ---------------------------
    function rerenderAll(){
      renderMonthChip();
      renderSummary();
      renderAlerts();
      renderCharts();
      renderBudgetCards();
      updateSortIndicators();
      renderTable();
    }

    // ---------------------------
    // Events
    // ---------------------------
    function bindEvents(){
      // Sidebar (mobile)
      const hamburger = document.getElementById("hamburger");
      const sidebarOverlay = document.getElementById("sidebarOverlay");
      hamburger?.addEventListener("click", () => document.body.classList.toggle("sidebar-open"));
      sidebarOverlay?.addEventListener("click", () => document.body.classList.remove("sidebar-open"));
      window.addEventListener("resize", () => {
        if (window.innerWidth > 900) document.body.classList.remove("sidebar-open");
      });

      // Searches
      document.getElementById("globalSearch").addEventListener("input", (e) => {
        state.searchGlobal = e.target.value;
        state.page = 1;
        renderTable();
      });
      document.getElementById("tableSearch").addEventListener("input", (e) => {
        state.searchTable = e.target.value;
        state.page = 1;
        renderTable();
      });

      // Filters panel toggle
      const toggleFilters = document.getElementById("toggleFilters");
      const panel = document.getElementById("filtersPanel");
      toggleFilters.addEventListener("click", () => {
        const open = panel.classList.toggle("open");
        toggleFilters.setAttribute("aria-expanded", String(open));
      });

      // Apply filters
      document.getElementById("applyFilters").addEventListener("click", () => {
        state.filters.category = document.getElementById("filterCategory").value;
        state.filters.period = document.getElementById("filterPeriod").value;
        state.filters.status = document.getElementById("filterStatus").value;
        state.filters.minLimit = document.getElementById("filterMinLimit").value;
        state.filters.maxLimit = document.getElementById("filterMaxLimit").value;
        state.page = 1;
        renderTable();
      });

      // Clear all
      document.getElementById("clearAll").addEventListener("click", () => {
        state.searchGlobal = "";
        state.searchTable = "";
        document.getElementById("globalSearch").value = "";
        document.getElementById("tableSearch").value = "";

        state.filters = { category:"", period:"", status:"", minLimit:"", maxLimit:"" };
        document.getElementById("filterCategory").value = "";
        document.getElementById("filterPeriod").value = "";
        document.getElementById("filterStatus").value = "";
        document.getElementById("filterMinLimit").value = "";
        document.getElementById("filterMaxLimit").value = "";

        state.page = 1;
        renderTable();
      });

      // Sorting
      document.querySelectorAll("thead th[data-sort]").forEach(th => {
        th.addEventListener("click", () => {
          const key = th.getAttribute("data-sort");
          if (!key) return;
          if (state.sort.key === key){
            state.sort.dir = state.sort.dir === "asc" ? "desc" : "asc";
          } else {
            state.sort.key = key;
            state.sort.dir = (key === "startDate") ? "desc" : "asc";
          }
          updateSortIndicators();
          renderTable();
        });
      });

      // Pagination
      document.getElementById("pager").addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-page]");
        if (!btn) return;
        state.page = Number(btn.dataset.page);
        renderTable();
      });

      // Table actions
      document.getElementById("budgetsTbody").addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-action]");
        if (!btn) return;

        const action = btn.dataset.action;
        const id = btn.dataset.id;
        const b = budgets.find(x => x.id === id);

        if (action === "view") openModal("view", b);
        if (action === "edit") openModal("edit", b);
        if(action === "delete"){
    if(confirm("Delete this budget?")){
        const f = document.createElement("form");
        f.method = "POST";
        f.action = `/budgets/${id}`;
        f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
        document.body.appendChild(f);
        f.submit();
    }
}
      });

      // Modal
      document.getElementById("openAddModal").addEventListener("click", () => openModal("add"));
      document.getElementById("emptyAddBtn").addEventListener("click", () => openModal("add"));
      document.getElementById("closeModal").addEventListener("click", closeModal);
      document.getElementById("cancelModal").addEventListener("click", closeModal);
      document.getElementById("saveBudget").addEventListener("click", saveFromModal);

      modalOverlay.addEventListener("click", (e) => {
        if (e.target === modalOverlay) closeModal();
      });
      window.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modalOverlay.classList.contains("open")) closeModal();
      });
    }

    // ---------------------------
    // Init
    // ---------------------------
    buildCharts();
    bindEvents();
    rerenderAll();
  </script>
</body>
</html>