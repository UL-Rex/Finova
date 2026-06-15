<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reports • Personal Finance Dashboard</title>

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

    .chip{
      font-size: 12px;
      color: rgba(15,23,42,.70);
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(15,23,42,.03);
      padding: 6px 10px;
      border-radius: 999px;
      white-space: nowrap;
    }

    /* Cards */
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

    /* Controls bar */
    .controls{
      padding: 14px;
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap: 10px;
      flex-wrap: wrap;
    }
    .controls-left{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 10px;
      align-items:end;
      flex: 1;
      min-width: 280px;
    }
    .field label{
      display:block;
      font-size: 12px;
      color: rgba(15,23,42,.70);
      margin-bottom: 6px;
      font-weight: 700;
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
      background:#fff;
    }
    .controls-right{
      display:flex;
      gap: 10px;
      flex-wrap: wrap;
      justify-content:flex-end;
    }

    /* Summary cards */
    .summary-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
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

    /* Insights / Alerts */
    .insights-grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }
    .insight{
      padding: 14px;
      border-left: 5px solid rgba(79,70,229,.85);
      background: linear-gradient(180deg, rgba(79,70,229,.06), rgba(255,255,255,1));
    }
    .insight.warning{
      border-left-color: rgba(245,158,11,.9);
      background: linear-gradient(180deg, rgba(245,158,11,.06), rgba(255,255,255,1));
    }
    .insight.success{
      border-left-color: rgba(16,185,129,.9);
      background: linear-gradient(180deg, rgba(16,185,129,.06), rgba(255,255,255,1));
    }
    .insight h4{ margin:0; font-size: 13px; letter-spacing:-.2px; }
    .insight p{ margin: 6px 0 0; font-size: 12px; color: var(--muted); line-height: 1.35; }
    .insight .row{ margin-top: 10px; display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }

    /* Analytics */
    .analytics-grid{
      display:grid;
      grid-template-columns: 2fr 1fr;
      gap: 12px;
      align-items:stretch;
    }
    .analytics-grid2{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      align-items:stretch;
      margin-top: 12px;
    }
    .card-head{
      padding: 14px 14px 0;
      display:flex; align-items:flex-end; justify-content:space-between; gap:10px;
    }
    .card-head h3{ margin:0; font-size: 14px; letter-spacing:-.2px; }
    .card-head p{ margin: 4px 0 0; font-size: 12px; color: var(--muted); }
    .canvas-wrap{ padding: 10px 14px 14px; height: 320px; }

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

    .search{
      position:relative;
      max-width: 420px;
      width: min(520px, 100%);
    }
    .search input{
      width:100%;
      height: 44px;
      padding: 10px 12px 10px 40px;
      border-radius: 12px;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.82);
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
    .amount.good{ color: rgba(6,95,70,.95); }
    .amount.bad{ color: rgba(127,29,29,.95); }

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

    /* Empty */
    .empty{
      display:none;
      padding: 24px;
      text-align:center;
      border-radius: var(--radius);
      border: 1px dashed rgba(15,23,42,.18);
      background: rgba(255,255,255,.70);
    }
    .empty.show{ display:block; }
    .empty h3{ margin: 10px 0 0; font-size: 16px; letter-spacing:-.2px; }
    .empty p{ margin: 6px 0 14px; color: var(--muted); font-size: 13px; }

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
      .controls-left{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .summary-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
      .analytics-grid{ grid-template-columns: 1fr; }
      .analytics-grid2{ grid-template-columns: 1fr; }
      .insights-grid{ grid-template-columns: 1fr; }
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
    }
    @media (max-width: 520px){
      .controls-left{ grid-template-columns: 1fr; }
      .summary-grid{ grid-template-columns: 1fr; }
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
      <!-- Mobile bar -->
      <div class="mobile-bar">
        <button class="hamburger" id="hamburger" aria-label="Open sidebar">☰</button>
        <div style="font-weight:800; letter-spacing:-.2px;">Reports</div>
      </div>

      <!-- Header -->
      <header class="top-header">
        <div class="title-block">
          <h1>Reports</h1>
          <p>Generate monthly, quarterly or annual financial insights</p>
        </div>

        <div class="header-actions">
          <button class="btn" id="exportJsonBtn" type="button">Export JSON</button>
          <button class="btn" id="exportCsvBtn" type="button">Export CSV</button>
          <button class="btn btn-primary" id="generateBtn" type="button">Generate Report</button>
        </div>
      </header>

      <!-- Controls -->
      <section class="card controls" aria-label="Report controls">
        <div class="controls-left">
          <div class="field">
            <label for="period">Report Period</label>
            <select id="period" class="control">
              <option value="monthly" selected>Monthly</option>
              <option value="quarterly">Quarterly</option>
              <option value="annual">Annual</option>
            </select>
          </div>
          <div class="field">
            <label for="dateFrom">From</label>
            <input id="dateFrom" type="month" class="control" />
          </div>
          <div class="field">
            <label for="dateTo">To</label>
            <input id="dateTo" type="month" class="control" />
          </div>
          <div class="field">
            <label for="taxRate">Tax Rate (est.)</label>
            <input id="taxRate" type="number" class="control" min="0" max="60" step="0.1" />
          </div>
        </div>

        <div class="controls-right">
          <span class="chip" id="rangeChip">Range</span>
          <button class="btn" id="applyBtn" type="button">Apply</button>
          <button class="btn" id="resetBtn" type="button">Reset</button>
        </div>
      </section>

      <!-- Summary -->
      <section class="section" aria-labelledby="summaryTitle">
        <div class="section-title">
          <div>
            <h2 id="summaryTitle">Report Summary</h2>
            <p>Totals for selected period</p>
          </div>
          <span class="chip" id="updatedChip">Updated</span>
        </div>

        <div class="summary-grid" id="summaryGrid"></div>
      </section>

      <!-- Insights -->
      <section class="section" aria-labelledby="insightsTitle">
        <div class="section-title">
          <div>
            <h2 id="insightsTitle">Insights</h2>
            <p>Key observations and recommendations (dummy)</p>
          </div>
        </div>
        <div class="insights-grid" id="insightsGrid"></div>
      </section>

      <!-- Analytics -->
      <section class="section" aria-labelledby="analyticsTitle">
        <div class="section-title">
          <div>
            <h2 id="analyticsTitle">Analytics</h2>
            <p>Income, expenses, savings, net worth and allocation</p>
          </div>
        </div>

        <div class="analytics-grid">
          <article class="card" aria-label="Cashflow trend chart">
            <div class="card-head">
              <div>
                <h3>Cashflow Trend</h3>
                <p>Income vs expenses + savings</p>
              </div>
              <span class="chip">Line</span>
            </div>
            <div class="canvas-wrap">
              <canvas id="cashflowChart"></canvas>
            </div>
          </article>

          <article class="card" aria-label="Spending breakdown chart">
            <div class="card-head">
              <div>
                <h3>Spending Breakdown</h3>
                <p>Selected period categories</p>
              </div>
              <span class="chip">Doughnut</span>
            </div>
            <div class="canvas-wrap">
              <canvas id="breakdownChart"></canvas>
            </div>
          </article>
        </div>

        <div class="analytics-grid2">
          <article class="card" aria-label="Net worth chart">
            <div class="card-head">
              <div>
                <h3>Net Worth</h3>
                <p>Estimated net worth trend</p>
              </div>
              <span class="chip">Area</span>
            </div>
            <div class="canvas-wrap">
              <canvas id="netWorthChart"></canvas>
            </div>
          </article>

          <article class="card" aria-label="Income sources chart">
            <div class="card-head">
              <div>
                <h3>Income Sources</h3>
                <p>Distribution (dummy)</p>
              </div>
              <span class="chip">Bar</span>
            </div>
            <div class="canvas-wrap">
              <canvas id="incomeSourcesChart"></canvas>
            </div>
          </article>
        </div>
      </section>

      <!-- Table -->
      <section class="section" aria-labelledby="detailsTitle">
        <div class="section-title">
          <div>
            <h2 id="detailsTitle">Report Details</h2>
            <p>Monthly/quarterly/annual summary table</p>
          </div>
        </div>

        <article class="card table-card">
          <div class="table-toolbar">
            <div class="toolbar-left">
              <div class="search">
                <span class="mag">⌕</span>
                <label class="sr-only" for="tableSearch">Search in table</label>
                <input id="tableSearch" type="search" placeholder="Search period label…" />
              </div>
              <button class="btn" id="clearSearch" type="button">Clear</button>
            </div>
            <div class="toolbar-right">
              <span class="chip" id="resultsChip">0 results</span>
            </div>
          </div>

          <div class="empty" id="emptyState">
            <h3>No report data found</h3>
            <p>Adjust your range or reset filters to see results.</p>
            <button class="btn btn-primary" id="emptyResetBtn" type="button">Reset</button>
          </div>

          <div class="table-wrap" id="tableWrap">
            <table aria-label="Report table">
              <thead>
                <tr>
                  <th data-sort="label">Period <span class="sort" id="sort-label">↕</span></th>
                  <th data-sort="income" style="text-align:right;">Income <span class="sort" id="sort-income">↕</span></th>
                  <th data-sort="expenses" style="text-align:right;">Expenses <span class="sort" id="sort-expenses">↕</span></th>
                  <th data-sort="savings" style="text-align:right;">Savings <span class="sort" id="sort-savings">↕</span></th>
                  <th data-sort="savingsRate" style="text-align:right;">Savings Rate <span class="sort" id="sort-savingsRate">↕</span></th>
                  <th data-sort="investReturn" style="text-align:right;">Inv. Return <span class="sort" id="sort-investReturn">↕</span></th>
                  <th data-sort="taxEst" style="text-align:right;">Tax Est. <span class="sort" id="sort-taxEst">↕</span></th>
                </tr>
              </thead>
              <tbody id="reportTbody"></tbody>
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
    // Dummy dataset (12 months)
    // ---------------------------
    // Using month keys: YYYY-MM
    const MONTHS = [
      "2025-07","2025-08","2025-09","2025-10","2025-11","2025-12",
      "2026-01","2026-02","2026-03","2026-04","2026-05","2026-06"
    ];

    // Income/Expense totals per month (dummy)
    const monthlyLedger = MONTHS.map((m, i) => {
      const baseIncome = 5200 + i*40;
      const baseExpenses = 3600 + i*55;
      const investReturn = 60 + (i%4)*22; // dummy monthly investment return
      return {
        month: m,
        income: Math.round(baseIncome + (i%3===0 ? 200 : 0)),
        expenses: Math.round(baseExpenses + (i%5===0 ? 120 : 0)),
        investReturn: Math.round(investReturn),
      };
    });

    // Expense categories for "selected period" breakdown (dummy base weights)
    const categoryWeights = {
      Food: 0.16,
      Rent: 0.38,
      Bills: 0.12,
      Transport: 0.07,
      Entertainment: 0.08,
      Shopping: 0.12,
      Health: 0.07
    };

    const incomeSourceWeights = {
      Salary: 0.78,
      Freelance: 0.14,
      Investments: 0.05,
      Refunds: 0.03
    };

    // ---------------------------
    // State
    // ---------------------------
    const state = {
      period: "monthly", // monthly|quarterly|annual
      from: "2025-07",
      to: "2026-06",
      taxRate: 12.5,
      search: "",
      sort: { key: "label", dir: "asc" },
      page: 1,
      pageSize: 6
    };

    const fmt = (n) => new Intl.NumberFormat("en-US", { style:"currency", currency:"USD" }).format(n);
    const clamp = (n,a,b) => Math.max(a, Math.min(b, n));

    function monthLabel(key){
      const [y,m] = key.split("-").map(Number);
      const d = new Date(y, m-1, 1);
      return d.toLocaleString("en-US", { month:"short", year:"numeric" });
    }

    function monthIndex(key){ return MONTHS.indexOf(key); }

    function inRange(key){
      const a = monthIndex(state.from);
      const b = monthIndex(state.to);
      const x = monthIndex(key);
      if (a === -1 || b === -1 || x === -1) return false;
      return x >= Math.min(a,b) && x <= Math.max(a,b);
    }

    function savings(income, expenses){ return income - expenses; }
    function savingsRate(income, expenses){
      const s = savings(income, expenses);
      return income ? (s/income)*100 : 0;
    }

    function taxEstimate(income, expenses){
      // Very basic placeholder: taxable = income - 20% of expenses
      const taxable = Math.max(0, income - (expenses * 0.20));
      return taxable * (state.taxRate / 100);
    }

    function deepClone(obj){
      return window.structuredClone ? structuredClone(obj) : JSON.parse(JSON.stringify(obj));
    }

    // ---------------------------
    // Grouping logic
    // ---------------------------
    function toQuarterKey(monthKey){
      const [y,m] = monthKey.split("-").map(Number);
      const q = Math.floor((m-1)/3) + 1;
      return `${y}-Q${q}`;
    }

    function groupLedger(){
      const filtered = monthlyLedger.filter(x => inRange(x.month));

      if (state.period === "monthly"){
        return filtered.map(x => ({
          label: monthLabel(x.month),
          key: x.month,
          income: x.income,
          expenses: x.expenses,
          investReturn: x.investReturn
        }));
      }

      if (state.period === "quarterly"){
        const map = {};
        for (const row of filtered){
          const q = toQuarterKey(row.month);
          if (!map[q]) map[q] = { label: q, key: q, income:0, expenses:0, investReturn:0 };
          map[q].income += row.income;
          map[q].expenses += row.expenses;
          map[q].investReturn += row.investReturn;
        }
        // sort by time
        const order = Object.values(map).sort((a,b)=>a.key.localeCompare(b.key));
        return order;
      }

      // annual
      const map = {};
      for (const row of filtered){
        const y = row.month.split("-")[0];
        if (!map[y]) map[y] = { label: y, key: y, income:0, expenses:0, investReturn:0 };
        map[y].income += row.income;
        map[y].expenses += row.expenses;
        map[y].investReturn += row.investReturn;
      }
      return Object.values(map).sort((a,b)=>a.key.localeCompare(b.key));
    }

    function buildReportRows(){
      const grouped = groupLedger();
      return grouped.map(r => {
        const sav = savings(r.income, r.expenses);
        const rate = savingsRate(r.income, r.expenses);
        const tax = taxEstimate(r.income, r.expenses);
        return {
          ...r,
          savings: sav,
          savingsRate: rate,
          taxEst: tax
        };
      });
    }

    // ---------------------------
    // Charts
    // ---------------------------
    let cashflowChart, breakdownChart, netWorthChart, incomeSourcesChart;

    function buildCharts(){
      cashflowChart = new Chart(document.getElementById("cashflowChart"), {
        type: "line",
        data: {
          labels: [],
          datasets: [
            {
              label: "Income",
              data: [],
              borderColor: "rgba(16,185,129,1)",
              backgroundColor: "rgba(16,185,129,.14)",
              fill: true,
              tension: 0.35,
              pointRadius: 3,
              borderWidth: 2
            },
            {
              label: "Expenses",
              data: [],
              borderColor: "rgba(239,68,68,1)",
              backgroundColor: "rgba(239,68,68,.10)",
              fill: true,
              tension: 0.35,
              pointRadius: 3,
              borderWidth: 2
            },
            {
              label: "Savings",
              data: [],
              borderColor: "rgba(79,70,229,1)",
              backgroundColor: "rgba(79,70,229,.10)",
              fill: true,
              tension: 0.35,
              pointRadius: 3,
              borderWidth: 2
            }
          ]
        },
        options: {
          responsive:true,
          maintainAspectRatio:false,
          interaction: { mode:"index", intersect:false },
          plugins: {
            legend: { labels: { color:"rgba(15,23,42,.70)" } },
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

      breakdownChart = new Chart(document.getElementById("breakdownChart"), {
        type: "doughnut",
        data: {
          labels: Object.keys(categoryWeights),
          datasets: [{
            data: [],
            backgroundColor: [
              "rgba(79,70,229,.88)",
              "rgba(37,99,235,.80)",
              "rgba(16,185,129,.78)",
              "rgba(245,158,11,.84)",
              "rgba(239,68,68,.76)",
              "rgba(100,116,139,.70)",
              "rgba(2,132,199,.75)"
            ],
            borderColor: "rgba(255,255,255,.95)",
            borderWidth: 2,
            hoverOffset: 6
          }]
        },
        options: {
          responsive:true,
          maintainAspectRatio:false,
          cutout:"62%",
          plugins:{
            legend:{
              position:"bottom",
              labels:{
                color:"rgba(15,23,42,.70)",
                padding: 14,
                boxWidth: 10,
                boxHeight: 10,
                usePointStyle:true,
                pointStyle:"circle"
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

      netWorthChart = new Chart(document.getElementById("netWorthChart"), {
        type: "line",
        data: {
          labels: [],
          datasets: [{
            label: "Net Worth",
            data: [],
            borderColor: "rgba(15,23,42,.85)",
            backgroundColor: "rgba(15,23,42,.06)",
            fill: true,
            tension: 0.35,
            pointRadius: 2,
            borderWidth: 2
          }]
        },
        options:{
          responsive:true,
          maintainAspectRatio:false,
          plugins:{
            legend:{ display:false },
            tooltip:{
              backgroundColor: "rgba(15,23,42,.96)",
              borderColor: "rgba(255,255,255,.14)",
              borderWidth: 1,
              padding: 12,
              callbacks: { label: (ctx) => ` ${fmt(ctx.parsed.y)}` }
            }
          },
          scales:{
            x: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color:"rgba(15,23,42,.65)" } },
            y: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color:"rgba(15,23,42,.65)", callback:(v)=>"$"+v } }
          }
        }
      });

      incomeSourcesChart = new Chart(document.getElementById("incomeSourcesChart"), {
        type: "bar",
        data: {
          labels: Object.keys(incomeSourceWeights),
          datasets: [{
            label: "Income",
            data: [],
            backgroundColor: "rgba(16,185,129,.22)",
            borderColor: "rgba(16,185,129,.55)",
            borderWidth: 1,
            borderRadius: 10
          }]
        },
        options:{
          responsive:true,
          maintainAspectRatio:false,
          plugins:{
            legend:{ display:false },
            tooltip:{
              backgroundColor: "rgba(15,23,42,.96)",
              borderColor: "rgba(255,255,255,.14)",
              borderWidth: 1,
              padding: 12,
              callbacks: { label: (ctx) => ` ${fmt(ctx.parsed.y)}` }
            }
          },
          scales:{
            x: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color:"rgba(15,23,42,.65)" } },
            y: { grid: { color: "rgba(15,23,42,.06)" }, ticks: { color:"rgba(15,23,42,.65)", callback:(v)=>"$"+v } }
          }
        }
      });
    }

    function renderCharts(rows){
      // Cashflow chart uses current grouped rows
      const labels = rows.map(r => r.label);
      const incomes = rows.map(r => r.income);
      const expenses = rows.map(r => r.expenses);
      const savingsArr = rows.map(r => r.savings);

      cashflowChart.data.labels = labels;
      cashflowChart.data.datasets[0].data = incomes;
      cashflowChart.data.datasets[1].data = expenses;
      cashflowChart.data.datasets[2].data = savingsArr;
      cashflowChart.update();

      // Breakdown: allocate total expenses over weights
      const totalExpenses = rows.reduce((a,b)=>a + b.expenses, 0);
      const breakdown = Object.keys(categoryWeights).map(k => totalExpenses * categoryWeights[k]);

      breakdownChart.data.datasets[0].data = breakdown.map(x => Math.round(x));
      breakdownChart.update();

      // Net worth: build monthly net worth then slice to range and optionally compress labels (use monthly base)
      const baseStart = 12000;
      let net = baseStart;
      const monthlyInRange = monthlyLedger.filter(x => inRange(x.month));
      const netSeries = monthlyInRange.map(m => {
        net += (m.income - m.expenses) + m.investReturn; // simplified
        return Math.round(net);
      });
      netWorthChart.data.labels = monthlyInRange.map(m => monthLabel(m.month));
      netWorthChart.data.datasets[0].data = netSeries;
      netWorthChart.update();

      // Income sources: allocate total income by weights
      const totalIncome = rows.reduce((a,b)=>a + b.income, 0);
      const srcVals = Object.keys(incomeSourceWeights).map(k => totalIncome * incomeSourceWeights[k]);
      incomeSourcesChart.data.datasets[0].data = srcVals.map(x => Math.round(x));
      incomeSourcesChart.update();
    }

    // ---------------------------
    // Summary + Insights
    // ---------------------------
    function renderSummary(rows){
      const income = rows.reduce((a,b)=>a+b.income,0);
      const expenses = rows.reduce((a,b)=>a+b.expenses,0);
      const sav = income - expenses;
      const rate = income ? (sav/income)*100 : 0;
      const inv = rows.reduce((a,b)=>a+b.investReturn,0);
      const tax = rows.reduce((a,b)=>a+b.taxEst,0);

      const grid = document.getElementById("summaryGrid");
      grid.innerHTML = `
        <article class="card summary-card" aria-label="Total income">
          <div class="summary-top">
            <div class="meta">
              <span>Total Income</span>
              <strong>${fmt(income)}</strong>
            </div>
            <span class="badge success">Inflow</span>
          </div>
          <div class="summary-foot">
            <span>Period</span>
            <span>${rows.length} item(s)</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Total expenses">
          <div class="summary-top">
            <div class="meta">
              <span>Total Expenses</span>
              <strong>${fmt(expenses)}</strong>
            </div>
            <span class="badge warning">Outflow</span>
          </div>
          <div class="summary-foot">
            <span>Spending</span>
            <span>${(income ? (expenses/income)*100 : 0).toFixed(0)}% of income</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Net savings">
          <div class="summary-top">
            <div class="meta">
              <span>Net Savings</span>
              <strong style="color:${sav>=0 ? "rgba(6,95,70,.95)" : "rgba(127,29,29,.95)"}">${fmt(sav)}</strong>
            </div>
            <span class="badge ${sav>=0 ? "success" : "danger"}">${sav>=0 ? "Positive" : "Negative"}</span>
          </div>
          <div class="summary-foot">
            <span>Savings Rate</span>
            <span>${rate.toFixed(0)}%</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Investments and tax">
          <div class="summary-top">
            <div class="meta">
              <span>Inv. Return (est.)</span>
              <strong>${fmt(inv)}</strong>
            </div>
            <span class="badge">Tax ${state.taxRate.toFixed(1)}%</span>
          </div>
          <div class="summary-foot">
            <span>Tax Est.</span>
            <span>${fmt(tax)}</span>
          </div>
        </article>
      `;
    }

    function renderInsights(rows){
      const income = rows.reduce((a,b)=>a+b.income,0);
      const expenses = rows.reduce((a,b)=>a+b.expenses,0);
      const sav = income - expenses;
      const rate = income ? (sav/income)*100 : 0;

      // Find top expense category from weights
      const topCat = Object.entries(categoryWeights).slice().sort((a,b)=>b[1]-a[1])[0]?.[0] || "Rent";
      const topCatShare = (categoryWeights[topCat] || 0) * 100;

      // Savings health
      let savingsInsightClass = "success";
      let savingsHeadline = "Healthy Savings Rate";
      let savingsMsg = `Your savings rate is ${rate.toFixed(0)}%. Keep it above 20% for strong financial health.`;

      if (rate < 10){
        savingsInsightClass = "warning";
        savingsHeadline = "Savings Rate Needs Attention";
        savingsMsg = `Your savings rate is ${rate.toFixed(0)}%. Consider reducing discretionary spending or increasing income streams.`;
      } else if (rate < 0){
        savingsInsightClass = "danger";
        savingsHeadline = "Negative Savings";
        savingsMsg = `You're spending more than you earn in this period. Review budgets and reduce high-impact categories.`;
      }

      const inv = rows.reduce((a,b)=>a+b.investReturn,0);
      const invMsg = inv > 0
        ? `Estimated investment return is ${fmt(inv)}. Keep contributions consistent to align with long-term goals.`
        : `No investment returns recorded. Consider tracking investment accounts for better net worth reporting.`;

      const grid = document.getElementById("insightsGrid");
      grid.innerHTML = `
        <article class="card insight ${savingsInsightClass}">
          <h4>${savingsHeadline}</h4>
          <p>${savingsMsg}</p>
          <div class="row">
            <span class="badge ${rate>=20 ? "success" : "warning"}">${rate.toFixed(0)}% rate</span>
            <span class="chip">Net: ${fmt(sav)}</span>
          </div>
        </article>

        <article class="card insight warning">
          <h4>Top Spending Category: ${topCat}</h4>
          <p>${topCat} represents about ${topCatShare.toFixed(0)}% of estimated spending. Review this category for quick savings opportunities.</p>
          <div class="row">
            <span class="badge warning">${topCatShare.toFixed(0)}% share</span>
            <span class="chip">Strategy: optimize</span>
          </div>
        </article>

        <article class="card insight">
          <h4>Investment Alignment</h4>
          <p>${invMsg}</p>
          <div class="row">
            <span class="badge">${fmt(inv)}</span>
            <span class="chip">Long-term growth</span>
          </div>
        </article>

        <article class="card insight success">
          <h4>Tax Planning (basic)</h4>
          <p>Based on your selected rate (${state.taxRate.toFixed(1)}%), we show a simple tax estimate. Replace with real slabs in ASP.NET backend.</p>
          <div class="row">
            <span class="badge success">Estimate enabled</span>
            <span class="chip">Backend: tax rules</span>
          </div>
        </article>
      `;
    }

    // ---------------------------
    // Table: filter/sort/pagination
    // ---------------------------
    function applySearch(rows){
      const q = (state.search || "").trim().toLowerCase();
      if (!q) return rows;
      return rows.filter(r => r.label.toLowerCase().includes(q));
    }

    function sortRows(rows){
      const { key, dir } = state.sort;
      const sign = dir === "asc" ? 1 : -1;
      const copy = [...rows];

      copy.sort((a,b) => {
        let av = a[key], bv = b[key];
        if (key === "label"){
          return sign * String(av).localeCompare(String(bv));
        }
        return sign * (Number(av) - Number(bv));
      });
      return copy;
    }

    function paginate(rows){
      const totalItems = rows.length;
      const totalPages = Math.max(1, Math.ceil(totalItems / state.pageSize));
      state.page = clamp(state.page, 1, totalPages);
      const start = (state.page - 1) * state.pageSize;
      return { pageItems: rows.slice(start, start + state.pageSize), totalItems, totalPages, start };
    }

    function updateSortIndicators(){
      const ids = ["label","income","expenses","savings","savingsRate","investReturn","taxEst"];
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

    function renderTable(rows){
      const tbody = document.getElementById("reportTbody");
      const empty = document.getElementById("emptyState");
      const tableWrap = document.getElementById("tableWrap");

      const searched = applySearch(rows);
      const sorted = sortRows(searched);
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

      tbody.innerHTML = pageItems.map(r => {
        const savCls = r.savings >= 0 ? "good" : "bad";
        const rateCls = r.savingsRate >= 20 ? "good" : "bad";
        return `
          <tr>
            <td>${r.label}</td>
            <td class="amount good">${fmt(r.income)}</td>
            <td class="amount bad">${fmt(r.expenses)}</td>
            <td class="amount ${savCls}">${fmt(r.savings)}</td>
            <td class="amount ${rateCls}">${r.savingsRate.toFixed(0)}%</td>
            <td class="amount good">${fmt(r.investReturn)}</td>
            <td class="amount">${fmt(r.taxEst)}</td>
          </tr>
        `;
      }).join("");

      const end = start + pageItems.length;
      document.getElementById("pageInfo").textContent = `Showing ${start+1}–${end} of ${totalItems}`;
      renderPager(state.page, totalPages);
    }

    // ---------------------------
    // Export helpers
    // ---------------------------
    function showToast(title, sub){
      document.getElementById("toastTitle").textContent = title;
      document.getElementById("toastSub").textContent = sub;
      const t = document.getElementById("toast");
      t.classList.add("show");
      clearTimeout(showToast._t);
      showToast._t = setTimeout(() => t.classList.remove("show"), 2400);
    }

    function download(filename, content, type){
      const blob = new Blob([content], { type });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = filename;
      document.body.appendChild(a);
      a.click();
      a.remove();
      URL.revokeObjectURL(url);
    }

    function toCsv(rows){
      const header = ["Period","Income","Expenses","Savings","SavingsRate(%)","InvestReturn","TaxEst"];
      const lines = rows.map(r => [
        r.label,
        r.income,
        r.expenses,
        r.savings,
        r.savingsRate.toFixed(2),
        r.investReturn,
        r.taxEst.toFixed(2)
      ].join(","));
      return [header.join(","), ...lines].join("\n");
    }

    // ---------------------------
    // Render all
    // ---------------------------
    function renderRangeChip(){
      document.getElementById("rangeChip").textContent = `${state.from} → ${state.to} • ${state.period}`;
      document.getElementById("updatedChip").textContent = `Updated: ${new Date().toLocaleString()}`;
    }

    function rerenderAll(){
      renderRangeChip();
      const rows = buildReportRows();
      renderSummary(rows);
      renderInsights(rows);
      renderCharts(rows);
      updateSortIndicators();
      renderTable(rows);
      return rows;
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

      // Controls
      document.getElementById("applyBtn").addEventListener("click", () => {
        state.period = document.getElementById("period").value;
        state.from = document.getElementById("dateFrom").value || state.from;
        state.to = document.getElementById("dateTo").value || state.to;
        state.taxRate = Number(document.getElementById("taxRate").value || state.taxRate);
        state.page = 1;
        rerenderAll();
        showToast("Applied", "Report filters applied (demo).");
      });

      document.getElementById("resetBtn").addEventListener("click", () => {
        state.period = "monthly";
        state.from = MONTHS[0];
        state.to = MONTHS[MONTHS.length - 1];
        state.taxRate = 12.5;
        state.search = "";
        state.sort = { key:"label", dir:"asc" };
        state.page = 1;

        document.getElementById("period").value = state.period;
        document.getElementById("dateFrom").value = state.from;
        document.getElementById("dateTo").value = state.to;
        document.getElementById("taxRate").value = state.taxRate;
        document.getElementById("tableSearch").value = "";

        rerenderAll();
        showToast("Reset", "Defaults restored (demo).");
      });

      // Table search
      document.getElementById("tableSearch").addEventListener("input", (e) => {
        state.search = e.target.value;
        state.page = 1;
        rerenderAll();
      });

      document.getElementById("clearSearch").addEventListener("click", () => {
        state.search = "";
        document.getElementById("tableSearch").value = "";
        state.page = 1;
        rerenderAll();
      });

      document.getElementById("emptyResetBtn").addEventListener("click", () => {
        document.getElementById("resetBtn").click();
      });

      // Sorting
      document.querySelectorAll("thead th[data-sort]").forEach(th => {
        th.addEventListener("click", () => {
          const key = th.getAttribute("data-sort");
          if (!key) return;
          if (state.sort.key === key) state.sort.dir = state.sort.dir === "asc" ? "desc" : "asc";
          else { state.sort.key = key; state.sort.dir = (key === "label" ? "asc" : "desc"); }
          rerenderAll();
        });
      });

      // Pagination
      document.getElementById("pager").addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-page]");
        if (!btn) return;
        state.page = Number(btn.dataset.page);
        rerenderAll();
      });

      // Exports
      document.getElementById("exportJsonBtn").addEventListener("click", () => {
        const rows = buildReportRows();
        download("report-demo.json", JSON.stringify({ meta: deepClone(state), rows }, null, 2), "application/json");
        showToast("Exported", "JSON downloaded (demo).");
      });

      document.getElementById("exportCsvBtn").addEventListener("click", () => {
        const rows = buildReportRows();
        download("report-demo.csv", toCsv(rows), "text/csv");
        showToast("Exported", "CSV downloaded (demo).");
      });

      document.getElementById("generateBtn").addEventListener("click", () => {
        showToast("Generated", "Report generated (demo). In MVC: generate PDF/server report.");
      });
    }

    // ---------------------------
    // Init
    // ---------------------------
    function initDefaults(){
      state.from = MONTHS[0];
      state.to = MONTHS[MONTHS.length - 1];

      document.getElementById("period").value = state.period;
      document.getElementById("dateFrom").value = state.from;
      document.getElementById("dateTo").value = state.to;
      document.getElementById("taxRate").value = state.taxRate;
    }

    buildCharts();
    initDefaults();
    bindEvents();
    rerenderAll();
  </script>
</body>
</html>