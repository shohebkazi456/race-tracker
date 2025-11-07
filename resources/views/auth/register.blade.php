<x-layouts.app>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card"><div class="card-body">
        <h1 class="h4 mb-3">Register</h1>
        <form method="POST" action="{{ route('register') }}">@csrf
          <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" required value="{{ old('name') }}"></div>
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
          <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Confirm Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
          <button class="btn btn-primary">Create Account</button>
        </form>
      </div></div>
    </div>
  </div>
</x-layouts.app>