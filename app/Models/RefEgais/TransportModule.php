<?php

namespace App\Models\RefEgais;

use Illuminate\Database\Eloquent\Model;

class TransportModule extends Model
{
    protected $table = 'ref_transport_module_egais';

    protected $fillable = ['descr', 'code', 'version', 'is_mark', 'fsrar_id', 'ip_address', 'port'];

}
