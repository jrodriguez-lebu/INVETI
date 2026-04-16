<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $acta->numero_acta }} - Acta de Entrega</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.4;
            background: #fff;
        }

        /* Page layout */
        .page {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .header {
            border: 2px solid #1e40af;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 16px;
        }
        .header-top {
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            padding: 12px 16px;
        }
        .header-top .republic {
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #93c5fd;
            margin-bottom: 4px;
        }
        .header-top .municipality {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .header-top .unit {
            font-size: 10px;
            color: #bfdbfe;
            margin-top: 3px;
        }
        .header-bottom {
            background-color: #1e40af;
            color: white;
            text-align: center;
            padding: 8px 16px;
        }
        .header-bottom .doc-title {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .header-bottom .acta-number {
            font-size: 20px;
            font-weight: bold;
            margin-top: 2px;
            color: #fbbf24;
        }

        /* Meta info row */
        .meta-row {
            display: table;
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin-bottom: 14px;
        }
        .meta-cell {
            display: table-cell;
            width: 50%;
            padding: 8px 12px;
            vertical-align: middle;
        }
        .meta-cell:first-child {
            border-right: 1px solid #d1d5db;
        }
        .meta-label {
            font-size: 9px;
            text-transform: uppercase;
            color: #6b7280;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .meta-value {
            font-size: 12px;
            font-weight: bold;
            color: #111827;
        }

        /* Sections */
        .section {
            margin-bottom: 14px;
        }
        .section-title {
            background-color: #1e40af;
            color: white;
            padding: 5px 10px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 2px 2px 0 0;
        }
        .section-body {
            border: 1px solid #d1d5db;
            border-top: none;
            border-radius: 0 0 4px 4px;
        }

        /* Data table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .data-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .data-table tr:last-child td {
            border-bottom: none;
        }
        .data-table .label {
            font-weight: bold;
            color: #374151;
            width: 35%;
        }
        .data-table .value {
            color: #111827;
        }
        .data-table .value.mono {
            font-family: 'Courier New', monospace;
            font-size: 10px;
        }
        .data-table .value.highlight {
            font-weight: bold;
            color: #1e40af;
        }

        /* Status badge */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-active { background: #d1fae5; color: #065f46; }
        .badge-repair { background: #fef3c7; color: #92400e; }
        .badge-inactive { background: #f3f4f6; color: #374151; }
        .badge-baja { background: #fee2e2; color: #991b1b; }

        /* Observations */
        .observations {
            border: 1px solid #fcd34d;
            background-color: #fffbeb;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 14px;
        }
        .observations-title {
            font-size: 9px;
            font-weight: bold;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .observations-text {
            font-size: 11px;
            color: #78350f;
        }

        /* Legal text */
        .legal-text {
            font-size: 9.5px;
            color: #4b5563;
            line-height: 1.5;
            margin-bottom: 14px;
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background-color: #f9fafb;
            text-align: justify;
        }

        /* Signatures */
        .signatures {
            display: table;
            width: 100%;
            margin-top: 20px;
        }
        .sig-cell {
            display: table-cell;
            width: 45%;
            text-align: center;
            padding: 0 10px;
        }
        .sig-spacer {
            display: table-cell;
            width: 10%;
        }
        .sig-line {
            border-top: 1.5px solid #374151;
            margin-bottom: 6px;
            margin-top: 40px;
        }
        .sig-role {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e40af;
        }
        .sig-name {
            font-size: 10px;
            color: #374151;
            margin-top: 2px;
        }
        .sig-rut {
            font-size: 9px;
            color: #6b7280;
            font-family: 'Courier New', monospace;
        }
        .sig-unit {
            font-size: 9px;
            color: #6b7280;
        }

        /* Footer */
        .footer {
            margin-top: 20px;
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
            text-align: center;
        }
        .footer p {
            font-size: 8.5px;
            color: #9ca3af;
        }

        /* Divider line */
        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 12px 0;
        }
    </style>
</head>
<body>
<div class="page">

    <!-- Header -->
    <div class="header">
        <div class="header-top">
            <div class="republic">República de Chile</div>
            <div class="municipality">ILUSTRE MUNICIPALIDAD DE LEBU</div>
            <div class="unit">Unidad de Informática y Tecnología</div>
        </div>
        <div class="header-bottom">
            <div class="doc-title">Acta de Entrega de Equipo Informático</div>
            <div class="acta-number">{{ $acta->numero_acta }}</div>
        </div>
    </div>

    <!-- Meta Row -->
    <div class="meta-row">
        <div class="meta-cell">
            <div class="meta-label">Fecha de Entrega</div>
            <div class="meta-value">
                {{ $acta->fecha_entrega->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
            </div>
        </div>
        <div class="meta-cell">
            <div class="meta-label">Estado del Documento</div>
            <div class="meta-value">
                @if($acta->firmada)
                    <span class="badge badge-active">&#10003; Firmada</span>
                @else
                    <span class="badge badge-repair">Pendiente de Firma</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Equipment Section -->
    <div class="section">
        <div class="section-title">I. Datos del Equipo Informático</div>
        <div class="section-body">
            <table class="data-table">
                <tr>
                    <td class="label">Tipo de Equipo</td>
                    <td class="value">{{ $acta->equipo->tipoEquipo->nombre ?? '-' }}</td>
                    <td class="label">N° de Inventario</td>
                    <td class="value highlight mono">{{ $acta->equipo->numero_inventario }}</td>
                </tr>
                <tr>
                    <td class="label">Marca</td>
                    <td class="value">{{ $acta->equipo->marca }}</td>
                    <td class="label">Modelo</td>
                    <td class="value">{{ $acta->equipo->modelo }}</td>
                </tr>
                <tr>
                    <td class="label">N° de Serie</td>
                    <td class="value mono">{{ $acta->equipo->numero_serie ?? 'No registrado' }}</td>
                    <td class="label">Estado</td>
                    <td class="value">
                        @php
                            $badgeClass = match($acta->equipo->estado) {
                                'activo' => 'badge-active',
                                'inactivo' => 'badge-inactive',
                                'baja' => 'badge-baja',
                                'reparacion' => 'badge-repair',
                                default => 'badge-inactive',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $acta->equipo->estado_label }}</span>
                    </td>
                </tr>
                @if($acta->equipo->descripcion)
                <tr>
                    <td class="label">Descripción</td>
                    <td class="value" colspan="3">{{ $acta->equipo->descripcion }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    <!-- Recipient Section -->
    <div class="section">
        <div class="section-title">II. Datos del Funcionario que Recibe</div>
        <div class="section-body">
            <table class="data-table">
                <tr>
                    <td class="label">Nombre Completo</td>
                    <td class="value" style="font-weight:bold">{{ $acta->funcionario->nombre_completo }}</td>
                    <td class="label">RUT</td>
                    <td class="value mono">{{ $acta->funcionario->rut }}</td>
                </tr>
                <tr>
                    <td class="label">Cargo</td>
                    <td class="value">{{ $acta->funcionario->cargo }}</td>
                    <td class="label">Departamento</td>
                    <td class="value">{{ $acta->funcionario->departamento->nombre ?? '-' }}</td>
                </tr>
                @if($acta->funcionario->email)
                <tr>
                    <td class="label">Email</td>
                    <td class="value" colspan="3">{{ $acta->funcionario->email }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    @if($acta->observaciones)
    <!-- Observations -->
    <div class="observations">
        <div class="observations-title">Observaciones</div>
        <div class="observations-text">{{ $acta->observaciones }}</div>
    </div>
    @endif

    <!-- Legal Text -->
    <div class="legal-text">
        El funcionario individualizado en este documento declara haber recibido el equipo informático descrito anteriormente,
        en conformidad con las políticas de uso de recursos tecnológicos de la Ilustre Municipalidad de Lebu, comprometiéndose
        a su uso exclusivo en actividades propias del cargo y a dar aviso inmediato ante cualquier deterioro, pérdida o mal
        funcionamiento del mismo. El equipo permanece como patrimonio municipal y deberá ser devuelto en las mismas condiciones
        al momento de finalizar su contrato o al ser requerido por la Unidad de Informática.
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div class="sig-cell">
            <div class="sig-line"></div>
            <div class="sig-role">Entrega</div>
            <div class="sig-unit">Unidad de Informática</div>
            <div class="sig-unit">Municipalidad de Lebu</div>
        </div>
        <div class="sig-spacer"></div>
        <div class="sig-cell">
            <div class="sig-line"></div>
            <div class="sig-role">Recibe</div>
            <div class="sig-name">{{ $acta->funcionario->nombre_completo }}</div>
            <div class="sig-rut">RUT: {{ $acta->funcionario->rut }}</div>
            <div class="sig-unit">{{ $acta->funcionario->cargo }}</div>
            <div class="sig-unit">{{ $acta->funcionario->departamento->nombre ?? '' }}</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Documento generado por INVETI &mdash; Sistema de Inventario Informático | Municipalidad de Lebu | {{ now()->format('d/m/Y H:i') }}</p>
        <p style="margin-top:3px">Este documento tiene validez oficial cuando esté debidamente firmado por ambas partes.</p>
    </div>

</div>
</body>
</html>
