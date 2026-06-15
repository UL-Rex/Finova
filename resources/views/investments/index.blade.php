<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Investments • Personal Finance Dashboard</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --sidebar-bg: #0b1220;
            --sidebar-bg2: #0a1020;
            --sidebar-text: rgba(255, 255, 255, .85);
            --sidebar-muted: rgba(255, 255, 255, .60);

            --content-bg: #f4f7fb;
            --content-bg2: #eef3fb;

            --card-bg: #ffffff;
            --card-stroke: rgba(17, 24, 39, .08);
            --text: #0f172a;
            --muted: #64748b;

            --brand: #4f46e5;
            --brand-2: #2563eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;

            --radius: 14px;
            --shadow: 0 10px 30px rgba(15, 23, 42, .08);
            --shadow2: 0 6px 18px rgba(15, 23, 42, .10);

            --ring: 0 0 0 4px rgba(79, 70, 229, .18);
            --t: 160ms cubic-bezier(.2, .8, .2, 1);

            --sidebar-w: 270px;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(900px 400px at 25% 0%, rgba(79, 70, 229, .10), transparent 60%),
                radial-gradient(900px 400px at 85% 10%, rgba(37, 99, 235, .08), transparent 60%),
                linear-gradient(180deg, var(--content-bg), var(--content-bg2));
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .app {
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            padding: 18px 14px;
            background: linear-gradient(180deg, var(--sidebar-bg), var(--sidebar-bg2));
            border-right: 1px solid rgba(255, 255, 255, .06);
            z-index: 40;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px 16px 10px;
            margin-bottom: 10px;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 1), rgba(37, 99, 235, 1));
            display: grid;
            place-items: center;
            color: white;
            font-weight: 800;
            box-shadow: 0 14px 30px rgba(79, 70, 229, .25);
        }

        .brand-text strong {
            display: block;
            color: white;
            font-size: 14px;
            letter-spacing: -.2px;
        }

        .brand-text span {
            display: block;
            color: var(--sidebar-muted);
            font-size: 12px;
            margin-top: 2px;
        }

        .nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding: 6px;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 12px;
            border-radius: 12px;
            color: var(--sidebar-text);
            border: 1px solid transparent;
            transition: background var(--t), transform var(--t), border-color var(--t);
        }

        .nav a:hover {
            background: rgba(255, 255, 255, .06);
            border-color: rgba(255, 255, 255, .10);
            transform: translateY(-1px);
        }

        .nav a.active {
            background: linear-gradient(135deg, rgba(79, 70, 229, .22), rgba(37, 99, 235, .14));
            border-color: rgba(79, 70, 229, .40);
            color: rgba(255, 255, 255, .95);
        }

        .nav .icon {
            width: 20px;
            height: 20px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .08);
            font-size: 12px;
            flex: 0 0 auto;
        }

        .nav .label {
            font-size: 13px;
            font-weight: 600;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 14px;
            left: 14px;
            right: 14px;
            padding: 12px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .10);
            color: rgba(255, 255, 255, .85);
        }

        .sidebar-footer .small {
            margin-top: 6px;
            font-size: 12px;
            color: var(--sidebar-muted);
            line-height: 1.35;
        }

        /* Main */
        .main {
            flex: 1;
            margin-left: var(--sidebar-w);
            padding: 22px 22px 36px;
            max-width: 1440px;
            width: 100%;
        }

        /* Header */
        .top-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
        }

        .title-block h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: -.3px;
        }

        .title-block p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .btn {
            height: 44px;
            padding: 0 12px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .85);
            color: var(--text);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform var(--t), box-shadow var(--t), background var(--t), border-color var(--t);
            box-shadow: 0 1px 0 rgba(15, 23, 42, .03);
            user-select: none;
            font-weight: 600;
            font-size: 13px;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow2);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            border-color: rgba(79, 70, 229, .35);
            color: #fff;
            box-shadow: 0 16px 30px rgba(79, 70, 229, .18);
        }

        .btn-primary:hover {
            box-shadow: 0 18px 36px rgba(79, 70, 229, .22);
            border-color: rgba(79, 70, 229, .45);
        }

        .chip {
            font-size: 12px;
            color: rgba(15, 23, 42, .70);
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(15, 23, 42, .03);
            padding: 6px 10px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-stroke);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .card:hover {
            border-color: rgba(15, 23, 42, .14);
        }

        .section {
            margin-top: 14px;
        }

        .section-title {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .section-title h2 {
            margin: 0;
            font-size: 14px;
            letter-spacing: -.2px;
        }

        .section-title p {
            margin: 4px 0 0;
            font-size: 12px;
            color: var(--muted);
        }

        /* Summary cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .summary-card {
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            transition: transform var(--t), box-shadow var(--t);
        }

        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, .10);
        }

        .summary-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .summary-top .meta span {
            display: block;
            font-size: 12px;
            color: var(--muted);
        }

        .summary-top .meta strong {
            display: block;
            margin-top: 4px;
            font-size: 18px;
            letter-spacing: -.3px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(15, 23, 42, .03);
            color: rgba(15, 23, 42, .75);
            white-space: nowrap;
        }

        .badge.success {
            background: rgba(16, 185, 129, .10);
            border-color: rgba(16, 185, 129, .25);
            color: rgba(6, 95, 70, .95);
        }

        .badge.warning {
            background: rgba(245, 158, 11, .12);
            border-color: rgba(245, 158, 11, .28);
            color: rgba(120, 53, 15, .95);
        }

        .badge.danger {
            background: rgba(239, 68, 68, .10);
            border-color: rgba(239, 68, 68, .25);
            color: rgba(127, 29, 29, .95);
        }

        .summary-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
            color: var(--muted);
        }

        /* Analytics */
        .analytics-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 12px;
            align-items: stretch;
        }

        .card-head {
            padding: 14px 14px 0;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 10px;
        }

        .card-head h3 {
            margin: 0;
            font-size: 14px;
            letter-spacing: -.2px;
        }

        .card-head p {
            margin: 4px 0 0;
            font-size: 12px;
            color: var(--muted);
        }

        .canvas-wrap {
            padding: 10px 14px 14px;
            height: 320px;
        }

        /* Holdings Table */
        .table-card {
            padding: 14px;
        }

        .table-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .search {
            position: relative;
            max-width: 420px;
            width: min(520px, 100%);
        }

        .search input {
            width: 100%;
            height: 44px;
            padding: 10px 12px 10px 40px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .82);
            outline: none;
            transition: box-shadow var(--t), border-color var(--t), background var(--t);
        }

        .search input:focus {
            border-color: rgba(79, 70, 229, .35);
            box-shadow: var(--ring);
            background: #fff;
        }

        .search .mag {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(15, 23, 42, .55);
            font-size: 14px;
            pointer-events: none;
        }

        .table-wrap {
            overflow: auto;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1080px;
            background: #fff;
        }

        thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            text-align: left;
            font-size: 12px;
            letter-spacing: .2px;
            color: rgba(15, 23, 42, .70);
            background: rgba(15, 23, 42, .03);
            border-bottom: 1px solid rgba(15, 23, 42, .08);
            padding: 12px 10px;
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
        }

        thead th .sort {
            margin-left: 6px;
            font-size: 11px;
            color: rgba(15, 23, 42, .45);
        }

        tbody td {
            font-size: 12.5px;
            color: rgba(15, 23, 42, .90);
            border-bottom: 1px solid rgba(15, 23, 42, .06);
            padding: 12px 10px;
            vertical-align: middle;
            white-space: nowrap;
        }

        tbody tr:hover td {
            background: rgba(79, 70, 229, .04);
        }

        .amount {
            text-align: right;
            font-variant-numeric: tabular-nums;
            font-weight: 800;
        }

        .amount.positive {
            color: rgba(6, 95, 70, .95);
        }

        .amount.negative {
            color: rgba(127, 29, 29, .95);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(15, 23, 42, .03);
            color: rgba(15, 23, 42, .75);
            white-space: nowrap;
        }

        .badge.success {
            background: rgba(16, 185, 129, .10);
            border-color: rgba(16, 185, 129, .25);
            color: rgba(6, 95, 70, .95);
        }

        .badge.warning {
            background: rgba(245, 158, 11, .12);
            border-color: rgba(245, 158, 11, .28);
            color: rgba(120, 53, 15, .95);
        }

        .actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .link-btn {
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .9);
            height: 34px;
            padding: 0 10px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: transform var(--t), box-shadow var(--t), background var(--t), border-color var(--t);
        }

        .link-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(15, 23, 42, .10);
        }

        .link-btn.danger {
            border-color: rgba(239, 68, 68, .25);
            background: rgba(239, 68, 68, .06);
            color: rgba(127, 29, 29, .95);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, .55);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 90;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            width: 760px;
            max-width: 100%;
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, .25);
            box-shadow: 0 30px 80px rgba(2, 6, 23, .35);
            overflow: hidden;
        }

        .modal-head {
            padding: 14px 14px 0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .modal-head h3 {
            margin: 0;
            font-size: 16px;
            letter-spacing: -.2px;
        }

        .modal-head p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .modal-close {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(15, 23, 42, .03);
            cursor: pointer;
            transition: transform var(--t), box-shadow var(--t);
        }

        .modal-close:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(15, 23, 42, .12);
        }

        .modal-body {
            padding: 12px 14px 14px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .field textarea {
            height: 92px;
            padding: 10px;
        }

        .field .hint {
            margin-top: 6px;
            font-size: 12px;
            color: var(--muted);
        }

        .modal-foot {
            padding: 12px 14px 14px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid rgba(15, 23, 42, .08);
            background: rgba(15, 23, 42, .02);
        }

        /* Responsive */
        .mobile-bar {
            display: none;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .hamburger {
            display: none;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .90);
            cursor: pointer;
            transition: transform var(--t), box-shadow var(--t);
        }

        .hamburger:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow2);
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, .45);
            display: none;
            z-index: 35;
        }

        body.sidebar-open .sidebar-overlay {
            display: block;
        }

        @media (max-width: 1200px) {
            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .analytics-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            .main {
                margin-left: 0;
            }

            .sidebar {
                transform: translateX(-110%);
                transition: transform var(--t);
                width: 290px;
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .hamburger {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .mobile-bar {
                display: flex;
            }

            .top-header {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions {
                justify-content: space-between;
            }
        }

        @media (max-width: 520px) {
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .btn,
            .btn-primary {
                width: 100%;
                justify-content: center;
            }

            .header-actions {
                flex-direction: column;
                align-items: stretch;
            }
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

            @if (session('success'))
                <div
                    style="padding:12px 16px;background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.25);border-radius:12px;color:rgba(6,95,70,.95);font-size:13px;margin-bottom:14px;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Mobile bar -->
            <div class="mobile-bar">
                <button class="hamburger" id="hamburger" aria-label="Open sidebar">☰</button>
                <div style="font-weight:800; letter-spacing:-.2px;">Investments</div>
            </div>

            <!-- Header -->
            <header class="top-header">
                <div class="title-block">
                    <h1>Investments</h1>
                    <p>Track your portfolio performance and asset allocation</p>
                </div>

                <div class="header-actions">
                    <button class="btn" id="exportBtn" type="button">Export CSV</button>
                    <button class="btn btn-primary" id="openAddModal" type="button">
                        <span>＋</span> Add Investment
                    </button>
                </div>
            </header>

            <!-- Summary Cards -->
            <section class="section" aria-labelledby="summaryTitle">
                <div class="section-title">
                    <div>
                        <h2 id="summaryTitle">Portfolio Summary</h2>
                        <p>Current snapshot of your investments</p>
                    </div>
                    <span class="chip" id="lastUpdated">Last updated: Today</span>
                </div>

                <div class="summary-grid" id="summaryGrid"></div>
            </section>

            <!-- Analytics -->
            <section class="section" aria-labelledby="analyticsTitle">
                <div class="section-title">
                    <div>
                        <h2 id="analyticsTitle">Portfolio Analytics</h2>
                        <p>Asset allocation and performance trends</p>
                    </div>
                </div>

                <div class="analytics-grid">
                    <article class="card" aria-label="Portfolio value trend">
                        <div class="card-head">
                            <div>
                                <h3>Portfolio Value Trend</h3>
                                <p>Last 6 months performance</p>
                            </div>
                            <span class="chip">Line</span>
                        </div>
                        <div class="canvas-wrap">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </article>

                    <article class="card" aria-label="Asset allocation">
                        <div class="card-head">
                            <div>
                                <h3>Asset Allocation</h3>
                                <p>By investment type</p>
                            </div>
                            <span class="chip">Doughnut</span>
                        </div>
                        <div class="canvas-wrap">
                            <canvas id="allocationChart"></canvas>
                        </div>
                    </article>
                </div>
            </section>

            <!-- Holdings Table -->
            <section class="section" aria-labelledby="holdingsTitle">
                <div class="section-title">
                    <div>
                        <h2 id="holdingsTitle">Investment Holdings</h2>
                        <p>Your current investments and performance</p>
                    </div>
                </div>

                <article class="card table-card">
                    <div class="table-toolbar">
                        <div class="search">
                            <span class="mag">⌕</span>
                            <label class="sr-only" for="tableSearch">Search investments</label>
                            <input id="tableSearch" type="search" placeholder="Search symbol, name, type…" />
                        </div>
                        <div>
                            <span class="chip" id="resultsChip">0 holdings</span>
                        </div>
                    </div>

                    <div class="table-wrap">
                        <table aria-label="Investment holdings table">
                            <thead>
                                <tr>
                                    <th data-sort="symbol">Symbol <span class="sort" id="sort-symbol">↕</span></th>
                                    <th data-sort="name">Name <span class="sort" id="sort-name">↕</span></th>
                                    <th data-sort="type">Type <span class="sort" id="sort-type">↕</span></th>
                                    <th data-sort="quantity" style="text-align:right;">Quantity <span class="sort"
                                            id="sort-quantity">↕</span></th>
                                    <th data-sort="purchasePrice" style="text-align:right;">Purchase Price <span
                                            class="sort" id="sort-purchasePrice">↕</span></th>
                                    <th data-sort="currentPrice" style="text-align:right;">Current Price <span
                                            class="sort" id="sort-currentPrice">↕</span></th>
                                    <th data-sort="currentValue" style="text-align:right;">Current Value <span
                                            class="sort" id="sort-currentValue">↕</span></th>
                                    <th data-sort="return" style="text-align:right;">Return <span class="sort"
                                            id="sort-return">↕</span></th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="holdingsTbody"></tbody>
                        </table>
                    </div>
                </article>
            </section>
        </main>
    </div>

    <!-- Add/Edit Investment Modal -->
    <div class="modal-overlay" id="modalOverlay" aria-hidden="true">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="modal-head">
                <div>
                    <h3 id="modalTitle">Add Investment</h3>
                    <p id="modalSubtitle">Add a new investment to your portfolio</p>
                </div>
                <button class="modal-close" id="closeModal" type="button" aria-label="Close">✕</button>
            </div>

            <form class="modal-body" id="investmentForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="investmentId">

                <div class="form-grid">
                    <div class="field">
                        <label for="symbol">Symbol / Ticker</label>
                        <input id="symbol" class="control" type="text" placeholder="e.g., AAPL, BTC, TSLA"
                            required />
                    </div>

                    <div class="field">
                        <label for="name">Investment Name</label>
                        <input id="name" name="name" class="control" type="text"
                            placeholder="e.g., Apple Inc." required />
                    </div>

                    <div class="field">
                        <label for="type">Investment Type</label>
                        <select id="type" name="type" class="control" required>
                            <option value="">Select type</option>
                            <option>Stocks</option>
                            <option>Mutual Funds</option>
                            <option>Bonds</option>
                            <option>Crypto</option>
                            <option>Real Estate</option>
                            <option>ETFs</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="quantity">Quantity</label>
                        <input id="quantity" class="control" type="number" min="0" step="0.01"
                            placeholder="0.00" required />
                    </div>

                    <div class="field">
                        <label for="purchasePrice">Purchase Price</label>
                        <input id="purchasePrice" name="invested_amount" class="control" type="number"
                            min="0" step="0.01" placeholder="0.00" required />
                    </div>

                    <div class="field">
                        <label for="currentPrice">Current Price</label>
                        <input id="currentPrice" name="current_value" class="control" type="number" min="0"
                            step="0.01" placeholder="0.00" required />
                    </div>

                    <div class="field">
                        <label for="purchaseDate">Purchase Date</label>
                        <input id="purchaseDate" name="date" class="control" type="date" required />
                    </div>

                    <div class="field">
                        <label for="notes">Notes (optional)</label>
                        <textarea id="notes" name="note" class="control" placeholder="Broker, strategy, etc."></textarea>
                    </div>
                </div>
            </form>

            <div class="modal-foot">
                <button class="btn" id="cancelModal" type="button">Cancel</button>
                <button class="btn btn-primary" id="saveInvestment" type="button">Save Investment</button>
            </div>
        </div>
    </div>

    <script>
        // ---------------------------
        // Dummy Data
        // ---------------------------
        let investments = {!! json_encode(
            $investments->map(
                fn($i) => [
                    'id' => $i->id,
                    'symbol' => strtoupper(substr($i->name, 0, 4)),
                    'name' => $i->name,
                    'type' => $i->type,
                    'quantity' => 1,
                    'purchasePrice' => (float) $i->invested_amount,
                    'currentPrice' => (float) $i->current_value,
                    'purchaseDate' => $i->date,
                    'notes' => $i->note ?? '',
                ],
            ),
        ) !!};

        const state = {
            search: "",
            sort: {
                key: "currentValue",
                dir: "desc"
            }
        };

        const fmt = (n) => new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD"
        }).format(n);
        const escapeHtml = (str) => String(str).replace(/[&<>"']/g, m => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        } [m]));

        // ---------------------------
        // Summary Cards
        // ---------------------------
        function renderSummary() {
            const totalValue = investments.reduce((sum, i) => sum + (i.quantity * i.currentPrice), 0);
            const totalCost = investments.reduce((sum, i) => sum + (i.quantity * i.purchasePrice), 0);
            const totalReturn = totalValue - totalCost;
            const roi = totalCost > 0 ? (totalReturn / totalCost) * 100 : 0;

            const grid = document.getElementById("summaryGrid");
            grid.innerHTML = `
        <article class="card summary-card" aria-label="Total Portfolio Value">
          <div class="summary-top">
            <div class="meta">
              <span>Total Portfolio Value</span>
              <strong>${fmt(totalValue)}</strong>
            </div>
            <span class="badge success">Live</span>
          </div>
          <div class="summary-foot">
            <span>Across ${investments.length} holdings</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Total Return">
          <div class="summary-top">
            <div class="meta">
              <span>Total Return</span>
              <strong style="color:${totalReturn >= 0 ? 'rgba(6,95,70,.95)' : 'rgba(127,29,29,.95)'}">${fmt(totalReturn)}</strong>
            </div>
            <span class="badge ${totalReturn >= 0 ? 'success' : 'danger'}">${totalReturn >= 0 ? 'Profit' : 'Loss'}</span>
          </div>
          <div class="summary-foot">
            <span>Realized + Unrealized</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Return on Investment">
          <div class="summary-top">
            <div class="meta">
              <span>Return on Investment</span>
              <strong>${roi.toFixed(1)}%</strong>
            </div>
            <span class="badge ${roi >= 0 ? 'success' : 'danger'}">${roi >= 0 ? 'Positive' : 'Negative'}</span>
          </div>
          <div class="summary-foot">
            <span>Since purchase</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Number of Investments">
          <div class="summary-top">
            <div class="meta">
              <span>Number of Investments</span>
              <strong>${investments.length}</strong>
            </div>
            <span class="badge">Active</span>
          </div>
          <div class="summary-foot">
            <span>Portfolio diversity</span>
          </div>
        </article>
      `;
        }

        // ---------------------------
        // Charts
        // ---------------------------
        let trendChart, allocationChart;

        function buildCharts() {
            trendChart = new Chart(document.getElementById("trendChart"), {
                type: "line",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                    datasets: [{
                        label: "Portfolio Value",
                        data: [45200, 48900, 52100, 49800, 56700, 61250],
                        borderColor: "rgba(79,70,229,1)",
                        backgroundColor: "rgba(79,70,229,.12)",
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: "rgba(15,23,42,.06)"
                            },
                            ticks: {
                                color: "rgba(15,23,42,.65)"
                            }
                        },
                        y: {
                            grid: {
                                color: "rgba(15,23,42,.06)"
                            },
                            ticks: {
                                color: "rgba(15,23,42,.65)",
                                callback: (v) => "$" + v
                            }
                        }
                    }
                }
            });

            allocationChart = new Chart(document.getElementById("allocationChart"), {
                type: "doughnut",
                data: {
                    labels: ["Stocks", "Crypto", "ETFs", "Mutual Funds", "Bonds"],
                    datasets: [{
                        data: [42, 18, 28, 8, 4],
                        backgroundColor: [
                            "rgba(79,70,229,.88)",
                            "rgba(245,158,11,.84)",
                            "rgba(16,185,129,.80)",
                            "rgba(37,99,235,.80)",
                            "rgba(100,116,139,.70)"
                        ],
                        borderColor: "rgba(255,255,255,.95)",
                        borderWidth: 2
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
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        // ---------------------------
        // Table
        // ---------------------------
        function renderTable() {
            const tbody = document.getElementById("holdingsTbody");
            let filtered = investments;

            // Search
            const searchTerm = document.getElementById("tableSearch").value.toLowerCase().trim();
            if (searchTerm) {
                filtered = filtered.filter(i =>
                    i.symbol.toLowerCase().includes(searchTerm) ||
                    i.name.toLowerCase().includes(searchTerm) ||
                    i.type.toLowerCase().includes(searchTerm)
                );
            }

            // Sort
            const {
                key,
                dir
            } = state.sort;
            const sign = dir === "asc" ? 1 : -1;
            filtered.sort((a, b) => {
                let av, bv;
                if (key === "currentValue") {
                    av = a.quantity * a.currentPrice;
                    bv = b.quantity * b.currentPrice;
                } else if (key === "return") {
                    av = ((a.currentPrice - a.purchasePrice) / a.purchasePrice) * 100;
                    bv = ((b.currentPrice - b.purchasePrice) / b.purchasePrice) * 100;
                } else {
                    av = a[key];
                    bv = b[key];
                }
                return sign * (av - bv);
            });

            document.getElementById("resultsChip").textContent = `${filtered.length} holdings`;

            tbody.innerHTML = filtered.map(inv => {
                const currentValue = inv.quantity * inv.currentPrice;
                const costBasis = inv.quantity * inv.purchasePrice;
                const ret = ((inv.currentPrice - inv.purchasePrice) / inv.purchasePrice) * 100;
                const retClass = ret >= 0 ? "positive" : "negative";

                return `
          <tr>
            <td><strong>${escapeHtml(inv.symbol)}</strong></td>
            <td>${escapeHtml(inv.name)}</td>
            <td><span class="badge">${escapeHtml(inv.type)}</span></td>
            <td class="amount">${inv.quantity}</td>
            <td class="amount">${fmt(inv.purchasePrice)}</td>
            <td class="amount">${fmt(inv.currentPrice)}</td>
            <td class="amount"><strong>${fmt(currentValue)}</strong></td>
            <td class="amount ${retClass}"><strong>${ret.toFixed(1)}%</strong></td>
            <td>
              <div class="actions">
                <button class="link-btn" type="button" data-action="edit" data-id="${inv.id}">Edit</button>
                <button class="link-btn danger" type="button" data-action="delete" data-id="${inv.id}">Delete</button>
              </div>
            </td>
          </tr>
        `;
            }).join("");
        }

        // ---------------------------
        // Modal
        // ---------------------------
        let modalMode = "add";
        const modalOverlay = document.getElementById("modalOverlay");

        function openModal(mode, investment = null) {
            modalMode = mode;
            const title = document.getElementById("modalTitle");
            const subtitle = document.getElementById("modalSubtitle");
            const saveBtn = document.getElementById("saveInvestment");

            if (mode === "add") {
                title.textContent = "Add Investment";
                subtitle.textContent = "Add a new investment to your portfolio";
                saveBtn.textContent = "Save Investment";
                document.getElementById("investmentForm").reset();
                document.getElementById("investmentId").value = "";
                document.getElementById("purchaseDate").value = new Date().toISOString().slice(0, 10);
            } else {
                title.textContent = "Edit Investment";
                subtitle.textContent = "Update investment details";
                saveBtn.textContent = "Update Investment";
                fillForm(investment);
            }

            modalOverlay.classList.add("open");
            modalOverlay.setAttribute("aria-hidden", "false");
        }

        function closeModal() {
            modalOverlay.classList.remove("open");
            modalOverlay.setAttribute("aria-hidden", "true");
        }

        function fillForm(inv) {
            document.getElementById("investmentId").value = inv.id;
            document.getElementById("symbol").value = inv.symbol;
            document.getElementById("name").value = inv.name;
            document.getElementById("type").value = inv.type;
            document.getElementById("quantity").value = inv.quantity;
            document.getElementById("purchasePrice").value = inv.purchasePrice;
            document.getElementById("currentPrice").value = inv.currentPrice;
            document.getElementById("purchaseDate").value = inv.purchaseDate;
            document.getElementById("notes").value = inv.notes || "";
        }

        function saveInvestment() {
            const form = document.getElementById("investmentForm");
            if (!form.reportValidity()) return;
            const id = document.getElementById("investmentId").value;
            document.getElementById("formMethod").value = id ? "PUT" : "POST";
            form.action = id ? `/investments/${id}` : "/investments";
            form.submit();
        }

        // ---------------------------
        // Events
        // ---------------------------
        function bindEvents() {
            // Search
            document.getElementById("tableSearch").addEventListener("input", () => {
                renderTable();
            });

            // Table sorting
            document.querySelectorAll("thead th[data-sort]").forEach(th => {
                th.addEventListener("click", () => {
                    const key = th.getAttribute("data-sort");
                    if (state.sort.key === key) {
                        state.sort.dir = state.sort.dir === "asc" ? "desc" : "asc";
                    } else {
                        state.sort.key = key;
                        state.sort.dir = key === "currentValue" || key === "return" ? "desc" : "asc";
                    }
                    renderTable();
                });
            });

            // Table actions
            document.getElementById("holdingsTbody").addEventListener("click", (e) => {
                const btn = e.target.closest("button[data-action]");
                if (!btn) return;

                const action = btn.dataset.action;
                const id = btn.dataset.id;
                const inv = investments.find(i => i.id === id);

                if (action === "edit") openModal("edit", inv);
                if (action === "delete") {
                    if (confirm("Delete this investment?")) {
                        const f = document.createElement("form");
                        f.method = "POST";
                        f.action = `/investments/${id}`;
                        f.innerHTML =
                            `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                        document.body.appendChild(f);
                        f.submit();
                    }
                }
            });

            // Modal
            document.getElementById("openAddModal").addEventListener("click", () => openModal("add"));
            document.getElementById("closeModal").addEventListener("click", closeModal);
            document.getElementById("cancelModal").addEventListener("click", closeModal);
            document.getElementById("saveInvestment").addEventListener("click", saveInvestment);

            modalOverlay.addEventListener("click", (e) => {
                if (e.target === modalOverlay) closeModal();
            });

            // Export
            document.getElementById("exportBtn").addEventListener("click", () => {
                const csv = "Symbol,Name,Type,Quantity,Purchase Price,Current Price,Value,Return\n" +
                    investments.map(i => {
                        const val = i.quantity * i.currentPrice;
                        const ret = ((i.currentPrice - i.purchasePrice) / i.purchasePrice) * 100;
                        return `${i.symbol},${i.name},${i.type},${i.quantity},${i.purchasePrice},${i.currentPrice},${val},${ret.toFixed(2)}%`;
                    }).join("\n");

                const blob = new Blob([csv], {
                    type: "text/csv"
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url;
                a.download = "investments.csv";
                a.click();
                URL.revokeObjectURL(url);
            });
        }

        function renderAll() {
            renderSummary();
            renderTable();
        }

        // Init
        buildCharts();
        bindEvents();
        renderAll();
    </script>
</body>

</html>
