<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkPenugasan extends Model
{
    protected $table      = 'sk_penugasans';
    protected $primaryKey = 'id_sk';
    protected $fillable   = [
        'nomor_sk',
        'tanggal_sk',
        'perihal_sk',
        'pengesah',
        'sk_path',
    ];

    protected $casts = [
        'tanggal_sk' => 'date',
    ];

    public function tandaTangan()
    {
        return $this->hasOne(TandaTangan::class, 'id_sk', 'id_sk');
    }
}