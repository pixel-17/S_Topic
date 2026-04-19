<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Motivo extends Model {
    use HasFactory;
    protected $fillable = ['categoria_id', 'nombre', 'descripcion'];
 
    public function categoria() {
        return $this->belongsTo(CategoriaMotivo::class, 'categoria_id');
    }
 
    public function atenciones() {
        return $this->hasMany(Atencion::class);
    }
}
