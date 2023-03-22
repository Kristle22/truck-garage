<div class="card">
    <div class="card-header">New Mechanic</div>

    <div class="card-body">
        <form method="POST" action="{{ route('mechanic-js.store') }}">
            <div class="form-group">
                <label>Name: </label>
                <input type="text" class="form-control" name="mechanic_name" value="{{ old('mechanic_name') }}">
                <small class="form-text text-muted">Enter new mechanic name.</small>
            </div>
            <div class="form-group">
                <label>Surname: </label>
                <input type="text" class="form-control" name="mechanic_surname"
                    value="{{ old('mechanic_surname') }}">
                <small class="form-text text-muted">Enter new mechanic surname.</small>
            </div>
            @csrf
            <button type="button" class="btn btn-primary">Add new</button>
        </form>
    </div>
</div>
