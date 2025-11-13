{{-- resources/views/admin/aceptadas.blade.php --}}
@extends('layouts.admin-invitados')

@section('title', 'Invitados Aceptados')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <h2 class="mb-3 mb-md-0 text-success fw-bold">Invitados Aceptados</h2>

    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
        <select id="vistaSolicitudes" class="form-select" style="width: 200px;">
            <option value="{{ route('ListSolInv') }}">Pendientes</option>
            <option value="{{ route('listaceptadosinvi') }}" selected>Aceptadas</option>
            <option value="{{ route('todassolid') }}">Todas</option>
        </select>

        
        <a href="{{ route('export.solicitudes') }}" class="btn btn-primary">
            <i class="bi bi-file-earmark-excel"></i> Exportar a Excel
        </a>

    </div>
</div>

<div class="table-responsive shadow-sm">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success">
            <tr>
                <th>ID Aceptado</th>
                <th>ID Solicitud</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>ID Invitado</th>
                <th>Edificio</th>
                <th>Visitantes</th>
                <th>Fecha solicitada</th>
                <th>Horario entrada</th>
                <th>Vehículo</th>
                <th>Placas</th>
                <th>Aceptado por</th>
            </tr>
        </thead>
        <tbody>
            @forelse($SolicitudesAceptadas as $solicitud)
                <tr>
                    <td>{{ $solicitud->Id_Aceptado }}</td>
                    <td>{{ $solicitud->FK_Id_Solicitud }}</td>
                    <td>{{ $solicitud->NombrePersonaInvitado }}</td>
                    <td>{{ $solicitud->ApellidoPersonaInvitado }}</td>
                    <td>{{ $solicitud->FK_Id_Invitados }}</td>
                    <td>{{ $solicitud->Edificio }}</td>
                    <td>{{ $solicitud->CantVis }}</td>
                    <td>{{ $solicitud->FechaSolicitada }}</td>
                    <td>{{ $solicitud->Horario_Entrada }}</td>
                    <td>{{ $solicitud->MarcaInvitado }} {{ $solicitud->ModeloInvitado }} ({{ $solicitud->ColorInvitado }})</td>
                    <td>{{ $solicitud->PlacasInvitado }}</td>
                    <td>{{ $solicitud->NombreUsuarioAceptado }}</td>
                </tr>
            @empty
                <tr><td colspan="12" class="text-center">No hay solicitudes aceptadas</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('vistaSolicitudes').addEventListener('change', e => window.location.href = e.target.value);
</script>
@endpush
