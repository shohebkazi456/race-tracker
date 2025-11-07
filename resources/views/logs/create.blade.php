<x-layouts.app>
  <div class="card"><div class="card-body">
    <h1 class="h4 mb-3">Record Checkpoint Reach</h1>

    @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
    @if($errors->any())
      <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('logs.store') }}">@csrf
      <div class="mb-3">
        <label class="form-label">Race</label>
        <select name="race_id" id="race" class="form-select" required>
          <option value="">-- Select --</option>
          @foreach($races as $r)
            <option value="{{ $r->id }}" @selected(old('race_id')==$r->id)>{{ $r->race_name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Member</label>
        <select name="member_id" id="member" class="form-select" required disabled>
          <option value="">-- Select --</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Checkpoint</label>
        <select name="checkpoint_id" id="checkpoint" class="form-select" required disabled>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Reached At</label>
        <input type="datetime-local" name="reached_at" class="form-control" required value="{{ now()->format('Y-m-d\TH:i') }}">
      </div>

      <button class="btn btn-primary">Record</button>
    </form>
  </div></div>

  <script>
    const raceSel = document.getElementById('race');
    const memberSel = document.getElementById('member');
    const cpSel = document.getElementById('checkpoint');

    async function loadMembers() {
      memberSel.innerHTML = '<option value="">-- Select --</option>';
      cpSel.innerHTML = '';
      memberSel.disabled = true;
      cpSel.disabled = true;

      const race_id = raceSel.value;
      if (!race_id) return;

      const url = new URL("{{ route('logs.members') }}", window.location.origin);
      url.searchParams.set('race_id', race_id);

      const res = await fetch(url);
      const list = await res.json();

      list.forEach(m => {
        const opt = document.createElement('option');
        opt.value = m.id;
        opt.textContent = m.label;
        memberSel.appendChild(opt);
      });

      memberSel.disabled = false;

      @if(old('member_id'))
        memberSel.value = "{{ (int) old('member_id') }}";
        if (memberSel.value) await loadNextCheckpoint();
      @endif
    }

    async function loadNextCheckpoint() {
      cpSel.innerHTML = '';
      cpSel.disabled = true;

      const race_id = raceSel.value;
      const member_id = memberSel.value;
      if (!race_id || !member_id) return;

      const url = new URL("{{ route('logs.next') }}", window.location.origin);
      url.searchParams.set('race_id', race_id);
      url.searchParams.set('member_id', member_id);

      const res = await fetch(url);
      const data = await res.json();

      if (data?.error) {
        alert(data.error);
        return;
      }

      if (data?.done) {
        const opt = document.createElement('option');
        opt.value = '';
        opt.textContent = 'Completed';
        cpSel.appendChild(opt);
        cpSel.disabled = true;
        return;
      }

      const opt = document.createElement('option');
      opt.value = data.id;
      opt.textContent = data.label;
      cpSel.appendChild(opt);
      cpSel.disabled = false;

      @if(old('checkpoint_id'))
        cpSel.value = "{{ (int) old('checkpoint_id') }}";
      @endif
    }

    raceSel.addEventListener('change', loadMembers);
    memberSel.addEventListener('change', loadNextCheckpoint);

    document.addEventListener('DOMContentLoaded', async () => {
      if (raceSel.value) {
        await loadMembers();
      }
    });
  </script>
</x-layouts.app>
