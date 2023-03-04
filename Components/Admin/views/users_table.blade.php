<x-rpd::card>
    <x-rpd::table
        title="List Users"
        :items="$items"
    >
        <x-slot name="filters">
            <x-rpd::input col="col" debounce="350" model="search"  placeholder="search..." />
        </x-slot>

        <x-slot name="buttons">
            <a href="{{ route('auth.users') }}" class="btn btn-outline-dark">reset</a>
            <a href="{{ route('auth.users.edit') }}" class="btn btn-outline-primary">add</a>
        </x-slot>

        <table class="table">
            <thead>
            <tr>
                <th>
                    <x-rpd::sort model="id" label="id" />
                </th>
                <th>name</th>
                <th>email</th>
                <th>roles</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $user)
            <tr>
                <td>
                    <a href="{{ route('auth.users.view',$user->id) }}">{{ $user->id }}</a>
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ optional(optional($user->roles)->pluck('name'))->join(',') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>

    </x-rpd::table>
</x-rpd::card>

