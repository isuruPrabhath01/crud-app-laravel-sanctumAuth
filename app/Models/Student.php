<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // protected $table = 'Student';

    protected $fillable = [
        'name',
        'address',
        'telNo'
    ]; 
    public function grade(){
        return $this->belongsTo(grade_table::class);
    }
}
