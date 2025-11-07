<x-layouts.app>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Members</h1>
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">+ New Member</a>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light"><tr><th>Name</th><th>Team</th><th>Race</th><th>Actions</th></tr></thead>
      <tbody>
      @foreach($members as $m)
        <tr>
          <td>{{ $m->member_name }}</td>
          <td>{{ $m->team->team_name }}</td>
          <td>{{ $m->race?->race_name ?? '-' }}</td>
          <td>
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.members.edit',$m) }}">Edit</a>
            <form class="d-inline" method="POST" action="{{ route('admin.members.destroy',$m) }}">
              @csrf @method('DELETE')
              <button onclick="return confirm('Delete?')" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
    {{ $members->links() }}
  </div>
</x-layouts.app>
