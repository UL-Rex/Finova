<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Goals • Personal Finance Dashboard</title>

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
    .search input:focus{
      border-color: rgba(79,70,229,.35);
      box-shadow: var(--ring);
      background:#fff;
    }
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
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:10px;
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
      border-left: 5px solid rgba(79,70,229,.9);
      background: linear-gradient(180deg, rgba(79,70,229,.06), rgba(255,255,255,1));
    }
    .alert-card.warning{
      border-left-color: rgba(245,158,11,.9);
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

    /* Goal cards */
    .goals-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 12px;
    }
    .goal-card{
      padding: 14px;
      transition: transform var(--t), box-shadow var(--t);
    }
    .goal-card:hover{ transform: translateY(-2px); box-shadow: 0 18px 40px rgba(15,23,42,.10); }
    .goal-top{
      display:flex; align-items:flex-start; justify-content:space-between; gap:10px;
      margin-bottom: 10px;
    }
    .goal-icon{
      width:40px; height:40px;
      border-radius: 14px;
      display:grid; place-items:center;
      background: rgba(79,70,229,.10);
      border: 1px solid rgba(79,70,229,.16);
      color: rgba(79,70,229,1);
      font-weight: 800;
      flex: 0 0 auto;
    }
    .goal-name{
      margin:0;
      font-size: 13px;
      font-weight: 800;
      letter-spacing:-.1px;
      line-height: 1.2;
    }
    .goal-sub{
      margin: 4px 0 0;
      font-size: 12px;
      color: var(--muted);
    }

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
      background: linear-gradient(90deg, rgba(79,70,229,1), rgba(37,99,235,1));
      transition: width 560ms cubic-bezier(.2,.8,.2,1);
    }
    .progress.success > i{ background: linear-gradient(90deg, rgba(16,185,129,1), rgba(37,99,235,1)); }
    .progress.warning > i{ background: linear-gradient(90deg, rgba(245,158,11,1), rgba(37,99,235,1)); }
    .progress.danger > i{ background: linear-gradient(90deg, rgba(239,68,68,1), rgba(245,158,11,1)); }

    .goal-meta{
      margin-top: 10px;
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      flex-wrap: wrap;
      font-size: 12px;
      color: var(--muted);
    }
    .meta-strong{ color: rgba(15,23,42,.88); font-weight: 700; }

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
      min-width: 1100px;
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
    thead th .sort{
      margin-left: 6px;
      font-size: 11px;
      color: rgba(15,23,42,.45);
    }
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
    .status.active{ background: rgba(79,70,229,.10); border-color: rgba(79,70,229,.20); color: rgba(49,46,129,.95); }
    .status.active .dot{ background: rgba(79,70,229,1); }
    .status.completed{ background: rgba(16,185,129,.10); border-color: rgba(16,185,129,.22); color: rgba(6,95,70,.95); }
    .status.completed .dot{ background: rgba(16,185,129,1); }
    .status.atrisk{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.25); color: rgba(120,53,15,.95); }
    .status.atrisk .dot{ background: rgba(245,158,11,1); }
    .status.overdue{ background: rgba(239,68,68,.10); border-color: rgba(239,68,68,.25); color: rgba(127,29,29,.95); }
    .status.overdue .dot{ background: rgba(239,68,68,1); }

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

    .toggle{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      padding: 10px 12px;
      border-radius: 12px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.02);
      height: 42px;
    }
    .toggle span{ font-size: 12px; color: rgba(15,23,42,.75); font-weight: 700; }
    .toggle input{ width: 18px; height: 18px; }

    .modal-foot{
      padding: 12px 14px 14px;
      display:flex;
      justify-content:flex-end;
      gap: 10px;
      border-top: 1px solid rgba(15,23,42,.08);
      background: rgba(15,23,42,.02);
    }

    /* Responsive */
    .mobile-bar{ display:none; align-items:center; gap: 10px; margin-bottom: 12px; }
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
      .goals-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
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
      .goals-grid{ grid-template-columns: 1fr; }
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

      <!-- Mobile bar -->
      <div class="mobile-bar">
        <button class="hamburger" id="hamburger" aria-label="Open sidebar">☰</button>
        <div style="font-weight:800; letter-spacing:-.2px;">Goals</div>
      </div>

      <!-- Top Header -->
      <header class="top-header">
        <div class="title-block">
          <h1>Goals</h1>
          <p>Set, track, and achieve your savings goals</p>
        </div>

        <div class="header-actions" aria-label="Header actions">
          <div class="search" role="search">
            <span class="mag">⌕</span>
            <label class="sr-only" for="globalSearch">Search goals</label>
            <input id="globalSearch" type="search" placeholder="Search goals, type, status…" />
          </div>

          <button class="btn" id="toggleFilters" type="button" aria-expanded="false">
            <span>⏷</span> Filter
          </button>

          <button class="btn btn-primary" id="openAddModal" type="button">
            <span>＋</span> Add Goal
          </button>
        </div>
      </header>

      <!-- Summary -->
      <section class="section" aria-labelledby="summaryTitle">
        <div class="section-title">
          <div>
            <h2 id="summaryTitle">Goals Summary</h2>
            <p>Performance overview (this month)</p>
          </div>
          <span class="chip" id="monthChip">Month</span>
        </div>
        <div class="summary-grid" id="summaryGrid"></div>
      </section>

      <!-- Alerts -->
      <section class="section" aria-labelledby="alertsTitle">
        <div class="section-title">
          <div>
            <h2 id="alertsTitle">Goal Alerts</h2>
            <p>Highlights for at-risk and completed goals</p>
          </div>
        </div>
        <div class="alert-grid" id="alertGrid"></div>
      </section>

      <!-- Analytics -->
      <section class="section" aria-labelledby="analyticsTitle">
        <div class="section-title">
          <div>
            <h2 id="analyticsTitle">Goal Analytics</h2>
            <p>Progress trend and goal type distribution</p>
          </div>
        </div>

        <div class="analytics-grid">
          <article class="card" aria-label="Savings progress trend chart">
            <div class="card-head">
              <div>
                <h3>Savings Progress Trend</h3>
                <p>Total saved across goals (last 6 months)</p>
              </div>
              <span class="chip">Line</span>
            </div>
            <div class="canvas-wrap">
              <canvas id="trendChart"></canvas>
            </div>
          </article>

          <article class="card" aria-label="Goal types chart">
            <div class="card-head">
              <div>
                <h3>Goal Types</h3>
                <p>Share by saved amount</p>
              </div>
              <span class="chip">Doughnut</span>
            </div>
            <div class="canvas-wrap">
              <canvas id="typesChart"></canvas>
            </div>
          </article>
        </div>
      </section>

      <!-- Goal Cards -->
      <section class="section" aria-labelledby="goalsGridTitle">
        <div class="section-title">
          <div>
            <h2 id="goalsGridTitle">Active Goals</h2>
            <p>Progress bars and timelines</p>
          </div>
          <span class="chip">Progress</span>
        </div>

        <div class="goals-grid" id="goalsGrid"></div>
      </section>

      <!-- Table -->
      <section class="section" aria-labelledby="recentGoalsTitle">
        <div class="section-title">
          <div>
            <h2 id="recentGoalsTitle">Goals</h2>
            <p>Search, filter, sort and manage goals</p>
          </div>
        </div>

        <article class="card table-card">
          <div class="table-toolbar">
            <div class="toolbar-left">
              <div class="search" style="max-width:420px; width: min(520px, 100%);">
                <span class="mag">⌕</span>
                <label class="sr-only" for="tableSearch">Search in table</label>
                <input id="tableSearch" type="search" placeholder="Search goals in table…" />
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
                <label for="filterType">Type</label>
                <select id="filterType" class="control">
                  <option value="">All</option>
                  <option>Emergency Fund</option>
                  <option>Vacation</option>
                  <option>Debt Payoff</option>
                  <option>Education</option>
                  <option>Purchase</option>
                  <option>Other</option>
                </select>
              </div>

              <div class="field">
                <label for="filterStatus">Status</label>
                <select id="filterStatus" class="control">
                  <option value="">All</option>
                  <option>Active</option>
                  <option>At risk</option>
                  <option>Overdue</option>
                  <option>Completed</option>
                </select>
              </div>

              <div class="field">
                <label for="filterPriority">Priority</label>
                <select id="filterPriority" class="control">
                  <option value="">All</option>
                  <option>Low</option>
                  <option>Medium</option>
                  <option>High</option>
                </select>
              </div>

              <div class="field">
                <label for="filterTargetFrom">Target date (from)</label>
                <input id="filterTargetFrom" class="control" type="date" />
              </div>

              <div class="field">
                <label for="filterTargetTo">Target date (to)</label>
                <input id="filterTargetTo" class="control" type="date" />
              </div>

              <div class="field">
                <label for="filterMinTarget">Min target</label>
                <input id="filterMinTarget" class="control" type="number" min="0" step="0.01" placeholder="0" />
              </div>

              <div class="field">
                <label for="filterMaxTarget">Max target</label>
                <input id="filterMaxTarget" class="control" type="number" min="0" step="0.01" placeholder="20000" />
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
                  <stop offset="1" stop-color="#10b981" stop-opacity="0.10"/>
                </linearGradient>
              </defs>
              <rect x="34" y="28" width="452" height="244" rx="22" fill="url(#g)" stroke="rgba(15,23,42,.10)"/>
              <rect x="70" y="70" width="380" height="30" rx="10" fill="rgba(255,255,255,.85)"/>
              <rect x="70" y="120" width="260" height="24" rx="10" fill="rgba(255,255,255,.78)"/>
              <rect x="70" y="156" width="320" height="24" rx="10" fill="rgba(255,255,255,.72)"/>
              <rect x="70" y="192" width="220" height="24" rx="10" fill="rgba(255,255,255,.68)"/>
              <circle cx="414" cy="146" r="44" fill="rgba(16,185,129,.14)" stroke="rgba(16,185,129,.22)"/>
              <path d="M402 146h24M414 134v24" stroke="rgba(16,185,129,.90)" stroke-width="6" stroke-linecap="round"/>
            </svg>
            <h3>No goals created yet</h3>
            <p>Create your first goal to start tracking progress.</p>
            <button class="btn btn-primary" id="emptyAddBtn" type="button">＋ Add Goal</button>
          </div>

          <div class="table-wrap" id="tableWrap">
            <table aria-label="Goals table">
              <thead>
                <tr>
                  <th data-sort="createdDate">Created <span class="sort" id="sort-createdDate">↕</span></th>
                  <th data-sort="title">Goal <span class="sort" id="sort-title">↕</span></th>
                  <th data-sort="type">Type <span class="sort" id="sort-type">↕</span></th>
                  <th data-sort="priority">Priority <span class="sort" id="sort-priority">↕</span></th>
                  <th data-sort="target" style="text-align:right;">Target <span class="sort" id="sort-target">↕</span></th>
                  <th data-sort="saved" style="text-align:right;">Saved <span class="sort" id="sort-saved">↕</span></th>
                  <th data-sort="progress" style="text-align:right;">Progress <span class="sort" id="sort-progress">↕</span></th>
                  <th data-sort="targetDate">Target Date <span class="sort" id="sort-targetDate">↕</span></th>
                  <th data-sort="status">Status <span class="sort" id="sort-status">↕</span></th>
                  <th style="text-align:right;">Actions</th>
                </tr>
              </thead>
              <tbody id="goalsTbody"></tbody>
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

  <!-- Add/Edit/View Modal -->
  <div class="modal-overlay" id="modalOverlay" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
      <div class="modal-head">
        <div>
          <h3 id="modalTitle">Add Goal</h3>
          <p id="modalSubtitle">Create a new financial goal</p>
        </div>
        <button class="modal-close" id="closeModal" type="button" aria-label="Close">✕</button>
      </div>

      <form class="modal-body" id="goalForm" method="POST">
  @csrf
  <input type="hidden" name="_method" id="formMethod" value="POST">
  <input type="hidden" name="id" id="goalId">

        <div class="form-grid">
          <div class="field">
            <label for="goalTitle">Goal Title</label>
            <input id="goalTitle" name="title" class="control" type="text" placeholder="e.g., Emergency Fund" required />
          </div>

          <div class="field">
            <label for="goalType">Goal Type</label>
            <select id="goalType" class="control" required>
              <option value="" disabled selected>Select type</option>
              <option>Emergency Fund</option>
              <option>Vacation</option>
              <option>Debt Payoff</option>
              <option>Education</option>
              <option>Purchase</option>
              <option>Other</option>
            </select>
          </div>

          <div class="field">
            <label for="goalTarget">Target Amount</label>
            <input id="goalTarget" name="target_amount" class="control" type="number" min="0" step="0.01" placeholder="0.00" required />
          </div>

          <div class="field">
            <label for="goalSaved">Current Saved</label>
            <input id="goalSaved" name="saved_amount" class="control" type="number" min="0" step="0.01" placeholder="0.00" />
          </div>

          <div class="field">
            <label for="goalPriority">Priority</label>
            <select id="goalPriority" class="control" required>
              <option>Low</option>
              <option selected>Medium</option>
              <option>High</option>
            </select>
          </div>

          <div class="field">
            <label for="goalStatus">Status</label>
            <select id="goalStatus" class="control" required>
              <option>Active</option>
              <option>At risk</option>
              <option>Overdue</option>
              <option>Completed</option>
            </select>
          </div>

          <div class="field">
            <label for="goalStartDate">Start Date</label>
            <input id="goalStartDate" class="control" type="date" required />
          </div>

          <div class="field">
            <label for="goalTargetDate">Target Date</label>
            <input id="goalTargetDate" name="deadline" class="control" type="date" required />
          </div>

          <div class="field" style="grid-column: 1 / -1;">
            <label>Auto-save</label>
            <div class="toggle">
              <span>Enable auto-save for this goal</span>
              <input id="goalAutoSave" type="checkbox" />
            </div>
            <div class="hint">Demo toggle (in MVC you can store this preference).</div>
          </div>

          <div class="field" style="grid-column: 1 / -1;">
            <label for="goalNotes">Notes</label>
            <textarea id="goalNotes" name="note" class="control" placeholder="Optional notes (plan, milestones, etc.)"></textarea>
            <div class="hint">Goal setting supports both short-term and long-term timelines.</div>
          </div>
        </div>
      </form>

      <div class="modal-foot">
        <button class="btn" id="cancelModal" type="button">Cancel</button>
        <button class="btn btn-primary" id="saveGoal" type="button">Save Goal</button>
      </div>
    </div>
  </div>

  <script>
    // ---------------------------
    // Dummy data + state
    // ---------------------------
    const TODAY = new Date("2026-06-06T12:00:00"); // fixed for consistent demo

    const TYPE_ICONS = {
      "Emergency Fund": "E",
      "Vacation": "V",
      "Debt Payoff": "D",
      "Education": "Ed",
      "Purchase": "P",
      "Other": "O"
    };

    let goals = {!! json_encode($goals->map(fn($g) => [
    'id'          => $g->id,
    'createdDate' => substr($g->created_at, 0, 10),
    'title'       => $g->title,
    'type'        => 'Other',
    'target'      => (float)$g->target_amount,
    'saved'       => (float)$g->saved_amount,
    'startDate'   => substr($g->created_at, 0, 10),
    'targetDate'  => $g->deadline ?? date('Y-m-d', strtotime('+90 days')),
    'priority'    => 'Medium',
    'status'      => 'Active',
    'autoSave'    => false,
    'notes'       => $g->note ?? '',
])) !!};

    const state = {
      searchGlobal: "",
      searchTable: "",
      filters: {
        type: "",
        status: "",
        priority: "",
        targetFrom: "",
        targetTo: "",
        minTarget: "",
        maxTarget: ""
      },
      sort: { key: "targetDate", dir: "asc" },
      page: 1,
      pageSize: 7
    };

    const fmt = (n) => new Intl.NumberFormat("en-US", { style:"currency", currency:"USD" }).format(n);
    const clamp = (n,a,b) => Math.max(a, Math.min(b,n));
    const parseDate = (s) => new Date(s + "T00:00:00");
    const daysBetween = (a,b) => Math.round((b.getTime() - a.getTime()) / (1000*60*60*24));

    function goalProgress(g){
      const target = Math.max(0, Number(g.target || 0));
      const saved = Math.max(0, Number(g.saved || 0));
      return target ? (saved/target)*100 : 0;
    }

    function normalizeStatus(g){
      // Keep user-selected status, but ensure "Overdue" if target date passed and not completed
      const td = parseDate(g.targetDate);
      const overdue = td < new Date(TODAY.toISOString().slice(0,10) + "T00:00:00");
      const pct = goalProgress(g);

      if (g.status === "Completed" || pct >= 100) return "Completed";
      if (overdue) return "Overdue";
      return g.status || "Active";
    }

    function statusClass(status){
      if (status === "Completed") return "completed";
      if (status === "Overdue") return "overdue";
      if (status === "At risk") return "atrisk";
      return "active";
    }

    function barClass(status, pct){
      if (status === "Completed" || pct >= 100) return "success";
      if (status === "Overdue") return "danger";
      if (status === "At risk") return "warning";
      return "";
    }

    function enrich(list){
      return list.map(g => {
        const progress = goalProgress(g);
        const status = normalizeStatus(g);
        const dLeft = daysBetween(TODAY, parseDate(g.targetDate));
        return { ...g, progress, status, daysLeft: dLeft };
      });
    }

    // ---------------------------
    // Charts
    // ---------------------------
    let trendChart, typesChart;

    function buildCharts(){
      trendChart = new Chart(document.getElementById("trendChart"), {
        type: "line",
        data: {
          labels: [],
          datasets: [{
            label: "Total Saved",
            data: [],
            borderColor: "rgba(79,70,229,1)",
            backgroundColor: "rgba(79,70,229,.14)",
            fill: true,
            tension: 0.35,
            pointRadius: 3,
            pointHoverRadius: 5,
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: { mode: "index", intersect: false },
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: "rgba(15,23,42,.96)",
              borderColor: "rgba(255,255,255,.14)",
              borderWidth: 1,
              padding: 12,
              callbacks: { label: (ctx) => ` ${fmt(ctx.parsed.y)}` }
            }
          },
          scales: {
            x: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color: "rgba(15,23,42,.65)" } },
            y: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color: "rgba(15,23,42,.65)", callback: (v) => "$" + v } }
          }
        }
      });

      typesChart = new Chart(document.getElementById("typesChart"), {
        type: "doughnut",
        data: {
          labels: ["Emergency Fund","Vacation","Debt Payoff","Education","Purchase","Other"],
          datasets: [{
            data: [0,0,0,0,0,0],
            backgroundColor: [
              "rgba(79,70,229,.88)",
              "rgba(37,99,235,.82)",
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
      // Trend: dummy 6-month cumulative savings snapshot
      const months = ["Jan","Feb","Mar","Apr","May","Jun"];
      // Build a simple upward series based on current total saved (demo)
      const totalSavedNow = enrich(goals).reduce((a,g)=>a + Math.min(g.saved, g.target), 0);
      const base = Math.max(0, totalSavedNow - 2400);
      const series = [base, base+350, base+740, base+1100, base+1680, totalSavedNow].map(x => Math.round(x));
      trendChart.data.labels = months;
      trendChart.data.datasets[0].data = series;
      trendChart.update();

      // Types breakdown by saved (cap at target)
      const list = enrich(goals);
      const sums = {};
      for (const g of list){
        const key = g.type;
        const val = Math.min(g.saved, g.target);
        sums[key] = (sums[key] || 0) + val;
      }
      const labels = typesChart.data.labels;
      typesChart.data.datasets[0].data = labels.map(l => Number((sums[l] || 0).toFixed(2)));
      typesChart.update();
    }

    // ---------------------------
    // Summary + Alerts + Cards
    // ---------------------------
    function renderMonthChip(){
      document.getElementById("monthChip").textContent =
        TODAY.toLocaleString("en-US", { month:"long", year:"numeric" });
    }

    function renderSummary(){
      const list = enrich(goals);
      const totalGoals = list.length;
      const completed = list.filter(g => g.status === "Completed").length;
      const active = list.filter(g => g.status !== "Completed").length;

      const totalSaved = list.reduce((a,g)=>a + Math.max(0, g.saved), 0);
      const totalTarget = list.reduce((a,g)=>a + Math.max(0, g.target), 0);
      const avgProgress = totalTarget ? (totalSaved/totalTarget)*100 : 0;

      const nearest = list
        .filter(g => g.status !== "Completed")
        .slice()
        .sort((a,b)=>a.daysLeft - b.daysLeft)[0];

      const nearestText = nearest
        ? `${nearest.title} (${nearest.daysLeft >= 0 ? nearest.daysLeft + "d left" : "overdue"})`
        : "—";

      document.getElementById("summaryGrid").innerHTML = `
        <article class="card summary-card" aria-label="Total goals">
          <div class="summary-top">
            <div class="meta">
              <span>Total Goals</span>
              <strong>${totalGoals}</strong>
            </div>
            <span class="badge">${active} active</span>
          </div>
          <div class="summary-foot">
            <span>Tracking</span>
            <span>${completed} completed</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Total saved">
          <div class="summary-top">
            <div class="meta">
              <span>Total Saved</span>
              <strong>${fmt(totalSaved)}</strong>
            </div>
            <span class="badge success">Savings</span>
          </div>
          <div class="summary-foot">
            <span>Total target</span>
            <span>${fmt(totalTarget)}</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Average progress">
          <div class="summary-top">
            <div class="meta">
              <span>Average Progress</span>
              <strong>${avgProgress.toFixed(0)}%</strong>
            </div>
            <span class="badge ${avgProgress >= 70 ? "success" : (avgProgress >= 40 ? "warning" : "danger")}">
              ${avgProgress >= 70 ? "On track" : (avgProgress >= 40 ? "Needs focus" : "At risk")}
            </span>
          </div>
          <div class="summary-foot">
            <span>Across all goals</span>
            <span>Progress</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Nearest target">
          <div class="summary-top">
            <div class="meta">
              <span>Nearest Target</span>
              <strong style="font-size:14px; line-height:1.2;">${escapeHtml(nearestText)}</strong>
            </div>
            <span class="badge">Timeline</span>
          </div>
          <div class="summary-foot">
            <span>Next due</span>
            <span>${nearest ? escapeHtml(nearest.targetDate) : "—"}</span>
          </div>
        </article>
      `;
    }

    function renderAlerts(){
      const list = enrich(goals);
      const completed = list.filter(g => g.status === "Completed");
      const overdue = list.filter(g => g.status === "Overdue");
      const atRisk = list.filter(g => g.status === "At risk");

      const cards = [];

      if (overdue.length){
        const g = overdue.slice().sort((a,b)=>a.daysLeft - b.daysLeft)[0];
        cards.push(`
          <article class="card alert-card danger" aria-label="Overdue goal alert">
            <h4>Overdue Goal</h4>
            <p><strong>${escapeHtml(g.title)}</strong> is overdue. Review timeline or increase contributions to catch up.</p>
            <div class="row">
              <span class="badge danger">${Math.min(100, g.progress).toFixed(0)}% progress</span>
              <span class="chip">Target: ${fmt(g.target)} • Saved: ${fmt(g.saved)}</span>
            </div>
          </article>
        `);
      }

      if (atRisk.length){
        const g = atRisk.slice().sort((a,b)=>a.daysLeft - b.daysLeft)[0];
        cards.push(`
          <article class="card alert-card warning" aria-label="At-risk goal alert">
            <h4>At-risk Goal</h4>
            <p><strong>${escapeHtml(g.title)}</strong> needs attention. Consider enabling auto-save or adjusting the target date.</p>
            <div class="row">
              <span class="badge warning">${g.daysLeft >= 0 ? g.daysLeft + " days left" : "overdue"}</span>
              <span class="chip">${fmt(g.target - g.saved)} remaining</span>
            </div>
          </article>
        `);
      }

      if (completed.length){
        const g = completed[0];
        cards.push(`
          <article class="card alert-card success" aria-label="Completed goal">
            <h4>Completed Goal</h4>
            <p>Great job! <strong>${escapeHtml(g.title)}</strong> is completed. You can create a new goal or reallocate savings.</p>
            <div class="row">
              <span class="badge success">Completed</span>
              <span class="chip">Target: ${fmt(g.target)}</span>
            </div>
          </article>
        `);
      }

      if (cards.length === 0){
        cards.push(`
          <article class="card alert-card success" aria-label="All goals healthy">
            <h4>All Goals Healthy</h4>
            <p>No goals are currently at risk or overdue. Keep consistent contributions to maintain progress.</p>
            <div class="row">
              <span class="badge success">No alerts</span>
              <span class="chip">Review weekly</span>
            </div>
          </article>
        `);
        cards.push(`
          <article class="card alert-card" aria-label="Suggestion">
            <h4>Suggestion</h4>
            <p>Create short-term goals (1–3 months) and long-term goals (6–12+ months) for better planning.</p>
            <div class="row">
              <span class="badge">Planning</span>
              <span class="chip">Short + Long term</span>
            </div>
          </article>
        `);
      } else if (cards.length === 1){
        cards.push(`
          <article class="card alert-card" aria-label="Tip">
            <h4>Tip</h4>
            <p>Split large goals into milestones (e.g., 25%, 50%, 75%) to stay motivated.</p>
            <div class="row">
              <span class="badge">Milestones</span>
              <span class="chip">Better tracking</span>
            </div>
          </article>
        `);
      }

      document.getElementById("alertGrid").innerHTML = cards.slice(0,2).join("");
    }

    function renderGoalCards(){
      const list = enrich(goals).slice().sort((a,b)=>a.daysLeft - b.daysLeft);
      const grid = document.getElementById("goalsGrid");

      grid.innerHTML = list.map(g => {
        const pct = clamp(g.progress, 0, 120);
        const cls = barClass(g.status, g.progress);
        const status = g.status;
        const daysText = g.daysLeft >= 0 ? `${g.daysLeft} days left` : `${Math.abs(g.daysLeft)} days overdue`;

        return `
          <article class="card goal-card" aria-label="${escapeHtml(g.title)} goal">
            <div class="goal-top">
              <div style="min-width:0;">
                <p class="goal-name" title="${escapeHtml(g.title)}">${escapeHtml(g.title)}</p>
                <p class="goal-sub">${escapeHtml(g.type)} • Target: ${fmt(g.target)}</p>
              </div>
              <div class="goal-icon" title="${escapeHtml(g.type)}">${escapeHtml(TYPE_ICONS[g.type] || "G")}</div>
            </div>

            <div class="progress ${cls}">
              <i style="width:${pct}%;"></i>
            </div>

            <div class="goal-meta">
              <span><span class="meta-strong">${fmt(g.saved)}</span> saved</span>
              <span>${Math.min(100, g.progress).toFixed(0)}%</span>
            </div>

            <div class="goal-meta" style="margin-top:6px;">
              <span>Target: <span class="meta-strong">${escapeHtml(g.targetDate)}</span></span>
              <span class="badge ${status === "Completed" ? "success" : (status === "Overdue" ? "danger" : (status === "At risk" ? "warning" : ""))}">
                ${escapeHtml(status)}
              </span>
            </div>

            <div class="goal-meta" style="margin-top:6px;">
              <span>${escapeHtml(daysText)}</span>
              <span>${g.autoSave ? "Auto-save on" : "Auto-save off"}</span>
            </div>
          </article>
        `;
      }).join("");
    }

    // ---------------------------
    // Table (filter/sort/pagination)
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

      return enrich(list).filter(g => {
        if (q){
          const hay = `${g.title} ${g.type} ${g.status} ${g.priority}`.toLowerCase();
          if (!hay.includes(q)) return false;
        }

        if (f.type && g.type !== f.type) return false;
        if (f.status && g.status !== f.status) return false;
        if (f.priority && g.priority !== f.priority) return false;

        const td = parseDate(g.targetDate);
        if (f.targetFrom && td < parseDate(f.targetFrom)) return false;
        if (f.targetTo && td > parseDate(f.targetTo)) return false;

        if (f.minTarget !== "" && g.target < Number(f.minTarget)) return false;
        if (f.maxTarget !== "" && g.target > Number(f.maxTarget)) return false;

        return true;
      });
    }

    function sortList(list){
      const { key, dir } = state.sort;
      const sign = dir === "asc" ? 1 : -1;
      const copy = [...list];

      copy.sort((a,b) => {
        let av = a[key], bv = b[key];

        if (key === "createdDate" || key === "targetDate"){
          av = parseDate(a[key]).getTime();
          bv = parseDate(b[key]).getTime();
        }
        if (["target","saved","progress"].includes(key)){
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
      const ids = ["createdDate","title","type","priority","target","saved","progress","targetDate","status"];
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
      const tbody = document.getElementById("goalsTbody");
      const empty = document.getElementById("emptyState");
      const tableWrap = document.getElementById("tableWrap");

      const filtered = applyAllFilters(goals);
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

      tbody.innerHTML = pageItems.map(g => {
        const cls = statusClass(g.status);
        return `
          <tr>
            <td>${escapeHtml(g.createdDate)}</td>
            <td title="${escapeHtml(g.title)}">${escapeHtml(g.title)}</td>
            <td>${escapeHtml(g.type)}</td>
            <td>${escapeHtml(g.priority)}</td>
            <td class="amount">${fmt(g.target)}</td>
            <td class="amount">${fmt(g.saved)}</td>
            <td class="amount">${Math.min(100, g.progress).toFixed(0)}%</td>
            <td>${escapeHtml(g.targetDate)}</td>
            <td>
              <span class="status ${cls}">
                <span class="dot"></span>
                ${escapeHtml(g.status)}
              </span>
            </td>
            <td>
              <div class="actions">
                <button class="link-btn" type="button" data-action="view" data-id="${g.id}">View</button>
                <button class="link-btn" type="button" data-action="edit" data-id="${g.id}">Edit</button>
                <button class="link-btn danger" type="button" data-action="delete" data-id="${g.id}">Delete</button>
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
    // Modal logic (add/edit/view)
    // ---------------------------
    let modalMode = "add";
    const modalOverlay = document.getElementById("modalOverlay");
    const form = document.getElementById("goalForm");

    const fields = {
      id: document.getElementById("goalId"),
      title: document.getElementById("goalTitle"),
      type: document.getElementById("goalType"),
      target: document.getElementById("goalTarget"),
      saved: document.getElementById("goalSaved"),
      priority: document.getElementById("goalPriority"),
      status: document.getElementById("goalStatus"),
      startDate: document.getElementById("goalStartDate"),
      targetDate: document.getElementById("goalTargetDate"),
      autoSave: document.getElementById("goalAutoSave"),
      notes: document.getElementById("goalNotes")
    };

    function setFormDisabled(disabled){
      form.querySelectorAll(".control, input[type='checkbox']").forEach(el => el.disabled = disabled);
    }

    function fillForm(g){
      if (!g) return;
      fields.id.value = g.id;
      fields.title.value = g.title;
      fields.type.value = g.type;
      fields.target.value = g.target;
      fields.saved.value = g.saved;
      fields.priority.value = g.priority;
      fields.status.value = g.status;
      fields.startDate.value = g.startDate;
      fields.targetDate.value = g.targetDate;
      fields.autoSave.checked = !!g.autoSave;
      fields.notes.value = g.notes || "";
    }

    function openModal(mode, goal=null){
      modalMode = mode;

      const title = document.getElementById("modalTitle");
      const subtitle = document.getElementById("modalSubtitle");
      const saveBtn = document.getElementById("saveGoal");

      if (mode === "add"){
        title.textContent = "Add Goal";
        subtitle.textContent = "Create a new financial goal";
        saveBtn.style.display = "inline-flex";
        saveBtn.textContent = "Save Goal";
        form.reset();
        fields.id.value = "";
        fields.startDate.value = TODAY.toISOString().slice(0,10);
        // default target date +90 days
        const td = new Date(TODAY); td.setDate(td.getDate() + 90);
        fields.targetDate.value = td.toISOString().slice(0,10);
        fields.autoSave.checked = false;
      } else if (mode === "edit"){
        title.textContent = "Edit Goal";
        subtitle.textContent = "Update goal details";
        saveBtn.style.display = "inline-flex";
        saveBtn.textContent = "Save Changes";
        fillForm(goal);
      } else {
        title.textContent = "View Goal";
        subtitle.textContent = "Review goal details";
        saveBtn.style.display = "none";
        fillForm(goal);
      }

      setFormDisabled(mode === "view");
      modalOverlay.classList.add("open");
      modalOverlay.setAttribute("aria-hidden", "false");
      setTimeout(() => fields.title.focus(), 50);
    }

    function closeModal(){
      modalOverlay.classList.remove("open");
      modalOverlay.setAttribute("aria-hidden", "true");
    }

    function saveFromModal(){
    if(!form.reportValidity()) return;
    const id = fields.id.value;
    document.getElementById("formMethod").value = id ? "PUT" : "POST";
    form.action = id ? `/goals/${id}` : "/goals";
    form.submit();
}

    // ---------------------------
    // Events
    // ---------------------------
    function bindEvents(){
      // Sidebar mobile
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
        state.filters.type = document.getElementById("filterType").value;
        state.filters.status = document.getElementById("filterStatus").value;
        state.filters.priority = document.getElementById("filterPriority").value;
        state.filters.targetFrom = document.getElementById("filterTargetFrom").value;
        state.filters.targetTo = document.getElementById("filterTargetTo").value;
        state.filters.minTarget = document.getElementById("filterMinTarget").value;
        state.filters.maxTarget = document.getElementById("filterMaxTarget").value;
        state.page = 1;
        renderTable();
      });

      // Clear all
      document.getElementById("clearAll").addEventListener("click", () => {
        state.searchGlobal = "";
        state.searchTable = "";
        document.getElementById("globalSearch").value = "";
        document.getElementById("tableSearch").value = "";

        state.filters = { type:"", status:"", priority:"", targetFrom:"", targetTo:"", minTarget:"", maxTarget:"" };
        document.getElementById("filterType").value = "";
        document.getElementById("filterStatus").value = "";
        document.getElementById("filterPriority").value = "";
        document.getElementById("filterTargetFrom").value = "";
        document.getElementById("filterTargetTo").value = "";
        document.getElementById("filterMinTarget").value = "";
        document.getElementById("filterMaxTarget").value = "";

        state.page = 1;
        renderTable();
      });

      // Sorting
      document.querySelectorAll("thead th[data-sort]").forEach(th => {
        th.addEventListener("click", () => {
          const key = th.getAttribute("data-sort");
          if (!key) return;
          if (state.sort.key === key) state.sort.dir = state.sort.dir === "asc" ? "desc" : "asc";
          else {
            state.sort.key = key;
            state.sort.dir = (key === "targetDate") ? "asc" : "asc";
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
      document.getElementById("goalsTbody").addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-action]");
        if (!btn) return;

        const action = btn.dataset.action;
        const id = btn.dataset.id;
        const g = goals.find(x => x.id === id);

        if (action === "view") openModal("view", g);
        if (action === "edit") openModal("edit", g);
        if(action === "delete"){
    if(confirm("Delete this goal?")){
        const f = document.createElement("form");
        f.method = "POST";
        f.action = `/goals/${id}`;
        f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
        document.body.appendChild(f);
        f.submit();
    }
}
      });

      // Modal open
      document.getElementById("openAddModal").addEventListener("click", () => openModal("add"));
      document.getElementById("emptyAddBtn").addEventListener("click", () => openModal("add"));

      // Modal close/save
      document.getElementById("closeModal").addEventListener("click", closeModal);
      document.getElementById("cancelModal").addEventListener("click", closeModal);
      document.getElementById("saveGoal").addEventListener("click", saveFromModal);

      modalOverlay.addEventListener("click", (e) => { if (e.target === modalOverlay) closeModal(); });
      window.addEventListener("keydown", (e) => { if (e.key === "Escape" && modalOverlay.classList.contains("open")) closeModal(); });
    }

    // ---------------------------
    // Rerender all
    // ---------------------------
    function rerenderAll(){
      renderMonthChip();
      renderSummary();
      renderAlerts();
      renderCharts();
      renderGoalCards();
      updateSortIndicators();
      renderTable();
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