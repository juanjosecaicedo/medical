<div>
  <div class="card">
    <div class="card-header">
      <h5>Lista de Usuarios</h5>
      <div class="">
        <input class="form-control" wire:model="search" placeholder="Buscar por nombre o correo"/>
        <button class="btn btn-primary" wire:click="register">Agregar usuario</button>
      </div>
    </div>

    @if($users->count())
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
                    <a class="dropdown-item" href="javascript:void(0);" wire:click="edit({{$item->id}})"><i
                        class="bx bx-edit-alt me-1"></i> Edit</a>
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
    @else
      <p class="text-center">{{ __('No hay resultados') }}</p>
    @endif
  </div>
  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="static"
       data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">
            @if($actionName == 'save')
              {{ __('Registrar') }}
            @else
              {{ __('Actualizar') }}
            @endif
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @if(session()->has('message'))
            <span class="text-primary">{{ session('message') }}</span>
          @endif
          <form wire:submit.prevent="setAction">
            <div class="mb-3">
              <label for="name" class="form-label">{{ __('Name') }}</label>
              <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                placeholder="Enter your username"
                wire:model="name"

              />
              @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">{{ __('Email') }}</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                     placeholder="Enter your email " autocomplete="username" wire:model="email"/>
              @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
              <label for="status">{{ __('Estado de usuario') }}</label>
              <select class="form-select @error('status') is-invalid @enderror" aria-label="select" name="status"
                      id="status" wire:model="status">
                <option @if($status == null) selected @endif >{{ __('---') }}</option>
                <option value="0" @if($status == 0) selected @endif>{{ __('Inactivo') }}</option>
                <option value="1" @if($status == 2) selected @endif >{{ __('Activo') }}</option>
              </select>
              @error('status') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  id="password"
                  class="form-control @error('password') is-invalid @enderror"
                  name="password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  aria-describedby="password"
                  wire:model="password"
                />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label" for="password_confirmation">Password</label>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  id="password_confirmation"
                  class="form-control"
                  name="password_confirmation"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  aria-describedby="password"
                  wire:model="password_confirmation"
                />
                @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @section('page-script')
    <script>
        Livewire.on('display-user-modal', event => {
            const userModal = new bootstrap.Modal('#userModal');
            userModal.show();
        })
    </script>
  @endsection
</div>

