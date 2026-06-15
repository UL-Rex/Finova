<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transactions • Personal Finance Dashboard</title>

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
            --slate: #94a3b8;

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

        /* Layout */
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

        /* Top header */
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

        .search {
            position: relative;
            min-width: 280px;
            max-width: 420px;
            width: 40vw;
        }

        .search input {
            width: 100%;
            height: 44px;
            padding: 10px 12px 10px 40px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .82);
            box-shadow: 0 1px 0 rgba(15, 23, 42, .03);
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

        .btn-icon {
            width: 44px;
            padding: 0;
            justify-content: center;
        }

        /* Card / Section */
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

        .chip {
            font-size: 12px;
            color: rgba(15, 23, 42, .70);
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(15, 23, 42, .03);
            padding: 6px 10px;
            border-radius: 999px;
            white-space: nowrap;
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

        /* Table */
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

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            flex: 1;
            min-width: 260px;
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filters-panel {
            display: none;
            margin: 10px 0 0;
            padding: 12px;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(15, 23, 42, .02);
        }

        .filters-panel.open {
            display: block;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }

        .field label {
            display: block;
            font-size: 12px;
            color: rgba(15, 23, 42, .70);
            margin-bottom: 6px;
            font-weight: 600;
        }

        .control {
            width: 100%;
            height: 42px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .92);
            padding: 0 10px;
            outline: none;
            transition: box-shadow var(--t), border-color var(--t);
        }

        .control:focus {
            border-color: rgba(79, 70, 229, .35);
            box-shadow: var(--ring);
            background: #fff;
        }

        .table-wrap {
            overflow: auto;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1120px;
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

        .amount.income {
            color: rgba(6, 95, 70, .95);
        }

        .amount.expense {
            color: rgba(127, 29, 29, .95);
        }

        .amount.transfer {
            color: rgba(15, 23, 42, .75);
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(15, 23, 42, .02);
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(15, 23, 42, .35);
        }

        .pill.cleared {
            background: rgba(16, 185, 129, .10);
            border-color: rgba(16, 185, 129, .22);
            color: rgba(6, 95, 70, .95);
        }

        .pill.cleared .dot {
            background: rgba(16, 185, 129, 1);
        }

        .pill.pending {
            background: rgba(245, 158, 11, .12);
            border-color: rgba(245, 158, 11, .25);
            color: rgba(120, 53, 15, .95);
        }

        .pill.pending .dot {
            background: rgba(245, 158, 11, 1);
        }

        .pill.failed {
            background: rgba(239, 68, 68, .10);
            border-color: rgba(239, 68, 68, .25);
            color: rgba(127, 29, 29, .95);
        }

        .pill.failed .dot {
            background: rgba(239, 68, 68, 1);
        }

        .type-pill {
            background: rgba(15, 23, 42, .02);
            border-color: rgba(15, 23, 42, .10);
            color: rgba(15, 23, 42, .85);
        }

        .type-pill.income {
            background: rgba(16, 185, 129, .10);
            border-color: rgba(16, 185, 129, .22);
            color: rgba(6, 95, 70, .95);
        }

        .type-pill.expense {
            background: rgba(239, 68, 68, .10);
            border-color: rgba(239, 68, 68, .22);
            color: rgba(127, 29, 29, .95);
        }

        .type-pill.transfer {
            background: rgba(100, 116, 139, .10);
            border-color: rgba(100, 116, 139, .20);
            color: rgba(15, 23, 42, .80);
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

        .pagination {
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pager {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .page-btn {
            height: 36px;
            padding: 0 10px;
            border-radius: 10px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .9);
            cursor: pointer;
            transition: transform var(--t), box-shadow var(--t);
            font-weight: 600;
            font-size: 12px;
        }

        .page-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(15, 23, 42, .10);
        }

        .page-btn.active {
            border-color: rgba(79, 70, 229, .35);
            background: rgba(79, 70, 229, .10);
            color: rgba(49, 46, 129, .95);
        }

        .page-info {
            font-size: 12px;
            color: var(--muted);
        }

        /* Empty state */
        .empty {
            display: none;
            padding: 24px;
            text-align: center;
            border-radius: var(--radius);
            border: 1px dashed rgba(15, 23, 42, .18);
            background: rgba(255, 255, 255, .70);
        }

        .empty.show {
            display: block;
        }

        .empty svg {
            width: 220px;
            max-width: 70%;
            height: auto;
            margin: 0 auto 10px;
            display: block;
            opacity: .95;
        }

        .empty h3 {
            margin: 10px 0 0;
            font-size: 16px;
            letter-spacing: -.2px;
        }

        .empty p {
            margin: 6px 0 14px;
            color: var(--muted);
            font-size: 13px;
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
            width: 780px;
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

            .filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .search {
                width: 52vw;
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

            .search {
                width: 100%;
                min-width: 0;
                max-width: none;
            }
        }

        @media (max-width: 520px) {
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .filter-grid {
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

            @if(session('success'))
<div style="padding:12px 16px;background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.25);border-radius:12px;color:rgba(6,95,70,.95);font-size:13px;margin-bottom:14px;">
  ✓ {{ session('success') }}
</div>
@endif

            <!-- Mobile bar -->
            <div class="mobile-bar">
                <button class="hamburger" id="hamburger" aria-label="Open sidebar">☰</button>
                <div style="font-weight:800; letter-spacing:-.2px;">Transactions</div>
            </div>

            <!-- Header -->
            <header class="top-header">
                <div class="title-block">
                    <h1>Transactions</h1>
                    <p>Track all income, expenses, and transfers in one place</p>
                </div>

                <div class="header-actions" aria-label="Header actions">
                    <div class="search" role="search">
                        <span class="mag">⌕</span>
                        <label class="sr-only" for="globalSearch">Search transactions</label>
                        <input id="globalSearch" type="search" placeholder="Search title, category, method, status…" />
                    </div>

                    <button class="btn" id="toggleFilters" type="button" aria-expanded="false">
                        <span>⏷</span> Filter
                    </button>

                    <button class="btn btn-primary" id="openAddModal" type="button">
                        <span>＋</span> Add Transaction
                    </button>
                </div>
            </header>

            <!-- Summary -->
            <section class="section" aria-labelledby="summaryTitle">
                <div class="section-title">
                    <div>
                        <h2 id="summaryTitle">Transaction Summary</h2>
                        <p>Current month overview</p>
                    </div>
                    <span class="chip" id="monthChip">Month</span>
                </div>

                <div class="summary-grid" id="summaryGrid"></div>
            </section>

            <!-- Analytics -->
            <section class="section" aria-labelledby="analyticsTitle">
                <div class="section-title">
                    <div>
                        <h2 id="analyticsTitle">Analytics</h2>
                        <p>Cashflow trend and category breakdown</p>
                    </div>
                </div>

                <div class="analytics-grid">
                    <article class="card" aria-label="Cashflow trend chart">
                        <div class="card-head">
                            <div>
                                <h3>Income vs Expenses Trend</h3>
                                <p>Last 6 months</p>
                            </div>
                            <span class="chip">Line</span>
                        </div>
                        <div class="canvas-wrap">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </article>

                    <article class="card" aria-label="Category breakdown chart">
                        <div class="card-head">
                            <div>
                                <h3>Category Breakdown</h3>
                                <p>Spending (this month)</p>
                            </div>
                            <span class="chip">Doughnut</span>
                        </div>
                        <div class="canvas-wrap">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </article>
                </div>
            </section>

            <!-- Table -->
            <section class="section" aria-labelledby="recentTxTitle">
                <div class="section-title">
                    <div>
                        <h2 id="recentTxTitle">Recent Transactions</h2>
                        <p>Search, filter, sort and manage entries</p>
                    </div>
                </div>

                <article class="card table-card">
                    <div class="table-toolbar">
                        <div class="toolbar-left">
                            <div class="search" style="max-width:420px; width: min(520px, 100%);">
                                <span class="mag">⌕</span>
                                <label class="sr-only" for="tableSearch">Search in table</label>
                                <input id="tableSearch" type="search" placeholder="Search in table…" />
                            </div>
                            <button class="btn btn-icon" id="clearAll" type="button"
                                title="Clear filters/search">↺</button>
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
                                    <option>Income</option>
                                    <option>Expense</option>
                                    <option>Transfer</option>
                                </select>
                            </div>

                            <div class="field">
                                <label for="filterCategory">Category</label>
                                <select id="filterCategory" class="control">
                                    <option value="">All</option>
                                    <option>Food</option>
                                    <option>Rent</option>
                                    <option>Bills</option>
                                    <option>Transport</option>
                                    <option>Entertainment</option>
                                    <option>Shopping</option>
                                    <option>Health</option>
                                    <option>Salary</option>
                                    <option>Freelance</option>
                                    <option>Investments</option>
                                    <option>Refunds</option>
                                </select>
                            </div>

                            <div class="field">
                                <label for="filterMethod">Payment/Account</label>
                                <select id="filterMethod" class="control">
                                    <option value="">All</option>
                                    <option>Bank</option>
                                    <option>Card</option>
                                    <option>Cash</option>
                                    <option>Wallet</option>
                                </select>
                            </div>

                            <div class="field">
                                <label for="filterStatus">Status</label>
                                <select id="filterStatus" class="control">
                                    <option value="">All</option>
                                    <option>Cleared</option>
                                    <option>Pending</option>
                                    <option>Failed</option>
                                </select>
                            </div>

                            <div class="field">
                                <label for="filterDateFrom">Date (from)</label>
                                <input id="filterDateFrom" type="date" class="control" />
                            </div>

                            <div class="field">
                                <label for="filterDateTo">Date (to)</label>
                                <input id="filterDateTo" type="date" class="control" />
                            </div>

                            <div class="field">
                                <label for="filterAmountMin">Min amount</label>
                                <input id="filterAmountMin" type="number" class="control" min="0" step="0.01"
                                    placeholder="0" />
                            </div>

                            <div class="field">
                                <label for="filterAmountMax">Max amount</label>
                                <input id="filterAmountMax" type="number" class="control" min="0" step="0.01"
                                    placeholder="5000" />
                            </div>

                            <div class="field">
                                <label>&nbsp;</label>
                                <button class="btn btn-primary" id="applyFilters" type="button">Apply Filters</button>
                            </div>
                        </div>
                    </div>

                    <!-- Empty state -->
                    <div class="empty" id="emptyState" aria-live="polite">
                        <svg viewBox="0 0 520 300" xmlns="http://www.w3.org/2000/svg" role="img"
                            aria-label="Empty state illustration">
                            <defs>
                                <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0" stop-color="#4f46e5" stop-opacity="0.18" />
                                    <stop offset="1" stop-color="#2563eb" stop-opacity="0.12" />
                                </linearGradient>
                            </defs>
                            <rect x="34" y="28" width="452" height="244" rx="22" fill="url(#g)"
                                stroke="rgba(15,23,42,.10)" />
                            <rect x="70" y="70" width="380" height="30" rx="10" fill="rgba(255,255,255,.85)" />
                            <rect x="70" y="120" width="260" height="24" rx="10" fill="rgba(255,255,255,.78)" />
                            <rect x="70" y="156" width="320" height="24" rx="10" fill="rgba(255,255,255,.72)" />
                            <rect x="70" y="192" width="220" height="24" rx="10" fill="rgba(255,255,255,.68)" />
                            <circle cx="414" cy="146" r="44" fill="rgba(79,70,229,.14)" stroke="rgba(79,70,229,.22)" />
                            <path d="M402 146h24M414 134v24" stroke="rgba(79,70,229,.85)" stroke-width="6"
                                stroke-linecap="round" />
                        </svg>
                        <h3>No transactions recorded yet</h3>
                        <p>Add your first transaction to start tracking cashflow.</p>
                        <button class="btn btn-primary" id="emptyAddBtn" type="button">＋ Add Transaction</button>
                    </div>

                    <div class="table-wrap" id="tableWrap">
                        <table aria-label="Transactions table">
                            <thead>
                                <tr>
                                    <th data-sort="date">Date <span class="sort" id="sort-date">↕</span></th>
                                    <th data-sort="title">Title <span class="sort" id="sort-title">↕</span></th>
                                    <th data-sort="category">Category <span class="sort" id="sort-category">↕</span>
                                    </th>
                                    <th data-sort="method">Payment/Account <span class="sort" id="sort-method">↕</span>
                                    </th>
                                    <th data-sort="type">Type <span class="sort" id="sort-type">↕</span></th>
                                    <th data-sort="amount" style="text-align:right;">Amount <span class="sort"
                                            id="sort-amount">↕</span></th>
                                    <th data-sort="status">Status <span class="sort" id="sort-status">↕</span></th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="txTbody"></tbody>
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
                    <h3 id="modalTitle">Add Transaction</h3>
                    <p id="modalSubtitle">Record income, expense, or transfer</p>
                </div>
                <button class="modal-close" id="closeModal" type="button" aria-label="Close">✕</button>
            </div>

            <form class="modal-body" id="txForm" method="POST">
  @csrf
  <input type="hidden" name="_method" id="formMethod" value="POST">
  <input type="hidden" name="id" id="txId">

                <div class="form-grid">
                    <div class="field">
                        <label for="txTitle">Title</label>
                        <input id="txTitle" name="title" class="control" type="text" placeholder="e.g., Grocery, Salary, Transfer"
                            required />
                    </div>

                    <div class="field">
                        <label for="txType">Type</label>
                        <select id="txType" name="type" class="control" required>
                            <option>Expense</option>
                            <option>Income</option>
                            <option>Transfer</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="txAmount">Amount</label>
                        <input id="txAmount" name="amount" class="control" type="number" min="0" step="0.01" placeholder="0.00"
                            required />
                    </div>

                    <div class="field">
                        <label for="txCategory">Category</label>
                        <select id="txCategory" name="category" class="control" required>
                            <option value="" disabled selected>Select category</option>
                            <optgroup label="Expense categories">
                                <option>Food</option>
                                <option>Rent</option>
                                <option>Bills</option>
                                <option>Transport</option>
                                <option>Entertainment</option>
                                <option>Shopping</option>
                                <option>Health</option>
                            </optgroup>
                            <optgroup label="Income categories">
                                <option>Salary</option>
                                <option>Freelance</option>
                                <option>Investments</option>
                                <option>Refunds</option>
                            </optgroup>
                            <optgroup label="Other">
                                <option>Transfer</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="field">
                        <label for="txMethod">Payment/Account</label>
                        <select id="txMethod" class="control" required>
                            <option value="" disabled selected>Select method</option>
                            <option>Bank</option>
                            <option>Card</option>
                            <option>Cash</option>
                            <option>Wallet</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="txDate">Date</label>
                        <input id="txDate" name="date" class="control" type="date" required />
                    </div>

                    <div class="field">
                        <label for="txStatus">Status</label>
                        <select id="txStatus" class="control" required>
                            <option>Cleared</option>
                            <option>Pending</option>
                            <option>Failed</option>
                        </select>
                    </div>

                    <div class="field" style="grid-column: 1 / -1;">
                        <label for="txNotes">Notes</label>
                        <textarea id="txNotes" name="note" class="control"
                            placeholder="Optional notes (merchant, reference, etc.)"></textarea>
                        <div class="hint">Demo only. In MVC integrate with your Transaction model + DB.</div>
                    </div>

                    <div class="field" style="grid-column: 1 / -1;">
                        <label for="txAttachment">Attachment (optional)</label>
                        <input id="txAttachment" class="control" type="file" accept="image/*,application/pdf" />
                        <div class="hint">Accepted: images/PDF. Demo stores filename only.</div>
                    </div>
                </div>
            </form>

            <div class="modal-foot">
                <button class="btn" id="cancelModal" type="button">Cancel</button>
                <button class="btn btn-primary" id="saveTx" type="button">Save Transaction</button>
            </div>
        </div>
    </div>

    <script>
        // ---------------------------
        // Dummy data + state
        // ---------------------------
        const TODAY = new Date("2026-06-06T12:00:00"); // fixed date for consistent demo

        let transactions = {!! json_encode($transactions->map(fn($t) => [
    'id'       => $t->id,
    'date'     => $t->date,
    'title'    => $t->title,
    'category' => $t->category ?? 'Other',
    'method'   => 'Bank',
    'type'     => ucfirst($t->type),
    'amount'   => (float)$t->amount,
    'status'   => 'Cleared',
    'notes'    => $t->note ?? '',
    'attachmentName' => '',
])) !!};

        const state = {
            searchGlobal: "",
            searchTable: "",
            filters: {
                type: "",
                category: "",
                method: "",
                status: "",
                dateFrom: "",
                dateTo: "",
                amountMin: "",
                amountMax: ""
            },
            sort: { key: "date", dir: "desc" },
            page: 1,
            pageSize: 8
        };

        const fmt = (n) => new Intl.NumberFormat("en-US", { style: "currency", currency: "USD" }).format(n);
        const clamp = (n, a, b) => Math.max(a, Math.min(b, n));
        const parseDate = (s) => new Date(s + "T00:00:00");
        const isSameMonth = (d, ref) => d.getFullYear() === ref.getFullYear() && d.getMonth() === ref.getMonth();
        const yearMonthKey = (d) => `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}`;
        const monthLabel = (d) => d.toLocaleString("en-US", { month: "short" });

        function escapeHtml(str) {
            return String(str)
                .replaceAll("&", "&amp;")
                .replaceAll("<", "&lt;")
                .replaceAll(">", "&gt;")
                .replaceAll('"', "&quot;")
                .replaceAll("'", "&#039;");
        }

        function signedAmount(tx) {
            if (tx.type === "Income") return tx.amount;
            if (tx.type === "Expense") return -tx.amount;
            return 0; // transfers don't affect net in this simplified demo
        }

        function currentMonthTx(list) {
            return list.filter(t => isSameMonth(parseDate(t.date), TODAY));
        }

        // ---------------------------
        // Charts
        // ---------------------------
        let trendChart, categoryChart;

        function buildCharts() {
            trendChart = new Chart(document.getElementById("trendChart"), {
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
                            pointHoverRadius: 5,
                            borderWidth: 2
                        },
                        {
                            label: "Expenses",
                            data: [],
                            borderColor: "rgba(239,68,68,1)",
                            backgroundColor: "rgba(239,68,68,.12)",
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
                    interaction: { mode: "index", intersect: false },
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

            categoryChart = new Chart(document.getElementById("categoryChart"), {
                type: "doughnut",
                data: {
                    labels: ["Food", "Rent", "Bills", "Transport", "Entertainment", "Shopping", "Health"],
                    datasets: [{
                        data: [0, 0, 0, 0, 0, 0, 0],
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

        function last6MonthsKeys() {
            const keys = [];
            const d = new Date(TODAY);
            d.setDate(1);
            for (let i = 5; i >= 0; i--) {
                const x = new Date(d);
                x.setMonth(x.getMonth() - i);
                keys.push(yearMonthKey(x));
            }
            return keys;
        }

        function renderCharts() {
            const keys = last6MonthsKeys();
            const totalsIncome = Object.fromEntries(keys.map(k => [k, 0]));
            const totalsExpense = Object.fromEntries(keys.map(k => [k, 0]));

            for (const tx of transactions) {
                const d = parseDate(tx.date);
                const k = yearMonthKey(d);
                if (!(k in totalsIncome)) continue;
                if (tx.type === "Income") totalsIncome[k] += tx.amount;
                if (tx.type === "Expense") totalsExpense[k] += tx.amount;
            }

            const labels = keys.map(k => {
                const [y, m] = k.split("-");
                return monthLabel(new Date(Number(y), Number(m) - 1, 1));
            });

            trendChart.data.labels = labels;
            trendChart.data.datasets[0].data = keys.map(k => Number(totalsIncome[k].toFixed(2)));
            trendChart.data.datasets[1].data = keys.map(k => Number(totalsExpense[k].toFixed(2)));
            trendChart.update();

            // Category breakdown (expenses this month)
            const month = currentMonthTx(transactions).filter(t => t.type === "Expense");
            const sums = {};
            for (const tx of month) {
                sums[tx.category] = (sums[tx.category] || 0) + tx.amount;
            }
            const lbls = categoryChart.data.labels;
            categoryChart.data.datasets[0].data = lbls.map(l => Number((sums[l] || 0).toFixed(2)));
            categoryChart.update();
        }

        // ---------------------------
        // Summary
        // ---------------------------
        function renderMonthChip() {
            document.getElementById("monthChip").textContent =
                TODAY.toLocaleString("en-US", { month: "long", year: "numeric" });
        }

        function renderSummary() {
            const month = currentMonthTx(transactions);
            const income = month.filter(t => t.type === "Income").reduce((a, t) => a + t.amount, 0);
            const expense = month.filter(t => t.type === "Expense").reduce((a, t) => a + t.amount, 0);
            const transfers = month.filter(t => t.type === "Transfer").reduce((a, t) => a + t.amount, 0);
            const net = income - expense;
            const pending = month.filter(t => t.status === "Pending").length;

            // Simple trend vs prev month net (dummy / computed if present)
            const prev = new Date(TODAY); prev.setMonth(prev.getMonth() - 1);
            const prevMonth = transactions.filter(t => isSameMonth(parseDate(t.date), prev));
            const prevIncome = prevMonth.filter(t => t.type === "Income").reduce((a, t) => a + t.amount, 0);
            const prevExpense = prevMonth.filter(t => t.type === "Expense").reduce((a, t) => a + t.amount, 0);
            const prevNet = prevIncome - prevExpense;
            const delta = prevNet ? ((net - prevNet) / Math.abs(prevNet)) * 100 : (net ? 4.8 : 0);

            document.getElementById("summaryGrid").innerHTML = `
        <article class="card summary-card" aria-label="Total transactions">
          <div class="summary-top">
            <div class="meta">
              <span>Total Transactions</span>
              <strong>${month.length}</strong>
            </div>
            <span class="badge">${pending} pending</span>
          </div>
          <div class="summary-foot">
            <span>This month</span>
            <span>${transfers ? fmt(transfers) + " transfers" : "No transfers"}</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Net cashflow">
          <div class="summary-top">
            <div class="meta">
              <span>Net Cashflow</span>
              <strong style="color:${net >= 0 ? "rgba(6,95,70,.95)" : "rgba(127,29,29,.95)"}">${fmt(net)}</strong>
            </div>
            <span class="badge ${delta >= 0 ? "success" : "danger"}">${delta >= 0 ? "↑" : "↓"} ${Math.abs(delta).toFixed(1)}%</span>
          </div>
          <div class="summary-foot">
            <span>Income - Expenses</span>
            <span>${net >= 0 ? "Positive" : "Negative"}</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Total income">
          <div class="summary-top">
            <div class="meta">
              <span>Total Income</span>
              <strong>${fmt(income)}</strong>
            </div>
            <span class="badge success">Inflow</span>
          </div>
          <div class="summary-foot">
            <span>Current month</span>
            <span>Cash-in</span>
          </div>
        </article>

        <article class="card summary-card" aria-label="Total expenses">
          <div class="summary-top">
            <div class="meta">
              <span>Total Expenses</span>
              <strong>${fmt(expense)}</strong>
            </div>
            <span class="badge ${expense > 0 ? "warning" : ""}">Outflow</span>
          </div>
          <div class="summary-foot">
            <span>Current month</span>
            <span>Cash-out</span>
          </div>
        </article>
      `;
        }

        // ---------------------------
        // Table logic
        // ---------------------------
        function applyAllFilters(list) {
            const q = (state.searchGlobal || state.searchTable || "").trim().toLowerCase();
            const f = state.filters;

            return list.filter(t => {
                if (q) {
                    const hay = `${t.title} ${t.category} ${t.method} ${t.type} ${t.status}`.toLowerCase();
                    if (!hay.includes(q)) return false;
                }

                if (f.type && t.type !== f.type) return false;
                if (f.category && t.category !== f.category) return false;
                if (f.method && t.method !== f.method) return false;
                if (f.status && t.status !== f.status) return false;

                const d = parseDate(t.date);
                if (f.dateFrom && d < parseDate(f.dateFrom)) return false;
                if (f.dateTo && d > parseDate(f.dateTo)) return false;

                if (f.amountMin !== "" && t.amount < Number(f.amountMin)) return false;
                if (f.amountMax !== "" && t.amount > Number(f.amountMax)) return false;

                return true;
            });
        }

        function sortList(list) {
            const { key, dir } = state.sort;
            const sign = dir === "asc" ? 1 : -1;
            const copy = [...list];

            copy.sort((a, b) => {
                let av = a[key], bv = b[key];
                if (key === "date") { av = parseDate(a.date).getTime(); bv = parseDate(b.date).getTime(); }
                if (key === "amount") { av = a.amount; bv = b.amount; }
                if (typeof av === "string" && typeof bv === "string") return sign * av.localeCompare(bv);
                return sign * (av - bv);
            });

            return copy;
        }

        function paginate(list) {
            const totalItems = list.length;
            const totalPages = Math.max(1, Math.ceil(totalItems / state.pageSize));
            state.page = clamp(state.page, 1, totalPages);
            const start = (state.page - 1) * state.pageSize;
            return { pageItems: list.slice(start, start + state.pageSize), totalItems, totalPages, start };
        }

        function updateSortIndicators() {
            const ids = ["date", "title", "category", "method", "type", "amount", "status"];
            for (const id of ids) {
                const el = document.getElementById("sort-" + id);
                if (!el) continue;
                if (state.sort.key !== id) el.textContent = "↕";
                else el.textContent = state.sort.dir === "asc" ? "↑" : "↓";
            }
        }

        function renderPager(page, totalPages) {
            const pager = document.getElementById("pager");
            const mkBtn = (label, p, disabled = false, active = false) => `
        <button class="page-btn ${active ? "active" : ""}" type="button" data-page="${p}" ${disabled ? "disabled" : ""}>${label}</button>
      `;

            let html = "";
            html += mkBtn("Prev", Math.max(1, page - 1), page === 1);

            const windowSize = 5;
            const half = Math.floor(windowSize / 2);
            let start = Math.max(1, page - half);
            let end = Math.min(totalPages, start + windowSize - 1);
            start = Math.max(1, end - windowSize + 1);

            if (start > 1) html += mkBtn("1", 1, false, page === 1);
            if (start > 2) html += `<span class="page-info" style="padding:0 4px;">…</span>`;
            for (let p = start; p <= end; p++) html += mkBtn(String(p), p, false, p === page);
            if (end < totalPages - 1) html += `<span class="page-info" style="padding:0 4px;">…</span>`;
            if (end < totalPages) html += mkBtn(String(totalPages), totalPages, false, page === totalPages);

            html += mkBtn("Next", Math.min(totalPages, page + 1), page === totalPages);
            pager.innerHTML = html;
        }

        function pillStatusClass(status) {
            const s = String(status || "").toLowerCase();
            if (s === "cleared") return "cleared";
            if (s === "pending") return "pending";
            return "failed";
        }

        function renderTable() {
            const tbody = document.getElementById("txTbody");
            const empty = document.getElementById("emptyState");
            const tableWrap = document.getElementById("tableWrap");

            const filtered = applyAllFilters(transactions);
            const sorted = sortList(filtered);
            const { pageItems, totalItems, totalPages, start } = paginate(sorted);

            document.getElementById("resultsChip").textContent = `${totalItems} result${totalItems === 1 ? "" : "s"}`;

            if (totalItems === 0) {
                tbody.innerHTML = "";
                empty.classList.add("show");
                tableWrap.style.display = "none";
                document.getElementById("pageInfo").textContent = `Showing 0–0 of 0`;
                renderPager(1, 1);
                return;
            }

            empty.classList.remove("show");
            tableWrap.style.display = "block";

            tbody.innerHTML = pageItems.map(t => {
                const amountClass = t.type === "Income" ? "income" : (t.type === "Expense" ? "expense" : "transfer");
                const amountPrefix = t.type === "Income" ? "+" : (t.type === "Expense" ? "-" : "");
                const statusCls = pillStatusClass(t.status);

                return `
          <tr>
            <td>${escapeHtml(t.date)}</td>
            <td title="${escapeHtml(t.title)}">${escapeHtml(t.title)}</td>
            <td>${escapeHtml(t.category)}</td>
            <td>${escapeHtml(t.method)}</td>
            <td>
              <span class="pill type-pill ${t.type.toLowerCase()}">
                <span class="dot"></span>${escapeHtml(t.type)}
              </span>
            </td>
            <td class="amount ${amountClass}">${amountPrefix}${fmt(t.amount)}</td>
            <td>
              <span class="pill ${statusCls}">
                <span class="dot"></span>${escapeHtml(t.status)}
              </span>
            </td>
            <td>
              <div class="actions">
                <button class="link-btn" type="button" data-action="view" data-id="${t.id}">View</button>
                <button class="link-btn" type="button" data-action="edit" data-id="${t.id}">Edit</button>
                <button class="link-btn danger" type="button" data-action="delete" data-id="${t.id}">Delete</button>
              </div>
            </td>
          </tr>
        `;
            }).join("");

            const end = start + pageItems.length;
            document.getElementById("pageInfo").textContent = `Showing ${start + 1}–${end} of ${totalItems}`;
            renderPager(state.page, totalPages);
        }

        // ---------------------------
        // Modal logic (Add/Edit/View)
        // ---------------------------
        let modalMode = "add";
        const modalOverlay = document.getElementById("modalOverlay");
        const form = document.getElementById("txForm");

        const fields = {
            id: document.getElementById("txId"),
            title: document.getElementById("txTitle"),
            type: document.getElementById("txType"),
            amount: document.getElementById("txAmount"),
            category: document.getElementById("txCategory"),
            method: document.getElementById("txMethod"),
            date: document.getElementById("txDate"),
            status: document.getElementById("txStatus"),
            notes: document.getElementById("txNotes"),
            attachment: document.getElementById("txAttachment")
        };

        function setFormDisabled(disabled) {
            form.querySelectorAll(".control").forEach(el => el.disabled = disabled);
            fields.attachment.disabled = disabled;
        }

        function fillForm(tx) {
            if (!tx) return;
            fields.id.value = tx.id;
            fields.title.value = tx.title;
            fields.type.value = tx.type;
            fields.amount.value = tx.amount;
            fields.category.value = tx.category;
            fields.method.value = tx.method;
            fields.date.value = tx.date;
            fields.status.value = tx.status;
            fields.notes.value = tx.notes || "";
            fields.attachment.value = "";
        }

        function openModal(mode, tx = null) {
            modalMode = mode;
            const title = document.getElementById("modalTitle");
            const subtitle = document.getElementById("modalSubtitle");
            const saveBtn = document.getElementById("saveTx");

            if (mode === "add") {
                title.textContent = "Add Transaction";
                subtitle.textContent = "Record income, expense, or transfer";
                saveBtn.style.display = "inline-flex";
                saveBtn.textContent = "Save Transaction";
                form.reset();
                fields.id.value = "";
                fields.date.value = TODAY.toISOString().slice(0, 10);
            } else if (mode === "edit") {
                title.textContent = "Edit Transaction";
                subtitle.textContent = "Update transaction details";
                saveBtn.style.display = "inline-flex";
                saveBtn.textContent = "Save Changes";
                fillForm(tx);
            } else {
                title.textContent = "View Transaction";
                subtitle.textContent = "Review transaction details";
                saveBtn.style.display = "none";
                fillForm(tx);
            }

            setFormDisabled(mode === "view");
            modalOverlay.classList.add("open");
            modalOverlay.setAttribute("aria-hidden", "false");
            setTimeout(() => fields.title.focus(), 50);
        }

        function closeModal() {
            modalOverlay.classList.remove("open");
            modalOverlay.setAttribute("aria-hidden", "true");
            fields.attachment.value = "";
        }

        function saveFromModal(){
    if(!form.reportValidity()) return;
    const id = fields.id.value;
    document.getElementById("formMethod").value = id ? "PUT" : "POST";
    form.action = id ? `/transactions/${id}` : "/transactions";
    form.submit();
}

        // ---------------------------
        // Rerender all
        // ---------------------------
        function rerenderAll() {
            renderMonthChip();
            renderSummary();
            renderCharts();
            updateSortIndicators();
            renderTable();
        }

        // ---------------------------
        // Events
        // ---------------------------
        function bindEvents() {
            // Sidebar mobile
            const hamburger = document.getElementById("hamburger");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            hamburger?.addEventListener("click", () => document.body.classList.toggle("sidebar-open"));
            sidebarOverlay?.addEventListener("click", () => document.body.classList.remove("sidebar-open"));
            window.addEventListener("resize", () => {
                if (window.innerWidth > 900) document.body.classList.remove("sidebar-open");
            });

            // Search
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
                state.filters.category = document.getElementById("filterCategory").value;
                state.filters.method = document.getElementById("filterMethod").value;
                state.filters.status = document.getElementById("filterStatus").value;
                state.filters.dateFrom = document.getElementById("filterDateFrom").value;
                state.filters.dateTo = document.getElementById("filterDateTo").value;
                state.filters.amountMin = document.getElementById("filterAmountMin").value;
                state.filters.amountMax = document.getElementById("filterAmountMax").value;
                state.page = 1;
                renderTable();
            });

            // Clear all
            document.getElementById("clearAll").addEventListener("click", () => {
                state.searchGlobal = "";
                state.searchTable = "";
                document.getElementById("globalSearch").value = "";
                document.getElementById("tableSearch").value = "";

                state.filters = { type: "", category: "", method: "", status: "", dateFrom: "", dateTo: "", amountMin: "", amountMax: "" };
                document.getElementById("filterType").value = "";
                document.getElementById("filterCategory").value = "";
                document.getElementById("filterMethod").value = "";
                document.getElementById("filterStatus").value = "";
                document.getElementById("filterDateFrom").value = "";
                document.getElementById("filterDateTo").value = "";
                document.getElementById("filterAmountMin").value = "";
                document.getElementById("filterAmountMax").value = "";

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
                        state.sort.dir = (key === "date") ? "desc" : "asc";
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
            document.getElementById("txTbody").addEventListener("click", (e) => {
                const btn = e.target.closest("button[data-action]");
                if (!btn) return;

                const action = btn.dataset.action;
                const id = btn.dataset.id;
                const tx = transactions.find(x => x.id === id);

                if (action === "view") openModal("view", tx);
                if (action === "edit") openModal("edit", tx);
                if(action === "delete"){
    if(confirm("Delete this transaction?")){
        const f = document.createElement("form");
        f.method = "POST";
        f.action = `/transactions/${id}`;
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
            document.getElementById("saveTx").addEventListener("click", saveFromModal);

            modalOverlay.addEventListener("click", (e) => { if (e.target === modalOverlay) closeModal(); });
            window.addEventListener("keydown", (e) => { if (e.key === "Escape" && modalOverlay.classList.contains("open")) closeModal(); });
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