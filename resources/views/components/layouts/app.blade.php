<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light border-bottom mb-3">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        @auth
          <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('logs.create') }}">Record Checkpoint</a></li>
          @if(auth()->user()->is_admin)
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.teams.index') }}">Teams</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.members.index') }}">Members</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.races.index') }}">Races</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.reports.index') }}">Reports</a></li>
          @endif
        @endauth
      </ul>
      <ul class="navbar-nav">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login.form') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register.form') }}">Register</a></li>
        @else
          <li class="nav-item"><span class="nav-link">Hi, {{ auth()->user()->name }}</span></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">@csrf
              <button class="btn btn-sm btn-outline-danger">Logout</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
<main class="container py-3">
  {{ $slot }}
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
