@extends('layouts.admin-invitados')

@section('title', 'Solicitudes Denegadas')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <h2 class="mb-3 mb-md-0 text-success fw-bold">Solicitudes de Invitados</h2>

    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
        {{-- Filtros --}}
        <select id="vistaSolicitudes" class="form-select" style="width: 200px;">
            <option value="{{ route('ListSolInv') }}" {{ request()->routeIs('ListSolInv') ? 'selected' : '' }}>Pendientes</option>
            <option value="{{ route('listaceptadosinvi') }}" {{ request()->routeIs('listaceptadosinvi') ? 'selected' : '' }}>Aceptadas</option>
            <option value="{{ route('listdenegadas') }}" {{ request()->routeIs('listdenegadas') ? 'selected' : '' }}>Denegadas</option>
            <option value="{{ route('todassolid') }}" {{ request()->routeIs('todassolid') ? 'selected' : '' }}>Todas</option>
        </select>

        {{-- Buscador --}}
        <div class="input-group" style="max-width: 350px;">
            <span class="input-group-text bg-success text-white"><i class="bi bi-search"></i></span>
            <input type="text" id="buscadorSolicitudes" class="form-control" placeholder="Buscar invitado...">
        </div>

        {{-- Exportar --}}
        <a href="{{ route('export.solicitudes') }}" class="btn btn-primary">
            <i class="bi bi-file-earmark-excel"></i> Exportar a Excel
        </a>
    </div>
</div>

{{-- Tabla --}}
<div class="table-responsive shadow-sm">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success">
            <tr>
                <th>ID Solicitud</th>
                <th>Nombre</th>
                <th>Tipo Invitado</th>
                <th>Edificio</th>
                <th>Visitas</th>
                <th>Motivo</th>
                <th>Fecha Solicitada</th>
                <th>Motivo de Rechazo</th>
                <th>Num Control Denegador</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($solicitudesRechazadas as $solicitud)
                <tr>
                    <td>{{ $solicitud->Id_Solicitud }}</td>
                    <td>{{ $solicitud->Nombres }} {{ $solicitud->ApellidoP }} {{ $solicitud->ApellidoM }}</td>
                    <td>{{ $solicitud->Tipo_Invitado }}</td>
                    <td>{{ $solicitud->Edificio }}</td>
                    <td>{{ $solicitud->CantVis }}</td>
                    <td>{{ $solicitud->MotivoVisit }}</td>
                    <td>{{ $solicitud->FechaSolicitada }}</td>
                    <td class="text-danger fw-semibold">{{ $solicitud->MotivoRechazo ?? '—' }}</td>
                    <td>{{ $solicitud->Num_Iden_Denegador }}</td>
                    <td class="text-center text-nowrap">
                        {{-- Botón Aceptar (si aplica) --}}
                        <button class="btn btn-success btn-sm open-modal"
                            data-id="{{ $solicitud->Id_Solicitud }}"
                            data-fecha="{{ $solicitud->FechaSolicitada }}">
                            <i class="bi bi-check-circle"></i> Aceptar
                        </button>

                        {{-- Botón Denegar con modal --}}
                        <button class="btn btn-danger btn-sm open-deny-modal"
                            data-id="{{ $solicitud->Id_Solicitud }}">
                            <i class="bi bi-x-circle"></i> Denegar
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="10" class="text-center">No hay solicitudes registradas</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL ACEPTAR --}}
<dialog id="acceptModal" class="border-0 rounded-3 shadow" style="max-width: 500px; width: 90%;">
    <form action="{{ route('AprovarSol') }}" method="POST" class="m-0">
        @csrf
        <div class="modal-header bg-success text-white rounded-top">
            <h5 class="modal-title mb-0">Aceptar Invitación</h5>
            <button type="button" class="btn-close btn-close-white" id="closeModal"></button>
        </div>

        <div class="modal-body">
            <input type="hidden" name="FK_Id_Solicitud" id="modal-solicitud-id">
            <div class="mb-3">
                <label for="modal-fecha-solicitada" class="form-label">Fecha y Hora Solicitada</label>
                <input type="datetime-local" class="form-control" name="Fecha_Hora_Solicitada" id="modal-fecha-solicitada" required>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelModal">Cancelar</button>
            <button type="submit" class="btn btn-success">Aceptar</button>
        </div>
    </form>
</dialog>

{{-- MODAL DENEGAR --}}
<dialog id="denyModal" class="border-0 rounded-3 shadow" style="max-width: 500px; width: 90%;">
    <form method="POST" id="denyForm">
        @csrf
        <div class="modal-header bg-danger text-white rounded-top">
            <h5 class="modal-title mb-0">Denegar Solicitud</h5>
            <button type="button" class="btn-close btn-close-white" id="closeDenyModal"></button>
        </div>

        <div class="modal-body">
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo del Rechazo</label>
                <textarea class="form-control" name="Motivo_Rechazo" id="motivo" rows="3" required></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelDenyModal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Denegar</button>
        </div>
    </form>
</dialog>
@endsection

@push('scripts')
<script>
document.getElementById('vistaSolicitudes').addEventListener('change', e => window.location.href = e.target.value);

// Buscador
document.getElementById('buscadorSolicitudes').addEventListener('keyup', function() {
    const valor = this.value.toLowerCase();
    document.querySelectorAll('table tbody tr').forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(valor) ? '' : 'none';
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Modal aceptar
    const dialog = document.getElementById('acceptModal');
    document.querySelectorAll('.open-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('modal-solicitud-id').value = btn.dataset.id;
            document.getElementById('modal-fecha-solicitada').value = new Date(btn.dataset.fecha).toISOString().slice(0,16);
            dialog.showModal();
        });
    });
    document.getElementById('closeModal').onclick = () => dialog.close();
    document.getElementById('cancelModal').onclick = () => dialog.close();
    dialog.addEventListener('click', e => {
        const rect = dialog.getBoundingClientRect();
        if (!(rect.top <= e.clientY && e.clientY <= rect.bottom && rect.left <= e.clientX && e.clientX <= rect.right))
            dialog.close();
    });

    // Modal denegar
    const denyDialog = document.getElementById('denyModal');
    const denyForm = document.getElementById('denyForm');
    document.querySelectorAll('.open-deny-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const solicitudId = btn.dataset.id;
            denyForm.action = `/solicitud/denegar/${solicitudId}`;
            denyDialog.showModal();
        });
    });
    document.getElementById('closeDenyModal').onclick = () => denyDialog.close();
    document.getElementById('cancelDenyModal').onclick = () => denyDialog.close();
    denyDialog.addEventListener('click', e => {
        const rect = denyDialog.getBoundingClientRect();
        if (!(rect.top <= e.clientY && e.clientY <= rect.bottom && rect.left <= e.clientX && e.clientX <= rect.right))
            denyDialog.close();
    });
});
</script>
@endpush
