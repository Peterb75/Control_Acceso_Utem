@extends('layouts.admin-invitados')

@section('title', 'Usuarios Activos')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <h2 class="mb-3 mb-md-0 text-success fw-bold">
        <i class="bi bi-person-check"></i> Usuarios Activos
    </h2>

    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
        <select id="vistaUsuarios" class="form-select" style="width: 200px;">
            <option value="{{ route('activos') }}" {{ request()->routeIs('activos') ? 'selected' : '' }}>Activos</option>
            <option value="{{ route('inactivos') }}" {{ request()->routeIs('inactivos') ? 'selected' : '' }}>Inactivos</option>
            <option value="{{ route('todos') }}" {{ request()->routeIs('todos') ? 'selected' : '' }}>Todos</option>
        </select>

        <div class="input-group" style="max-width: 350px;">
            <span class="input-group-text bg-success text-white"><i class="bi bi-search"></i></span>
            <input type="text" id="buscadorUsuarios" class="form-control" placeholder="Buscar número de control...">
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUsuario">
            <i class="bi bi-person-plus"></i> Agregar Usuario
        </button>
    </div>
</div>

<div class="table-responsive shadow-sm">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success">
            <tr>
                <th>Número de Control</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Tipo Usuario</th>
                <th>Puesto</th>
                <th>Área</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $u)
                <tr>
                    <td>{{ $u->Num_Iden }}</td>
                    <td>{{ $u->Nombres }} {{ $u->ApellidoP }} {{ $u->ApellidoM }}</td>
                    <td>{{ $u->Correo }}</td>
                    <td>{{ $u->TipoUsuarios }}</td>
                    <td>{{ $u->NombrePuesto }}</td>
                    <td>{{ $u->NombreArea }}</td>
                    <td class="text-center text-nowrap">
                        <a href="{{ route('editar', $u->Id_Users) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <form action="{{ route('baja', $u->Id_Users) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-danger btn-sm" type="submit">
                                <i class="bi bi-person-dash"></i> Dar de Baja
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No hay usuarios activos</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('admin.partials.modal-usuario')
@endsection

@push('scripts')
<script>
document.getElementById('vistaUsuarios').addEventListener('change', e => window.location.href = e.target.value);

document.getElementById('buscadorUsuarios').addEventListener('keyup', function() {
    const valor = this.value.toLowerCase();
    document.querySelectorAll('table tbody tr').forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(valor) ? '' : 'none';
    });
});
</script>
@endpush
