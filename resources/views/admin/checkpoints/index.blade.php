<x-layouts.app>
  <div class="d-flex justify-content-between mb-3">
    <h1 class="h4 mb-0">Checkpoints · {{ $race->race_name }}</h1>
    <a href="{{ route('admin.races.checkpoints.create',$race) }}" class="btn btn-primary">+ Add</a>
  </div>
  <ol class="list-group list-group-numbered">
    @foreach($checkpoints as $cp)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>#{{ $cp->order_no }} — {{ $cp->checkpoint_name }}</span>
        <span>
          <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.races.checkpoints.edit',[$race,$cp]) }}">Edit</a>
          <form class="d-inline" method="POST" action="{{ route('admin.races.checkpoints.destroy',[$race,$cp]) }}">
            @csrf @method('DELETE')
            <button onclick="return confirm('Delete?')" class="btn btn-sm btn-outline-danger">Delete</button>
          </form>
        </span>
      </li>
    @endforeach
  </ol>
</x-layouts.app>
