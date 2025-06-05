<x-applayout>
    <x-admin.breadcrumb title="Add Permissions" />

    @if ($errors->any())
        <div class="col-lg-12 pb-4 px-2">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="col-lg-12 pb-4">
        <div class="form-card px-3">
            <form action="{{ route('admin.permission', $role->id) }}" method="post">
                @csrf
                <div style="display: flex; flex-wrap: wrap;">
                    @foreach ($permissions as $permission)
                        <div
                            style="padding:5px 15px;border:1px dashed; border-radius:5px; margin:5px;display:flex;align-items:center;">
                            <input type="checkbox" style="height: 25px;" name="permissions[]" value="{{ $permission->name }}"
                                {{ $rolePermissions->contains($permission->id) ? 'checked' : '' }}>
                            <label for=""
                                style="margin-bottom: 0; margin-left:4px;">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-success mt-2">Update</button>
            </form>
        </div>
    </div>
</x-applayout>
