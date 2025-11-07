<x-layouts.app>
  <h1 class="h4 mb-3">Reports</h1>
  <ul class="list-group">
    @foreach($races as $race)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>{{ $race->race_name }}</span>
        <span>
          <a class="btn btn-sm btn-outline-success" href="{{ route('admin.reports.race',$race) }}">Race Report</a>
          <a class="btn btn-sm btn-outline-success" href="{{ route('admin.reports.team',$race) }}">Team Ranking</a>
        </span>
      </li>
    @endforeach
  </ul>
</x-layouts.app>
