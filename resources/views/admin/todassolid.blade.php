{{-- resources/views/admin/todas.blade.php --}}
@extends('layouts.admin-invitados')

@section('title', 'Todas las Solicitudes')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <h2 class="mb-3 mb-md-0 text-success fw-bold">Todas las Solicitudes</h2>

    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
        <select id="vistaSolicitudes" class="form-select" style="width: 200px;">
            <option value="{{ route('ListSolInv') }}">Pendientes</option>
            <option value="{{ route('listaceptadosinvi') }}">Aceptadas</option>
            <option value="{{ route('todassolid') }}" selected>Todas</option>
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
                <th>ID Solicitud</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Transporte</th>
                <th>Vehículo</th>
                <th>Edificio</th>
                <th>Visitantes</th>
                <th>Nombres de Acompañantes</th>
                <th>Motivo</th>
                <th>Fecha Solicitada</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($solicitudesgeneral as $solicitud)
                <tr>
                    <td>{{ $solicitud->Id_Solicitud }}</td>
                    <td>{{ $solicitud->NombreInvitado }}</td>
                    <td>{{ $solicitud->ApellidoPInvitado }} {{ $solicitud->ApellidoMInvitado }}</td>
                    <td>{{ $solicitud->CorreoInvitado }}</td>
                    <td>{{ $solicitud->TipoTransporte }}</td>
                    <td>{{ $solicitud->TipoVehiculo }}</td>
                    <td>{{ $solicitud->Edificio }}</td>
                    <td>{{ $solicitud->CantVis}}</td>
                    <td>{{$solicitud->Acompanantes}}</td>
                    <td>{{ $solicitud->MotivoVisit }}</td>
                    <td>{{ $solicitud->Fecha_Hora_Solicitada }}</td>
                    <td>{{ $solicitud->Estado }}</td>
                </tr>
            @empty
                <tr><td colspan="11" class="text-center">No hay solicitudes registradas</td></tr>
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
