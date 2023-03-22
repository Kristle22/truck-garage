<div class="card">
    <div class="card-header">Mechanic Edit</div>
    <div class="card-body">
        <form method="POST" action="{{ route('mechanic-js.update', $mechanic) }}">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="mechanic_name" class="form-control"
                    value="{{ old('mechanic_name', $mechanic->name) }}">
                <small class="form-text text-muted">Enter new mechanic name.</small>
            </div>
            <div class="form-group">
                <label>Surname</label>
                <input type="text" name="mechanic_surname" class="form-control"
                    value="{{ old('mechanic_surname', $mechanic->surname) }}">
                <small class="form-text text-muted">Enter new mechanic surname.</small>
            </div>
            @csrf
            <button type="button" class="btn btn-info">Update mechanic</button>
        </form>
    </div>
</div>
