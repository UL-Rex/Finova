<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Income • Finova</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    /* Top header */
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

    /* Card */
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
    .chip{
      font-size: 12px;
      color: rgba(15,23,42,.70);
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.03);
      padding: 6px 10px;
      border-radius: 999px;
      white-space: nowrap;
    }
    .canvas-wrap{ padding: 10px 14px 14px; height: 320px; }

    /* Source cards */
    .source-grid{
      display:grid;
      grid-template-columns: repeat(5, minmax(0,1fr));
      gap: 12px;
    }
    .source-card{ padding: 14px; transition: transform var(--t), box-shadow var(--t); }
    .source-card:hover{ transform: translateY(-2px); box-shadow: 0 18px 40px rgba(15,23,42,.10); }
    .source-top{
      display:flex; align-items:center; justify-content:space-between; gap: 10px;
      margin-bottom: 10px;
    }
    .source-icon{
      width:40px; height:40px;
      border-radius: 14px;
      display:grid; place-items:center;
      background: rgba(16,185,129,.10);
      border: 1px solid rgba(16,185,129,.16);
      color: rgba(6,95,70,.95);
      font-weight: 800;
    }
    .source-name{ font-size: 13px; font-weight: 700; margin:0; }
    .source-amt{ margin: 4px 0 0; font-size: 12px; color: var(--muted); }

    .progress{
      height: 10px;
      border-radius: 999px;
      background: rgba(15,23,42,.06);
      border: 1px solid rgba(15,23,42,.08);
      overflow:hidden;
    }
    .progress > i{
      display:block; height:100%; width:0%;
      border-radius: 999px;
      background: linear-gradient(90deg, rgba(16,185,129,1), rgba(37,99,235,1));
      transition: width 560ms cubic-bezier(.2,.8,.2,1);
    }
    .progress.warning > i{ background: linear-gradient(90deg, rgba(245,158,11,1), rgba(37,99,235,1)); }
    .progress.danger > i{ background: linear-gradient(90deg, rgba(239,68,68,1), rgba(245,158,11,1)); }

    .source-meta{
      margin-top: 10px;
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      font-size: 12px; color: var(--muted);
    }

    /* Target alerts */
    .alert-grid{
      display:grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 12px;
    }
    .alert-card{
      padding: 14px;
      border-left: 5px solid rgba(16,185,129,.9);
      background: linear-gradient(180deg, rgba(16,185,129,.06), rgba(255,255,255,1));
    }
    .alert-card.warning{
      border-left-color: rgba(245,158,11,.9);
      background: linear-gradient(180deg, rgba(245,158,11,.06), rgba(255,255,255,1));
    }
    .alert-card.danger{
      border-left-color: rgba(239,68,68,.9);
      background: linear-gradient(180deg, rgba(239,68,68,.06), rgba(255,255,255,1));
    }
    .alert-card h4{ margin:0; font-size: 13px; letter-spacing:-.2px; }
    .alert-card p{ margin: 6px 0 0; font-size: 12px; color: var(--muted); line-height: 1.35; }
    .alert-card .row{
      margin-top: 10px;
      display:flex; align-items:center; justify-content:space-between; gap:10px;
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
      min-width: 920px;
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
    tbody tr:hover td{ background: rgba(16,185,129,.06); }

    .amount{
      text-align:right;
      font-variant-numeric: tabular-nums;
      font-weight: 800;
      color: rgba(6,95,70,.95);
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

    .status.received{ background: rgba(16,185,129,.10); border-color: rgba(16,185,129,.22); color: rgba(6,95,70,.95); }
    .status.received .dot{ background: rgba(16,185,129,1); }
    .status.pending{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.25); color: rgba(120,53,15,.95); }
    .status.pending .dot{ background: rgba(245,158,11,1); }

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
      border-color: rgba(16,185,129,.35);
      background: rgba(16,185,129,.10);
      color: rgba(6,95,70,.95);
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
      width: 740px;
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
      .source-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
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
      .source-grid{ grid-template-columns: 1fr; }
      .btn, .btn-primary{ width: 100%; justify-content:center; }
      .header-actions{ flex-direction: column; align-items: stretch; }
    }
  </style>
