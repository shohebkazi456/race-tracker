<x-layouts.app>
  <div class="card"><div class="card-body">
    <h1 class="h5 mb-3">Edit Checkpoint · {{ $race->race_name }}</h1>
   <form method="POST" action="{{ route('admin.races.checkpoints.update', [$race, $checkpoint]) }}">
@csrf @method('PUT')
      <input type="hidden" name="race_id" value="{{ $race->id }}">
      <div class="mb-3"><label class="form-label">Name</label><input name="checkpoint_name" class="form-control" value="{{ old('checkpoint_name',$checkpoint->checkpoint_name) }}" required></div>
      <div class="mb-3"><label class="form-label">Order No (1 = Start)</label><input name="order_no" type="number" min="1" class="form-control" value="{{ old('order_no',$checkpoint->order_no) }}" required></div>
      <button class="btn btn-primary">Update</button>
    </form>
  </div></div>
</x-layouts.app>
