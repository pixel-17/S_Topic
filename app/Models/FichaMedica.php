<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class FichaMedica extends Model {
    use HasFactory;
 
    protected $table = 'fichas_medicas';
 
    protected $fillable = [
        'estudiante_id', 'tipo_sangre', 'alergias',
        'enfermedades_previas', 'medicamentos_actuales',
        'telefono_emergencia', 'contacto_emergencia',
    ];
 
    public function estudiante() {
        return $this->belongsTo(Estudiante::class);
    }
}
