
<x-rpd::card>
    <div>
        <x-slot name="buttons">
        </x-slot>

        <x-rpd::edit title="User Edit">
            <div>
                <div class="row mb-5">
                    <x-rpd::input col="col-6" model="user.name" label="Name" />
                    <x-rpd::input col="col-6" model="user.email" label="Email" />
                    <x-rpd::input col="col-6" model="psswd" label="New Password" type="password" />
                </div>
            </div>
            <x-slot name="actions">

                <button type="submit" class="btn btn-primary">Save</button>
            </x-slot>
        </x-rpd::edit>

    </div>
</x-rpd::card>



@section('doc')
    <div class="row my-3">
        <div class="col-4">
            @include('demo::Articles.views.folders')
        </div>
        <div class="col-8">
            <div v-pre class="documenter h-100">
                <h4>route</h4>
{!! App\Modules\Demo\Documenter::showCode("Components/routes.php", false, '^Route::get\(\'demo\/article\/edit.*}\);$') !!}
            </div>
        </div>
    </div>
    <div class="row" v-pre>
        <div class="col-6">
            <div class="documenter">
                <h4>component</h4>
{!! App\Modules\Demo\Documenter::showCode("Components/Articles/ArticlesEdit.php") !!}
            </div>
        </div>
        <div class="col-6">
            <div class="documenter">
                <h4>view</h4>
{!! App\Modules\Demo\Documenter::showCode("Components/Articles/views/articles_edit.blade.php", true) !!}
            </div>
        </div>
    </div>
@endsection
