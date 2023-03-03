<x-rpd::card>
    <x-rpd::view title="User Detail">
      <x-slot name="buttons">
        <a href="{{ route('auth.users') }}" class="btn btn-outline-primary">list</a>
        <a href="{{ route('auth.users.edit',$user->id) }}" class="btn btn-outline-primary">edit</a>
      </x-slot>

      <dl class="row">
        <dt class="col-3">Name</dt>
        <dd class="col-9">{{ $user->name }}</dd>
        <dt class="col-3">Email</dt>
        <dd class="col-9">{{ $user->email }}</dd>
      </dl>

    </x-rpd::view>
</x-rpd::card>

