<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentIncidence extends Model
{
    use HasFactory;

    protected $table = "student_incidence";
    protected $fillable = ['id', 'id_person', 'id_career', 'old_turn', 'old_period_year', 'old_period_init', 'old_is_online', 'new_turn', 'new_period_year', 'new_period_init', 'new_is_online', 'observacion', 'status', 'user'];
}
