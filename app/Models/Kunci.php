<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunci extends Model
{
    protected $table      = 'kuncis';
    protected $primaryKey = 'id_kunci';
    protected $fillable   = ['n', 'e', 'd'];

    public function tandaTangan()
    {
        return $this->hasMany(TandaTangan::class, 'id_kunci', 'id_kunci');
    }
}