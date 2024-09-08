
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
      <a class="nav-link" href="/">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    @if(auth()->user()->id == 1)
    <li class="nav-item">
      <a class="nav-link" href="{{ route('user.index') }}">
        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
        <span class="menu-title">Pengguna</span>
      </a>
    </li>
    @endif
    
    @if(auth()->user()->id == 1 || auth()->user()->role() == 'ketua')
    <li class="nav-item">
      <a class="nav-link" href="{{ route('user.verifikasi') }}">
        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
        <span class="menu-title">Verifikasi</span>
      </a>
    </li>
    @endif

    @if(auth()->user()->role() != 'sekretaris_proker')
    <li class="nav-item">
      <a class="nav-link" href="{{ route('ormawa.index') }}">
        <i class="mdi mdi-flag-outline menu-icon"></i>
        <span class="menu-title">Ormawa</span>
      </a>
    </li>
    @endif

    @if(auth()->user()->role() != 'sekretaris_proker')
    <li class="nav-item">
      <a class="nav-link" href="{{ route('proker.index') }}">
        <i class="mdi mdi-book-open menu-icon"></i>
        <span class="menu-title">Program Kerja</span>
      </a>
    </li>
    @endif

    @if((auth()->user()->role() != 'anggota' && auth()->user()->ormawa_id != null) || auth()->user()->id == 1)
    <li class="nav-item">
      <a class="nav-link" href="{{ route('proposal.index') }}">
        <i class="mdi mdi-file-document menu-icon"></i>
        <span class="menu-title">Proposal</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('lpj.index') }}">
        <i class="mdi mdi-file-document menu-icon"></i>
        <span class="menu-title">Laporan <br> Pertanggungjawaban</span>
      </a>
    </li>
    @endif

  </ul>
</nav>