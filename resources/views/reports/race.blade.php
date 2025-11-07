<x-layouts.app>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4">Race Report · {{ $race->race_name }}</h1>
    <a href="{{ route('admin.reports.race.csv', $race) }}" class="btn btn-sm btn-outline-success">
      Export CSV
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-sm align-middle">

      <thead class="table-light">
        <tr>
          <th>Member</th><th>Team</th>
          @foreach($checkpoints as $cp)
            <th>#{{ $cp->order_no }} {{ $cp->checkpoint_name }}</th>
          @endforeach
          <th>Total Time</th>
        </tr>
      </thead>

      <tbody>
      @foreach($members as $row)
        <tr>
          <td>{{ $row['member']->member_name }}</td>
          <td>{{ $row['member']->team->team_name }}</td>
          @foreach($checkpoints as $cp)
            <td>{{ optional($row['times'][$cp->order_no])->format('Y-m-d H:i:s') ?? '—' }}</td>
          @endforeach
          <td>
            @if($row['duration']) {{ $row['duration']->format('%ad %Hh %Im %Ss') }} @else — @endif
          </td>
        </tr>
      @endforeach
      </tbody>
      
    </table>
  </div>
</x-layouts.app>
