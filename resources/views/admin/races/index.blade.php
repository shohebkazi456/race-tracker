<x-layouts.app>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Races</h1>
    <a href="{{ route('admin.races.create') }}" class="btn btn-primary">+ New Race</a>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light"><tr><th>Name</th><th>Description</th><th>Checkpoints</th><th>Actions</th></tr></thead>
      <tbody>
      @foreach($races as $r)
        <tr>
          <td>{{ $r->race_name }}</td>
          <td>{{ $r->description }}</td>
          <td>{{ $r->checkpoints_count }}</td>
          <td>
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.races.edit',$r) }}">Edit</a>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.races.checkpoints.index',$r) }}">Checkpoints</a>
            <form class="d-inline" method="POST" action="{{ route('admin.races.destroy',$r) }}">
              @csrf @method('DELETE')
              <button onclick="return confirm('Delete?')" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
    {{ $races->links() }}
  </div>
</x-layouts.app>
