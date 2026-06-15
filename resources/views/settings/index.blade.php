<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Settings • Personal Finance Dashboard</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        .btn-danger {
            border-color: rgba(239, 68, 68, .25);
            background: rgba(239, 68, 68, .06);
            color: rgba(127, 29, 29, .95);
        }

        /* Cards / Sections */
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

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-stroke);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 12px;
            align-items: start;
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

        .card-body {
            padding: 12px 14px 14px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .field label {
            display: block;
            font-size: 12px;
            color: rgba(15, 23, 42, .72);
            margin-bottom: 6px;
            font-weight: 700;
        }

        .control {
            width: 100%;
            height: 42px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .92);
            padding: 0 10px;
            outline: none;
            transition: box-shadow var(--t), border-color var(--t), background var(--t);
        }

        .control:focus {
            border-color: rgba(79, 70, 229, .35);
            box-shadow: var(--ring);
            background: #fff;
        }

        .field textarea {
            height: 92px;
            padding: 10px;
        }

        .hint {
            margin-top: 6px;
            font-size: 12px;
            color: var(--muted);
            line-height: 1.35;
        }

        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .divider {
            height: 1px;
            background: rgba(15, 23, 42, .08);
            margin: 12px 0;
        }

        /* Profile card */
        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .08);
            background: rgba(15, 23, 42, .02);
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background:
                radial-gradient(18px 18px at 30% 30%, rgba(255, 255, 255, 0.55), transparent 60%),
                linear-gradient(135deg, rgba(79, 70, 229, .90), rgba(37, 99, 235, .75));
            box-shadow: 0 10px 20px rgba(79, 70, 229, .18);
            border: 1px solid rgba(79, 70, 229, .20);
            flex: 0 0 auto;
        }

        .profile strong {
            display: block;
            font-size: 13px;
            letter-spacing: -.2px;
        }

        .profile span {
            display: block;
            font-size: 12px;
            color: var(--muted);
            margin-top: 3px;
        }

        /* Toggles */
        .toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 12px;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .08);
            background: rgba(15, 23, 42, .02);
            transition: transform var(--t), box-shadow var(--t);
        }

        .toggle:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow2);
        }

        .toggle .meta strong {
            display: block;
            font-size: 13px;
            letter-spacing: -.2px;
        }

        .toggle .meta span {
            display: block;
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
            line-height: 1.35;
        }

        .toggle input {
            width: 18px;
            height: 18px;
        }

        /* Security list */
        .action-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .action-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 12px;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .08);
            background: rgba(15, 23, 42, .02);
            transition: transform var(--t), box-shadow var(--t);
        }

        .action-item:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow2);
        }

        .action-item .meta strong {
            display: block;
            font-size: 13px;
            letter-spacing: -.2px;
        }

        .action-item .meta span {
            display: block;
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
            line-height: 1.35;
        }

        .toast {
            position: fixed;
            right: 18px;
            bottom: 18px;
            max-width: 360px;
            background: rgba(15, 23, 42, .96);
            color: rgba(255, 255, 255, .92);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 14px;
            padding: 12px 12px;
            box-shadow: 0 30px 70px rgba(2, 6, 23, .35);
            opacity: 0;
            transform: translateY(10px);
            pointer-events: none;
            transition: opacity var(--t), transform var(--t);
            z-index: 120;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast .t-title {
            font-weight: 800;
            font-size: 13px;
        }

        .toast .t-sub {
            margin-top: 4px;
            color: rgba(255, 255, 255, .72);
            font-size: 12px;
            line-height: 1.35;
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

        @media (max-width: 1100px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
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
            .form-grid {
                grid-template-columns: 1fr;
            }

            .btn,
            .btn-primary,
            .btn-danger {
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
                <div style="font-weight:800; letter-spacing:-.2px;">Settings</div>
            </div>

            <!-- Header -->
            <header class="top-header">
                <div class="title-block">
                    <h1>Settings</h1>
                    <p>Manage profile, preferences, security and data options</p>
                </div>

                <div class="header-actions">
                    <button class="btn" id="resetDemo" type="button">Reset Demo</button>
                    <button class="btn btn-primary" id="saveAll" type="button">Save Changes</button>
                </div>
            </header>

            <section class="section">
                <div class="settings-grid">
                    <!-- Left column: Profile + Preferences -->
                    <div style="display:grid; gap:12px;">
                        <!-- Profile -->
                        <article class="card" aria-label="Profile settings">
                            <div class="card-head">
                                <div>
                                    <h3>Profile</h3>
                                    <p>Personal information and basic account details</p>
                                </div>
                                <span class="chip">Account</span>
                            </div>

                            <div class="card-body">
                                <div class="profile" aria-label="User card">
                                    <div class="avatar" aria-hidden="true"></div>
                                    <div style="min-width:0;">
                                        <strong id="profileName">{{ Auth::user()->name }}</strong>
                                        <span id="profileEmail">{{ Auth::user()->email }}</span>
                                    </div>
                                    <div style="margin-left:auto;">
                                        <span class="chip" id="planChip">Free Plan</span>
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <form id="profileForm" method="POST" action="{{ route('settings.update') }}">
                                    @csrf
                                    <div class="form-grid">
                                        <div class="field">
                                            <label for="fullName">Full Name</label>
                                            <input class="control" id="fullName" name="name" type="text"
                                                value="{{ Auth::user()->name }}" />
                                        </div>

                                        <div class="field">
                                            <label for="email">Email</label>
                                            <input class="control" id="email" name="email" type="email"
                                                value="{{ Auth::user()->email }}" />
                                        </div>

                                        <div class="field">
                                            <label for="phone">Phone</label>
                                            <input class="control" id="phone" type="tel"
                                                placeholder="+92 3xx xxxxxxx" value="+92 300 1234567" />
                                        </div>

                                        <div class="field">
                                            <label for="country">Country</label>
                                            <select class="control" id="country">
                                                <option>Pakistan</option>
                                                <option>India</option>
                                                <option>United States</option>
                                                <option>United Kingdom</option>
                                                <option>Other</option>
                                            </select>
                                        </div>

                                        <div class="field">
                                            <label for="currency">Default Currency</label>
                                            <select class="control" id="currency">
                                                <option value="USD">USD ($)</option>
                                                <option value="PKR" selected>PKR (₨)</option>
                                                <option value="INR">INR (₹)</option>
                                                <option value="EUR">EUR (€)</option>
                                            </select>
                                            <div class="hint">Used for budgets, goals and reports.</div>
                                        </div>

                                        <div class="field">
                                            <label for="timezone">Timezone</label>
                                            <select class="control" id="timezone">
                                                <option selected>Asia/Karachi</option>
                                                <option>Asia/Kolkata</option>
                                                <option>UTC</option>
                                                <option>America/New_York</option>
                                                <option>Europe/London</option>
                                            </select>
                                            <div class="hint">Affects dates in transactions and reports.</div>
                                        </div>

                                        <div class="field" style="grid-column: 1 / -1;">
                                            <label for="bio">Bio</label>
                                            <textarea class="control" id="bio" placeholder="Short description (optional)">Finance tracking for better budgeting and goals.</textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </article>

                        {{-- Password Change --}}
                        <article class="card" style="margin-top:0;">
                            <div class="card-head">
                                <div>
                                    <h3>Change Password</h3>
                                    <p>Update your account password</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('settings.password') }}">
                                    @csrf
                                    <div class="form-grid">
                                        <div class="field">
                                            <label>Current Password</label>
                                            <input class="control" name="current_password" type="password"
                                                required />
                                            @error('current_password')
                                                <div class="hint" style="color:red;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="field">
                                            <label>New Password</label>
                                            <input class="control" name="password" type="password" required />
                                        </div>
                                        <div class="field">
                                            <label>Confirm Password</label>
                                            <input class="control" name="password_confirmation" type="password"
                                                required />
                                        </div>
                                        <div class="field">
                                            <label>&nbsp;</label>
                                            <button class="btn btn-primary" type="submit">Update Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </article>


                        <!-- Preferences -->
                        <article class="card" aria-label="Preferences settings">
                            <div class="card-head">
                                <div>
                                    <h3>Preferences</h3>
                                    <p>Customize the dashboard experience</p>
                                </div>
                                <span class="chip">UI</span>
                            </div>
                            <div class="card-body" style="display:grid; gap:10px;">
                                <div class="toggle">
                                    <div class="meta">
                                        <strong>Enable Notifications</strong>
                                        <span>Budget alerts, due dates, and insights notifications.</span>
                                    </div>
                                    <input id="prefNotifications" type="checkbox" checked />
                                </div>

                                <div class="toggle">
                                    <div class="meta">
                                        <strong>Smart Categorization</strong>
                                        <span>Automatically categorize expenses based on keywords.</span>
                                    </div>
                                    <input id="prefAutoCategory" type="checkbox" checked />
                                </div>

                                <div class="toggle">
                                    <div class="meta">
                                        <strong>Monthly Summary Email</strong>
                                        <span>Receive a report email at the end of each month.</span>
                                    </div>
                                    <input id="prefMonthlyEmail" type="checkbox" />
                                </div>

                                <div class="toggle">
                                    <div class="meta">
                                        <strong>Privacy Mode</strong>
                                        <span>Hide amounts on screen until you hover.</span>
                                    </div>
                                    <input id="prefPrivacyMode" type="checkbox" />
                                </div>

                                <div class="divider"></div>

                                <div class="row">
                                    <div>
                                        <div style="font-weight:800; font-size:13px;">Theme</div>
                                        <div class="hint" style="margin-top:4px;">For now, UI is fixed. In MVC you
                                            can
                                            store theme preference.</div>
                                    </div>
                                    <select id="prefTheme" class="control" style="max-width: 220px;">
                                        <option selected>Light content + Dark sidebar</option>
                                        <option>Dark (future)</option>
                                    </select>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Right column: Security + Data + Danger zone -->
                    <div style="display:grid; gap:12px;">
                        <!-- Security -->
                        <article class="card" aria-label="Security settings">
                            <div class="card-head">
                                <div>
                                    <h3>Security</h3>
                                    <p>Protect your account and financial data</p>
                                </div>
                                <span class="chip">Security</span>
                            </div>
                            <div class="card-body">
                                <div class="action-list">
                                    <div class="action-item">
                                        <div class="meta">
                                            <strong>Change Password</strong>
                                            <span>Update your password regularly to stay secure.</span>
                                        </div>
                                        <button class="btn" id="changePasswordBtn" type="button">Update</button>
                                    </div>

                                    <div class="action-item">
                                        <div class="meta">
                                            <strong>Two-Factor Authentication (2FA)</strong>
                                            <span>Enable 2FA for extra account security.</span>
                                        </div>
                                        <button class="btn btn-primary" id="enable2faBtn"
                                            type="button">unavailable</button>
                                    </div>

                                    <div class="action-item">
                                        <div class="meta">
                                            <strong>Active Sessions</strong>
                                            <span>Review devices that are logged in to your account.</span>
                                        </div>
                                        <button class="btn" id="sessionsBtn" type="button">View</button>
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <div class="toggle">
                                    <div class="meta">
                                        <strong>Remember This Device</strong>
                                        <span>Skip 2FA on this device for 30 days (if 2FA is enabled).</span>
                                    </div>
                                    <input id="prefRememberDevice" type="checkbox" />
                                </div>
                            </div>
                        </article>

                        <!-- Data & Sync -->
                        <article class="card" aria-label="Data and syncing settings">
                            <div class="card-head">
                                <div>
                                    <h3>Data & Sync</h3>
                                    <p>Backups, exports, and device syncing</p>
                                </div>
                                <span class="chip">Cloud</span>
                            </div>

                            <div class="card-body" style="display:grid; gap:10px;">
                                <div class="toggle">
                                    <div class="meta">
                                        <strong>Multi-device Sync (Cloud)</strong>
                                        <span>Sync your data across devices. (Demo toggle)</span>
                                    </div>
                                    <input id="prefSync" type="checkbox" checked />
                                </div>

                                <div class="action-item">
                                    <div class="meta">
                                        <strong>Export Data</strong>
                                        <span>Download a copy of your data (CSV/JSON). Demo uses a placeholder
                                            file.</span>
                                    </div>
                                    <button class="btn" id="exportBtn" type="button">Export</button>
                                </div>

                                <div class="action-item">
                                    <div class="meta">
                                        <strong>Backup</strong>
                                        <span>Create a backup snapshot. (Demo)</span>
                                    </div>
                                    <button class="btn" id="backupBtn" type="button">Create</button>
                                </div>

                                <div class="row">
                                    <div>
                                        <div style="font-weight:800; font-size:13px;">Retention</div>
                                        <div class="hint" style="margin-top:4px;">How long backups are kept (for
                                            future
                                            backend).</div>
                                    </div>
                                    <select id="prefRetention" class="control" style="max-width: 220px;">
                                        <option>7 days</option>
                                        <option selected>30 days</option>
                                        <option>90 days</option>
                                        <option>1 year</option>
                                    </select>
                                </div>
                            </div>
                        </article>

                        <!-- Danger zone -->
                        <article class="card" aria-label="Danger zone settings">
                            <div class="card-head">
                                <div>
                                    <h3>Danger Zone</h3>
                                    <p>Irreversible actions — proceed carefully</p>
                                </div>
                                <span class="chip"
                                    style="background: rgba(239,68,68,.06); border-color: rgba(239,68,68,.20); color: rgba(127,29,29,.95);">Sensitive</span>
                            </div>

                            <div class="card-body" style="display:grid; gap:10px;">
                                <div class="action-item">
                                    <div class="meta">
                                        <strong>Clear All Demo Data</strong>
                                        <span>Removes local settings (demo only). In MVC, this would delete user data
                                            from DB.</span>
                                    </div>
                                    <button class="btn btn-danger" id="clearDataBtn" type="button">Clear</button>
                                </div>

                                <div class="action-item">
                                    <div class="meta">
                                        <strong>Delete Account</strong>
                                        <span>Permanently remove your account and all associated data. (Demo)</span>
                                    </div>
                                    <button class="btn btn-danger" id="deleteAccountBtn"
                                        type="button">Delete</button>
                                </div>

                                <div class="hint">
                                    Note: This is a UI template for your ASP.NET Core MVC integration. No real backend
                                    is connected.
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="toast" id="toast" role="status" aria-live="polite">
        <div class="t-title" id="toastTitle">Saved</div>
        <div class="t-sub" id="toastSub">Your changes have been saved (demo).</div>
    </div>

    <script>
        // Demo persistence (localStorage) — helpful before ASP.NET integration
        const STORAGE_KEY = "finpulse_settings_demo_v1";

        const defaults = {
            profile: {
                fullName: "Alex Johnson",
                email: "alex@example.com",
                phone: "+92 300 1234567",
                country: "Pakistan",
                currency: "PKR",
                timezone: "Asia/Karachi",
                bio: "Finance tracking for better budgeting and goals."
            },
            prefs: {
                notifications: true,
                autoCategory: true,
                monthlyEmail: false,
                privacyMode: false,
                theme: "Light content + Dark sidebar",
                rememberDevice: false,
                sync: true,
                retention: "30 days"
            }
        };

        function loadSettings() {
            try {
                const raw = localStorage.getItem(STORAGE_KEY);
                return raw ? {
                    ...defaults,
                    ...JSON.parse(raw)
                } : structuredClone(defaults);
            } catch {
                return structuredClone(defaults);
            }
        }

        function saveSettings(data) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        }

        function $(id) {
            return document.getElementById(id);
        }

        function showToast(title, sub) {
            $("toastTitle").textContent = title;
            $("toastSub").textContent = sub;
            const t = $("toast");
            t.classList.add("show");
            clearTimeout(showToast._t);
            showToast._t = setTimeout(() => t.classList.remove("show"), 2400);
        }

        function bindSidebarMobile() {
            const hamburger = $("hamburger");
            const overlay = $("sidebarOverlay");

            hamburger?.addEventListener("click", () => document.body.classList.toggle("sidebar-open"));
            overlay?.addEventListener("click", () => document.body.classList.remove("sidebar-open"));
            window.addEventListener("resize", () => {
                if (window.innerWidth > 900) document.body.classList.remove("sidebar-open");
            });
        }

        function hydrateUI(data) {
            // Profile header
            $("profileName").textContent = data.profile.fullName;
            $("profileEmail").textContent = data.profile.email;

            // Inputs
            $("fullName").value = data.profile.fullName;
            $("email").value = data.profile.email;
            $("phone").value = data.profile.phone;
            $("country").value = data.profile.country;
            $("currency").value = data.profile.currency;
            $("timezone").value = data.profile.timezone;
            $("bio").value = data.profile.bio;

            // Pref toggles
            $("prefNotifications").checked = !!data.prefs.notifications;
            $("prefAutoCategory").checked = !!data.prefs.autoCategory;
            $("prefMonthlyEmail").checked = !!data.prefs.monthlyEmail;
            $("prefPrivacyMode").checked = !!data.prefs.privacyMode;
            $("prefTheme").value = data.prefs.theme;
            $("prefRememberDevice").checked = !!data.prefs.rememberDevice;
            $("prefSync").checked = !!data.prefs.sync;
            $("prefRetention").value = data.prefs.retention;

            applyPrivacyMode(!!data.prefs.privacyMode);
        }

        function collectUI() {
            return {
                profile: {
                    fullName: $("fullName").value.trim() || defaults.profile.fullName,
                    email: $("email").value.trim() || defaults.profile.email,
                    phone: $("phone").value.trim(),
                    country: $("country").value,
                    currency: $("currency").value,
                    timezone: $("timezone").value,
                    bio: $("bio").value.trim()
                },
                prefs: {
                    notifications: $("prefNotifications").checked,
                    autoCategory: $("prefAutoCategory").checked,
                    monthlyEmail: $("prefMonthlyEmail").checked,
                    privacyMode: $("prefPrivacyMode").checked,
                    theme: $("prefTheme").value,
                    rememberDevice: $("prefRememberDevice").checked,
                    sync: $("prefSync").checked,
                    retention: $("prefRetention").value
                }
            };
        }

        function applyPrivacyMode(on) {
            // Demo privacy mode: blur any currency-looking content in profile card (simple UX demo)
            // In real app you can toggle masking amounts across pages.
            const emailEl = $("profileEmail");
            if (!emailEl) return;
            emailEl.style.filter = on ? "blur(5px)" : "none";
            emailEl.style.transition = "filter 160ms ease";
            emailEl.title = on ? "Privacy mode enabled (hover to view)" : "";
            if (on) {
                emailEl.addEventListener("mouseenter", () => emailEl.style.filter = "none", {
                    passive: true
                });
                emailEl.addEventListener("mouseleave", () => emailEl.style.filter = "blur(5px)", {
                    passive: true
                });
            }
        }

        function bindActions() {
            $("saveAll").addEventListener("click", () => {
                const data = collectUI();
                saveSettings(data);
                hydrateUI(data);
                showToast("Saved", "Your changes have been saved (demo).");
            });

            $("resetDemo").addEventListener("click", () => {
                if (!confirm("Reset all settings to default (demo)?")) return;
                localStorage.removeItem(STORAGE_KEY);
                const data = loadSettings();
                hydrateUI(data);
                showToast("Reset", "Settings were reset to defaults (demo).");
            });

            // Preferences live effects (demo)
            $("prefPrivacyMode").addEventListener("change", (e) => {
                applyPrivacyMode(e.target.checked);
                showToast("Updated", "Privacy mode changed (demo).");
            });

            // Security / Data actions (demo)
            $("changePasswordBtn").addEventListener("click", () => showToast("Password",
                "Password change flow will be implemented in MVC."));
            $("enable2faBtn").addEventListener("click", () => showToast("2FA",
                "2FA setup flow will be implemented in MVC."));
            $("sessionsBtn").addEventListener("click", () => showToast("Sessions",
                "Active sessions view will be implemented in MVC."));
            $("exportBtn").addEventListener("click", () => {
                // Create a small demo file
                const data = collectUI();
                const blob = new Blob([JSON.stringify(data, null, 2)], {
                    type: "application/json"
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url;
                a.download = "finpulse-settings-demo.json";
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
                showToast("Exported", "Downloaded settings JSON (demo).");
            });
            $("backupBtn").addEventListener("click", () => showToast("Backup", "Backup snapshot created (demo)."));

            $("clearDataBtn").addEventListener("click", () => {
                if (!confirm("Clear demo data in this browser?")) return;
                localStorage.removeItem(STORAGE_KEY);
                hydrateUI(loadSettings());
                showToast("Cleared", "Demo data cleared (localStorage).");
            });

            $("deleteAccountBtn").addEventListener("click", () => {
                if (!confirm("This is a demo. Simulate account deletion?")) return;
                showToast("Account", "Account deletion will be handled by backend (MVC).");
            });
        }

        // Init
        bindSidebarMobile();
        const data = loadSettings();
        hydrateUI(data);
        bindActions();
    </script>
</body>

</html>
