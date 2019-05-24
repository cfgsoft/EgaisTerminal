<?php

namespace App\Models\RefEgais;

use Illuminate\Database\Eloquent\Model;

class ClientEgais extends Model
{
    protected $table = 'ref_client_egais';

    protected $fillable = ['descr', 'code', 'inn', 'kpp', 'state', 'version'];
}
