<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['cliente_nome', 'status', 'data', 'total'];


    public function itens()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
