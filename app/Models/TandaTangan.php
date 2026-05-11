<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TandaTangan extends Model
{
    protected $table      = 'tanda_tangans';
    protected $primaryKey = 'id_tt';
    protected $fillable   = [
        'id_sk',
        'id_kunci',
        'plaintext',
        'ciphertext',
        'qr_path',
        'token',
    ];

    public function sk()
    {
        return $this->belongsTo(SkPenugasan::class, 'id_sk', 'id_sk');
    }

    public function kunci()
    {
        return $this->belongsTo(Kunci::class, 'id_kunci', 'id_kunci');
    }
}