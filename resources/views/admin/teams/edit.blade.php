<x-layouts.app>
  <div class="card"><div class="card-body">
    <h1 class="h4 mb-3">Edit Team</h1>
    <form method="POST" action="{{ route('admin.teams.update',$team) }}">@csrf @method('PUT')
      <div class="mb-3"><label class="form-label">Team Name</label>
        <input name="team_name" class="form-control" value="{{ old('team_name',$team->team_name) }}" required></div>
      <button class="btn btn-primary">Update</button>
    </form>
  </div></div>
</x-layouts.app>