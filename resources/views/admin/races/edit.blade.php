<x-layouts.app>
  <div class="card"><div class="card-body">
    <h1 class="h4 mb-3">Edit Race</h1>
    <form method="POST" action="{{ route('admin.races.update',$race) }}">@csrf @method('PUT')
      <div class="mb-3"><label class="form-label">Race Name</label><input name="race_name" class="form-control" required value="{{ old('race_name',$race->race_name) }}"></div>
      <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description',$race->description) }}</textarea></div>
      <button class="btn btn-primary">Update</button>
    </form>
  </div></div>
</x-layouts.app>
