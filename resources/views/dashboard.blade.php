{{-- @extends('layouts.app') --}}

{{-- @section('title', 'Dashboard — Finova')
@section('page-title', 'Dashboard') --}}



{{-- @section('content') --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — Finova</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
        <style>
            :root {
                --bg0: #070A12;
                --bg1: #0B1020;
                --panel: rgba(255, 255, 255, 0.06);
                --panel2: rgba(255, 255, 255, 0.08);
                --stroke: rgba(255, 255, 255, 0.10);
                --text: rgba(255, 255, 255, 0.92);
                --muted: rgba(255, 255, 255, 0.65);

                --brand: #7C5CFF;
                --good: #27D7A8;
                --bad: #FF5D6C;
                --warn: #FFB020;

                --radius: 16px;
                --shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
                --shadow2: 0 6px 18px rgba(0, 0, 0, 0.30);
                --blur: 14px;
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
                    radial-gradient(1200px 600px at 10% 10%, rgba(124, 92, 255, 0.20), transparent 60%),
                    radial-gradient(900px 500px at 90% 20%, rgba(39, 215, 168, 0.12), transparent 55%),
                    radial-gradient(900px 500px at 30% 90%, rgba(255, 93, 108, 0.10), transparent 55%),
                    linear-gradient(180deg, var(--bg0), var(--bg1));
                overflow-x: hidden;
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            /* Layout */
            .app {
                display: flex;
                min-height: 100vh;
            }

            /* Sidebar */
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 270px;
                height: 100vh;
                padding: 18px 14px;
                border-right: 1px solid rgba(255, 255, 255, 0.08);
                background: rgba(8, 10, 18, 0.72);
                backdrop-filter: blur(var(--blur));
                -webkit-backdrop-filter: blur(var(--blur));
                z-index: 50;
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 12px 16px 12px;
                margin-bottom: 8px;
            }

            .brand-badge {
                width: 38px;
                height: 38px;
                border-radius: 12px;
                background: linear-gradient(135deg, rgba(124, 92, 255, 1), rgba(39, 215, 168, 1));
                box-shadow: 0 10px 22px rgba(124, 92, 255, 0.20);
                display: grid;
                place-items: center;
                font-weight: 800;
                letter-spacing: -0.5px;
            }

            .brand-title {
                line-height: 1.1;
            }

            .brand-title strong {
                display: block;
                font-size: 14px;
            }

            .brand-title span {
                font-size: 12px;
                color: var(--muted);
            }

            .nav {
                margin-top: 10px;
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
                color: rgba(255, 255, 255, 0.78);
                border: 1px solid transparent;
                transition: transform .15s ease, background .15s ease, border-color .15s ease;
            }

            .nav a:hover {
                background: rgba(255, 255, 255, 0.06);
                border-color: rgba(255, 255, 255, 0.10);
                transform: translateY(-1px);
            }

            .nav a.active {
                background: linear-gradient(135deg, rgba(124, 92, 255, 0.20), rgba(39, 215, 168, 0.08));
                border-color: rgba(124, 92, 255, 0.35);
                color: rgba(255, 255, 255, 0.92);
            }

            .nav .icon {
                width: 20px;
                height: 20px;
                display: grid;
                place-items: center;
                border-radius: 8px;
                background: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.08);
                font-size: 12px;
            }

            .nav .label {
                font-size: 13px;
                font-weight: 600;
            }

            .sidebar-footer {
                position: absolute;
                left: 14px;
                right: 14px;
                bottom: 14px;
                padding: 12px;
                border-radius: 14px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .sidebar-footer .small {
                font-size: 12px;
                color: var(--muted);
                margin-top: 6px;
                line-height: 1.35;
            }

            /* Main */
            .main {
                flex: 1;
                margin-left: 270px;
                padding: 22px 22px 28px 22px;
                max-width: 1400px;
                width: 100%;
            }

            /* Header */
            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 16px;
            }

            .topbar-left {
                display: flex;
                align-items: center;
                gap: 12px;
                min-width: 240px;
            }

            .hamburger {
                display: none;
                width: 42px;
                height: 42px;
                border-radius: 12px;
                border: 1px solid rgba(255, 255, 255, 0.10);
                background: rgba(255, 255, 255, 0.06);
                color: var(--text);
                cursor: pointer;
                transition: transform .15s ease, background .15s ease;
            }

            .hamburger:hover {
                transform: translateY(-1px);
                background: rgba(255, 255, 255, 0.08);
            }

            .greeting h1 {
                font-size: 18px;
                margin: 0;
                letter-spacing: -0.2px;
            }

            .greeting p {
                margin: 3px 0 0 0;
                font-size: 12px;
                color: var(--muted);
            }

            .summary {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
            }

            .balance-pill {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 14px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.10);
                backdrop-filter: blur(var(--blur));
                -webkit-backdrop-filter: blur(var(--blur));
                box-shadow: var(--shadow2);
                max-width: 520px;
                width: 100%;
            }

            .balance-pill .dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: var(--good);
                box-shadow: 0 0 0 6px rgba(39, 215, 168, 0.10);
                flex: 0 0 auto;
            }

            .balance-pill .meta {
                display: flex;
                flex-direction: column;
                gap: 2px;
                min-width: 0;
            }

            .balance-pill .meta span {
                font-size: 12px;
                color: var(--muted);
            }

            .balance-pill .meta strong {
                font-size: 14px;
                letter-spacing: -0.2px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .topbar-right {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 10px;
                min-width: 200px;
            }

            .icon-btn {
                width: 44px;
                height: 44px;
                border-radius: 14px;
                background: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.10);
                color: var(--text);
                cursor: pointer;
                transition: transform .15s ease, background .15s ease, border-color .15s ease;
                display: grid;
                place-items: center;
                position: relative;
            }

            .icon-btn:hover {
                transform: translateY(-1px);
                background: rgba(255, 255, 255, 0.08);
                border-color: rgba(255, 255, 255, 0.14);
            }

            .badge {
                position: absolute;
                top: 10px;
                right: 10px;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: var(--bad);
                box-shadow: 0 0 0 6px rgba(255, 93, 108, 0.12);
            }

            /* .avatar {
                width: 44px;
                height: 44px;
                border-radius: 14px;
                background:
                    radial-gradient(18px 18px at 30% 30%, rgba(255, 255, 255, 0.35), transparent 60%),
                    linear-gradient(135deg, rgba(124, 92, 255, 0.85), rgba(39, 215, 168, 0.70));
                border: 1px solid rgba(255, 255, 255, 0.16);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
            } */

            /* Cards & grids */
            .grid {
                display: grid;
                gap: 14px;
            }

            .kpis {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                margin: 8px 0 14px;
            }

            .card {
                background: var(--panel);
                border: 1px solid var(--stroke);
                border-radius: var(--radius);
                box-shadow: var(--shadow);
                backdrop-filter: blur(var(--blur));
                -webkit-backdrop-filter: blur(var(--blur));
                overflow: hidden;
            }

            .card-inner {
                padding: 14px 14px 12px 14px;
            }

            .card:hover {
                border-color: rgba(255, 255, 255, 0.14);
                transform: translateY(-1px);
                transition: transform .15s ease, border-color .15s ease;
            }

            .kpi-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 10px;
            }

            .kpi-title {
                font-size: 12px;
                color: var(--muted);
                margin: 0;
            }

            .kpi-icon {
                width: 36px;
                height: 36px;
                border-radius: 14px;
                background: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.10);
                display: grid;
                place-items: center;
                font-size: 13px;
            }

            .kpi-value {
                margin: 0;
                font-size: 18px;
                font-weight: 700;
                letter-spacing: -0.3px;
            }

            .kpi-sub {
                margin: 6px 0 0 0;
                font-size: 12px;
                color: var(--muted);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .pill {
                font-size: 11px;
                padding: 4px 8px;
                border-radius: 999px;
                border: 1px solid rgba(255, 255, 255, 0.12);
                background: rgba(255, 255, 255, 0.06);
                color: rgba(255, 255, 255, 0.82);
            }

            .pill.good {
                border-color: rgba(39, 215, 168, 0.35);
                background: rgba(39, 215, 168, 0.10);
            }

            .pill.bad {
                border-color: rgba(255, 93, 108, 0.35);
                background: rgba(255, 93, 108, 0.10);
            }

            .pill.warn {
                border-color: rgba(255, 176, 32, 0.35);
                background: rgba(255, 176, 32, 0.10);
            }

            /* Charts section */
            .charts {
                grid-template-columns: 2fr 1fr;
                margin-bottom: 14px;
            }

            .card-header {
                padding: 14px 14px 0 14px;
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                gap: 10px;
            }

            .card-header h3 {
                margin: 0;
                font-size: 14px;
                font-weight: 700;
                letter-spacing: -0.2px;
            }

            .card-header p {
                margin: 4px 0 0 0;
                font-size: 12px;
                color: var(--muted);
            }

            .card-tools {
                display: flex;
                gap: 8px;
                align-items: center;
            }

            .mini-chip {
                font-size: 11px;
                padding: 6px 10px;
                border-radius: 999px;
                border: 1px solid rgba(255, 255, 255, 0.10);
                background: rgba(255, 255, 255, 0.06);
                color: rgba(255, 255, 255, 0.78);
                user-select: none;
            }

            .canvas-wrap {
                padding: 10px 14px 14px 14px;
                height: 320px;
            }

            .canvas-wrap.small {
                height: 320px;
            }

            /* Bottom section */
            .bottom {
                grid-template-columns: 2fr 1fr;
            }

            /* Table */
            .table-wrap {
                padding: 10px 14px 14px;
                overflow: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                min-width: 560px;
            }

            th,
            td {
                text-align: left;
                padding: 12px 10px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                font-size: 12.5px;
            }

            th {
                color: rgba(255, 255, 255, 0.70);
                font-weight: 600;
                letter-spacing: 0.2px;
                background: rgba(255, 255, 255, 0.03);
                position: sticky;
                top: 0;
                backdrop-filter: blur(10px);
            }

            td {
                color: rgba(255, 255, 255, 0.86);
            }

            .amount {
                font-variant-numeric: tabular-nums;
                white-space: nowrap;
                text-align: right;
            }

            .type {
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .dot {
                width: 9px;
                height: 9px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.30);
                box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.05);
            }

            .dot.income {
                background: var(--good);
                box-shadow: 0 0 0 6px rgba(39, 215, 168, 0.10);
            }

            .dot.expense {
                background: var(--bad);
                box-shadow: 0 0 0 6px rgba(255, 93, 108, 0.10);
            }

            /* Progress lists */
            .list {
                padding: 10px 14px 14px;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
            }

            .row .name {
                font-size: 13px;
                font-weight: 600;
                color: rgba(255, 255, 255, 0.90);
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .tag {
                font-size: 11px;
                color: rgba(255, 255, 255, 0.72);
                padding: 4px 8px;
                border-radius: 999px;
                border: 1px solid rgba(255, 255, 255, 0.10);
                background: rgba(255, 255, 255, 0.05);
                white-space: nowrap;
            }

            .bar {
                height: 10px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.08);
                border: 1px solid rgba(255, 255, 255, 0.10);
                overflow: hidden;
                margin: 6px 0px;
            }

            .bar>i {
                display: block;
                height: 100%;
                width: 0%;
                border-radius: 999px;
                background: linear-gradient(90deg, rgba(124, 92, 255, 1), rgba(39, 215, 168, 1));
                box-shadow: 0 10px 20px rgba(124, 92, 255, 0.15);
                transition: width .6s cubic-bezier(.2, .8, .2, 1);
            }

            .bar.bad>i {
                background: linear-gradient(90deg, rgba(255, 93, 108, 1), rgba(255, 176, 32, 1));
            }

            .bar.good>i {
                background: linear-gradient(90deg, rgba(39, 215, 168, 1), rgba(124, 92, 255, 1));
            }

            .meta2 {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-top: 8px;
                font-size: 12px;
                color: var(--muted);
            }

            .stack {
                display: grid;
                grid-template-columns: 1fr;
                gap: 14px;
            }

            /* Responsive */
            @media (max-width: 1100px) {
                .kpis {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .charts {
                    grid-template-columns: 1fr;
                }

                .bottom {
                    grid-template-columns: 1fr;
                }

                .canvas-wrap,
                .canvas-wrap.small {
                    height: 300px;
                }

                .summary {
                    justify-content: flex-start;
                }
            }

            @media (max-width: 820px) {
                .main {
                    margin-left: 0;
                    padding: 18px;
                }

                .hamburger {
                    display: grid;
                    place-items: center;
                }

                .sidebar {
                    transform: translateX(-110%);
                    transition: transform .18s ease;
                    width: 290px;
                }

                body.sidebar-open .sidebar {
                    transform: translateX(0);
                }

                .overlay {
                    position: fixed;
                    inset: 0;
                    background: rgba(0, 0, 0, 0.45);
                    z-index: 40;
                    opacity: 0;
                    pointer-events: none;
                    transition: opacity .18s ease;
                }

                body.sidebar-open .overlay {
                    opacity: 1;
                    pointer-events: auto;
                }

                .topbar {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .topbar-left,
                .topbar-right,
                .summary {
                    width: 100%;
                    justify-content: space-between;
                }

                .balance-pill {
                    max-width: 100%;
                }
            }

            @media (max-width: 520px) {
                .kpis {
                    grid-template-columns: 1fr;
                }

                table {
                    min-width: 520px;
                }

                /* keep horizontal scroll on small screens */
            }

            /* .btnRL {
                border: 2px solid rgb(168, 44, 44);
                border-radius: 10px;
                background-color: rgba(255, 255, 255, 0.06);
                color: rgb(223, 41, 41);
                font-size: 18px;
                padding: 3px;
                transition: transform .15s ease, background .15s ease, border-color .15s ease;
            }

            .btnRL:hover {
                background-color: rgb(223, 41, 41);
                border: 2px solid rgb(236, 236, 236);
                color: rgb(236, 236, 236);
                transition: transform .15s ease, background .15s ease, border-color .15s ease;
            } */
        </style>
<body>
    <div class="app">
        @include('layouts.sidebar')

        

        <main class="main">
            <!-- Top bar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="hamburger" id="hamburger" aria-label="Open menu">☰</button>
                    <div class="greeting">
                        <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                        <p>Here’s your financial snapshot for the last 6 months.</p>
                    </div>
                </div>

                <div class="summary">
                    <div class="balance-pill">
                        <span class="dot"></span>
                        <div class="meta">
                            <span>Total Balance</span>
                            <strong id="headerBalance">$0</strong>
                        </div>
                        <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                            <span class="pill good" id="balanceDelta">+0.0%</span>
                            <span class="mini-chip">All accounts</span>
                        </div>
                    </div>
                </div>

                <div class="topbar-right">
                    {{-- <button class="icon-btn" aria-label="Notifications">
                        🔔
                        <span class="badge" aria-hidden="true"></span>
                    </button> --}}
                    {{-- <button class="btnRL">Logout</button> --}}
                    <form method="POST" action="{{ route('logout') }}" ">
                                              @csrf
                                          <button type="submit" style="
                                               width: 100%;
                                           padding: 12px;
                                           border-radius: 12px;
                                           border: 1px solid rgba(255,93,108,0.30);
                                           background: rgba(255,93,108,0.08);
                                           color: rgba(255,93,108,0.90);
                                           font-size: 13px;
                                           font-weight: 600;
                                           cursor: pointer;
                                           transition: background .15s ease;
                                       ">
                                            Logout
                                       </button>
                                                        </form>
                    {{-- <div class="avatar" title="Profile"></div> --}}
                </div>
            </header>

            <!-- KPI cards -->
            <section class="grid kpis">
                <div class="card">
                    <div class="card-inner">
                        <div class="kpi-top">
                            <p class="kpi-title">Total Balance</p>
                            <div class="kpi-icon">💳</div>
                        </div>
                        <p class="kpi-value" id="kpiBalance">$0</p>
                        <p class="kpi-sub"><span class="pill good" id="kpiBalanceTrend">+0.0%</span> vs last month</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <div class="kpi-top">
                            <p class="kpi-title">Total Income</p>
                            <div class="kpi-icon">⬆</div>
                        </div>
                        <p class="kpi-value" id="kpiIncome">$0</p>
                        <p class="kpi-sub"><span class="pill good">Stable</span> recurring salary + freelance</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <div class="kpi-top">
                            <p class="kpi-title">Total Expenses</p>
                            <div class="kpi-icon">⬇</div>
                        </div>
                        <p class="kpi-value" id="kpiExpenses">$0</p>
                        <p class="kpi-sub"><span class="pill warn" id="kpiExpenseRatio">0%</span> of income</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <div class="kpi-top">
                            <p class="kpi-title">Budget Remaining</p>
                            <div class="kpi-icon">🎯</div>
                        </div>
                        <p class="kpi-value" id="kpiBudgetRemaining">$0</p>
                        <p class="kpi-sub"><span class="pill" id="kpiBudgetUsed">0% used</span> this month</p>
                    </div>
                </div>
            </section>

            <!-- Charts -->
            <section class="grid charts">
                <article class="card">
                    <div class="card-header">
                        <div>
                            <h3>Income vs Expenses</h3>
                            <p>Last 6 months performance</p>
                        </div>
                        <div class="card-tools">
                            <span class="mini-chip">Line</span>
                            <span class="mini-chip">6M</span>
                        </div>
                    </div>
                    <div class="canvas-wrap">
                        <canvas id="lineChart"></canvas>
                    </div>
                </article>

                <article class="card">
                    <div class="card-header">
                        <div>
                            <h3>Expense Categories</h3>
                            <p>Where your money goes</p>
                        </div>
                        <div class="card-tools">
                            <span class="mini-chip">Pie</span>
                        </div>
                    </div>
                    <div class="canvas-wrap small">
                        <canvas id="pieChart"></canvas>
                    </div>
                </article>
            </section>

            <!-- Bottom -->
            <section class="grid bottom">
                <!-- Recent transactions -->
                <article class="card">
                    <div class="card-header">
                        <div>
                            <h3>Recent Transactions</h3>
                            <p>Latest activity across accounts</p>
                        </div>
                        <div class="card-tools">
                            <span class="mini-chip">Dummy data</span>
                        </div>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:130px;">Date</th>
                                    <th>Description</th>
                                    <th style="width:140px;">Type</th>
                                    <th style="width:140px; text-align:right;">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="txBody"></tbody>
                        </table>
                    </div>
                </article>

                <!-- Budgets + Goals -->
                <div class="stack">
                    <article class="card">
                        <div class="card-header">
                            <div>
                                <h3>Budgets</h3>
                                <p>Spending vs limit</p>
                            </div>
                            <div class="card-tools">
                                <span class="mini-chip">This month</span>
                            </div>
                        </div>
                        <div class="list" id="budgetList"></div>
                    </article>

                    <article class="card">
                        <div class="card-header">
                            <div>
                                <h3>Goals</h3>
                                <p>Progress tracker</p>
                            </div>
                            <div class="card-tools">
                                <span class="mini-chip">Auto-save</span>
                            </div>
                        </div>
                        <div class="list" id="goalsList"></div>
                    </article>
                </div>
            </section>
        </main>

        {{-- @endsection --}}

        <script>
            // ---------- Dummy Data ----------
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun"];
            const incomeSeries = [5200, 5400, 5100, 5750, 5900, 6100];
            const expenseSeries = [3600, 3950, 3720, 4200, 4100, 4450];

            const expenseCategories = {
                labels: ["Food", "Rent", "Bills", "Transport", "Entertainment"],
                values: [680, 2100, 520, 260, 440]
            };

            const transactions = [{
                    date: "2026-06-03",
                    desc: "Salary - Main Job",
                    amount: 4200,
                    type: "Income"
                },
                {
                    date: "2026-06-02",
                    desc: "Rent Payment",
                    amount: -2100,
                    type: "Expense"
                },
                {
                    date: "2026-06-02",
                    desc: "Groceries - Market",
                    amount: -128.45,
                    type: "Expense"
                },
                {
                    date: "2026-06-01",
                    desc: "Freelance Invoice",
                    amount: 950,
                    type: "Income"
                },
                {
                    date: "2026-05-31",
                    desc: "Streaming Subscription",
                    amount: -15.99,
                    type: "Expense"
                },
                {
                    date: "2026-05-30",
                    desc: "Electricity Bill",
                    amount: -96.20,
                    type: "Expense"
                }
            ];

            const budgets = [{
                    name: "Food",
                    spent: 680,
                    limit: 900
                },
                {
                    name: "Rent",
                    spent: 2100,
                    limit: 2100
                },
                {
                    name: "Bills",
                    spent: 520,
                    limit: 650
                },
                {
                    name: "Transport",
                    spent: 260,
                    limit: 320
                },
                {
                    name: "Entertainment",
                    spent: 440,
                    limit: 400
                }
            ];

            const goals = [{
                    name: "Emergency Fund",
                    saved: 4200,
                    target: 10000
                },
                {
                    name: "Vacation",
                    saved: 1600,
                    target: 3000
                },
                {
                    name: "New Laptop",
                    saved: 900,
                    target: 1800
                }
            ];

            // ---------- Helpers ----------
            const fmt = (n) => new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            }).format(n);

            function clamp(n, min, max) {
                return Math.max(min, Math.min(max, n));
            }

            // ---------- KPIs ----------
            const totalIncome6m = incomeSeries.reduce((a, b) => a + b, 0);
            const totalExpenses6m = expenseSeries.reduce((a, b) => a + b, 0);
            const net6m = totalIncome6m - totalExpenses6m;

            // "Total balance" dummy: assume starting + net
            const startingBalance = 12450;
            const totalBalance = startingBalance + net6m;

            // Budget remaining (this month): use budgets array as this month
            const budgetLimitTotal = budgets.reduce((a, b) => a + b.limit, 0);
            const budgetSpentTotal = budgets.reduce((a, b) => a + b.spent, 0);
            const budgetRemaining = budgetLimitTotal - budgetSpentTotal;
            const budgetUsedPct = budgetLimitTotal ? (budgetSpentTotal / budgetLimitTotal) * 100 : 0;

            const lastMonthNet = incomeSeries[4] - expenseSeries[4];
            const thisMonthNet = incomeSeries[5] - expenseSeries[5];
            const balanceDeltaPct = lastMonthNet !== 0 ? ((thisMonthNet - lastMonthNet) / Math.abs(lastMonthNet)) * 100 : 4.2;

            document.getElementById("headerBalance").textContent = fmt(totalBalance);
            document.getElementById("kpiBalance").textContent = fmt(totalBalance);
            document.getElementById("kpiIncome").textContent = fmt(totalIncome6m);
            document.getElementById("kpiExpenses").textContent = fmt(totalExpenses6m);
            document.getElementById("kpiBudgetRemaining").textContent = fmt(budgetRemaining);

            const deltaText = `${balanceDeltaPct >= 0 ? "+" : ""}${balanceDeltaPct.toFixed(1)}%`;
            document.getElementById("balanceDelta").textContent = deltaText;
            document.getElementById("kpiBalanceTrend").textContent = deltaText;

            const expenseRatio = totalIncome6m ? (totalExpenses6m / totalIncome6m) * 100 : 0;
            document.getElementById("kpiExpenseRatio").textContent = `${expenseRatio.toFixed(0)}%`;

            document.getElementById("kpiBudgetUsed").textContent = `${budgetUsedPct.toFixed(0)}% used`;

            // ---------- Charts (Chart.js) ----------
            const css = getComputedStyle(document.documentElement);
            const gridColor = "rgba(255,255,255,0.08)";
            const tickColor = "rgba(255,255,255,0.65)";

            // Line chart gradients
            const lineCanvas = document.getElementById("lineChart");
            const ctxLine = lineCanvas.getContext("2d");

            const incomeGrad = ctxLine.createLinearGradient(0, 0, 0, 320);
            incomeGrad.addColorStop(0, "rgba(39, 215, 168, 0.35)");
            incomeGrad.addColorStop(1, "rgba(39, 215, 168, 0.00)");

            const expenseGrad = ctxLine.createLinearGradient(0, 0, 0, 320);
            expenseGrad.addColorStop(0, "rgba(255, 93, 108, 0.35)");
            expenseGrad.addColorStop(1, "rgba(255, 93, 108, 0.00)");

            new Chart(lineCanvas, {
                type: "line",
                data: {
                    labels: months,
                    datasets: [{
                            label: "Income",
                            data: incomeSeries,
                            borderColor: "rgba(39, 215, 168, 1)",
                            backgroundColor: incomeGrad,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            borderWidth: 2
                        },
                        {
                            label: "Expenses",
                            data: expenseSeries,
                            borderColor: "rgba(255, 93, 108, 1)",
                            backgroundColor: expenseGrad,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: "index",
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: tickColor,
                                boxWidth: 10,
                                boxHeight: 10,
                                usePointStyle: true,
                                pointStyle: "circle"
                            }
                        },
                        tooltip: {
                            backgroundColor: "rgba(10, 12, 20, 0.92)",
                            borderColor: "rgba(255,255,255,0.12)",
                            borderWidth: 1,
                            titleColor: "rgba(255,255,255,0.92)",
                            bodyColor: "rgba(255,255,255,0.82)",
                            padding: 12,
                            callbacks: {
                                label: (ctx) => `${ctx.dataset.label}: ${fmt(ctx.parsed.y)}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: "rgba(255,255,255,0.06)"
                            },
                            ticks: {
                                color: tickColor
                            }
                        },
                        y: {
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: tickColor,
                                callback: (v) => "$" + v
                            }
                        }
                    }
                }
            });

            // Pie chart
            const pieCanvas = document.getElementById("pieChart");
            new Chart(pieCanvas, {
                type: "pie",
                data: {
                    labels: expenseCategories.labels,
                    datasets: [{
                        data: expenseCategories.values,
                        backgroundColor: [
                            "rgba(124, 92, 255, 0.95)", // Food
                            "rgba(255, 93, 108, 0.92)", // Rent
                            "rgba(255, 176, 32, 0.92)", // Bills
                            "rgba(39, 215, 168, 0.92)", // Transport
                            "rgba(91, 169, 255, 0.92)" // Entertainment
                        ],
                        borderColor: "rgba(10, 12, 20, 0.35)",
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom",
                            labels: {
                                color: tickColor,
                                padding: 14,
                                boxWidth: 10,
                                boxHeight: 10,
                                usePointStyle: true,
                                pointStyle: "circle"
                            }
                        },
                        tooltip: {
                            backgroundColor: "rgba(10, 12, 20, 0.92)",
                            borderColor: "rgba(255,255,255,0.12)",
                            borderWidth: 1,
                            titleColor: "rgba(255,255,255,0.92)",
                            bodyColor: "rgba(255,255,255,0.82)",
                            padding: 12,
                            callbacks: {
                                label: (ctx) => {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const val = ctx.parsed;
                                    const pct = total ? (val / total) * 100 : 0;
                                    return `${ctx.label}: ${fmt(val)} (${pct.toFixed(0)}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // ---------- Transactions table ----------
            const txBody = document.getElementById("txBody");
            txBody.innerHTML = transactions.map(tx => {
                const isIncome = tx.amount >= 0;
                const typeClass = isIncome ? "income" : "expense";
                const amountText = `${isIncome ? "+" : "-"}${fmt(Math.abs(tx.amount))}`;
                return `
        <tr>
          <td>${tx.date}</td>
          <td>${tx.desc}</td>
          <td>
            <span class="type">
              <span class="dot ${typeClass}"></span>
              ${tx.type}
            </span>
          </td>
          <td class="amount" style="color:${isIncome ? "rgba(39,215,168,0.95)" : "rgba(255,93,108,0.95)"}">${amountText}</td>
        </tr>
      `;
            }).join("");

            // ---------- Budgets ----------
            const budgetList = document.getElementById("budgetList");
            budgetList.innerHTML = budgets.map(b => {
                const pct = b.limit ? (b.spent / b.limit) * 100 : 0;
                const pctClamped = clamp(pct, 0, 130);
                const barClass = pct <= 85 ? "good" : (pct <= 100 ? "" : "bad");
                return `
        <div>
          <div class="row">
            <div class="name">${b.name} <span class="tag">${fmt(b.spent)} / ${fmt(b.limit)}</span></div>
            <div class="tag">${pct.toFixed(0)}%</div>
          </div>
          <div class="bar ${barClass}">
            <i style="width:${pctClamped}%;"></i>
          </div>
          <div class="meta2">
            <span>${pct <= 100 ? `${fmt(b.limit - b.spent)} remaining` : `${fmt(b.spent - b.limit)} over budget`}</span>
            <span>${pct <= 100 ? "On track" : "Needs attention"}</span>
          </div>
        </div>
      `;
            }).join("");

            // ---------- Goals ----------
            const goalsList = document.getElementById("goalsList");
            goalsList.innerHTML = goals.map(g => {
                const pct = g.target ? (g.saved / g.target) * 100 : 0;
                const pctClamped = clamp(pct, 0, 100);
                return `
        <div>
          <div class="row">
            <div class="name">${g.name} <span class="tag">${fmt(g.saved)} / ${fmt(g.target)}</span></div>
            <div class="tag">${pct.toFixed(0)}%</div>
          </div>
          <div class="bar">
            <i style="width:${pctClamped}%;"></i>
          </div>
          <div class="meta2">
            <span>${fmt(Math.max(0, g.target - g.saved))} to go</span>
            <span>Progress</span>
          </div>
        </div>
      `;
            }).join("");

            // ---------- Mobile sidebar toggle ----------
            const hamburger = document.getElementById("hamburger");
            const overlay = document.getElementById("overlay");

            function openSidebar() {
                document.body.classList.add("sidebar-open");
            }

            function closeSidebar() {
                document.body.classList.remove("sidebar-open");
            }

            hamburger.addEventListener("click", () => {
                document.body.classList.contains("sidebar-open") ? closeSidebar() : openSidebar();
            });
            overlay.addEventListener("click", closeSidebar);

            // Close sidebar when resizing up to desktop
            window.addEventListener("resize", () => {
                if (window.innerWidth > 820) closeSidebar();
            });
        </script>
    </div><!-- .app -->
</body>

</html>
