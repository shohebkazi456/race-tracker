<x-layouts.app>
  <div class="card"><div class="card-body">
    <h1 class="h5 mb-3">Add Checkpoint · {{ $race->race_name }}</h1>
    <form method="POST" action="{{ route('admin.races.checkpoints.store',$race) }}">@csrf
      <input type="hidden" name="race_id" value="{{ $race->id }}">
      <div class="mb-3"><label class="form-label">Name</label><input name="checkpoint_name" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Order No (1 = Start)</label><input name="order_no" type="number" min="1" class="form-control" required></div>
      <button class="btn btn-primary">Save</button>
    </form>
  </div></div>
</x-layouts.app>
