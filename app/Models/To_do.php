<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class To_do extends Model
{
    use HasFactory;

    // 데이터베이스 테이블 이름
    protected $table = 'to_dos';

    // 칼럼
    protected $fillable = [
        'tno',
        'userid',
        'tdate',
        'to_do',
        'is_checked'
    ];
}