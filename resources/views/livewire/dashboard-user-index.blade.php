<div class="card">
  <h5 class="card-header">Lista de Usuarios</h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody class="table-border-bottom-0">
      @foreach($users as $item)
        <tr wire:key="{{ $item->id  }}">
          <td>{{ $item->id }}</td>
          <td><strong>{{ $item->name }}</strong></td>
          <td>{{ $item->email }}</td>
          <td>
            @if($item->status)
              <span class="badge bg-label-primary me-1">Active</span>
            @else
              <span class="badge bg-label-danger me-1">inactivo</span>
            @endif
          </td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $users->links() }}
  </div>
</div>
