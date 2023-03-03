<nav class="navbar navbar-expand py-3 bg-white">
  <div class="container">
    <a class="navbar-brand" href="#">Navbar</a>
    
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
      <ul class="navbar-nav">
        @can('viewAny-group')
          <li class="nav-item">
            <a 
              @class([
                'nav-link',
                'active' => Route::is('groups.index')
              ]) 
              href="{{ route('groups.index') }}">
              Groups
            </a>
          </li>            
        @endcan
        <li class="nav-item">
          <a class="nav-link" href="#">Products</a>
        </li>
 
        {{-- user shit here --}}
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            {{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="@route('profile.edit')">Profile</a></li>
            <li><a class="dropdown-item" href="@route('logout')">Logout</a></li>
          </ul>
        </li>

      </ul>
    </div>

  </div>
</nav>