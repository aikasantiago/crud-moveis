<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    protected $fillable = ['pedido_id', 'movel_id', 'quantidade', 'preco_unitario'];
    protected $table = 'pedido_itens';

    public function movel()
    {
        return $this->belongsTo(Movel::class, 'movel_id');
    }



    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
