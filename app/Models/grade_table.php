<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grade_table extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'grade_name',
        'location',
    ]; 
    public function students(){
        return $this->hasMany(Student::class);
    }
}
