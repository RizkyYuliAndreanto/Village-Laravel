<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    // gunakan nama tabel sesuai migration
    protected $table = 'beritas';

    // migration hanya membuat id + timestamps — tetap gunakan guarded kosong
    protected $guarded = [];

    public $timestamps = true;

    protected $dates = [
        'deleted_at',
    ];
}
