<div class="card">
    <div class="card-header">Mechanics list</div>
    <div class="card-body">
        <div class="m-3">
            {{ $mechanics->links() }}
        </div>
        <ul class="list-group">
            @foreach ($mechanics as $mechanic)
                <li class="list-group-item">
                    <div class="row-item">
                        <div class="row-item__basic">
                            <span>{{ $mechanic->name }} {{ $mechanic->surname }}</span>
                            @if ($mechanic->getTrucks->count())
                                <small>Works on {{ $mechanic->getTrucks->count() }} trucks.</small>
                            @else
                                <small>Currently has no trucks.</small>
                            @endif
                        </div>
                        <div class="row-item__btns">
                            <a href="{{ route('mechanic-js.index') }}#edit|{{ $mechanic->id }}"
                                class="btn btn-info link-btn">Edit</a>
                            <form method="POST" action="{{ route('mechanic-js.destroy', $mechanic) }}">
                                <button type="button" class="btn btn-danger">Delete</button>
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="m-3">
            {{ $mechanics->links() }}
        </div>
    </div>
</div>
