<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Brand</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-5">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('product.shoppingCart') }}"><i class="fa fa-shopping-cart"></i> Shopping Cart
          <span class="badge bg-secondary">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-user"></i> User Management
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          @if(Auth::check())
            <li><a class="dropdown-item" href="{{ route('user.profile') }}">User Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
          @else
            <li><a class="dropdown-item" href="{{ route('user.signup') }}">Signup</a></li>
            <li><a class="dropdown-item" href="{{ route('user.signin') }}">Signin</a></li>
            <li><hr class="dropdown-divider"></li>
          @endif       
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>