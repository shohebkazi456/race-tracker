<x-layouts.app>
  <div class="card"><div class="card-body">
    <h1 class="h4 mb-3">New Race</h1>
    <form method="POST" action="{{ route('admin.races.store') }}">@csrf
      <div class="mb-3"><label class="form-label">Race Name</label><input name="race_name" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
      <button class="btn btn-primary">Save</button>
    </form>
  </div></div>
</x-layouts.app>
