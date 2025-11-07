<x-layouts.app>
  <div class="card"><div class="card-body">
    <h1 class="h4 mb-3">New Team</h1>
    <form method="POST" action="{{ route('admin.teams.store') }}">@csrf
      <div class="mb-3"><label class="form-label">Team Name</label><input name="team_name" class="form-control" required></div>
      <button class="btn btn-primary">Save</button>
    </form>
  </div></div>
</x-layouts.app>