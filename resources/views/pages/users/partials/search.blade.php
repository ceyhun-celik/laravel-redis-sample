<form action="{{ route('users.index') }}" method="GET">
    <input type="text" name="search" class="border border-gray-300" id="search" value="{{ request()->get('search') }}" placeholder="Search.." />
</form>