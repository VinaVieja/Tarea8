<?php

namespace App\Models;

use CodeIgniter\Model;

class MensajeModel extends Model
{
    protected $table = 'mensajes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['averia_id','usuario','mensaje','created_at'];
    public $useTimestamps = false;
}
