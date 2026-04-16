<?php

namespace Database\Seeders;

use App\Models\ActaEntrega;
use App\Models\Departamento;
use App\Models\Equipo;
use App\Models\Funcionario;
use App\Models\TipoEquipo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tipos de equipo
        $tipos = [
            ['nombre' => 'AIO',           'icono' => 'desktop-computer',  'descripcion' => 'Computador todo en uno'],
            ['nombre' => 'Notebook',       'icono' => 'laptop',            'descripcion' => 'Computador portátil'],
            ['nombre' => 'Impresora',      'icono' => 'printer',           'descripcion' => 'Impresora de escritorio'],
            ['nombre' => 'Multifuncional', 'icono' => 'printer',           'descripcion' => 'Equipo multifuncional (imprime, escanea, copia)'],
            ['nombre' => 'Smartphone',     'icono' => 'device-mobile',     'descripcion' => 'Teléfono inteligente'],
            ['nombre' => 'Monitor',        'icono' => 'desktop-computer',  'descripcion' => 'Monitor de pantalla'],
            ['nombre' => 'UPS',            'icono' => 'battery-charging',  'descripcion' => 'Sistema de alimentación ininterrumpida'],
            ['nombre' => 'Switch',         'icono' => 'server',            'descripcion' => 'Conmutador de red'],
            ['nombre' => 'Router',         'icono' => 'wifi',              'descripcion' => 'Enrutador de red'],
            ['nombre' => 'Proyector',      'icono' => 'film',              'descripcion' => 'Proyector de imágenes'],
            ['nombre' => 'Servidor',       'icono' => 'server',            'descripcion' => 'Servidor de datos'],
            ['nombre' => 'Tablet',         'icono' => 'device-tablet',     'descripcion' => 'Tableta digital'],
            ['nombre' => 'Otro',           'icono' => 'cube',              'descripcion' => 'Otro tipo de equipo'],
        ];

        foreach ($tipos as $tipo) {
            TipoEquipo::create($tipo);
        }

        // Departamentos
        $departamentos = [
            ['nombre' => 'Alcaldía',                'descripcion' => 'Despacho del Alcalde'],
            ['nombre' => 'Administración Municipal', 'descripcion' => 'Unidad de Administración Municipal'],
            ['nombre' => 'Secretaría Municipal',     'descripcion' => 'Secretaría Municipal y Concejo'],
            ['nombre' => 'SECPLAN',                  'descripcion' => 'Secretaría Comunal de Planificación'],
            ['nombre' => 'DIDECO',                   'descripcion' => 'Dirección de Desarrollo Comunitario'],
            ['nombre' => 'DAEM',                     'descripcion' => 'Departamento de Administración de Educación Municipal'],
            ['nombre' => 'Finanzas',                 'descripcion' => 'Unidad de Finanzas Municipales'],
            ['nombre' => 'RRHH',                     'descripcion' => 'Recursos Humanos'],
            ['nombre' => 'Obras Municipales',        'descripcion' => 'Dirección de Obras Municipales'],
            ['nombre' => 'Informática',              'descripcion' => 'Unidad de Informática y Tecnología'],
            ['nombre' => 'Tesorería',                'descripcion' => 'Tesorería Municipal'],
            ['nombre' => 'Jurídico',                 'descripcion' => 'Asesoría Jurídica'],
        ];

        foreach ($departamentos as $dep) {
            Departamento::create($dep);
        }

        // Funcionarios de ejemplo
        $funcionarios = [
            [
                'nombre'          => 'Juan Carlos',
                'apellido'        => 'Muñoz Pérez',
                'rut'             => '12.345.678-9',
                'cargo'           => 'Analista de Sistemas',
                'departamento_id' => 10, // Informática
                'email'           => 'jmunoz@muniLebu.cl',
                'telefono'        => '+56 9 1234 5678',
                'activo'          => true,
            ],
            [
                'nombre'          => 'María Isabel',
                'apellido'        => 'González Torres',
                'rut'             => '13.456.789-0',
                'cargo'           => 'Secretaria',
                'departamento_id' => 2, // Administración Municipal
                'email'           => 'mgonzalez@muniLebu.cl',
                'telefono'        => '+56 9 2345 6789',
                'activo'          => true,
            ],
            [
                'nombre'          => 'Pedro Antonio',
                'apellido'        => 'Rojas Soto',
                'rut'             => '14.567.890-1',
                'cargo'           => 'Contador',
                'departamento_id' => 7, // Finanzas
                'email'           => 'projas@muniLebu.cl',
                'telefono'        => null,
                'activo'          => true,
            ],
            [
                'nombre'          => 'Carmen Lucía',
                'apellido'        => 'Vásquez Morales',
                'rut'             => '15.678.901-2',
                'cargo'           => 'Asistente Social',
                'departamento_id' => 5, // DIDECO
                'email'           => 'cvasquez@muniLebu.cl',
                'telefono'        => '+56 9 3456 7890',
                'activo'          => true,
            ],
            [
                'nombre'          => 'Roberto',
                'apellido'        => 'Fuentes Díaz',
                'rut'             => '16.789.012-3',
                'cargo'           => 'Técnico en Computación',
                'departamento_id' => 10, // Informática
                'email'           => 'rfuentes@muniLebu.cl',
                'telefono'        => '+56 9 4567 8901',
                'activo'          => true,
            ],
        ];

        foreach ($funcionarios as $func) {
            Funcionario::create($func);
        }

        // Equipos de ejemplo
        $equiposData = [
            [
                'tipo_equipo_id'    => 1,  // AIO
                'marca'             => 'HP',
                'modelo'            => 'EliteOne 800 G6',
                'numero_serie'      => 'SN-HP-001234',
                'numero_inventario' => 'INV-2024-001',
                'estado'            => 'activo',
                'funcionario_id'    => 1,
                'departamento_id'   => 10,
                'fecha_adquisicion' => '2024-01-15',
                'valor_adquisicion' => 850000,
                'descripcion'       => 'AIO HP para oficina de informática',
            ],
            [
                'tipo_equipo_id'    => 2,  // Notebook
                'marca'             => 'Lenovo',
                'modelo'            => 'ThinkPad X1 Carbon',
                'numero_serie'      => 'SN-LEN-005678',
                'numero_inventario' => 'INV-2024-002',
                'estado'            => 'activo',
                'funcionario_id'    => 2,
                'departamento_id'   => 2,
                'fecha_adquisicion' => '2024-02-20',
                'valor_adquisicion' => 1200000,
                'descripcion'       => 'Notebook para secretaría',
            ],
            [
                'tipo_equipo_id'    => 3,  // Impresora
                'marca'             => 'Brother',
                'modelo'            => 'HL-L2350DW',
                'numero_serie'      => 'SN-BRO-009012',
                'numero_inventario' => 'INV-2024-003',
                'estado'            => 'activo',
                'funcionario_id'    => null,
                'departamento_id'   => 7,
                'fecha_adquisicion' => '2024-03-10',
                'valor_adquisicion' => 180000,
            ],
            [
                'tipo_equipo_id'    => 4,  // Multifuncional
                'marca'             => 'Epson',
                'modelo'            => 'EcoTank L15150',
                'numero_serie'      => 'SN-EPS-003456',
                'numero_inventario' => 'INV-2024-004',
                'estado'            => 'reparacion',
                'funcionario_id'    => null,
                'departamento_id'   => 5,
                'fecha_adquisicion' => '2023-06-01',
                'valor_adquisicion' => 450000,
                'observaciones'     => 'En reparación por falla en sistema de tinta',
            ],
            [
                'tipo_equipo_id'    => 6,  // Monitor
                'marca'             => 'Dell',
                'modelo'            => 'P2422H',
                'numero_serie'      => 'SN-DEL-007890',
                'numero_inventario' => 'INV-2024-005',
                'estado'            => 'activo',
                'funcionario_id'    => 3,
                'departamento_id'   => 7,
                'fecha_adquisicion' => '2024-01-15',
                'valor_adquisicion' => 250000,
            ],
            [
                'tipo_equipo_id'    => 2,  // Notebook
                'marca'             => 'HP',
                'modelo'            => 'ProBook 450 G9',
                'numero_serie'      => 'SN-HP-002345',
                'numero_inventario' => 'INV-2024-006',
                'estado'            => 'activo',
                'funcionario_id'    => 4,
                'departamento_id'   => 5,
                'fecha_adquisicion' => '2024-04-05',
                'valor_adquisicion' => 750000,
            ],
            [
                'tipo_equipo_id'    => 7,  // UPS
                'marca'             => 'APC',
                'modelo'            => 'Back-UPS 1100VA',
                'numero_serie'      => 'SN-APC-001122',
                'numero_inventario' => 'INV-2024-007',
                'estado'            => 'activo',
                'funcionario_id'    => null,
                'departamento_id'   => 10,
                'fecha_adquisicion' => '2024-01-15',
                'valor_adquisicion' => 120000,
            ],
            [
                'tipo_equipo_id'    => 1,  // AIO
                'marca'             => 'Dell',
                'modelo'            => 'OptiPlex 7400 AIO',
                'numero_serie'      => 'SN-DEL-008901',
                'numero_inventario' => 'INV-2024-008',
                'estado'            => 'activo',
                'funcionario_id'    => 5,
                'departamento_id'   => 10,
                'fecha_adquisicion' => '2024-05-20',
                'valor_adquisicion' => 920000,
            ],
            [
                'tipo_equipo_id'    => 5,  // Smartphone
                'marca'             => 'Samsung',
                'modelo'            => 'Galaxy A54',
                'numero_serie'      => 'SN-SAM-004567',
                'numero_inventario' => 'INV-2024-009',
                'estado'            => 'activo',
                'funcionario_id'    => 1,
                'departamento_id'   => 10,
                'fecha_adquisicion' => '2024-03-01',
                'valor_adquisicion' => 350000,
            ],
            [
                'tipo_equipo_id'    => 2,  // Notebook
                'marca'             => 'Asus',
                'modelo'            => 'ExpertBook B1 B1500',
                'numero_serie'      => 'SN-ASU-006789',
                'numero_inventario' => 'INV-2023-010',
                'estado'            => 'inactivo',
                'funcionario_id'    => null,
                'departamento_id'   => null,
                'fecha_adquisicion' => '2023-01-10',
                'valor_adquisicion' => 600000,
                'observaciones'     => 'Equipo dado de baja temporal, batería defectuosa',
            ],
        ];

        foreach ($equiposData as $equipoData) {
            Equipo::create($equipoData);
        }

        // Actas de entrega de ejemplo
        ActaEntrega::create([
            'numero_acta'    => 'ACT-2024-0001',
            'equipo_id'      => 1,
            'funcionario_id' => 1,
            'fecha_entrega'  => '2024-01-16',
            'observaciones'  => 'Equipo entregado en buen estado con todos sus accesorios.',
            'firmada'        => true,
        ]);

        ActaEntrega::create([
            'numero_acta'    => 'ACT-2024-0002',
            'equipo_id'      => 2,
            'funcionario_id' => 2,
            'fecha_entrega'  => '2024-02-21',
            'observaciones'  => 'Entrega de notebook con cargador y estuche.',
            'firmada'        => true,
        ]);

        ActaEntrega::create([
            'numero_acta'    => 'ACT-2024-0003',
            'equipo_id'      => 6,
            'funcionario_id' => 4,
            'fecha_entrega'  => '2024-04-06',
            'observaciones'  => 'Notebook entregado con cargador.',
            'firmada'        => false,
        ]);
    }
}
