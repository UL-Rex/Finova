<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Expenses • Finova</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --sidebar-bg: #0b1220;
            --sidebar-bg2: #0a1020;
            --sidebar-text: rgba(255, 255, 255, .85);
            --sidebar-muted: rgba(255, 255, 255, .60);
            --sidebar-stroke: rgba(255, 255, 255, .10);

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

        /* Card */
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

        .chip {
            font-size: 12px;
            color: rgba(15, 23, 42, .70);
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(15, 23, 42, .03);
            padding: 6px 10px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .canvas-wrap {
            padding: 10px 14px 14px;
            height: 320px;
        }

        /* Category spending cards */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }

        .cat-card {
            padding: 14px;
            transition: transform var(--t), box-shadow var(--t);
        }

        .cat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, .10);
        }

        .cat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .cat-icon {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: rgba(79, 70, 229, .10);
            border: 1px solid rgba(79, 70, 229, .16);
            color: rgba(79, 70, 229, 1);
            font-weight: 700;
        }

        .cat-name {
            font-size: 13px;
            font-weight: 700;
            margin: 0;
        }

        .cat-amt {
            margin: 4px 0 0;
            font-size: 12px;
            color: var(--muted);
        }

        .progress {
            height: 10px;
            border-radius: 999px;
            background: rgba(15, 23, 42, .06);
            border: 1px solid rgba(15, 23, 42, .08);
            overflow: hidden;
        }

        .progress>i {
            display: block;
            height: 100%;
            width: 0%;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(79, 70, 229, 1), rgba(37, 99, 235, 1));
            transition: width 560ms cubic-bezier(.2, .8, .2, 1);
        }

        .progress.warning>i {
            background: linear-gradient(90deg, rgba(245, 158, 11, 1), rgba(239, 68, 68, 1));
        }

        .cat-meta {
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
            color: var(--muted);
        }

        /* Budget warning */
        .warning-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .warn-card {
            padding: 14px;
            border-left: 5px solid rgba(245, 158, 11, .9);
            background: linear-gradient(180deg, rgba(245, 158, 11, .06), rgba(255, 255, 255, 1));
        }

        .warn-card.danger {
            border-left-color: rgba(239, 68, 68, .9);
            background: linear-gradient(180deg, rgba(239, 68, 68, .06), rgba(255, 255, 255, 1));
        }

        .warn-card h4 {
            margin: 0;
            font-size: 13px;
            letter-spacing: -.2px;
        }

        .warn-card p {
            margin: 6px 0 0;
            font-size: 12px;
            color: var(--muted);
            line-height: 1.35;
        }

        .warn-card .row {
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
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
            min-width: 920px;
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
            font-weight: 700;
        }

        .status {
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

        .status.paid {
            background: rgba(16, 185, 129, .10);
            border-color: rgba(16, 185, 129, .22);
            color: rgba(6, 95, 70, .95);
        }

        .status.paid .dot {
            background: rgba(16, 185, 129, 1);
        }

        .status.pending {
            background: rgba(245, 158, 11, .12);
            border-color: rgba(245, 158, 11, .25);
            color: rgba(120, 53, 15, .95);
        }

        .status.pending .dot {
            background: rgba(245, 158, 11, 1);
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
            width: 740px;
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

            .category-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
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

            .warning-grid {
                grid-template-columns: 1fr;
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

            .category-grid {
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

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        <main class="main">

            {{-- Success message --}}
            @if (session('success'))
                <div
                    style="padding:12px 16px; background:rgba(16,185,129,.12); border:1px solid rgba(16,185,129,.25); border-radius:12px; color:rgba(6,95,70,.95); font-size:13px; margin-bottom:14px;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Mobile bar -->
            <div class="mobile-bar">
                <button class="hamburger" id="hamburger">☰</button>
                <div style="font-weight:800;">Expenses</div>
            </div>

            <!-- Top Header -->
            <header class="top-header">
                <div class="title-block">
                    <h1>Expenses</h1>
                    <p>Track and manage your daily expenses</p>
                </div>
                <div class="header-actions">
                    <div class="search" role="search">
                        <span class="mag">⌕</span>
                        <input id="globalSearch" type="search" placeholder="Search expenses…" />
                    </div>
                    <button class="btn" id="toggleFilters" type="button">⏷ Filter</button>
                    <button class="btn btn-primary" id="openAddModal" type="button">＋ Add Expense</button>
                </div>
            </header>

            <!-- Summary Cards -->
            <section class="section">
                <div class="section-title">
                    <div>
                        <h2>Expense Summary</h2>
                        <p>Current month overview</p>
                    </div>
                    <span class="chip" id="monthChip">Month</span>
                </div>
                <div class="summary-grid" id="summaryGrid"></div>
            </section>

            <!-- Budget Warnings -->
            <section class="section">
                <div class="section-title">
                    <div>
                        <h2>Budget Warnings</h2>
                        <p>Alerts based on monthly budget thresholds</p>
                    </div>
                </div>
                <div class="warning-grid" id="warningGrid"></div>
            </section>

            <!-- Analytics -->
            <section class="section">
                <div class="section-title">
                    <div>
                        <h2>Expense Analytics</h2>
                        <p>Trends and breakdown</p>
                    </div>
                </div>
                <div class="analytics-grid">
                    <article class="card">
                        <div class="card-head">
                            <div>
                                <h3>Expense Trend</h3>
                                <p>Monthly expense visualization</p>
                            </div>
                            <span class="chip">Last 6 months</span>
                        </div>
                        <div class="canvas-wrap"><canvas id="trendChart"></canvas></div>
                    </article>
                    <article class="card">
                        <div class="card-head">
                            <div>
                                <h3>Category Breakdown</h3>
                                <p>Share of total spending</p>
                            </div>
                            <span class="chip">This month</span>
                        </div>
                        <div class="canvas-wrap"><canvas id="categoryChart"></canvas></div>
                    </article>
                </div>
            </section>

            <!-- Category Cards -->
            <section class="section">
                <div class="section-title">
                    <div>
                        <h2>Category Spending</h2>
                        <p>Progress vs category limits</p>
                    </div>
                </div>
                <div class="category-grid" id="categoryGrid"></div>
            </section>

            <!-- Table -->
            <section class="section">
                <div class="section-title">
                    <div>
                        <h2>Recent Expenses</h2>
                        <p>Search, filter, sort and manage entries</p>
                    </div>
                </div>
                <article class="card table-card">
                    <div class="table-toolbar">
                        <div class="toolbar-left">
                            <div class="search" style="max-width:420px;">
                                <span class="mag">⌕</span>
                                <input id="tableSearch" type="search" placeholder="Search recent expenses…" />
                            </div>
                            <button class="btn btn-icon" id="clearAll" type="button" title="Clear">↺</button>
                        </div>
                        <div class="toolbar-right">
                            <span class="chip" id="resultsChip">0 results</span>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="filters-panel" id="filtersPanel">
                        <div class="filter-grid">
                            <div class="field">
                                <label>Category</label>
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
                                <input id="filterAmountMax" type="number" class="control" placeholder="1000" />
                            </div>
                            <div class="field">
                                <label>&nbsp;</label>
                                <button class="btn btn-primary" id="applyFilters" type="button">Apply
                                    Filters</button>
                            </div>
                        </div>
                    </div>

                    <!-- Empty state -->
                    <div class="empty" id="emptyState">
                        <h3>No expenses recorded yet</h3>
                        <p>Add your first expense to start tracking.</p>
                        <button class="btn btn-primary" id="emptyAddBtn" type="button">＋ Add Expense</button>
                    </div>

                    <!-- Table -->
                    <div class="table-wrap" id="tableWrap">
                        <table>
                            <thead>
                                <tr>
                                    <th data-sort="date">Date <span class="sort" id="sort-date">↕</span></th>
                                    <th data-sort="title">Title <span class="sort" id="sort-title">↕</span></th>
                                    <th data-sort="category">Category <span class="sort"
                                            id="sort-category">↕</span></th>
                                    <th data-sort="amount" style="text-align:right;">Amount <span class="sort"
                                            id="sort-amount">↕</span></th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="expensesTbody"></tbody>
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
        <div class="modal" role="dialog">
            <div class="modal-head">
                <div>
                    <h3 id="modalTitle">Add Expense</h3>
                    <p id="modalSubtitle">Record a new expense entry</p>
                </div>
                <button class="modal-close" id="closeModal">✕</button>
            </div>

            <form class="modal-body" id="expenseForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="expenseId">

                <div class="form-grid">
                    <div class="field">
                        <label>Expense Title</label>
                        <input id="expenseTitle" name="title" class="control" type="text"
                            placeholder="e.g., Grocery shopping" required />
                    </div>
                    <div class="field">
                        <label>Amount</label>
                        <input id="expenseAmount" name="amount" class="control" type="number" min="0"
                            step="0.01" placeholder="0.00" required />
                    </div>
                    <div class="field">
                        <label>Category</label>
                        <select id="expenseCategory" name="category" class="control" required>
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
                        <label>Date</label>
                        <input id="expenseDate" name="date" class="control" type="date" required />
                    </div>
                    <div class="field" style="grid-column: 1 / -1;">
                        <label>Notes</label>
                        <textarea id="expenseNotes" name="note" class="control" placeholder="Optional notes"></textarea>
                    </div>
                </div>
            </form>

            <div class="modal-foot">
                <button class="btn" id="cancelModal" type="button">Cancel</button>
                <button class="btn btn-primary" id="saveExpense" type="button">Save Expense</button>
            </div>
        </div>
    </div>

    <script>
        // Laravel DB se real data
        let expenses = {!! json_encode($expenses->map(fn($e) => [
    'id'       => $e->id,
    'date'     => $e->date,
    'title'    => $e->title,
    'category' => $e->category,
    'amount'   => (float)$e->amount,
    'note'     => $e->note ?? '',
    'payment'  => 'Card',
    'status'   => 'Paid',
])) !!};

        const TODAY = new Date();

        const CATEGORY_LIMITS = {
            Food: 600,
            Transport: 220,
            Bills: 520,
            Entertainment: 250,
            Shopping: 400,
            Health: 180
        };
        const MONTHLY_BUDGET = 1800;
        const ICONS = {
            Food: "F",
            Transport: "T",
            Bills: "B",
            Entertainment: "E",
            Shopping: "S",
            Health: "H"
        };

        const state = {
            searchGlobal: "",
            searchTable: "",
            filters: {
                category: "",
                dateFrom: "",
                dateTo: "",
                amountMin: "",
                amountMax: ""
            },
            sort: {
                key: "date",
                dir: "desc"
            },
            page: 1,
            pageSize: 7
        };

        const fmt = (n) => new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD"
        }).format(n);
        const clamp = (n, a, b) => Math.max(a, Math.min(b, n));

        function parseDate(s) {
            return new Date(s + "T00:00:00");
        }

        function isSameMonth(d, ref) {
            return d.getFullYear() === ref.getFullYear() && d.getMonth() === ref.getMonth();
        }

        function monthLabel(d) {
            return d.toLocaleString("en-US", {
                month: "short"
            });
        }

        function yearMonthKey(d) {
            return `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,"0")}`;
        }

        let trendChart, categoryChart;

        function buildCharts() {
            trendChart = new Chart(document.getElementById("trendChart"), {
                type: "line",
                data: {
                    labels: [],
                    datasets: [{
                        label: "Expenses",
                        data: [],
                        borderColor: "rgba(79,70,229,1)",
                        backgroundColor: "rgba(79,70,229,.14)",
                        fill: true,
                        tension: 0.35,
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

            categoryChart = new Chart(document.getElementById("categoryChart"), {
                type: "doughnut",
                data: {
                    labels: ["Food", "Transport", "Bills", "Entertainment", "Shopping", "Health"],
                    datasets: [{
                        data: [0, 0, 0, 0, 0, 0],
                        backgroundColor: ["rgba(79,70,229,.90)", "rgba(37,99,235,.85)",
                            "rgba(16,185,129,.85)", "rgba(245,158,11,.85)", "rgba(239,68,68,.80)",
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

        function currentMonthExpenses(list) {
            return list.filter(e => isSameMonth(parseDate(e.date), TODAY));
        }

        function sumByCategory(list) {
            const m = {};
            for (const e of list) m[e.category] = (m[e.category] || 0) + e.amount;
            return m;
        }

        function total(list) {
            return list.reduce((a, b) => a + b.amount, 0);
        }

        function highestCategory(list) {
            const s = sumByCategory(list);
            let best = {
                category: "—",
                amount: 0
            };
            for (const [c, a] of Object.entries(s))
                if (a > best.amount) best = {
                    category: c,
                    amount: a
                };
            return best;
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

        function monthlyTotalsLast6(list) {
            const keys = last6MonthsKeys();
            const totals = Object.fromEntries(keys.map(k => [k, 0]));
            for (const e of list) {
                const k = yearMonthKey(parseDate(e.date));
                if (k in totals) totals[k] += e.amount;
            }
            return {
                keys,
                values: keys.map(k => Number(totals[k].toFixed(2)))
            };
        }

        function applyAllFilters(list) {
            const q = (state.searchGlobal || state.searchTable || "").trim().toLowerCase();
            const f = state.filters;
            return list.filter(e => {
                if (q && !`${e.title} ${e.category}`.toLowerCase().includes(q)) return false;
                if (f.category && e.category !== f.category) return false;
                if (f.dateFrom && parseDate(e.date) < parseDate(f.dateFrom)) return false;
                if (f.dateTo && parseDate(e.date) > parseDate(f.dateTo)) return false;
                if (f.amountMin !== "" && e.amount < Number(f.amountMin)) return false;
                if (f.amountMax !== "" && e.amount > Number(f.amountMax)) return false;
                return true;
            });
        }

        function sortList(list) {
            const {
                key,
                dir
            } = state.sort;
            const sign = dir === "asc" ? 1 : -1;
            return [...list].sort((a, b) => {
                let av = a[key],
                    bv = b[key];
                if (key === "date") {
                    av = parseDate(a.date).getTime();
                    bv = parseDate(b.date).getTime();
                }
                if (key === "amount") {
                    av = a.amount;
                    bv = b.amount;
                }
                if (typeof av === "string") return sign * av.localeCompare(bv);
                return sign * (av - bv);
            });
        }

        function paginate(list) {
            const total = list.length;
            const pages = Math.max(1, Math.ceil(total / state.pageSize));
            state.page = clamp(state.page, 1, pages);
            const start = (state.page - 1) * state.pageSize;
            return {
                pageItems: list.slice(start, start + state.pageSize),
                totalItems: total,
                totalPages: pages,
                start
            };
        }

        function renderMonthChip() {
            document.getElementById("monthChip").textContent = TODAY.toLocaleString("en-US", {
                month: "long",
                year: "numeric"
            });
        }

        function renderSummary() {
            const ml = currentMonthExpenses(expenses);
            const mt = total(ml);
            const prev = new Date(TODAY);
            prev.setMonth(prev.getMonth() - 1);
            const pt = total(expenses.filter(e => isSameMonth(parseDate(e.date), prev)));
            const delta = pt ? ((mt - pt) / pt) * 100 : 0;
            const hi = highestCategory(ml);
            document.getElementById("summaryGrid").innerHTML = `
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Total Expenses</span><strong>${fmt(mt)}</strong></div><span class="badge ${delta<=0?"success":"warning"}">${delta<=0?"↓":"↑"} ${Math.abs(delta).toFixed(1)}%</span></div><div class="summary-foot"><span>Current month</span><span>${ml.length} entries</span></div></article>
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Highest Category</span><strong>${hi.category}</strong></div><span class="badge">${mt?(hi.amount/mt*100).toFixed(0):0}% of total</span></div><div class="summary-foot"><span>Spent</span><span>${fmt(hi.amount)}</span></div></article>
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Avg Daily Spending</span><strong>${fmt(TODAY.getDate()?mt/TODAY.getDate():0)}</strong></div><span class="badge">Per day</span></div><div class="summary-foot"><span>Days elapsed</span><span>${TODAY.getDate()}</span></div></article>
        <article class="card summary-card"><div class="summary-top"><div class="meta"><span>Transactions</span><strong>${ml.length}</strong></div><span class="badge">This month</span></div><div class="summary-foot"><span>Total entries</span><span>${expenses.length}</span></div></article>
      `;
        }

        function renderWarnings() {
            const ml = currentMonthExpenses(expenses);
            const spent = total(ml);
            const pct = MONTHLY_BUDGET ? (spent / MONTHLY_BUDGET) * 100 : 0;
            const hi = highestCategory(ml);
            let card1 = pct >= 100 ?
                `<article class="card warn-card danger"><h4>Overspending Warning</h4><p>Expenses exceeded monthly budget.</p><div class="row"><span class="badge danger">Over by ${fmt(spent-MONTHLY_BUDGET)}</span><span class="chip">Budget: ${fmt(MONTHLY_BUDGET)}</span></div></article>` :
                pct >= 80 ?
                `<article class="card warn-card"><h4>Budget Alert — ${pct.toFixed(0)}% used</h4><p>Approaching monthly limit.</p><div class="row"><span class="badge warning">${fmt(spent)} spent</span><span class="chip">${fmt(MONTHLY_BUDGET-spent)} left</span></div></article>` :
                `<article class="card warn-card" style="border-left-color:rgba(16,185,129,.9);background:linear-gradient(180deg,rgba(16,185,129,.06),#fff)"><h4>Budget Healthy</h4><p>Spending at ${pct.toFixed(0)}% of budget.</p><div class="row"><span class="badge success">${fmt(spent)} spent</span><span class="chip">${fmt(MONTHLY_BUDGET-spent)} left</span></div></article>`;
            document.getElementById("warningGrid").innerHTML = card1 +
                `<article class="card warn-card" style="border-left-color:rgba(79,70,229,.9);background:linear-gradient(180deg,rgba(79,70,229,.06),#fff)"><h4>Top Driver: ${hi.category}</h4><p>Largest spending category this month.</p><div class="row"><span class="badge">${fmt(hi.amount)} spent</span><span class="chip">Limit: ${fmt(CATEGORY_LIMITS[hi.category]??0)}</span></div></article>`;
        }

        function renderCategoryCards() {
            const sums = sumByCategory(currentMonthExpenses(expenses));
            document.getElementById("categoryGrid").innerHTML = ["Food", "Transport", "Bills", "Shopping", "Entertainment"]
                .map(cat => {
                    const spent = sums[cat] || 0;
                    const limit = CATEGORY_LIMITS[cat] || 0;
                    const pct = limit ? (spent / limit) * 100 : 0;
                    return `<article class="card cat-card"><div class="cat-top"><div><p class="cat-name">${cat}</p><p class="cat-amt">${fmt(spent)} spent</p></div><div class="cat-icon">${ICONS[cat]||"•"}</div></div><div class="progress ${pct>=90?"warning":""}"><i style="width:${clamp(pct,0,140)}%;"></i></div><div class="cat-meta"><span>${pct.toFixed(0)}% used</span><span>${limit?fmt(Math.max(0,limit-spent))+" left":"No limit"}</span></div></article>`;
                }).join("");
        }

        function renderCharts() {
            const mt = monthlyTotalsLast6(expenses);
            trendChart.data.labels = mt.keys.map(k => {
                const [y, m] = k.split("-");
                return monthLabel(new Date(Number(y), Number(m) - 1, 1));
            });
            trendChart.data.datasets[0].data = mt.values;
            trendChart.update();
            const sums = sumByCategory(currentMonthExpenses(expenses));
            categoryChart.data.datasets[0].data = categoryChart.data.labels.map(l => Number((sums[l] || 0).toFixed(2)));
            categoryChart.update();
        }

        function updateSortIndicators() {
            ["date", "title", "category", "amount"].forEach(id => {
                const el = document.getElementById("sort-" + id);
                if (el) el.textContent = state.sort.key !== id ? "↕" : state.sort.dir === "asc" ? "↑" : "↓";
            });
        }

        function escapeHtml(str) {
            return String(str).replaceAll("&", "&amp;").replaceAll("<", "&lt;").replaceAll(">", "&gt;");
        }

        function renderTable() {
            const filtered = applyAllFilters(expenses);
            const sorted = sortList(filtered);
            const {
                pageItems,
                totalItems,
                totalPages,
                start
            } = paginate(sorted);
            document.getElementById("resultsChip").textContent = `${totalItems} result${totalItems===1?"":"s"}`;
            const empty = document.getElementById("emptyState");
            const tableWrap = document.getElementById("tableWrap");
            if (totalItems === 0) {
                empty.classList.add("show");
                tableWrap.style.display = "none";
                document.getElementById("pageInfo").textContent = "Showing 0–0 of 0";
                renderPager(1, 1);
                return;
            }
            empty.classList.remove("show");
            tableWrap.style.display = "block";
            document.getElementById("expensesTbody").innerHTML = pageItems.map(e => `
        <tr>
          <td>${e.date}</td>
          <td>${escapeHtml(e.title)}</td>
          <td>${escapeHtml(e.category)}</td>
          <td class="amount">${fmt(e.amount)}</td>
          <td><div class="actions">
            <button class="link-btn" type="button" data-action="view" data-id="${e.id}">View</button>
            <button class="link-btn" type="button" data-action="edit" data-id="${e.id}">Edit</button>
            <button class="link-btn danger" type="button" data-action="delete" data-id="${e.id}">Delete</button>
          </div></td>
        </tr>`).join("");
            document.getElementById("pageInfo").textContent =
                `Showing ${start+1}–${start+pageItems.length} of ${totalItems}`;
            renderPager(state.page, totalPages);
        }

        function renderPager(page, totalPages) {
            const mkBtn = (label, p, disabled = false, active = false) =>
                `<button class="page-btn ${active?"active":""}" type="button" data-page="${p}" ${disabled?"disabled":""}>${label}</button>`;
            let html = mkBtn("Prev", Math.max(1, page - 1), page === 1);
            for (let p = 1; p <= totalPages; p++) html += mkBtn(String(p), p, false, p === page);
            html += mkBtn("Next", Math.min(totalPages, page + 1), page === totalPages);
            document.getElementById("pager").innerHTML = html;
        }

        function rerenderAll() {
            renderMonthChip();
            renderSummary();
            renderWarnings();
            renderCategoryCards();
            renderCharts();
            updateSortIndicators();
            renderTable();
        }

        // Modal
        let modalMode = "add";
        const modalOverlay = document.getElementById("modalOverlay");
        const form = document.getElementById("expenseForm");
        const fields = {
            id: document.getElementById("expenseId"),
            title: document.getElementById("expenseTitle"),
            amount: document.getElementById("expenseAmount"),
            category: document.getElementById("expenseCategory"),
            date: document.getElementById("expenseDate"),
            notes: document.getElementById("expenseNotes")
        };

        function openModal(mode, expense = null) {
            modalMode = mode;
            document.getElementById("modalTitle").textContent = mode === "add" ? "Add Expense" : mode === "edit" ?
                "Edit Expense" : "View Expense";
            document.getElementById("saveExpense").style.display = mode === "view" ? "none" : "inline-flex";
            if (mode === "add") {
                form.reset();
                fields.id.value = "";
                fields.date.value = new Date().toISOString().slice(0, 10);
            } else if (expense) {
                fields.id.value = expense.id;
                fields.title.value = expense.title;
                fields.amount.value = expense.amount;
                fields.category.value = expense.category;
                fields.date.value = expense.date;
                fields.notes.value = expense.note || "";
            }
            form.querySelectorAll(".control").forEach(el => el.disabled = mode === "view");
            modalOverlay.classList.add("open");
        }

        function closeModal() {
            modalOverlay.classList.remove("open");
        }

        function saveFromModal() {
            if (!form.reportValidity()) return;
            const id = fields.id.value;
            document.getElementById("formMethod").value = id ? "PUT" : "POST";
            form.action = id ? `/expenses/${id}` : "/expenses";
            form.submit();
        }

        // Events
        document.getElementById("hamburger")?.addEventListener("click", () => document.body.classList.toggle(
            "sidebar-open"));
        document.getElementById("sidebarOverlay")?.addEventListener("click", () => document.body.classList.remove(
            "sidebar-open"));
        document.getElementById("globalSearch").addEventListener("input", e => {
            state.searchGlobal = e.target.value;
            state.page = 1;
            renderTable();
        });
        document.getElementById("tableSearch").addEventListener("input", e => {
            state.searchTable = e.target.value;
            state.page = 1;
            renderTable();
        });
        document.getElementById("toggleFilters").addEventListener("click", () => document.getElementById("filtersPanel")
            .classList.toggle("open"));
        document.getElementById("applyFilters").addEventListener("click", () => {
            state.filters.category = document.getElementById("filterCategory").value;
            state.filters.dateFrom = document.getElementById("filterDateFrom").value;
            state.filters.dateTo = document.getElementById("filterDateTo").value;
            state.filters.amountMin = document.getElementById("filterAmountMin").value;
            state.filters.amountMax = document.getElementById("filterAmountMax").value;
            state.page = 1;
            renderTable();
        });
        document.getElementById("clearAll").addEventListener("click", () => {
            state.searchGlobal = "";
            state.searchTable = "";
            state.filters = {
                category: "",
                dateFrom: "",
                dateTo: "",
                amountMin: "",
                amountMax: ""
            };
            state.page = 1;
            document.getElementById("globalSearch").value = "";
            document.getElementById("tableSearch").value = "";
            renderTable();
        });
        document.querySelectorAll("thead th[data-sort]").forEach(th => th.addEventListener("click", () => {
            const key = th.getAttribute("data-sort");
            if (state.sort.key === key) state.sort.dir = state.sort.dir === "asc" ? "desc" : "asc";
            else {
                state.sort.key = key;
                state.sort.dir = "asc";
            }
            updateSortIndicators();
            renderTable();
        }));
        document.getElementById("pager").addEventListener("click", e => {
            const btn = e.target.closest("button[data-page]");
            if (btn) {
                state.page = Number(btn.dataset.page);
                renderTable();
            }
        });
        document.getElementById("expensesTbody").addEventListener("click", e => {
            const btn = e.target.closest("button[data-action]");
            if (!btn) return;
            const action = btn.dataset.action;
            const id = btn.dataset.id;
            const exp = expenses.find(x => String(x.id) === String(id));
            if (action === "view") openModal("view", exp);
            if (action === "edit") openModal("edit", exp);
            if (action === "delete") {
                if (confirm("Delete this expense?")) {
                    const f = document.createElement("form");
                    f.method = "POST";
                    f.action = `/expenses/${id}`;
                    f.innerHTML =
                        `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                    document.body.appendChild(f);
                    f.submit();
                }
            }
        });
        document.getElementById("openAddModal").addEventListener("click", () => openModal("add"));
        document.getElementById("emptyAddBtn").addEventListener("click", () => openModal("add"));
        document.getElementById("closeModal").addEventListener("click", closeModal);
        document.getElementById("cancelModal").addEventListener("click", closeModal);
        document.getElementById("saveExpense").addEventListener("click", saveFromModal);
        modalOverlay.addEventListener("click", e => {
            if (e.target === modalOverlay) closeModal();
        });
        window.addEventListener("keydown", e => {
            if (e.key === "Escape") closeModal();
        });

        buildCharts();
        rerenderAll();
    </script>
</body>

</html>
