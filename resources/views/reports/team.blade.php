<x-layouts.app>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4">Team Ranking · {{ $race->race_name }}</h1>
    <a href="{{ route('admin.reports.team.csv', $race) }}" class="btn btn-sm btn-outline-success">
      Export CSV
    </a>
  </div>

  <ol class="list-group">
    @forelse($teamStats as $row)
      <li class="list-group-item d-flex justify-content-between">
        <span>{{ $loop->iteration }}. {{ $row['team']->team_name }}</span>
        <span>{{ gmdate('H:i:s', (int)$row['avg_seconds']) }} avg</span>
      </li>
    @empty
      <li class="list-group-item">No teams with completed members yet.</li>
    @endforelse
  </ol>
</x-layouts.app>
