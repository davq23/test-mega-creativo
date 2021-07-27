<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = "students";

    protected $primaryKey = "id";

    protected $fillable = ['name', 'last_names', 'email', 'status', 'major_id'];
}
