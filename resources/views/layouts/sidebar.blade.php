<aside class="sidebar" id="sidebar" aria-label="Primary navigation">
  <div class="brand">
    {{-- <div class="brand-mark">F</div> --}}
    {{-- <div class="brand-text">
      <strong>Finova</strong>
      <span>Personal Finance</span>
    </div> --}}
        <img src="{{ asset('assets/logo.png') }}" alt="Finova" height="50">

  </div>

  <nav class="nav">
  <a href="{{ route('dashboard') }}"><span class="icon">D</span><span class="label">Dashboard</span></a>
  <a href="{{ route('expenses.index') }}" class="{{ request()->routeIs('expenses.*') ? 'active' : '' }}"><span class="icon">E</span><span class="label">Expenses</span></a>
  <a href="{{ route('income.index') }}"><span class="icon">I</span><span class="label">Income</span></a>
  <a href="{{ route('budgets.index') }}"><span class="icon">B</span><span class="label">Budget</span></a>
  <a href="{{ route('goals.index') }}"><span class="icon">G</span><span class="label">Goals</span></a>
  <a href="{{ route('transactions.index') }}"><span class="icon">T</span><span class="label">Transactions</span></a>
  <a href="{{ route('investments.index') }}"><span class="icon">V</span><span class="label">Investments</span></a>
  <a href="{{ route('debts.index') }}"><span class="icon">L</span><span class="label">Debts</span></a>
  <a href="{{ route('education.index') }}"><span class="icon">Ed</span><span class="label">Education</span></a>
  <a href="{{ route('reports.index') }}"><span class="icon">R</span><span class="label">Reports</span></a>
  <a href="{{ route('settings.index') }}"><span class="icon">S</span><span class="label">Setting</span></a>
</nav>

  <div class="sidebar-footer">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
      <strong style="font-size:13px;">Smart Tip</strong>
      <span class="mini-chip">Month</span>
    </div>
    <div class="small">
      Keep expenses under <strong>60%</strong> of income to maintain healthy cashflow.
    </div>
  </div>
</aside>