<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Debts • Finova</title>
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
      width:38px; height:38px; border-radius:12px;
      background: linear-gradient(135deg, rgba(79,70,229,1), rgba(37,99,235,1));
      display:grid; place-items:center;
      color:white; font-weight:800;
      box-shadow: 0 14px 30px rgba(79,70,229,.25);
    }
    .brand-text strong{ display:block; color:white; font-size:14px; letter-spacing:-.2px; }
    .brand-text span{ display:block; color:var(--sidebar-muted); font-size:12px; margin-top:2px; }

    .nav{ display:flex; flex-direction:column; gap:6px; padding:6px; }
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
      width:20px; height:20px;
      display:grid; place-items:center;
      border-radius:8px;
      background: rgba(255,255,255,.06);
      border:1px solid rgba(255,255,255,.08);
      font-size:12px;
      flex:0 0 auto;
    }
    .nav .label{ font-size:13px; font-weight:600; }

    .sidebar-footer{
      position:absolute;
      bottom:14px; left:14px; right:14px;
      padding:12px;
      border-radius:14px;
      background: rgba(255,255,255,.05);
      border:1px solid rgba(255,255,255,.10);
      color: rgba(255,255,255,.85);
    }
    .sidebar-footer .small{
      margin-top:6px;
      font-size:12px;
      color:var(--sidebar-muted);
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
      gap:14px;
      margin-bottom:14px;
    }
    .title-block h1{ margin:0; font-size:22px; letter-spacing:-.3px; }
    .title-block p{ margin:6px 0 0; color:var(--muted); font-size:13px; }

    .header-actions{
      display:flex;
      align-items:center;
      gap:10px;
      flex-wrap:wrap;
      justify-content:flex-end;
    }

    .search{
      position:relative;
      min-width:280px;
      max-width:420px;
      width:40vw;
    }
    .search input{
      width:100%;
      height:44px;
      padding:10px 12px 10px 40px;
      border-radius:12px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.82);
      outline:none;
      transition: box-shadow var(--t), border-color var(--t), background var(--t);
    }
    .search input:focus{
      border-color: rgba(79,70,229,.35);
      box-shadow: var(--ring);
      background:#fff;
    }
    .search .mag{
      position:absolute; left:12px; top:50%;
      transform: translateY(-50%);
      color: rgba(15,23,42,.55);
      font-size:14px;
      pointer-events:none;
    }

    .btn{
      height:44px;
      padding:0 12px;
      border-radius:12px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.85);
      color: var(--text);
      cursor:pointer;
      display:inline-flex;
      align-items:center;
      gap:8px;
      transition: transform var(--t), box-shadow var(--t), background var(--t), border-color var(--t);
      box-shadow: 0 1px 0 rgba(15,23,42,.03);
      font-weight:600;
      font-size:13px;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow2); }
    .btn-primary{
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      border-color: rgba(79,70,229,.35);
      color:#fff;
      box-shadow: 0 16px 30px rgba(79,70,229,.18);
    }

    /* Card / section */
    .card{
      background: var(--card-bg);
      border:1px solid var(--card-stroke);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
    }
    .card:hover{ border-color: rgba(15,23,42,.14); }

    .section{ margin-top:14px; }
    .section-title{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:10px;
      margin-bottom:10px;
    }
    .section-title h2{ margin:0; font-size:14px; letter-spacing:-.2px; }
    .section-title p{ margin:4px 0 0; font-size:12px; color:var(--muted); }
    .chip{
      font-size:12px;
      color: rgba(15,23,42,.70);
      border:1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.03);
      padding:6px 10px;
      border-radius:999px;
      white-space:nowrap;
    }

    /* Summary cards */
    .summary-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0,1fr));
      gap:12px;
    }
    .summary-card{
      padding:14px;
      display:flex;
      flex-direction:column;
      gap:10px;
      transition: transform var(--t), box-shadow var(--t);
    }
    .summary-card:hover{ transform: translateY(-2px); box-shadow: 0 18px 40px rgba(15,23,42,.10); }
    .summary-top{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
    }
    .summary-top .meta span{
      display:block;
      font-size:12px;
      color:var(--muted);
    }
    .summary-top .meta strong{
      display:block;
      margin-top:4px;
      font-size:18px;
      letter-spacing:-.3px;
    }
    .badge{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding:6px 10px;
      border-radius:999px;
      font-size:12px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.03);
      color: rgba(15,23,42,.75);
    }
    .badge.success{ background: rgba(16,185,129,.10); border-color: rgba(16,185,129,.25); color: rgba(6,95,70,.95); }
    .badge.warning{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.28); color: rgba(120,53,15,.95); }
    .badge.danger{ background: rgba(239,68,68,.10); border-color: rgba(239,68,68,.25); color: rgba(127,29,29,.95); }

    .summary-foot{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      font-size:12px;
      color:var(--muted);
    }

    /* Alerts */
    .alerts-grid{
      display:grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap:12px;
    }
    .alert-card{
      padding:14px;
      border-left:5px solid rgba(245,158,11,.9);
      background: linear-gradient(180deg, rgba(245,158,11,.06), rgba(255,255,255,1));
    }
    .alert-card.danger{
      border-left-color: rgba(239,68,68,.9);
      background: linear-gradient(180deg, rgba(239,68,68,.06), rgba(255,255,255,1));
    }
    .alert-card.success{
      border-left-color: rgba(16,185,129,.9);
      background: linear-gradient(180deg, rgba(16,185,129,.06), rgba(255,255,255,1));
    }
    .alert-card h4{ margin:0; font-size:13px; letter-spacing:-.2px; }
    .alert-card p{ margin:6px 0 0; font-size:12px; color:var(--muted); line-height:1.35; }
    .alert-card .row{
      margin-top:10px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      flex-wrap:wrap;
    }

    /* Analytics */
    .analytics-grid{
      display:grid;
      grid-template-columns: 2fr 1fr;
      gap:12px;
      align-items:stretch;
    }
    .analytics-grid2{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:12px;
      margin-top:12px;
    }
    .card-head{
      padding:14px 14px 0;
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:10px;
    }
    .card-head h3{ margin:0; font-size:14px; letter-spacing:-.2px; }
    .card-head p{ margin:4px 0 0; font-size:12px; color:var(--muted); }
    .canvas-wrap{ padding:10px 14px 14px; height:320px; }

    /* Debt cards */
    .debt-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0,1fr));
      gap:12px;
    }
    .debt-card{
      padding:14px;
      transition: transform var(--t), box-shadow var(--t);
    }
    .debt-card:hover{ transform: translateY(-2px); box-shadow: 0 18px 40px rgba(15,23,42,.10); }
    .debt-top{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:10px;
      margin-bottom:10px;
    }
    .debt-name{
      margin:0;
      font-size:13px;
      font-weight:800;
      letter-spacing:-.1px;
      line-height:1.2;
    }
    .debt-sub{
      margin:4px 0 0;
      font-size:12px;
      color:var(--muted);
    }
    .debt-icon{
      width:40px; height:40px;
      border-radius:14px;
      display:grid; place-items:center;
      background: rgba(239,68,68,.10);
      border:1px solid rgba(239,68,68,.16);
      color: rgba(127,29,29,.95);
      font-weight:800;
      flex:0 0 auto;
    }
    .progress{
      height:10px;
      border-radius:999px;
      background: rgba(15,23,42,.06);
      border:1px solid rgba(15,23,42,.08);
      overflow:hidden;
    }
    .progress > i{
      display:block;
      height:100%;
      width:0%;
      border-radius:999px;
      background: linear-gradient(90deg, rgba(239,68,68,1), rgba(245,158,11,1));
      transition: width 560ms cubic-bezier(.2,.8,.2,1);
    }
    .progress.success > i{ background: linear-gradient(90deg, rgba(16,185,129,1), rgba(79,70,229,1)); }
    .progress.warning > i{ background: linear-gradient(90deg, rgba(245,158,11,1), rgba(239,68,68,1)); }

    .debt-meta{
      margin-top:10px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      font-size:12px;
      color:var(--muted);
      flex-wrap:wrap;
    }

    /* Table */
    .table-card{ padding:14px; }
    .table-toolbar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      flex-wrap:wrap;
      margin-bottom:10px;
    }
    .toolbar-left{
      display:flex;
      align-items:center;
      gap:10px;
      flex-wrap:wrap;
      flex:1;
      min-width:260px;
    }
    .toolbar-right{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; }

    .filters-panel{
      display:none;
      margin:10px 0 0;
      padding:12px;
      border-radius:14px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.02);
    }
    .filters-panel.open{ display:block; }

    .filter-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0,1fr));
      gap:10px;
    }
    .field label{
      display:block;
      font-size:12px;
      color: rgba(15,23,42,.70);
      margin-bottom:6px;
      font-weight:600;
    }
    .control{
      width:100%;
      height:42px;
      border-radius:12px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.92);
      padding:0 10px;
      outline:none;
      transition: box-shadow var(--t), border-color var(--t);
    }
    .control:focus{
      border-color: rgba(79,70,229,.35);
      box-shadow: var(--ring);
      background:#fff;
    }

    .table-wrap{
      overflow:auto;
      border-radius:14px;
      border:1px solid rgba(15,23,42,.08);
    }
    table{
      width:100%;
      border-collapse:collapse;
      min-width: 1150px;
      background:#fff;
    }
    thead th{
      position:sticky;
      top:0;
      z-index:1;
      text-align:left;
      font-size:12px;
      letter-spacing:.2px;
      color: rgba(15,23,42,.70);
      background: rgba(15,23,42,.03);
      border-bottom:1px solid rgba(15,23,42,.08);
      padding:12px 10px;
      white-space:nowrap;
      cursor:pointer;
      user-select:none;
    }
    thead th .sort{ margin-left:6px; font-size:11px; color: rgba(15,23,42,.45); }
    tbody td{
      font-size:12.5px;
      color: rgba(15,23,42,.90);
      border-bottom:1px solid rgba(15,23,42,.06);
      padding:12px 10px;
      vertical-align:middle;
      white-space:nowrap;
    }
    tbody tr:hover td{ background: rgba(239,68,68,.04); }

    .amount{
      text-align:right;
      font-variant-numeric: tabular-nums;
      font-weight:800;
    }

    .pill{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:6px 10px;
      border-radius:999px;
      font-size:12px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.02);
    }
    .dot{
      width:8px; height:8px;
      border-radius:50%;
      background: rgba(15,23,42,.35);
    }
    .pill.ok{
      background: rgba(16,185,129,.10);
      border-color: rgba(16,185,129,.22);
      color: rgba(6,95,70,.95);
    }
    .pill.ok .dot{ background: rgba(16,185,129,1); }
    .pill.due{
      background: rgba(245,158,11,.12);
      border-color: rgba(245,158,11,.25);
      color: rgba(120,53,15,.95);
    }
    .pill.due .dot{ background: rgba(245,158,11,1); }
    .pill.late{
      background: rgba(239,68,68,.10);
      border-color: rgba(239,68,68,.25);
      color: rgba(127,29,29,.95);
    }
    .pill.late .dot{ background: rgba(239,68,68,1); }

    .actions{
      display:flex;
      gap:8px;
      justify-content:flex-end;
    }
    .link-btn{
      border:1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.90);
      height:34px;
      padding:0 10px;
      border-radius:10px;
      cursor:pointer;
      font-size:12px;
      font-weight:600;
      transition: transform var(--t), box-shadow var(--t);
    }
    .link-btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(15,23,42,.10); }
    .link-btn.danger{
      border-color: rgba(239,68,68,.25);
      background: rgba(239,68,68,.06);
      color: rgba(127,29,29,.95);
    }

    .pagination{
      margin-top:12px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      flex-wrap:wrap;
    }
    .pager{ display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .page-btn{
      height:36px;
      padding:0 10px;
      border-radius:10px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.9);
      cursor:pointer;
      transition: transform var(--t), box-shadow var(--t);
      font-weight:600;
      font-size:12px;
    }
    .page-btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(15,23,42,.10); }
    .page-btn.active{
      border-color: rgba(239,68,68,.35);
      background: rgba(239,68,68,.10);
      color: rgba(127,29,29,.95);
    }
    .page-info{ font-size:12px; color:var(--muted); }

    /* Empty */
    .empty{
      display:none;
      padding:24px;
      text-align:center;
      border-radius: var(--radius);
      border:1px dashed rgba(15,23,42,.18);
      background: rgba(255,255,255,.70);
    }
    .empty.show{ display:block; }
    .empty h3{ margin:10px 0 0; font-size:16px; letter-spacing:-.2px; }
    .empty p{ margin:6px 0 14px; color:var(--muted); font-size:13px; }

    /* Modal */
    .modal-overlay{
      position:fixed;
      inset:0;
      background: rgba(2,6,23,.55);
      display:none;
      align-items:center;
      justify-content:center;
      padding:16px;
      z-index:90;
    }
    .modal-overlay.open{ display:flex; }
    .modal{
      width:780px;
      max-width:100%;
      background:#fff;
      border-radius:16px;
      border:1px solid rgba(255,255,255,.25);
      box-shadow: 0 30px 80px rgba(2,6,23,.35);
      overflow:hidden;
    }
    .modal-head{
      padding:14px 14px 0;
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:10px;
    }
    .modal-head h3{ margin:0; font-size:16px; letter-spacing:-.2px; }
    .modal-head p{ margin:6px 0 0; color:var(--muted); font-size:12px; }
    .modal-close{
      width:40px; height:40px;
      border-radius:12px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.03);
      cursor:pointer;
      transition: transform var(--t), box-shadow var(--t);
    }
    .modal-close:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(15,23,42,.12); }
    .modal-body{ padding:12px 14px 14px; }
    .form-grid{
      display:grid;
      grid-template-columns: repeat(2, minmax(0,1fr));
      gap:10px;
    }
    .field textarea{ height:92px; padding:10px; }
    .field .hint{ margin-top:6px; font-size:12px; color:var(--muted); }
    .modal-foot{
      padding:12px 14px 14px;
      display:flex;
      justify-content:flex-end;
      gap:10px;
      border-top:1px solid rgba(15,23,42,.08);
      background: rgba(15,23,42,.02);
    }

    /* Toast */
    .toast{
      position: fixed;
      right: 18px;
      bottom: 18px;
      max-width: 360px;
      background: rgba(15,23,42,.96);
      color: rgba(255,255,255,.92);
      border: 1px solid rgba(255,255,255,.12);
      border-radius: 14px;
      padding: 12px 12px;
      box-shadow: 0 30px 70px rgba(2,6,23,.35);
      opacity: 0;
      transform: translateY(10px);
      pointer-events:none;
      transition: opacity var(--t), transform var(--t);
      z-index: 120;
    }
    .toast.show{ opacity: 1; transform: translateY(0); }
    .toast .t-title{ font-weight: 800; font-size: 13px; }
    .toast .t-sub{ margin-top: 4px; color: rgba(255,255,255,.72); font-size: 12px; line-height:1.35; }

    /* Responsive */
    .mobile-bar{ display:none; align-items:center; gap:10px; margin-bottom:12px; }
    .hamburger{
      display:none;
      width:44px; height:44px;
      border-radius:12px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.90);
      cursor:pointer;
      transition: transform var(--t), box-shadow var(--t);
    }
    .hamburger:hover{ transform: translateY(-1px); box-shadow: var(--shadow2); }
    .sidebar-overlay{
      position:fixed;
      inset:0;
      background: rgba(2,6,23,.45);
      display:none;
      z-index:35;
    }
    body.sidebar-open .sidebar-overlay{ display:block; }

    @media (max-width: 1200px){
      .summary-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
      .analytics-grid{ grid-template-columns:1fr; }
      .analytics-grid2{ grid-template-columns:1fr; }
      .debt-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
      .alerts-grid{ grid-template-columns:1fr; }
      .filter-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
      .search{ width:52vw; }
    }
    @media (max-width: 900px){
      .main{ margin-left:0; }
      .sidebar{
        transform: translateX(-110%);
        transition: transform var(--t);
        width:290px;
      }
      body.sidebar-open .sidebar{ transform: translateX(0); }
      .hamburger{ display:inline-flex; align-items:center; justify-content:center; }
      .mobile-bar{ display:flex; }
      .top-header{ flex-direction:column; align-items:stretch; }
      .header-actions{ justify-content:space-between; }
      .search{ width:100%; min-width:0; max-width:none; }
    }
    @media (max-width: 520px){
      .summary-grid{ grid-template-columns:1fr; }
      .debt-grid{ grid-template-columns:1fr; }
      .form-grid{ grid-template-columns:1fr; }
      .filter-grid{ grid-template-columns:1fr; }
      .btn, .btn-primary{ width:100%; justify-content:center; }
      .header-actions{ flex-direction:column; align-items:stretch; }
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
        <div style="font-weight:800;">Debts</div>
      </div>

      <header class="top-header">
        <div class="title-block">
          <h1>Debts</h1>
          <p>Track loans, repayment plans, due dates and payoff projections</p>
        </div>
        <div class="header-actions">
          <div class="search">
            <span class="mag">⌕</span>
            <input id="globalSearch" type="search" placeholder="Search lender, debt type, status…" />
          </div>
          <button class="btn" id="toggleFilters">Filter</button>
          <button class="btn btn-primary" id="openAddModal">＋ Add Debt</button>
        </div>
      </header>

      <section class="section">
        <div class="section-title">
          <div><h2>Debt Summary</h2><p>Outstanding balance and repayment overview</p></div>
          <span class="chip">{{ date('F Y') }}</span>
        </div>
        <div class="summary-grid" id="summaryGrid"></div>
      </section>

      <section class="section">
        <div class="section-title">
          <div><h2>Payment Alerts</h2><p>Upcoming due dates and overdue payments</p></div>
        </div>
        <div class="alerts-grid" id="alertsGrid"></div>
      </section>

      <section class="section">
        <div class="section-title">
          <div><h2>Debt Analytics</h2><p>Debt trend, payoff projection and type breakdown</p></div>
        </div>
        <div class="analytics-grid">
          <article class="card">
            <div class="card-head">
              <div><h3>Debt Balance Trend</h3><p>Last 6 months total balance</p></div>
              <span class="chip">Line</span>
            </div>
            <div class="canvas-wrap"><canvas id="debtTrendChart"></canvas></div>
          </article>
          <article class="card">
            <div class="card-head">
              <div><h3>Debt Types</h3><p>Outstanding by type</p></div>
              <span class="chip">Doughnut</span>
            </div>
            <div class="canvas-wrap"><canvas id="debtTypesChart"></canvas></div>
          </article>
        </div>
        <div class="analytics-grid2">
          <article class="card">
            <div class="card-head">
              <div><h3>Payoff Projection</h3><p>Estimated remaining months</p></div>
              <span class="chip">Bar</span>
            </div>
            <div class="canvas-wrap"><canvas id="payoffChart"></canvas></div>
          </article>
          <article class="card">
            <div class="card-head">
              <div><h3>Interest Rates</h3><p>APR comparison by debt</p></div>
              <span class="chip">Bar</span>
            </div>
            <div class="canvas-wrap"><canvas id="aprChart"></canvas></div>
          </article>
        </div>
      </section>

      <section class="section">
        <div class="section-title">
          <div><h2>Active Debts</h2><p>Progress bars and payoff status</p></div>
        </div>
        <div class="debt-grid" id="debtGrid"></div>
      </section>

      <section class="section">
        <article class="card table-card">
          <div class="table-toolbar">
            <div class="toolbar-left">
              <div class="search" style="max-width:420px;">
                <span class="mag">⌕</span>
                <input id="tableSearch" type="search" placeholder="Search debts…" />
              </div>
              <button class="btn" id="clearAll">Clear</button>
            </div>
            <div class="toolbar-right">
              <span class="chip" id="resultsChip">0 results</span>
            </div>
          </div>

          <div class="filters-panel" id="filtersPanel">
            <div class="filter-grid">
              <div class="field">
                <label>Debt Type</label>
                <select id="filterType" class="control">
                  <option value="">All</option>
                  <option>Credit Card</option>
                  <option>Student Loan</option>
                  <option>Mortgage</option>
                  <option>Personal Loan</option>
                  <option>Auto Loan</option>
                </select>
              </div>
              <div class="field">
                <label>Status</label>
                <select id="filterStatus" class="control">
                  <option value="">All</option>
                  <option>On track</option>
                  <option>Due soon</option>
                  <option>Overdue</option>
                </select>
              </div>
              <div class="field">
                <label>Min Balance</label>
                <input id="filterMinBalance" class="control" type="number" placeholder="0" />
              </div>
              <div class="field">
                <label>Max Balance</label>
                <input id="filterMaxBalance" class="control" type="number" placeholder="50000" />
              </div>
              <div class="field">
                <label>&nbsp;</label>
                <button class="btn btn-primary" id="applyFilters">Apply Filters</button>
              </div>
            </div>
          </div>

          <div class="empty" id="emptyState">
            <h3>No debts added yet</h3>
            <p>Add your first debt to start tracking payoff and schedules.</p>
            <button class="btn btn-primary" id="emptyAddBtn">＋ Add Debt</button>
          </div>

          <div class="table-wrap" id="tableWrap">
            <table>
              <thead>
                <tr>
                  <th data-sort="name">Debt <span class="sort" id="sort-name">↕</span></th>
                  <th data-sort="type">Type <span class="sort" id="sort-type">↕</span></th>
                  <th data-sort="balance" style="text-align:right;">Balance <span class="sort" id="sort-balance">↕</span></th>
                  <th data-sort="apr" style="text-align:right;">APR <span class="sort" id="sort-apr">↕</span></th>
                  <th data-sort="minPayment" style="text-align:right;">Min Payment <span class="sort" id="sort-minPayment">↕</span></th>
                  <th data-sort="nextDueDate">Next Due <span class="sort" id="sort-nextDueDate">↕</span></th>
                  <th data-sort="status">Status <span class="sort" id="sort-status">↕</span></th>
                  <th style="text-align:right;">Actions</th>
                </tr>
              </thead>
              <tbody id="debtsTbody"></tbody>
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
          <h3 id="modalTitle">Add Debt</h3>
          <p id="modalSubtitle">Record a new debt account</p>
        </div>
        <button class="modal-close" id="closeModal">✕</button>
      </div>

      <form class="modal-body" id="debtForm" method="POST">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">
        <input type="hidden" name="id" id="debtId">

        <div class="form-grid">
          <div class="field">
            <label>Debt Name</label>
            <input id="debtName" name="title" class="control" type="text" placeholder="e.g., Visa Card" required />
          </div>
          <div class="field">
            <label>Debt Type</label>
            <select id="debtType" name="type" class="control" required>
              <option value="" disabled selected>Select type</option>
              <option>Credit Card</option>
              <option>Student Loan</option>
              <option>Mortgage</option>
              <option>Personal Loan</option>
              <option>Auto Loan</option>
            </select>
          </div>
          <div class="field">
            <label>Total Amount</label>
            <input id="totalAmount" name="total_amount" class="control" type="number" min="0" step="0.01" placeholder="0.00" required />
          </div>
          <div class="field">
            <label>Paid Amount</label>
            <input id="paidAmount" name="paid_amount" class="control" type="number" min="0" step="0.01" placeholder="0.00" />
          </div>
          <div class="field">
            <label>Interest Rate (APR %)</label>
            <input id="interestRate" name="interest_rate" class="control" type="number" min="0" step="0.01" placeholder="0.00" />
          </div>
          <div class="field">
            <label>Due Date</label>
            <input id="dueDate" name="due_date" class="control" type="date" />
          </div>
        </div>
      </form>

      <div class="modal-foot">
        <button class="btn" id="cancelModal">Cancel</button>
        <button class="btn btn-primary" id="saveDebt">Save Debt</button>
      </div>
    </div>
  </div>

  <script>
    let debts = {!! json_encode($debts->map(fn($d) => [
        'id'          => $d->id,
        'name'        => $d->title,
        'type'        => $d->type,
        'balance'     => (float)($d->total_amount - $d->paid_amount),
        'total'       => (float)$d->total_amount,
        'paid'        => (float)$d->paid_amount,
        'apr'         => (float)($d->interest_rate ?? 0),
        'minPayment'  => (float)($d->total_amount * 0.03),
        'nextDueDate' => $d->due_date ?? date('Y-m-d'),
        'status'      => 'On track',
        'monthsLeft'  => max(0, round(($d->total_amount - $d->paid_amount) / max(1, $d->total_amount * 0.03))),
        'notes'       => '',
    ])) !!};

    const TODAY = new Date();

    const debtTrend = {
      labels: ["Jan","Feb","Mar","Apr","May","Jun"],
      values: [25500,24800,23950,23100,22400,21650]
    };

    const state = {
      searchGlobal:"", searchTable:"",
      filters:{ type:"", status:"", minBalance:"", maxBalance:"" },
      sort:{ key:"balance", dir:"desc" },
      page:1, pageSize:6
    };

    const fmt = (n) => new Intl.NumberFormat("en-US",{style:"currency",currency:"USD"}).format(n);
    const clamp = (n,a,b) => Math.max(a,Math.min(b,n));
    function escapeHtml(str){ return String(str).replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;"); }
    function daysUntil(dateStr){ const d=new Date(dateStr+"T00:00:00"); const t=new Date(TODAY.toISOString().slice(0,10)+"T00:00:00"); return Math.round((d-t)/(1000*60*60*24)); }
    function pillClass(status){ if(status==="On track") return "ok"; if(status==="Due soon") return "due"; return "late"; }
    function progressClass(d){ return d.status==="Overdue"||d.status==="Due soon"?"warning":"success"; }

    function enrich(list){
      return list.map(d=>{ const urgency=daysUntil(d.nextDueDate); const paidPct=d.total?clamp((d.paid/d.total)*100,0,100):0; return{...d,urgency,paidPct}; });
    }

    let debtTrendChart, debtTypesChart, payoffChart, aprChart;

    function buildCharts(){
      debtTrendChart = new Chart(document.getElementById("debtTrendChart"),{
        type:"line",
        data:{ labels:[], datasets:[{ data:[], borderColor:"rgba(239,68,68,1)", backgroundColor:"rgba(239,68,68,.12)", fill:true, tension:0.35, borderWidth:2 }] },
        options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{ x:{grid:{color:"rgba(15,23,42,.06)"},ticks:{color:"rgba(15,23,42,.65)"}}, y:{grid:{color:"rgba(15,23,42,.06)"},ticks:{color:"rgba(15,23,42,.65)",callback:(v)=>"$"+v}} } }
      });
      debtTypesChart = new Chart(document.getElementById("debtTypesChart"),{
        type:"doughnut",
        data:{ labels:["Credit Card","Student Loan","Mortgage","Personal Loan","Auto Loan"], datasets:[{ data:[0,0,0,0,0], backgroundColor:["rgba(239,68,68,.82)","rgba(79,70,229,.82)","rgba(37,99,235,.78)","rgba(245,158,11,.82)","rgba(100,116,139,.70)"], borderColor:"rgba(255,255,255,.95)", borderWidth:2 }] },
        options:{ responsive:true, maintainAspectRatio:false, cutout:"62%", plugins:{ legend:{ position:"bottom", labels:{ color:"rgba(15,23,42,.70)", padding:14, boxWidth:10, usePointStyle:true } } } }
      });
      payoffChart = new Chart(document.getElementById("payoffChart"),{
        type:"bar",
        data:{ labels:[], datasets:[{ label:"Months left", data:[], backgroundColor:"rgba(239,68,68,.20)", borderColor:"rgba(239,68,68,.55)", borderWidth:1, borderRadius:10 }] },
        options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{ x:{grid:{color:"rgba(15,23,42,.06)"},ticks:{color:"rgba(15,23,42,.65)"}}, y:{grid:{color:"rgba(15,23,42,.06)"},ticks:{color:"rgba(15,23,42,.65)"}} } }
      });
      aprChart = new Chart(document.getElementById("aprChart"),{
        type:"bar",
        data:{ labels:[], datasets:[{ label:"APR %", data:[], backgroundColor:"rgba(245,158,11,.22)", borderColor:"rgba(245,158,11,.55)", borderWidth:1, borderRadius:10 }] },
        options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{ x:{grid:{color:"rgba(15,23,42,.06)"},ticks:{color:"rgba(15,23,42,.65)"}}, y:{grid:{color:"rgba(15,23,42,.06)"},ticks:{color:"rgba(15,23,42,.65)",callback:(v)=>v+"%"}} } }
      });
    }

    function renderCharts(){
      debtTrendChart.data.labels=debtTrend.labels;
      debtTrendChart.data.datasets[0].data=debtTrend.values;
      debtTrendChart.update();
      const list=enrich(debts);
      const byType={}; list.forEach(d=>{byType[d.type]=(byType[d.type]||0)+d.balance;});
      debtTypesChart.data.datasets[0].data=debtTypesChart.data.labels.map(l=>Math.round(byType[l]||0));
      debtTypesChart.update();
      payoffChart.data.labels=list.map(d=>d.name);
      payoffChart.data.datasets[0].data=list.map(d=>Number(d.monthsLeft||0));
      payoffChart.update();
      aprChart.data.labels=list.map(d=>d.name);
      aprChart.data.datasets[0].data=list.map(d=>Number(d.apr||0));
      aprChart.update();
    }

    function renderSummary(){
      const list=enrich(debts);
      const totalBalance=list.reduce((a,b)=>a+b.balance,0);
      const avgApr=list.length?(list.reduce((a,b)=>a+b.apr,0)/list.length):0;
      const totalMinPay=list.reduce((a,b)=>a+b.minPayment,0);
      const overdueCount=list.filter(d=>d.status==="Overdue").length;
      const mostExp=list.slice().sort((a,b)=>b.apr-a.apr)[0];
      document.getElementById("summaryGrid").innerHTML=`
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Total Outstanding</span><strong>${fmt(totalBalance)}</strong></div><span class="badge danger">Debt</span></div><div class="summary-foot"><span>Accounts</span><span>${list.length}</span></div></article>
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Monthly Minimum</span><strong>${fmt(totalMinPay)}</strong></div><span class="badge warning">Payments</span></div><div class="summary-foot"><span>Due dates</span><span>Tracked</span></div></article>
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Average APR</span><strong>${avgApr.toFixed(2)}%</strong></div><span class="badge ${avgApr>15?"danger":"warning"}">${avgApr>15?"High":"Moderate"}</span></div><div class="summary-foot"><span>Highest APR</span><span>${mostExp?mostExp.name:"—"}</span></div></article>
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Overdue Accounts</span><strong>${overdueCount}</strong></div><span class="badge ${overdueCount?"danger":"success"}">${overdueCount?"Action":"Good"}</span></div><div class="summary-foot"><span>Priority</span><span>${overdueCount?"Pay now":"On track"}</span></div></article>`;
    }

    function renderAlerts(){
      const list=enrich(debts);
      const overdue=list.filter(d=>d.status==="Overdue");
      const dueSoon=list.filter(d=>d.status==="Due soon");
      const cards=[];
      if(overdue.length){ const d=overdue[0]; cards.push(`<article class="card alert-card danger"><h4>Overdue Payment</h4><p><strong>${escapeHtml(d.name)}</strong> is overdue. Pay ASAP.</p><div class="row"><span class="badge danger">Due: ${d.nextDueDate}</span><span class="chip">Min: ${fmt(d.minPayment)}</span></div></article>`); }
      if(dueSoon.length){ const d=dueSoon[0]; cards.push(`<article class="card alert-card"><h4>Payment Due Soon</h4><p><strong>${escapeHtml(d.name)}</strong> is due soon.</p><div class="row"><span class="badge warning">${daysUntil(d.nextDueDate)} day(s) left</span><span class="chip">Min: ${fmt(d.minPayment)}</span></div></article>`); }
      if(!cards.length){ cards.push(`<article class="card alert-card success"><h4>No Payment Alerts</h4><p>All debts on track.</p><div class="row"><span class="badge success">All good</span><span class="chip">Snowball/Avalanche</span></div></article>`); cards.push(`<article class="card alert-card success"><h4>Strategy Suggestion</h4><p>Pay extra toward highest APR debt to reduce interest.</p><div class="row"><span class="badge success">Avalanche</span><span class="chip">Lower interest</span></div></article>`); }
      else if(cards.length===1){ cards.push(`<article class="card alert-card success"><h4>Automation Tip</h4><p>Enable auto-pay for minimum payments.</p><div class="row"><span class="badge success">Auto-pay</span><span class="chip">Reduce risk</span></div></article>`); }
      document.getElementById("alertsGrid").innerHTML=cards.slice(0,2).join("");
    }

    function renderDebtCards(){
      const list=enrich(debts).slice().sort((a,b)=>b.balance-a.balance);
      document.getElementById("debtGrid").innerHTML=list.map(d=>`
        <article class="card debt-card">
          <div class="debt-top">
            <div><p class="debt-name">${escapeHtml(d.name)}</p><p class="debt-sub">${escapeHtml(d.type)} • APR ${d.apr.toFixed(2)}%</p></div>
            <div class="debt-icon">D</div>
          </div>
          <div class="progress ${progressClass(d)}"><i style="width:${d.paidPct.toFixed(0)}%;"></i></div>
          <div class="debt-meta"><span>Balance: <strong>${fmt(d.balance)}</strong></span><span>${d.paidPct.toFixed(0)}% paid</span></div>
          <div class="debt-meta" style="margin-top:6px;"><span>Due: <strong>${d.nextDueDate}</strong></span><span>${d.urgency<0?Math.abs(d.urgency)+" day(s) late":d.urgency+" day(s) left"}</span></div>
          <div class="debt-meta" style="margin-top:6px;"><span>Min: <strong>${fmt(d.minPayment)}</strong></span><span class="pill ${pillClass(d.status)}"><span class="dot"></span>${escapeHtml(d.status)}</span></div>
        </article>`).join("");
    }

    function applyAllFilters(list){
      const q=(state.searchGlobal||state.searchTable||"").trim().toLowerCase();
      const f=state.filters;
      return enrich(list).filter(d=>{
        if(q&&!`${d.name} ${d.type} ${d.status}`.toLowerCase().includes(q)) return false;
        if(f.type&&d.type!==f.type) return false;
        if(f.status&&d.status!==f.status) return false;
        if(f.minBalance!==""&&d.balance<Number(f.minBalance)) return false;
        if(f.maxBalance!==""&&d.balance>Number(f.maxBalance)) return false;
        return true;
      });
    }

    function sortList(list){ const{key,dir}=state.sort; const sign=dir==="asc"?1:-1; return[...list].sort((a,b)=>{ let av=a[key],bv=b[key]; if(key==="nextDueDate"){av=new Date(a.nextDueDate).getTime();bv=new Date(b.nextDueDate).getTime();} if(typeof av==="string") return sign*av.localeCompare(bv); return sign*(Number(av)-Number(bv)); }); }
    function paginate(list){ const total=list.length; const pages=Math.max(1,Math.ceil(total/state.pageSize)); state.page=clamp(state.page,1,pages); const start=(state.page-1)*state.pageSize; return{pageItems:list.slice(start,start+state.pageSize),totalItems:total,totalPages:pages,start}; }
    function updateSortIndicators(){ ["name","type","balance","apr","minPayment","nextDueDate","status"].forEach(id=>{ const el=document.getElementById("sort-"+id); if(el) el.textContent=state.sort.key!==id?"↕":state.sort.dir==="asc"?"↑":"↓"; }); }
    function renderPager(page,totalPages){ const mkBtn=(label,p,disabled=false,active=false)=>`<button class="page-btn ${active?"active":""}" type="button" data-page="${p}" ${disabled?"disabled":""}>${label}</button>`; let html=mkBtn("Prev",Math.max(1,page-1),page===1); for(let p=1;p<=totalPages;p++) html+=mkBtn(String(p),p,false,p===page); html+=mkBtn("Next",Math.min(totalPages,page+1),page===totalPages); document.getElementById("pager").innerHTML=html; }

    function renderTable(){
      const filtered=applyAllFilters(debts); const sorted=sortList(filtered);
      const{pageItems,totalItems,totalPages,start}=paginate(sorted);
      document.getElementById("resultsChip").textContent=`${totalItems} result${totalItems===1?"":"s"}`;
      const empty=document.getElementById("emptyState"); const tableWrap=document.getElementById("tableWrap");
      if(totalItems===0){ empty.classList.add("show"); tableWrap.style.display="none"; document.getElementById("pageInfo").textContent="Showing 0–0 of 0"; renderPager(1,1); return; }
      empty.classList.remove("show"); tableWrap.style.display="block";
      document.getElementById("debtsTbody").innerHTML=pageItems.map(d=>`
        <tr>
          <td>${escapeHtml(d.name)}</td>
          <td>${escapeHtml(d.type)}</td>
          <td class="amount">${fmt(d.balance)}</td>
          <td class="amount">${d.apr.toFixed(2)}%</td>
          <td class="amount">${fmt(d.minPayment)}</td>
          <td>${d.nextDueDate}</td>
          <td><span class="pill ${pillClass(d.status)}"><span class="dot"></span>${escapeHtml(d.status)}</span></td>
          <td><div class="actions">
            <button class="link-btn" type="button" data-action="view" data-id="${d.id}">View</button>
            <button class="link-btn" type="button" data-action="edit" data-id="${d.id}">Edit</button>
            <button class="link-btn danger" type="button" data-action="delete" data-id="${d.id}">Delete</button>
          </div></td>
        </tr>`).join("");
      document.getElementById("pageInfo").textContent=`Showing ${start+1}–${start+pageItems.length} of ${totalItems}`;
      renderPager(state.page,totalPages);
    }

    function rerenderAll(){ renderSummary(); renderAlerts(); renderCharts(); renderDebtCards(); updateSortIndicators(); renderTable(); }

    // Modal
    let modalMode="add";
    const modalOverlay=document.getElementById("modalOverlay");
    const form=document.getElementById("debtForm");
    const fields={ id:document.getElementById("debtId"), name:document.getElementById("debtName"), type:document.getElementById("debtType"), totalAmount:document.getElementById("totalAmount"), paidAmount:document.getElementById("paidAmount"), interestRate:document.getElementById("interestRate"), dueDate:document.getElementById("dueDate") };

    function openModal(mode,debt=null){
      modalMode=mode;
      document.getElementById("modalTitle").textContent=mode==="add"?"Add Debt":mode==="edit"?"Edit Debt":"View Debt";
      document.getElementById("saveDebt").style.display=mode==="view"?"none":"inline-flex";
      if(mode==="add"){ form.reset(); fields.id.value=""; }
      else if(debt){ fields.id.value=debt.id; fields.name.value=debt.name; fields.type.value=debt.type; fields.totalAmount.value=debt.total; fields.paidAmount.value=debt.paid; fields.interestRate.value=debt.apr; fields.dueDate.value=debt.nextDueDate; }
      form.querySelectorAll(".control").forEach(el=>el.disabled=mode==="view");
      modalOverlay.classList.add("open");
    }

    function closeModal(){ modalOverlay.classList.remove("open"); }

    function saveFromModal(){
      if(!form.reportValidity()) return;
      const id=fields.id.value;
      document.getElementById("formMethod").value=id?"PUT":"POST";
      form.action=id?`/debts/${id}`:"/debts";
      form.submit();
    }

    // Events
    document.getElementById("hamburger")?.addEventListener("click",()=>document.body.classList.toggle("sidebar-open"));
    document.getElementById("sidebarOverlay")?.addEventListener("click",()=>document.body.classList.remove("sidebar-open"));
    document.getElementById("globalSearch").addEventListener("input",e=>{ state.searchGlobal=e.target.value; state.page=1; renderTable(); });
    document.getElementById("tableSearch").addEventListener("input",e=>{ state.searchTable=e.target.value; state.page=1; renderTable(); });
    document.getElementById("toggleFilters").addEventListener("click",()=>document.getElementById("filtersPanel").classList.toggle("open"));
    document.getElementById("applyFilters").addEventListener("click",()=>{ state.filters.type=document.getElementById("filterType").value; state.filters.status=document.getElementById("filterStatus").value; state.filters.minBalance=document.getElementById("filterMinBalance").value; state.filters.maxBalance=document.getElementById("filterMaxBalance").value; state.page=1; renderTable(); });
    document.getElementById("clearAll").addEventListener("click",()=>{ state.searchGlobal=""; state.searchTable=""; state.filters={type:"",status:"",minBalance:"",maxBalance:""}; state.page=1; document.getElementById("globalSearch").value=""; document.getElementById("tableSearch").value=""; renderTable(); });
    document.querySelectorAll("thead th[data-sort]").forEach(th=>th.addEventListener("click",()=>{ const key=th.getAttribute("data-sort"); if(state.sort.key===key) state.sort.dir=state.sort.dir==="asc"?"desc":"asc"; else{ state.sort.key=key; state.sort.dir="asc"; } updateSortIndicators(); renderTable(); }));
    document.getElementById("pager").addEventListener("click",e=>{ const btn=e.target.closest("button[data-page]"); if(btn){ state.page=Number(btn.dataset.page); renderTable(); } });
    document.getElementById("debtsTbody").addEventListener("click",e=>{ const btn=e.target.closest("button[data-action]"); if(!btn) return; const action=btn.dataset.action; const id=btn.dataset.id; const debt=debts.find(x=>String(x.id)===String(id)); if(action==="view") openModal("view",debt); if(action==="edit") openModal("edit",debt); if(action==="delete"){ if(confirm("Delete this debt?")){ const f=document.createElement("form"); f.method="POST"; f.action=`/debts/${id}`; f.innerHTML=`<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`; document.body.appendChild(f); f.submit(); } } });
    document.getElementById("openAddModal").addEventListener("click",()=>openModal("add"));
    document.getElementById("emptyAddBtn").addEventListener("click",()=>openModal("add"));
    document.getElementById("closeModal").addEventListener("click",closeModal);
    document.getElementById("cancelModal").addEventListener("click",closeModal);
    document.getElementById("saveDebt").addEventListener("click",saveFromModal);
    modalOverlay.addEventListener("click",e=>{ if(e.target===modalOverlay) closeModal(); });
    window.addEventListener("keydown",e=>{ if(e.key==="Escape") closeModal(); });

    buildCharts();
    rerenderAll();
  </script>
</body>
</html>