</head>
<body>
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="app">
    @include('layouts.sidebar')

    <main class="main">

      @if(session('success'))
      <div style="padding:12px 16px;background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.25);border-radius:12px;color:rgba(6,95,70,.95);font-size:13px;margin-bottom:14px;">
        ✓ {{ session('success') }}
      </div>
      @endif

      <div class="mobile-bar">
        <button class="hamburger" id="hamburger">☰</button>
        <div style="font-weight:800;">Income</div>
      </div>

      <header class="top-header">
        <div class="title-block">
          <h1>Income</h1>
          <p>Track and manage your income streams</p>
        </div>
        <div class="header-actions">
          <div class="search">
            <span class="mag">⌕</span>
            <input id="globalSearch" type="search" placeholder="Search income, sources…" />
          </div>
          <button class="btn" id="toggleFilters" type="button">⏷ Filter</button>
          <button class="btn btn-primary" id="openAddModal" type="button">＋ Add Income</button>
        </div>
      </header>

      <section class="section">
        <div class="section-title">
          <div><h2>Income Summary</h2><p>Current month overview</p></div>
          <span class="chip" id="monthChip">Month</span>
        </div>
        <div class="summary-grid" id="summaryGrid"></div>
      </section>

      <section class="section">
        <div class="section-title">
          <div><h2>Income Target Alerts</h2><p>Progress toward monthly target</p></div>
        </div>
        <div class="alert-grid" id="alertGrid"></div>
      </section>

      <section class="section">
        <div class="section-title">
          <div><h2>Income Analytics</h2><p>Trends and source breakdown</p></div>
        </div>
        <div class="analytics-grid">
          <article class="card">
            <div class="card-head">
              <div><h3>Income Trend</h3><p>Monthly income visualization</p></div>
              <span class="chip">Last 6 months</span>
            </div>
            <div class="canvas-wrap"><canvas id="trendChart"></canvas></div>
          </article>
          <article class="card">
            <div class="card-head">
              <div><h3>Source Breakdown</h3><p>Share of total income</p></div>
              <span class="chip">This month</span>
            </div>
            <div class="canvas-wrap"><canvas id="sourceChart"></canvas></div>
          </article>
        </div>
      </section>

      <section class="section">
        <div class="section-title">
          <div><h2>Income Sources</h2><p>Progress vs source targets</p></div>
        </div>
        <div class="source-grid" id="sourceGrid"></div>
      </section>

      <section class="section">
        <div class="section-title">
          <div><h2>Recent Income</h2><p>Search, filter, sort and manage entries</p></div>
        </div>
        <article class="card table-card">
          <div class="table-toolbar">
            <div class="toolbar-left">
              <div class="search" style="max-width:420px;">
                <span class="mag">⌕</span>
                <input id="tableSearch" type="search" placeholder="Search recent income…" />
              </div>
              <button class="btn btn-icon" id="clearAll" title="Clear">↺</button>
            </div>
            <div class="toolbar-right">
              <span class="chip" id="resultsChip">0 results</span>
            </div>
          </div>

          <div class="filters-panel" id="filtersPanel">
            <div class="filter-grid">
              <div class="field">
                <label>Source</label>
                <select id="filterSource" class="control">
                  <option value="">All</option>
                  <option>Salary</option><option>Freelance</option>
                  <option>Investments</option><option>Refunds</option><option>Other</option>
                </select>
              </div>
              <div class="field">
                <label>Date From</label>
                <input id="filterDateFrom" type="date" class="control" />
              </div>
              <div class="field">
                <label>Date To</label>
                <input id="filterDateTo" type="date" class="control" />
              </div>
              <div class="field">
                <label>Min Amount</label>
                <input id="filterAmountMin" type="number" class="control" placeholder="0" />
              </div>
              <div class="field">
                <label>Max Amount</label>
                <input id="filterAmountMax" type="number" class="control" placeholder="5000" />
              </div>
              <div class="field">
                <label>&nbsp;</label>
                <button class="btn btn-primary" id="applyFilters">Apply Filters</button>
              </div>
            </div>
          </div>

          <div class="empty" id="emptyState">
            <h3>No income recorded yet</h3>
            <p>Add your first income entry to start tracking.</p>
            <button class="btn btn-primary" id="emptyAddBtn">＋ Add Income</button>
          </div>

          <div class="table-wrap" id="tableWrap">
            <table>
              <thead>
                <tr>
                  <th data-sort="date">Date <span class="sort" id="sort-date">↕</span></th>
                  <th data-sort="title">Title <span class="sort" id="sort-title">↕</span></th>
                  <th data-sort="source">Source <span class="sort" id="sort-source">↕</span></th>
                  <th data-sort="amount" style="text-align:right;">Amount <span class="sort" id="sort-amount">↕</span></th>
                  <th style="text-align:right;">Actions</th>
                </tr>
              </thead>
              <tbody id="incomeTbody"></tbody>
            </table>
          </div>

          <div class="pagination">
            <div class="page-info" id="pageInfo">Showing 0–0 of 0</div>
            <div class="pager" id="pager"></div>
          </div>
        </article>
      </section>
    </main>
  </div>

  <!-- Modal -->
  <div class="modal-overlay" id="modalOverlay">
    <div class="modal">
      <div class="modal-head">
        <div>
          <h3 id="modalTitle">Add Income</h3>
          <p id="modalSubtitle">Record a new income entry</p>
        </div>
        <button class="modal-close" id="closeModal">✕</button>
      </div>

      <form class="modal-body" id="incomeForm" method="POST">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">
        <input type="hidden" name="id" id="incomeId">

        <div class="form-grid">
          <div class="field">
            <label>Income Title</label>
            <input id="incomeTitle" name="title" class="control" type="text" placeholder="e.g., Salary - June" required />
          </div>
          <div class="field">
            <label>Amount</label>
            <input id="incomeAmount" name="amount" class="control" type="number" min="0" step="0.01" placeholder="0.00" required />
          </div>
          <div class="field">
            <label>Source</label>
            <select id="incomeSource" name="source" class="control" required>
              <option value="" disabled selected>Select source</option>
              <option>Salary</option><option>Freelance</option>
              <option>Investments</option><option>Refunds</option><option>Other</option>
            </select>
          </div>
          <div class="field">
            <label>Date</label>
            <input id="incomeDate" name="date" class="control" type="date" required />
          </div>
          <div class="field" style="grid-column:1/-1;">
            <label>Notes</label>
            <textarea id="incomeNotes" name="note" class="control" placeholder="Optional notes"></textarea>
          </div>
        </div>
      </form>

      <div class="modal-foot">
        <button class="btn" id="cancelModal">Cancel</button>
        <button class="btn btn-primary" id="saveIncome">Save Income</button>
      </div>
    </div>
  </div>

  <script>
    let incomes = {!! json_encode($incomes->map(fn($e) => [
        'id'     => $e->id,
        'date'   => $e->date,
        'title'  => $e->title,
        'source' => $e->source,
        'amount' => (float)$e->amount,
        'note'   => $e->note ?? '',
        'receivedVia' => 'Bank',
        'status' => 'Received',
    ])) !!};

    const TODAY = new Date();
    const MONTHLY_INCOME_TARGET = 6000;
    const SOURCE_TARGETS = { Salary:4500, Freelance:1200, Investments:400, Refunds:150, Other:200 };
    const SOURCE_ICONS = { Salary:"S", Freelance:"F", Investments:"I", Refunds:"R", Other:"O" };

    const state = {
      searchGlobal:"", searchTable:"",
      filters:{ source:"", dateFrom:"", dateTo:"", amountMin:"", amountMax:"" },
      sort:{ key:"date", dir:"desc" },
      page:1, pageSize:7
    };

    const fmt = (n) => new Intl.NumberFormat("en-US",{style:"currency",currency:"USD"}).format(n);
    const clamp = (n,a,b) => Math.max(a,Math.min(b,n));
    const parseDate = (s) => new Date(s+"T00:00:00");
    const isSameMonth = (d,ref) => d.getFullYear()===ref.getFullYear()&&d.getMonth()===ref.getMonth();
    const monthLabel = (d) => d.toLocaleString("en-US",{month:"short"});
    const yearMonthKey = (d) => `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,"0")}`;

    let trendChart, sourceChart;

    function buildCharts(){
      trendChart = new Chart(document.getElementById("trendChart"),{
        type:"line",
        data:{ labels:[], datasets:[{ label:"Income", data:[], borderColor:"rgba(16,185,129,1)", backgroundColor:"rgba(16,185,129,.16)", fill:true, tension:0.35, borderWidth:2 }] },
        options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{ x:{grid:{color:"rgba(15,23,42,.06)"},ticks:{color:"rgba(15,23,42,.65)"}}, y:{grid:{color:"rgba(15,23,42,.06)"},ticks:{color:"rgba(15,23,42,.65)",callback:(v)=>"$"+v}} } }
      });
      sourceChart = new Chart(document.getElementById("sourceChart"),{
        type:"doughnut",
        data:{ labels:["Salary","Freelance","Investments","Refunds","Other"], datasets:[{ data:[0,0,0,0,0], backgroundColor:["rgba(16,185,129,.86)","rgba(37,99,235,.82)","rgba(79,70,229,.84)","rgba(245,158,11,.85)","rgba(100,116,139,.70)"], borderColor:"rgba(255,255,255,.95)", borderWidth:2 }] },
        options:{ responsive:true, maintainAspectRatio:false, cutout:"62%", plugins:{ legend:{ position:"bottom", labels:{ color:"rgba(15,23,42,.70)", padding:14, boxWidth:10, usePointStyle:true } } } }
      });
    }

    function currentMonthIncomes(list){ return list.filter(e=>isSameMonth(parseDate(e.date),TODAY)); }
    function sumAll(list){ return list.reduce((a,b)=>a+b.amount,0); }
    function sumBySource(list){ const m={}; for(const e of list) m[e.source]=(m[e.source]||0)+e.amount; return m; }
    function highestSource(list){ const s=sumBySource(list); let best={source:"—",amount:0}; for(const[k,v]of Object.entries(s)) if(v>best.amount) best={source:k,amount:v}; return best; }
    function last6Keys(){ const keys=[]; const d=new Date(TODAY); d.setDate(1); for(let i=5;i>=0;i--){ const x=new Date(d); x.setMonth(x.getMonth()-i); keys.push(yearMonthKey(x)); } return keys; }
    function monthly6(list){ const keys=last6Keys(); const t=Object.fromEntries(keys.map(k=>[k,0])); for(const e of list){ const k=yearMonthKey(parseDate(e.date)); if(k in t) t[k]+=e.amount; } return{keys,values:keys.map(k=>Number(t[k].toFixed(2)))}; }

    function applyFilters(list){
      const q=(state.searchGlobal||state.searchTable||"").trim().toLowerCase();
      const f=state.filters;
      return list.filter(e=>{
        if(q&&!`${e.title} ${e.source}`.toLowerCase().includes(q)) return false;
        if(f.source&&e.source!==f.source) return false;
        if(f.dateFrom&&parseDate(e.date)<parseDate(f.dateFrom)) return false;
        if(f.dateTo&&parseDate(e.date)>parseDate(f.dateTo)) return false;
        if(f.amountMin!==""&&e.amount<Number(f.amountMin)) return false;
        if(f.amountMax!==""&&e.amount>Number(f.amountMax)) return false;
        return true;
      });
    }

    function sortList(list){ const{key,dir}=state.sort; const sign=dir==="asc"?1:-1; return[...list].sort((a,b)=>{ let av=a[key],bv=b[key]; if(key==="date"){av=parseDate(a.date).getTime();bv=parseDate(b.date).getTime();} if(key==="amount"){av=a.amount;bv=b.amount;} if(typeof av==="string") return sign*av.localeCompare(bv); return sign*(av-bv); }); }
    function paginate(list){ const total=list.length; const pages=Math.max(1,Math.ceil(total/state.pageSize)); state.page=clamp(state.page,1,pages); const start=(state.page-1)*state.pageSize; return{pageItems:list.slice(start,start+state.pageSize),totalItems:total,totalPages:pages,start}; }
    function escapeHtml(str){ return String(str).replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;"); }

    function renderMonthChip(){ document.getElementById("monthChip").textContent=TODAY.toLocaleString("en-US",{month:"long",year:"numeric"}); }

    function renderSummary(){
      const ml=currentMonthIncomes(incomes); const mt=sumAll(ml);
      const prev=new Date(TODAY); prev.setMonth(prev.getMonth()-1);
      const pt=sumAll(incomes.filter(e=>isSameMonth(parseDate(e.date),prev)));
      const delta=pt?((mt-pt)/pt)*100:0;
      const hi=highestSource(ml);
      document.getElementById("summaryGrid").innerHTML=`
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Total Income</span><strong>${fmt(mt)}</strong></div><span class="badge ${delta>=0?"success":"danger"}">${delta>=0?"↑":"↓"} ${Math.abs(delta).toFixed(1)}%</span></div><div class="summary-foot"><span>Current month</span><span>${ml.length} entries</span></div></article>
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Highest Source</span><strong>${hi.source}</strong></div><span class="badge">${mt?(hi.amount/mt*100).toFixed(0):0}% of total</span></div><div class="summary-foot"><span>Received</span><span>${fmt(hi.amount)}</span></div></article>
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Avg Daily Income</span><strong>${fmt(TODAY.getDate()?mt/TODAY.getDate():0)}</strong></div><span class="badge">Per day</span></div><div class="summary-foot"><span>Days elapsed</span><span>${TODAY.getDate()}</span></div></article>
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Transactions</span><strong>${ml.length}</strong></div><span class="badge">This month</span></div><div class="summary-foot"><span>Total entries</span><span>${incomes.length}</span></div></article>`;
    }

    function renderAlerts(){
      const ml=currentMonthIncomes(incomes);
      const received=sumAll(ml.filter(x=>x.status==="Received"));
      const pending=sumAll(ml.filter(x=>x.status==="Pending"));
      const pct=MONTHLY_INCOME_TARGET?(received/MONTHLY_INCOME_TARGET)*100:0;
      const card1=received>=MONTHLY_INCOME_TARGET
        ?`<article class="card alert-card"><h4>Target Achieved</h4><p>Monthly income target reached.</p><div class="row"><span class="badge success">${fmt(received)} received</span><span class="chip">Target: ${fmt(MONTHLY_INCOME_TARGET)}</span></div></article>`
        :pct>=80
        ?`<article class="card alert-card warning"><h4>Almost There — ${pct.toFixed(0)}%</h4><p>Close to monthly target.</p><div class="row"><span class="badge warning">${fmt(received)} received</span><span class="chip">${fmt(MONTHLY_INCOME_TARGET-received)} remaining</span></div></article>`
        :`<article class="card alert-card"><h4>On Track — ${pct.toFixed(0)}%</h4><p>Keep tracking all income sources.</p><div class="row"><span class="badge success">${fmt(received)} received</span><span class="chip">${fmt(MONTHLY_INCOME_TARGET-received)} remaining</span></div></article>`;
      const card2=`<article class="card alert-card ${pending>0?"warning":""}"><h4>Pending Income</h4><p>${pending>0?"Pending entries may increase totals.":"No pending income."}</p><div class="row"><span class="badge ${pending>0?"warning":"success"}">${fmt(pending)} pending</span><span class="chip">Target: ${fmt(MONTHLY_INCOME_TARGET)}</span></div></article>`;
      document.getElementById("alertGrid").innerHTML=card1+card2;
    }

    function renderSourceCards(){
      const sums=sumBySource(currentMonthIncomes(incomes));
      document.getElementById("sourceGrid").innerHTML=["Salary","Freelance","Investments","Refunds","Other"].map(src=>{
        const received=sums[src]||0; const target=SOURCE_TARGETS[src]||0;
        const pct=target?(received/target)*100:0;
        const barClass=pct<50?"danger":pct<85?"warning":"";
        return`<article class="card source-card"><div class="source-top"><div><p class="source-name">${src}</p><p class="source-amt">${fmt(received)} received</p></div><div class="source-icon">${SOURCE_ICONS[src]||"•"}</div></div><div class="progress ${barClass}"><i style="width:${clamp(pct,0,160)}%;"></i></div><div class="source-meta"><span>${pct.toFixed(0)}% of target</span><span>${target?fmt(Math.max(0,target-received))+" to go":"No target"}</span></div></article>`;
      }).join("");
    }

    function renderCharts(){
      const mt=monthly6(incomes);
      trendChart.data.labels=mt.keys.map(k=>{ const[y,m]=k.split("-"); return monthLabel(new Date(Number(y),Number(m)-1,1)); });
      trendChart.data.datasets[0].data=mt.values;
      trendChart.update();
      const sums=sumBySource(currentMonthIncomes(incomes));
      sourceChart.data.datasets[0].data=sourceChart.data.labels.map(l=>Number((sums[l]||0).toFixed(2)));
      sourceChart.update();
    }

    function updateSortIndicators(){ ["date","title","source","amount"].forEach(id=>{ const el=document.getElementById("sort-"+id); if(el) el.textContent=state.sort.key!==id?"↕":state.sort.dir==="asc"?"↑":"↓"; }); }

    function renderPager(page,totalPages){ const mkBtn=(label,p,disabled=false,active=false)=>`<button class="page-btn ${active?"active":""}" type="button" data-page="${p}" ${disabled?"disabled":""}>${label}</button>`; let html=mkBtn("Prev",Math.max(1,page-1),page===1); for(let p=1;p<=totalPages;p++) html+=mkBtn(String(p),p,false,p===page); html+=mkBtn("Next",Math.min(totalPages,page+1),page===totalPages); document.getElementById("pager").innerHTML=html; }

    function renderTable(){
      const filtered=applyFilters(incomes); const sorted=sortList(filtered);
      const{pageItems,totalItems,totalPages,start}=paginate(sorted);
      document.getElementById("resultsChip").textContent=`${totalItems} result${totalItems===1?"":"s"}`;
      const empty=document.getElementById("emptyState"); const tableWrap=document.getElementById("tableWrap");
      if(totalItems===0){ empty.classList.add("show"); tableWrap.style.display="none"; document.getElementById("pageInfo").textContent="Showing 0–0 of 0"; renderPager(1,1); return; }
      empty.classList.remove("show"); tableWrap.style.display="block";
      document.getElementById("incomeTbody").innerHTML=pageItems.map(e=>`
        <tr>
          <td>${e.date}</td>
          <td>${escapeHtml(e.title)}</td>
          <td>${escapeHtml(e.source)}</td>
          <td class="amount">${fmt(e.amount)}</td>
          <td><div class="actions">
            <button class="link-btn" type="button" data-action="view" data-id="${e.id}">View</button>
            <button class="link-btn" type="button" data-action="edit" data-id="${e.id}">Edit</button>
            <button class="link-btn danger" type="button" data-action="delete" data-id="${e.id}">Delete</button>
          </div></td>
        </tr>`).join("");
      document.getElementById("pageInfo").textContent=`Showing ${start+1}–${start+pageItems.length} of ${totalItems}`;
      renderPager(state.page,totalPages);
    }

    function rerenderAll(){ renderMonthChip(); renderSummary(); renderAlerts(); renderSourceCards(); renderCharts(); updateSortIndicators(); renderTable(); }

    // Modal
    let modalMode="add";
    const modalOverlay=document.getElementById("modalOverlay");
    const form=document.getElementById("incomeForm");
    const fields={ id:document.getElementById("incomeId"), title:document.getElementById("incomeTitle"), amount:document.getElementById("incomeAmount"), source:document.getElementById("incomeSource"), date:document.getElementById("incomeDate"), notes:document.getElementById("incomeNotes") };

    function openModal(mode,income=null){
      modalMode=mode;
      document.getElementById("modalTitle").textContent=mode==="add"?"Add Income":mode==="edit"?"Edit Income":"View Income";
      document.getElementById("saveIncome").style.display=mode==="view"?"none":"inline-flex";
      if(mode==="add"){ form.reset(); fields.id.value=""; fields.date.value=new Date().toISOString().slice(0,10); }
      else if(income){ fields.id.value=income.id; fields.title.value=income.title; fields.amount.value=income.amount; fields.source.value=income.source; fields.date.value=income.date; fields.notes.value=income.note||""; }
      form.querySelectorAll(".control").forEach(el=>el.disabled=mode==="view");
      modalOverlay.classList.add("open");
    }

    function closeModal(){ modalOverlay.classList.remove("open"); }

    function saveFromModal(){
      if(!form.reportValidity()) return;
      const id=fields.id.value;
      document.getElementById("formMethod").value=id?"PUT":"POST";
      form.action=id?`/income/${id}`:"/income";
      form.submit();
    }

    // Events
    document.getElementById("hamburger")?.addEventListener("click",()=>document.body.classList.toggle("sidebar-open"));
    document.getElementById("sidebarOverlay")?.addEventListener("click",()=>document.body.classList.remove("sidebar-open"));
    document.getElementById("globalSearch").addEventListener("input",e=>{ state.searchGlobal=e.target.value; state.page=1; renderTable(); });
    document.getElementById("tableSearch").addEventListener("input",e=>{ state.searchTable=e.target.value; state.page=1; renderTable(); });
    document.getElementById("toggleFilters").addEventListener("click",()=>document.getElementById("filtersPanel").classList.toggle("open"));
    document.getElementById("applyFilters").addEventListener("click",()=>{ state.filters.source=document.getElementById("filterSource").value; state.filters.dateFrom=document.getElementById("filterDateFrom").value; state.filters.dateTo=document.getElementById("filterDateTo").value; state.filters.amountMin=document.getElementById("filterAmountMin").value; state.filters.amountMax=document.getElementById("filterAmountMax").value; state.page=1; renderTable(); });
    document.getElementById("clearAll").addEventListener("click",()=>{ state.searchGlobal=""; state.searchTable=""; state.filters={source:"",dateFrom:"",dateTo:"",amountMin:"",amountMax:""}; state.page=1; document.getElementById("globalSearch").value=""; document.getElementById("tableSearch").value=""; renderTable(); });
    document.querySelectorAll("thead th[data-sort]").forEach(th=>th.addEventListener("click",()=>{ const key=th.getAttribute("data-sort"); if(state.sort.key===key) state.sort.dir=state.sort.dir==="asc"?"desc":"asc"; else{ state.sort.key=key; state.sort.dir="asc"; } updateSortIndicators(); renderTable(); }));
    document.getElementById("pager").addEventListener("click",e=>{ const btn=e.target.closest("button[data-page]"); if(btn){ state.page=Number(btn.dataset.page); renderTable(); } });
    document.getElementById("incomeTbody").addEventListener("click",e=>{ const btn=e.target.closest("button[data-action]"); if(!btn) return; const action=btn.dataset.action; const id=btn.dataset.id; const income=incomes.find(x=>String(x.id)===String(id)); if(action==="view") openModal("view",income); if(action==="edit") openModal("edit",income); if(action==="delete"){ if(confirm("Delete this income entry?")){ const f=document.createElement("form"); f.method="POST"; f.action=`/income/${id}`; f.innerHTML=`<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`; document.body.appendChild(f); f.submit(); } } });
    document.getElementById("openAddModal").addEventListener("click",()=>openModal("add"));
    document.getElementById("emptyAddBtn").addEventListener("click",()=>openModal("add"));
    document.getElementById("closeModal").addEventListener("click",closeModal);
    document.getElementById("cancelModal").addEventListener("click",closeModal);
    document.getElementById("saveIncome").addEventListener("click",saveFromModal);
    modalOverlay.addEventListener("click",e=>{ if(e.target===modalOverlay) closeModal(); });
    window.addEventListener("keydown",e=>{ if(e.key==="Escape") closeModal(); });

    buildCharts();
    rerenderAll();
  </script>
</body>
</html>