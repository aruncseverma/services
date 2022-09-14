<form action="{{ route('index.posts.search') }}" method="GET">
    <div class="input-group">
        <input type="search" class="form-control" placeholder="Search..." name="s" value="{{ app('request')->input('s') }}">
        <span class="input-group-btn">
            <button class="btn btn-danger" type="submit"><i class="fa fa-search"></i> Search</button>
        </span>
    </div>
</form>