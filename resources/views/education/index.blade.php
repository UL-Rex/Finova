<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Education • Personal Finance Dashboard</title>

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

      --radius: 14px;
      --shadow: 0 10px 30px rgba(15,23,42,.08);
      --shadow2: 0 6px 18px rgba(15,23,42,.10);

      --ring: 0 0 0 4px rgba(79,70,229,.18);
      --t: 160ms cubic-bezier(.2,.8,.2,1);

      --sidebar-w: 270px;
    }

    *{ box-sizing:border-box; }
    html,body{ height:100%; }
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
      width:20px; height:20px; display:grid; place-items:center;
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
      user-select:none;
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
      white-space:nowrap;
    }
    .badge.success{ background: rgba(16,185,129,.10); border-color: rgba(16,185,129,.25); color: rgba(6,95,70,.95); }
    .badge.warning{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.28); color: rgba(120,53,15,.95); }

    .summary-foot{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      font-size:12px;
      color:var(--muted);
    }

    /* Tabs */
    .tabs{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
    }
    .tab-btn{
      height: 38px;
      padding: 0 12px;
      border-radius: 999px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.75);
      cursor:pointer;
      font-weight:700;
      font-size: 12px;
      transition: transform var(--t), box-shadow var(--t), background var(--t);
      color: rgba(15,23,42,.80);
    }
    .tab-btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow2); }
    .tab-btn.active{
      background: rgba(79,70,229,.10);
      border-color: rgba(79,70,229,.25);
      color: rgba(49,46,129,.95);
    }

    /* Grids */
    .grid-3{
      display:grid;
      grid-template-columns: repeat(3, minmax(0,1fr));
      gap:12px;
    }
    .grid-2{
      display:grid;
      grid-template-columns: 1.4fr 1fr;
      gap:12px;
      align-items:stretch;
    }

    /* Course cards */
    .course-card{
      padding:14px;
      transition: transform var(--t), box-shadow var(--t);
    }
    .course-card:hover{ transform: translateY(-2px); box-shadow: 0 18px 40px rgba(15,23,42,.10); }
    .course-top{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:10px;
      margin-bottom:10px;
    }
    .course-title{
      margin:0;
      font-size:13px;
      font-weight:800;
      letter-spacing:-.1px;
      line-height:1.2;
    }
    .course-meta{
      margin:4px 0 0;
      font-size:12px;
      color:var(--muted);
    }
    .course-icon{
      width:40px; height:40px;
      border-radius:14px;
      display:grid; place-items:center;
      background: rgba(79,70,229,.10);
      border:1px solid rgba(79,70,229,.16);
      color: rgba(79,70,229,1);
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
      background: linear-gradient(90deg, rgba(79,70,229,1), rgba(37,99,235,1));
      transition: width 560ms cubic-bezier(.2,.8,.2,1);
    }
    .course-bottom{
      margin-top:10px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      flex-wrap:wrap;
      font-size:12px;
      color:var(--muted);
    }

    /* Tools cards */
    .tool-card{ padding:14px; }
    .tool-card h3{
      margin:0;
      font-size:14px;
      letter-spacing:-.2px;
    }
    .tool-card p{
      margin:6px 0 0;
      font-size:12px;
      color: var(--muted);
      line-height:1.35;
    }
    .tool-form{
      margin-top: 12px;
      display:grid;
      grid-template-columns: repeat(2, minmax(0,1fr));
      gap:10px;
    }
    .field label{
      display:block;
      font-size:12px;
      color: rgba(15,23,42,.70);
      margin-bottom:6px;
      font-weight:700;
    }
    .control{
      width:100%;
      height:42px;
      border-radius:12px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.92);
      padding:0 10px;
      outline:none;
      transition: box-shadow var(--t), border-color var(--t), background var(--t);
    }
    .control:focus{
      border-color: rgba(79,70,229,.35);
      box-shadow: var(--ring);
      background:#fff;
    }
    .tool-results{
      margin-top: 12px;
      padding: 12px;
      border-radius: 14px;
      border:1px solid rgba(15,23,42,.08);
      background: rgba(15,23,42,.02);
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:10px;
      flex-wrap:wrap;
    }
    .tool-results strong{ font-size:13px; }
    .tool-results span{ color:var(--muted); font-size:12px; display:block; margin-top:4px; line-height:1.35; }

    .canvas-wrap{
      padding:10px 14px 14px;
      height: 300px;
    }

    /* Table */
    .table-card{ padding:14px; }
    .table-wrap{
      overflow:auto;
      border-radius:14px;
      border:1px solid rgba(15,23,42,.08);
    }
    table{
      width:100%;
      border-collapse:collapse;
      min-width: 980px;
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
    tbody tr:hover td{ background: rgba(79,70,229,.04); }

    .tag{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:6px 10px;
      border-radius:999px;
      font-size:12px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.02);
      color: rgba(15,23,42,.78);
    }

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
      font-weight:700;
      transition: transform var(--t), box-shadow var(--t);
    }
    .link-btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(15,23,42,.10); }
    .link-btn.primary{
      border-color: rgba(79,70,229,.25);
      background: rgba(79,70,229,.08);
      color: rgba(49,46,129,.95);
    }

    /* Pagination */
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
      font-weight:700;
      font-size:12px;
    }
    .page-btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(15,23,42,.10); }
    .page-btn.active{
      border-color: rgba(79,70,229,.35);
      background: rgba(79,70,229,.10);
      color: rgba(49,46,129,.95);
    }
    .page-info{ font-size:12px; color:var(--muted); }

    /* Empty state */
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
      .grid-3{ grid-template-columns: repeat(2, minmax(0,1fr)); }
      .grid-2{ grid-template-columns: 1fr; }
      .search{ width:52vw; }
      .tool-form{ grid-template-columns: 1fr; }
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
      .grid-3{ grid-template-columns:1fr; }
      .btn, .btn-primary{ width:100%; justify-content:center; }
      .header-actions{ flex-direction:column; align-items:stretch; }
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
      <!-- Mobile bar -->
      <div class="mobile-bar">
        <button class="hamburger" id="hamburger" aria-label="Open sidebar">☰</button>
        <div style="font-weight:800; letter-spacing:-.2px;">Education</div>
      </div>

      <!-- Header -->
      <header class="top-header">
        <div class="title-block">
          <h1>Education</h1>
          <p>Resources, guides and calculators to improve financial literacy</p>
        </div>

        <div class="header-actions">
          <div class="search" role="search">
            <span class="mag">⌕</span>
            <input id="globalSearch" type="search" placeholder="Search courses, tools, articles…" />
          </div>

          <button class="btn" id="filterBtn" type="button">Filter</button>
          <button class="btn btn-primary" id="startBtn" type="button">Start Learning</button>
        </div>
      </header>

      <!-- Summary -->
      <section class="section" aria-labelledby="summaryTitle">
        <div class="section-title">
          <div>
            <h2 id="summaryTitle">Learning Summary</h2>
            <p>Your learning progress and activity</p>
          </div>
          <div class="tabs" aria-label="Education tabs">
            <button class="tab-btn active" data-tab="courses" type="button">Courses</button>
            <button class="tab-btn" data-tab="tools" type="button">Tools</button>
            <button class="tab-btn" data-tab="articles" type="button">Articles</button>
          </div>
        </div>

        <div class="summary-grid" id="summaryGrid"></div>
      </section>

      <!-- Courses Tab -->
      <section class="section tab" id="tab-courses" aria-label="Courses section">
        <div class="section-title">
          <div>
            <h2>Featured Courses</h2>
            <p>Short modules with progress tracking</p>
          </div>
          <span class="chip">Self-paced</span>
        </div>

        <div class="grid-3" id="coursesGrid"></div>
      </section>

      <!-- Tools Tab -->
      <section class="section tab" id="tab-tools" style="display:none;" aria-label="Tools section">
        <div class="section-title">
          <div>
            <h2>Calculators & Tools</h2>
            <p>Quick calculations to support better decisions</p>
          </div>
          <span class="chip">Interactive</span>
        </div>

        <div class="grid-2">
          <article class="card tool-card" aria-label="Debt payoff calculator">
            <h3>Debt Payoff Estimator</h3>
            <p>Estimate months to pay off debt based on balance, APR and monthly payment.</p>

            <div class="tool-form">
              <div class="field">
                <label for="debtBalance">Balance</label>
                <input id="debtBalance" class="control" type="number" min="0" step="0.01" value="2500" />
              </div>
              <div class="field">
                <label for="debtApr">APR (%)</label>
                <input id="debtApr" class="control" type="number" min="0" step="0.01" value="18.5" />
              </div>
              <div class="field">
                <label for="debtPay">Monthly Payment</label>
                <input id="debtPay" class="control" type="number" min="0" step="0.01" value="150" />
              </div>
              <div class="field">
                <label>&nbsp;</label>
                <button class="btn btn-primary" id="calcDebtBtn" type="button">Calculate</button>
              </div>
            </div>

            <div class="tool-results" id="debtResult">
              <div>
                <strong id="debtMonths">— months</strong>
                <span id="debtNote">Enter values and calculate.</span>
              </div>
              <span class="chip" id="debtTotalInterest">Interest: —</span>
            </div>
          </article>

          <article class="card tool-card" aria-label="Savings rate calculator">
            <h3>Savings Rate Calculator</h3>
            <p>Understand what percentage of your income you are saving.</p>

            <div class="tool-form">
              <div class="field">
                <label for="srIncome">Monthly Income</label>
                <input id="srIncome" class="control" type="number" min="0" step="0.01" value="6000" />
              </div>
              <div class="field">
                <label for="srExpenses">Monthly Expenses</label>
                <input id="srExpenses" class="control" type="number" min="0" step="0.01" value="4200" />
              </div>
              <div class="field">
                <label for="srSavings">Monthly Savings (optional)</label>
                <input id="srSavings" class="control" type="number" min="0" step="0.01" placeholder="Auto (Income - Expenses)" />
              </div>
              <div class="field">
                <label>&nbsp;</label>
                <button class="btn btn-primary" id="calcSrBtn" type="button">Calculate</button>
              </div>
            </div>

            <div class="tool-results" id="srResult">
              <div>
                <strong id="srRate">— %</strong>
                <span id="srNote">Aim for 20%+ if possible.</span>
              </div>
              <span class="chip" id="srAmount">Saved: —</span>
            </div>
          </article>
        </div>

        <div class="section" aria-label="Investment simulator">
          <div class="section-title">
            <div>
              <h2>Investment Simulator</h2>
              <p>Projected growth with compounding (dummy model)</p>
            </div>
            <span class="chip">Chart.js</span>
          </div>

          <article class="card">
            <div class="tool-card" style="border-radius:14px;">
              <div class="tool-form" style="grid-template-columns: repeat(4, minmax(0,1fr));">
                <div class="field">
                  <label for="invInitial">Initial</label>
                  <input id="invInitial" class="control" type="number" min="0" step="0.01" value="2000" />
                </div>
                <div class="field">
                  <label for="invMonthly">Monthly Add</label>
                  <input id="invMonthly" class="control" type="number" min="0" step="0.01" value="250" />
                </div>
                <div class="field">
                  <label for="invRate">Annual Return (%)</label>
                  <input id="invRate" class="control" type="number" min="0" step="0.1" value="10" />
                </div>
                <div class="field">
                  <label for="invYears">Years</label>
                  <input id="invYears" class="control" type="number" min="1" step="1" value="5" />
                </div>
                <div class="field" style="grid-column: 1 / -1;">
                  <button class="btn btn-primary" id="calcInvBtn" type="button">Run Simulation</button>
                </div>
              </div>
            </div>
            <div class="canvas-wrap">
              <canvas id="invChart"></canvas>
            </div>
          </article>
        </div>
      </section>

      <!-- Articles Tab -->
      <section class="section tab" id="tab-articles" style="display:none;" aria-label="Articles section">
        <div class="section-title">
          <div>
            <h2>Guides & Articles</h2>
            <p>Curated reading list (dummy data)</p>
          </div>
          <span class="chip">Reading</span>
        </div>

        <article class="card table-card">
          <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; margin-bottom:10px;">
            <div class="chip" id="resultsChip">0 results</div>
            <div class="chip" id="savedChip">Saved: 0</div>
          </div>

          <div class="empty" id="emptyState">
            <h3>No articles found</h3>
            <p>Try changing your search term.</p>
            <button class="btn btn-primary" id="resetSearchBtn" type="button">Reset Search</button>
          </div>

          <div class="table-wrap" id="tableWrap">
            <table aria-label="Articles table">
              <thead>
                <tr>
                  <th data-sort="title">Title <span class="sort" id="sort-title">↕</span></th>
                  <th data-sort="level">Level <span class="sort" id="sort-level">↕</span></th>
                  <th data-sort="topic">Topic <span class="sort" id="sort-topic">↕</span></th>
                  <th data-sort="minutes" style="text-align:right;">Read <span class="sort" id="sort-minutes">↕</span></th>
                  <th data-sort="date">Date <span class="sort" id="sort-date">↕</span></th>
                  <th style="text-align:right;">Actions</th>
                </tr>
              </thead>
              <tbody id="articlesTbody"></tbody>
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

  <div class="toast" id="toast" role="status" aria-live="polite">
    <div class="t-title" id="toastTitle">Done</div>
    <div class="t-sub" id="toastSub">Action completed (demo).</div>
  </div>

  <script>
    // ---------------------------
    // Dummy Data
    // ---------------------------
    const courses = [
      { id:"c1", title:"Budgeting Basics", icon:"B", lessons:8, minutes:45, progress:62, level:"Beginner" },
      { id:"c2", title:"Emergency Fund Plan", icon:"E", lessons:6, minutes:35, progress:28, level:"Beginner" },
      { id:"c3", title:"Debt Payoff Strategies", icon:"D", lessons:7, minutes:50, progress:46, level:"Intermediate" },
      { id:"c4", title:"Investing 101", icon:"I", lessons:9, minutes:60, progress:18, level:"Beginner" },
      { id:"c5", title:"Tax & Reports", icon:"T", lessons:5, minutes:30, progress:0, level:"Intermediate" },
      { id:"c6", title:"Risk & Asset Allocation", icon:"R", lessons:8, minutes:55, progress:12, level:"Advanced" }
    ];

    const articles = [
      { id:"a1", title:"How to build a realistic monthly budget", level:"Beginner", topic:"Budget", minutes:6, date:"2026-06-01" },
      { id:"a2", title:"The 50/30/20 rule explained", level:"Beginner", topic:"Budget", minutes:5, date:"2026-05-21" },
      { id:"a3", title:"Avalanche vs Snowball: debt payoff methods", level:"Intermediate", topic:"Debt", minutes:8, date:"2026-05-11" },
      { id:"a4", title:"Emergency fund: how much is enough?", level:"Beginner", topic:"Savings", minutes:7, date:"2026-04-29" },
      { id:"a5", title:"Asset allocation for long-term goals", level:"Advanced", topic:"Investing", minutes:10, date:"2026-04-08" },
      { id:"a6", title:"Tax estimation basics for freelancers", level:"Intermediate", topic:"Tax", minutes:9, date:"2026-03-19" },
      { id:"a7", title:"Cut subscriptions: quick wins to save money", level:"Beginner", topic:"Spending", minutes:4, date:"2026-03-02" }
    ];

    const STORAGE_KEY = "finpulse_saved_articles_v1";
    const savedSet = new Set();

    const state = {
      tab: "courses",
      search: "",
      sort: { key:"date", dir:"desc" },
      page: 1,
      pageSize: 5
    };

    const fmt = (n) => new Intl.NumberFormat("en-US", { style:"currency", currency:"USD" }).format(n);
    const clamp = (n,a,b) => Math.max(a, Math.min(b,n));

    // ---------------------------
    // Toast
    // ---------------------------
    function showToast(title, sub){
      document.getElementById("toastTitle").textContent = title;
      document.getElementById("toastSub").textContent = sub;
      const t = document.getElementById("toast");
      t.classList.add("show");
      clearTimeout(showToast._t);
      showToast._t = setTimeout(() => t.classList.remove("show"), 2200);
    }

    // ---------------------------
    // Summary
    // ---------------------------
    function renderSummary(){
      const totalCourses = courses.length;
      const inProgress = courses.filter(c => c.progress > 0 && c.progress < 100).length;
      const completed = courses.filter(c => c.progress >= 100).length;
      const avgProgress = totalCourses ? (courses.reduce((a,c)=>a+c.progress,0)/totalCourses) : 0;

      const totalSaved = savedSet.size;

      document.getElementById("summaryGrid").innerHTML = `
        <article class="card summary-card">
          <div class="summary-top">
            <div class="meta">
              <span>Courses</span>
              <strong>${totalCourses}</strong>
            </div>
            <span class="badge success">Library</span>
          </div>
          <div class="summary-foot"><span>In progress</span><span>${inProgress}</span></div>
        </article>

        <article class="card summary-card">
          <div class="summary-top">
            <div class="meta">
              <span>Average Progress</span>
              <strong>${avgProgress.toFixed(0)}%</strong>
            </div>
            <span class="badge ${avgProgress >= 50 ? "success" : "warning"}">${avgProgress >= 50 ? "On track" : "Keep going"}</span>
          </div>
          <div class="summary-foot"><span>Completed</span><span>${completed}</span></div>
        </article>

        <article class="card summary-card">
          <div class="summary-top">
            <div class="meta">
              <span>Saved Articles</span>
              <strong>${totalSaved}</strong>
            </div>
            <span class="badge">Bookmarks</span>
          </div>
          <div class="summary-foot"><span>Reading list</span><span>Updated</span></div>
        </article>

        <article class="card summary-card">
          <div class="summary-top">
            <div class="meta">
              <span>Weekly Tip</span>
              <strong>Automate savings</strong>
            </div>
            <span class="badge success">Tip</span>
          </div>
          <div class="summary-foot"><span>Action</span><span>Enable auto-save goals</span></div>
        </article>
      `;
    }

    // ---------------------------
    // Courses
    // ---------------------------
    function renderCourses(){
      const grid = document.getElementById("coursesGrid");
      grid.innerHTML = courses.map(c => `
        <article class="card course-card">
          <div class="course-top">
            <div style="min-width:0;">
              <p class="course-title" title="${escapeHtml(c.title)}">${escapeHtml(c.title)}</p>
              <p class="course-meta">${escapeHtml(c.level)} • ${c.lessons} lessons • ~${c.minutes} min</p>
            </div>
            <div class="course-icon">${escapeHtml(c.icon)}</div>
          </div>

          <div class="progress"><i style="width:${clamp(c.progress,0,100)}%;"></i></div>

          <div class="course-bottom">
            <span>${c.progress}% complete</span>
            <button class="link-btn primary" type="button" data-course="${c.id}">${c.progress > 0 ? "Continue" : "Start"}</button>
          </div>
        </article>
      `).join("");

      grid.addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-course]");
        if (!btn) return;
        showToast("Course", "Course player will be integrated in MVC (demo).");
      }, { once:true });
    }

    // ---------------------------
    // Tools (Calculators)
    // ---------------------------
    function debtPayoffMonths(balance, aprPercent, payment){
      // Simple amortization estimate (monthly compounding)
      const r = (aprPercent/100)/12;
      if (payment <= balance*r) return { months: Infinity, interest: Infinity };

      let months = 0;
      let totalInterest = 0;
      let b = balance;

      while (b > 0 && months < 1200){ // safety cap
        const interest = b * r;
        totalInterest += interest;
        b = (b + interest) - payment;
        months++;
      }
      return { months, interest: totalInterest };
    }

    function calcDebt(){
      const balance = Number(document.getElementById("debtBalance").value || 0);
      const apr = Number(document.getElementById("debtApr").value || 0);
      const pay = Number(document.getElementById("debtPay").value || 0);

      const out = debtPayoffMonths(balance, apr, pay);

      const monthsEl = document.getElementById("debtMonths");
      const noteEl = document.getElementById("debtNote");
      const intEl = document.getElementById("debtTotalInterest");

      if (!isFinite(out.months)){
        monthsEl.textContent = "Not possible";
        noteEl.textContent = "Payment is too low to cover monthly interest. Increase payment.";
        intEl.textContent = "Interest: —";
        showToast("Debt", "Increase monthly payment to reduce payoff time.");
        return;
      }

      monthsEl.textContent = `${out.months} months`;
      noteEl.textContent = `Estimated payoff time with ${fmt(pay)}/month.`;
      intEl.textContent = `Interest: ${fmt(out.interest)}`;
      showToast("Calculated", "Debt payoff estimate updated.");
    }

    function calcSavingsRate(){
      const income = Number(document.getElementById("srIncome").value || 0);
      const expenses = Number(document.getElementById("srExpenses").value || 0);
      const inputSavings = document.getElementById("srSavings").value;
      const savings = inputSavings !== "" ? Number(inputSavings || 0) : (income - expenses);

      const rate = income ? (savings / income) * 100 : 0;

      document.getElementById("srRate").textContent = `${rate.toFixed(0)}%`;
      document.getElementById("srAmount").textContent = `Saved: ${fmt(savings)}`;

      const note = rate >= 20 ? "Great target. Maintain consistency." : (rate >= 10 ? "Good start. Try to improve gradually." : "Low savings rate. Review spending & increase income.");
      document.getElementById("srNote").textContent = note;

      showToast("Calculated", "Savings rate updated.");
    }

    // Investment simulation chart
    let invChart;

    function buildInvChart(){
      invChart = new Chart(document.getElementById("invChart"), {
        type: "line",
        data: {
          labels: [],
          datasets: [{
            label: "Projected Balance",
            data: [],
            borderColor: "rgba(79,70,229,1)",
            backgroundColor: "rgba(79,70,229,.14)",
            fill: true,
            tension: 0.35,
            pointRadius: 2,
            borderWidth: 2
          }]
        },
        options: {
          responsive:true,
          maintainAspectRatio:false,
          interaction: { mode:"index", intersect:false },
          plugins: {
            legend: { display:false },
            tooltip: {
              backgroundColor: "rgba(15,23,42,.96)",
              borderColor: "rgba(255,255,255,.14)",
              borderWidth: 1,
              padding: 12,
              callbacks: { label: (ctx) => ` ${fmt(ctx.parsed.y)}` }
            }
          },
          scales: {
            x: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color:"rgba(15,23,42,.65)" } },
            y: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color:"rgba(15,23,42,.65)", callback:(v)=>"$"+v } }
          }
        }
      });
    }

    function runInvestmentSim(){
      const initial = Number(document.getElementById("invInitial").value || 0);
      const monthly = Number(document.getElementById("invMonthly").value || 0);
      const rate = Number(document.getElementById("invRate").value || 0) / 100;
      const years = Math.max(1, Number(document.getElementById("invYears").value || 1));

      const months = years * 12;
      const r = rate / 12;

      const labels = [];
      const values = [];

      let bal = initial;
      for (let m=1; m<=months; m++){
        bal = (bal * (1 + r)) + monthly;
        if (m % 3 === 0 || m === 1 || m === months){ // fewer points
          labels.push(`M${m}`);
          values.push(Math.round(bal));
        }
      }

      invChart.data.labels = labels;
      invChart.data.datasets[0].data = values;
      invChart.update();

      showToast("Simulation", `Projected balance after ${years} year(s): ${fmt(values[values.length-1] || 0)}`);
    }

    // ---------------------------
    // Articles (table)
    // ---------------------------
    function escapeHtml(str){
      return String(str)
        .replaceAll("&","&amp;")
        .replaceAll("<","&lt;")
        .replaceAll(">","&gt;")
        .replaceAll('"',"&quot;")
        .replaceAll("'","&#039;");
    }

    function applyArticleSearch(list){
      const q = (state.search || "").trim().toLowerCase();
      if (!q) return list;
      return list.filter(a => `${a.title} ${a.topic} ${a.level}`.toLowerCase().includes(q));
    }

    function sortArticles(list){
      const { key, dir } = state.sort;
      const sign = dir === "asc" ? 1 : -1;
      const copy = [...list];

      copy.sort((a,b) => {
        let av = a[key], bv = b[key];
        if (key === "minutes") return sign * (a.minutes - b.minutes);
        if (key === "date") return sign * (new Date(a.date).getTime() - new Date(b.date).getTime());
        return sign * String(av).localeCompare(String(bv));
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
      const ids = ["title","level","topic","minutes","date"];
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

    function saveBookmarks(){
      localStorage.setItem(STORAGE_KEY, JSON.stringify([...savedSet]));
      document.getElementById("savedChip").textContent = `Saved: ${savedSet.size}`;
    }

    function renderArticles(){
      const tbody = document.getElementById("articlesTbody");
      const empty = document.getElementById("emptyState");
      const tableWrap = document.getElementById("tableWrap");

      const filtered = applyArticleSearch(articles);
      const sorted = sortArticles(filtered);
      const { pageItems, totalItems, totalPages, start } = paginate(sorted);

      document.getElementById("resultsChip").textContent = `${totalItems} result${totalItems === 1 ? "" : "s"}`;
      saveBookmarks();

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

      tbody.innerHTML = pageItems.map(a => {
        const saved = savedSet.has(a.id);
        return `
          <tr>
            <td title="${escapeHtml(a.title)}">${escapeHtml(a.title)}</td>
            <td><span class="tag">${escapeHtml(a.level)}</span></td>
            <td><span class="tag">${escapeHtml(a.topic)}</span></td>
            <td style="text-align:right;">${a.minutes} min</td>
            <td>${escapeHtml(a.date)}</td>
            <td>
              <div class="actions">
                <button class="link-btn primary" type="button" data-action="view" data-id="${a.id}">View</button>
                <button class="link-btn" type="button" data-action="save" data-id="${a.id}">
                  ${saved ? "Saved" : "Save"}
                </button>
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
    // Tabs
    // ---------------------------
    function setTab(tab){
      state.tab = tab;
      document.querySelectorAll(".tab-btn").forEach(b => b.classList.toggle("active", b.dataset.tab === tab));
      document.querySelectorAll(".tab").forEach(s => s.style.display = "none");
      document.getElementById("tab-" + tab).style.display = "block";

      // slight UX
      if (tab === "articles") renderArticles();
      showToast("Tab", `Opened ${tab}.`);
    }

    // ---------------------------
    // Events
    // ---------------------------
    function bindEvents(){
      // Mobile sidebar
      const hamburger = document.getElementById("hamburger");
      const overlay = document.getElementById("sidebarOverlay");
      hamburger?.addEventListener("click", () => document.body.classList.toggle("sidebar-open"));
      overlay?.addEventListener("click", () => document.body.classList.remove("sidebar-open"));
      window.addEventListener("resize", () => {
        if (window.innerWidth > 900) document.body.classList.remove("sidebar-open");
      });

      // Tabs
      document.querySelectorAll(".tab-btn").forEach(btn => {
        btn.addEventListener("click", () => setTab(btn.dataset.tab));
      });

      // Search
      document.getElementById("globalSearch").addEventListener("input", (e) => {
        state.search = e.target.value;
        state.page = 1;

        // If searching, show Articles tab for best UX
        setTab("articles");
        renderArticles();
      });

      // Tools buttons
      document.getElementById("calcDebtBtn").addEventListener("click", calcDebt);
      document.getElementById("calcSrBtn").addEventListener("click", calcSavingsRate);
      document.getElementById("calcInvBtn").addEventListener("click", runInvestmentSim);

      // Start learning
      document.getElementById("startBtn").addEventListener("click", () => {
        setTab("courses");
        showToast("Learning", "Pick a course to start (demo).");
      });

      // Filter placeholder
      document.getElementById("filterBtn").addEventListener("click", () => {
        showToast("Filter", "Filtering UI can be added (topic/level).");
      });

      // Articles actions + sorting + pagination
      document.getElementById("articlesTbody").addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-action]");
        if (!btn) return;

        const action = btn.dataset.action;
        const id = btn.dataset.id;
        const item = articles.find(x => x.id === id);

        if (action === "view"){
          showToast("Article", `Open article: ${item?.title || ""} (demo).`);
        }

        if (action === "save"){
          if (savedSet.has(id)) savedSet.delete(id);
          else savedSet.add(id);
          saveBookmarks();
          renderArticles();
          showToast("Saved", savedSet.has(id) ? "Added to reading list." : "Removed from reading list.");
        }
      });

      document.querySelectorAll("thead th[data-sort]").forEach(th => {
        th.addEventListener("click", () => {
          const key = th.getAttribute("data-sort");
          if (!key) return;
          if (state.sort.key === key) state.sort.dir = state.sort.dir === "asc" ? "desc" : "asc";
          else { state.sort.key = key; state.sort.dir = (key === "date") ? "desc" : "asc"; }
          updateSortIndicators();
          renderArticles();
        });
      });

      document.getElementById("pager").addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-page]");
        if (!btn) return;
        state.page = Number(btn.dataset.page);
        renderArticles();
      });

      document.getElementById("resetSearchBtn").addEventListener("click", () => {
        state.search = "";
        document.getElementById("globalSearch").value = "";
        state.page = 1;
        setTab("articles");
        renderArticles();
      });
    }

    // ---------------------------
    // Init
    // ---------------------------
    function init(){
      renderSummary();
      renderCourses();
      buildInvChart();
      runInvestmentSim();
      updateSortIndicators();
      renderArticles();
      saveBookmarks();
      setTab("courses");
      bindEvents();
    }

    init();
  </script>
</body>
</html>