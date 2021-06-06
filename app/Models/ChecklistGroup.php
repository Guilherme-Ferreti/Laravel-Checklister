<?php

namespace App\Models;

use App\Models\Checklist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChecklistGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }
}
