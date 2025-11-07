<x-layouts.app>
  <div class="card"><div class="card-body">
    <h1 class="h4 mb-3">Edit Member</h1>
    <form method="POST" action="{{ route('admin.members.update',$member) }}">@csrf @method('PUT')
      <div class="mb-3">
        <label class="form-label">Team</label>
        <select name="team_id" class="form-select" required>
          @foreach($teams as $t)<option value="{{ $t->id }}" @selected($member->team_id==$t->id)>{{ $t->team_name }}</option>@endforeach
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Member Name</label>
        <input name="member_name" class="form-control" required value="{{ old('member_name',$member->member_name) }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Assign Race (optional)</label>
        <select name="race_id" class="form-select">
          <option value="">-- None --</option>
          @foreach($races as $r)<option value="{{ $r->id }}" @selected($member->race_id==$r->id)>{{ $r->race_name }}</option>@endforeach
        </select>
      </div>
      <button class="btn btn-primary">Update</button>
    </form>
  </div></div>
</x-layouts.app>
