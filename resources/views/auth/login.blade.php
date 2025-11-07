<x-layouts.app>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card"><div class="card-body">
        <h1 class="h4 mb-3">Login</h1>
        <form method="POST" action="{{ route('login') }}">@csrf
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
          <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
          <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label for="remember" class="form-check-label">Remember me</label></div>
          <button class="btn btn-primary">Login</button>
        </form>
      </div></div>
    </div>
  </div>
</x-layouts.app>