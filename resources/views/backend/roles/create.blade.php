@extends('backend.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>{{ isset($role) ? 'Edit Role' : 'Add Role' }}</h5>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary float-end">Back</a>
    </div>

    <div class="card-body">
        <form action="{{ isset($role) ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}" method="POST">
            @csrf
            @if(isset($role))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $role->name ?? old('name') }}" required>
            </div>

            <div class="mb-3">
                <h6>Permissions</h6>

                @foreach($permissions as $module => $modulePermissions)
                
                    <div class="mb-2 border p-2 rounded">
                        <strong>{{ $modulePermissions }}</strong>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input select-all" data-module="{{ $module }}" id="select_all_{{ $module }}">
                            <label class="form-check-label" for="select_all_{{ $module }}">Select All</label>
                        </div>

                        {{-- @if(isset($modulePermissions))
                            @foreach($modulePermissions as $permission)
                                <div class="form-check ms-3">
                                    <input type="checkbox" name="permissions[]" class="form-check-input {{ $module }}" value="{{ $permission->id }}"
                                        id="perm_{{ $permission->id }}"
                                        {{ isset($role) && $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        @endif --}}
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success">{{ isset($role) ? 'Update Role' : 'Create Role' }}</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Select All per module
    document.querySelectorAll('.select-all').forEach(function(checkbox){
        checkbox.addEventListener('change', function(){
            let module = this.dataset.module;
            document.querySelectorAll('input.' + module).forEach(function(permCheckbox){
                permCheckbox.checked = checkbox.checked;
            });
        });
    });
</script>
@endsection
