<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AveriasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'cliente' => 'Juan Pérez',
                'problema' => 'Sin conexión a Internet',
                'fechahora' => date('Y-m-d H:i:s'),
                'status' => 'PENDIENTE',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'cliente' => 'María López',
                'problema' => 'Velocidad intermitente',
                'fechahora' => date('Y-m-d H:i:s'),
                'status' => 'EN_PROCESO',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'cliente' => 'Carlos Díaz',
                'problema' => 'Router dañado',
                'fechahora' => date('Y-m-d H:i:s'),
                'status' => 'PENDIENTE',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('averias')->insertBatch($data);
    }
}
