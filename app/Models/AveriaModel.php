<?php

namespace App\Models;

use CodeIgniter\Model;

class AveriaModel extends Model
{
    protected $table = 'averias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cliente', 'problema', 'fechahora', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true; 
    protected $dateFormat = 'datetime'; 
}