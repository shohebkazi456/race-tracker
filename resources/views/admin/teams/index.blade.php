<x-layouts.app>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Teams</h1>
    <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">+ New Team</a>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light"><tr><th>Name</th><th>Members</th><th>Actions</th></tr></thead>
      <tbody>
      @foreach($teams as $t)
        <tr>
          <td>{{ $t->team_name }}</td>
          <td>{{ $t->members_count }}</td>
          <td>
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.teams.edit',$t) }}">Edit</a>
            <form class="d-inline" method="POST" action="{{ route('admin.teams.destroy',$t) }}">
              @csrf @method('DELETE')
              <button onclick="return confirm('Delete?')" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
    {{ $teams->links() }}
  </div>
</x-layouts.app>