<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Laravel Login Registration</title>
    <link rel="stylesheet prefetch" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
    <ul class="nav nav-pills" >
        @if(\Auth::check())
          <li>
            {{ link_to_route('logout', 'Logout') }}
          </li>
        @else
          <li>
            {{ link_to_route('login', 'Login') }}
          </li>
        @endif
         
         <li>
          {{ link_to_route('users.create', 'New User') }}
        </li>

          <li>
          {{ link_to_route('forgotpassword', 'forgot password ? ') }}
        </li>
      
      </ul>
      @yield('content')
    </div>
  </body>
</html>
