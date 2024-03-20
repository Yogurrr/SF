<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // 데이터베이스 테이블 이름
    protected $table = 'schedules';

    // 칼럼
    protected $fillable = [
        'sno',
        'userid',
        'sdate',
        'schedule',
    ];
}