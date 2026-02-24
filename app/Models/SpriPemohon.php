<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpriPemohon extends Model
{
    // Koneksi ke Database SPRI (Sesuai config database.php)
    protected $connection = 'mysql_spri'; 
    
    // Nama Tabel di Database SPRI (Sesuai file spri_link yang dilampirkan)
    protected $table = 'nxt_spri_links';

    // Karena kita cuma mau baca (View), matikan timestamp jika tabel aslinya tidak punya created_at/updated_at
    public $timestamps = false;

    // Primary Key (Biasanya nomor_permohonan jika unik)
    protected $primaryKey = 'nomor_permohonan';
    
    // Pastikan primary key bukan integer auto-increment (karena formatnya string/varchar)
    public $incrementing = false;
    protected $keyType = 'string';
}