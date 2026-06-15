<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finova Website</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
</head>

<body>

    <nav class="navbar">
        <div class="nav-inner">

            <!-- Logo -->
            <div class="logo MSS">
                <a href="index.html" class="logoH"><img src="{{ asset('assets/logo.png') }}" alt="logo" class="logoHimg"></a>
            </div>

            <!-- Top center pill tabs -->
            <div class="top-tabs">
                <a href="#aboutLink">About</a>
                <span class="divider"></span>
                <a href="#security">Features</a>
                <span class="divider"></span>
                <a href="{{ route('login') }}" class="active">Login</a>
                {{-- <a href="/login page/login.html" class="active">Login</a> --}}
            </div>

            <!-- Login button -->
            <button class="login-btn MSS"> <a href="{{ route('register') }}" class="active">Register</a></button>

        </div>

        <!-- <div class="outlineNav"></div> -->

    </nav>

    <section class="hero" id="aboutLink">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <h1 class="reveal">Master your money with <span class="gradient">intelligent clarity</span></h1>
                    <p class="hero-desc reveal">A premium personal finance dashboard that transforms your financial data
                        into
                        actionable insights. Track spending, manage budgets, and build wealth with unprecedented ease.
                    </p>
                    <div class="hero-actions reveal">
                        <button class="btn btn-primary"> <a href="{{ route('register') }}" class="active">Sign Up</a></button>
                        <button class="btn btn-secondary"> <a href="{{ route('login') }}" class="active">Login</a></button>
                    </div>
                    <div class="hero-trust reveal">
                        <div class="trust-avatars">
                            <div class="trust-avatar trust-avatar-1">M</div>
                            <div class="trust-avatar trust-avatar-2">J</div>
                            <div class="trust-avatar trust-avatar-3">A</div>
                            <div class="trust-avatar trust-avatar-4">S</div>
                        </div>
                        <div class="trust-text"><strong>5,000+</strong> professionals manage their finances with
                            Wealthwise</div>
                    </div>
                </div>

                <div class="hero-visual reveal">
                    <div class="dashboard-3d">
                        <div class="floating-widget floating-1">
                            <div class="float-label">Net Worth</div>
                            <div class="float-value">$284.5K</div>
                            <div class="float-sub">↑ 18% YoY</div>
                        </div>
                        <div class="floating-widget floating-2">
                            <div class="float-label">Monthly Savings</div>
                            <div class="float-value">$4,280</div>
                            <div class="float-sub">45% of income</div>
                        </div>

                        <div class="dashboard-frame">
                            <div class="dash-header">
                                <div>
                                    <div class="dash-title">Dashboard</div>
                                    <div class="dash-title-sub">Welcome back, Morgan</div>
                                </div>
                                <div class="dash-dots">
                                    <div class="dash-dot dash-dot-r"></div>
                                    <div class="dash-dot dash-dot-a"></div>
                                    <div class="dash-dot dash-dot-g"></div>
                                </div>
                            </div>

                            <div class="stats-row">
                                <div class="stat-card">
                                    <div class="stat-label">Total Balance</div>
                                    <div class="stat-value">$28,420</div>
                                    <span class="stat-change up">↑ 5.2%</span>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-label">Monthly Income</div>
                                    <div class="stat-value">$9,500</div>
                                    <span class="stat-change up">↑ 2.1%</span>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-label">Spending</div>
                                    <div class="stat-value">$3,840</div>
                                    <span class="stat-change down">↓ 1.8%</span>
                                </div>
                            </div>

                            <div class="chart-section">
                                <div class="chart-header">
                                    <span class="chart-title">Cash Flow</span>
                                    <div class="chart-tabs">
                                        <span class="chart-tab">W</span>
                                        <span class="chart-tab active">M</span>
                                        <span class="chart-tab">Y</span>
                                    </div>
                                </div>
                                <svg class="chart-svg" viewBox="0 0 500 100" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad1" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:0.2" />
                                            <stop offset="100%" style="stop-color:#3B82F6;stop-opacity:0" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,70 Q60,55 120,45 T240,30 T360,20 T500,15" fill="none"
                                        stroke="#3B82F6" stroke-width="2.5" stroke-linecap="round" />
                                    <path d="M0,70 Q60,55 120,45 T240,30 T360,20 T500,15 L500,100 L0,100"
                                        fill="url(#grad1)" />
                                </svg>
                            </div>

                            <div class="dash-bottom">
                                <div class="activity-card">
                                    <div class="card-title">Recent Activity</div>
                                    <div class="activity-item">
                                        <div class="activity-icon" style="background:rgba(16,185,129,0.15)">↓</div>
                                        <div class="activity-info">
                                            <div class="activity-name">Salary Deposit</div>
                                            <div class="activity-date">Today at 09:30</div>
                                        </div>
                                        <div class="activity-amount in">+$9,500</div>
                                    </div>
                                    <div class="activity-item">
                                        <div class="activity-icon" style="background:rgba(244,63,94,0.15)">↑</div>
                                        <div class="activity-info">
                                            <div class="activity-name">Grocery Store</div>
                                            <div class="activity-date">Yesterday</div>
                                        </div>
                                        <div class="activity-amount out">-$124.50</div>
                                    </div>
                                    <div class="activity-item">
                                        <div class="activity-icon" style="background:rgba(245,158,11,0.15)">↑</div>
                                        <div class="activity-info">
                                            <div class="activity-name">Netflix Subscription</div>
                                            <div class="activity-date">Dec 1</div>
                                        </div>
                                        <div class="activity-amount out">-$15.99</div>
                                    </div>
                                </div>

                                <div class="goals-card">
                                    <div class="card-title">Savings Goals</div>
                                    <div class="goal-item">
                                        <div class="goal-header">
                                            <span class="goal-name">Emergency Fund</span>
                                            <span class="goal-pct">72%</span>
                                        </div>
                                        <div class="goal-bar">
                                            <div class="goal-fill grad-blue-purple"
                                                style="animation-delay:0.2s;width:72%"></div>
                                        </div>
                                    </div>
                                    <div class="goal-item">
                                        <div class="goal-header">
                                            <span class="goal-name">Vacation</span>
                                            <span class="goal-pct">45%</span>
                                        </div>
                                        <div class="goal-bar">
                                            <div class="goal-fill grad-purple-rose"
                                                style="animation-delay:0.4s;width:45%"></div>
                                        </div>
                                    </div>
                                    <div class="goal-item">
                                        <div class="goal-header">
                                            <span class="goal-name">Home Downpayment</span>
                                            <span class="goal-pct">28%</span>
                                        </div>
                                        <div class="goal-bar">
                                            <div class="goal-fill grad-green-cyan"
                                                style="animation-delay:0.6s;width:28%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- ==========================================================================
       2. TRUSTED STATISTICS SECTION
       ========================================================================== -->
    <section class="statistics">
        <div class="section-container">
            <div class="statistics-grid">
                <div class="stat-item">
                    <div class="stat-number">$18.4B+</div>
                    <div class="stat-label">Assets Managed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">$2.4M</div>
                    <div class="stat-label">Average Net Worth</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.997%</div>
                    <div class="stat-label">System Uptime</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">11,000+</div>
                    <div class="stat-label">Connected Places</div>
                </div>
            </div>
        </div>
    </section>




    <section class="section" aria-label="Security and privacy" id="security">
        <div class="container">
            <div class="section__head">
                <!-- <div class="kicker reveal"><span class="kicker__dot" aria-hidden="true"></span> Security & Privacy</div> -->
                <h2 class="h2 reveal">Encrypted by default. Designed to feel private.</h2>
                <p class="p p--center reveal">
                    Your financial data deserves bank-grade handling. This interface keeps trust visible without turning
                    security into spectacle.
                </p>
            </div>

            <div class="securityGrid">
                <div class="shieldWrap reveal" aria-label="Security visuals">
                    <div class="shield">
                        <div class="shieldRings" aria-hidden="true"></div>
                        <div class="shieldCenter" aria-hidden="true">
                            <svg width="42" height="42" viewBox="0 0 24 24" fill="none"
                                stroke="rgba(248,250,252,.95)" stroke-width="2.4" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 2l8 4v6c0 5-3.5 9.5-8 10-4.5-.5-8-5-8-10V6l8-4z" />
                                <path d="M9 12l2 2 4-5" />
                            </svg>
                        </div>
                    </div>

                    <div class="lockPanel" aria-hidden="true">
                        <div class="lockPanel__head">
                            <h4>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="rgba(59,130,246,.95)" stroke-width="2.3" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    <path d="M5 11h14v10H5V11z" />
                                </svg>
                                Encrypted channel
                            </h4>
                            <span>TLS + at-rest encryption</span>
                        </div>
                        <div class="lockPanel__body">
                            <div class="cipherRow"><span>Payload</span><b>Confidential</b></div>
                            <div class="cipherRow"><span>Keys</span><b>Rotated</b></div>
                            <div class="cipherRow"><span>Access</span><b>Scoped</b></div>
                        </div>
                    </div>
                </div>

                <div class="reveal revealspS">
                    <h2 class="h2" style="font-size:clamp(26px, 3.1vw, 38px); margin:0 0 12px;">Security that’s
                        present, not performative</h2>
                    <p class="p p--lg">
                        Authentication and data protection are built into the experience. You see the trust signals
                        through clean, purposeful UI so you can focus on your finances.
                    </p>

                    <div class="secCards" role="list" aria-label="Security capabilities">
                        <article class="secCard" role="listitem">
                            <div class="secCard__icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="rgba(59,130,246,.95)" stroke-width="2.4" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 2l8 4v6c0 5-3.5 9.5-8 10-4.5-.5-8-5-8-10V6l8-4z" />
                                </svg>
                            </div>
                            <div class="secCard__text">
                                <h4>Encrypted financial data</h4>
                                <p>Bank-grade encryption protects sensitive information in transit and at rest.</p>
                            </div>
                        </article>

                        <article class="secCard" role="listitem">
                            <div class="secCard__icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="rgba(6,182,212,.95)" stroke-width="2.4" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                            </div>
                            <div class="secCard__text">
                                <h4>Secure authentication</h4>
                                <p>Multi step verification patterns and strong session handling designed for
                                    reliability.</p>
                            </div>
                        </article>

                        <article class="secCard" role="listitem">
                            <div class="secCard__icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="rgba(139,92,246,.95)" stroke-width="2.4" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 10c0 6-9 14-9 14S3 16 3 10a9 9 0 0 1 18 0z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                            </div>
                            <div class="secCard__text">
                                <h4>Privacy-first design</h4>
                                <p>Minimal surfaces, scoped access, and security messaging that stays clear and quiet.
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Take Control of Your Finances?</h2>
                <p>Join thousands of users who are already mastering their money with Finova. Start your journey today
                    no credit card required.</p>
                <div class="cta-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                </div>
            </div>
        </div>
    </section>


    <footer class="footer-section">
        <div class="container">

            <div class="footer-top">

                <!-- Logo + Description -->
                <div class="footer-brand">
                    <h2>Finova</h2>
                    <p>
                        Smart personal finance dashboard to manage expenses,
                        savings, investments, and financial goals securely.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="footer-links">
                    <h4>Quick Links</h4>

                    <a href="#">Home</a>
                    <a href="#">Features</a>
                    <a href="#">About</a>
                </div>

                <!-- Legal -->
                <div class="footer-links">
                    <h4>Legal</h4>

                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms & Conditions</a>
                    <a href="#">Security</a>
                </div>

                <!-- Social -->
                <div class="footer-links">
                    <h4>Connect</h4>

                    <a href="#">GitHub</a>
                    <a href="#">LinkedIn</a>
                    <a href="#">Twitter</a>
                </div>

            </div>

            <!-- Bottom -->
            <div class="footer-bottom">
                <p>© 2026 Finova. All rights reserved.</p>
            </div>

        </div>
    </footer>

    <script src="{{ asset('assets/script.js') }}"></script>
</body>

</html>
