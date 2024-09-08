<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="/">
      <div class="row content-justify-center align-items-center">
          <img src="{{ asset('images/logoHD.png') }}" class="mr-2" alt="logo"/>
          <h3 class="mt-3 text-primary">Ormawa</h3>
      </div>
    </a>
    <a class="navbar-brand brand-logo-mini" href="/">
      <div class="row content-justify-center align-items-center">
          <img src="{{ asset('images/logoHD.png') }}" class="w-50 h-50" alt="logo"/>
      </div>
    </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    <ul class="navbar-nav mr-lg-2">
      
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="{{ route('notifikasi') }}">
          <i class="icon-bell mx-0"></i>
          @if( $isOpenCount > 0)
          <span class="count"></span>
          {{ $isOpenCount }}
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <p class="mb-0 font-weight-normal float-left dropdown-header">Notifikasi</p>
          <a class="dropdown-item preview-item" href="#">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-warning">
                <i class="ti-info-alt mx-0"></i>
                <span class="count"></span>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Peringatan</h6>
            </div>
          </a>
          <a class="dropdown-item preview-item" href="#">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-success">
                <i class="ti-info-alt mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Feedback</h6>
            </div>
          </a>
        </div>
      </li>
      
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <img src="{{ asset('images/profile-user.png') }}" alt="profile"/>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <div class="dropdown-item d-block">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h5 class="font-weight-bold">{{ auth()->user()->nama }}</h5>
              <h6 class="font-weight-normal mb-0">

                @if(auth()->user()->role() == 'sekretaris_umum')
                  Sekretaris Umum
                @elseif(auth()->user()->role() == 'sekretaris_proker')
                  Sekretaris Proker
                @else
                  {{ ucfirst(auth()->user()->role()) }}
                @endif
                @if (auth()->user()->id != 1)
                  {{ ucfirst(auth()->user()->ormawa?->nama) }}
                @endif
              </h6>
              
            </div>
          </div>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
            <i class="ti-power-off text-primary"></i>
            Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
        </div>
      </li>

    </ul>
  </div>
</nav>

