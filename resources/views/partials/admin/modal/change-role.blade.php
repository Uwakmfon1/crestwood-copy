<div class="modal fade" id="changeRoleModal" tabindex="-1" role="dialog" aria-labelledby="changeRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeRoleModalLabel">Change Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.admins.role.change') }}" id="changeRoleForm">
                    @csrf
                    <div class="form-group">
                        <label for="oldAdminRole">Role</label>
                        <select name="role" id="oldAdminRole" class="form-control text-dark">
                            @foreach(\Spatie\Permission\Models\Role::all()->where('name', '!=', 'Super Admin') as $role)
                                <option @if(old('role') == $role['id']) selected @endif value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="adminToChangeRoleID" name="admin">
                        @error('role')
                        <strong class="text-danger">
                            {{ $message }}
                        </strong>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="confirmFormSubmit('changeRoleForm')" class="btn btn-primary">Change Role</button>
            </div>
        </div>
    </div>
</div>
