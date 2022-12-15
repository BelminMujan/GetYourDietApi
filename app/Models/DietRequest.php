<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DietStatus;

class DietRequest extends Model
{
    use HasFactory;
    protected $table = 'diet_requests';
    protected $fillable = ['goal','body_type','weight', 'height', 'activity', 'allergies', 'diseases', 'email', 'first_name', 'last_name', 'gender', 'dob', 'status', 'create_account'];
    protected $casts = [
        'allergies' => 'array',
        'diseases' => 'array'
    ];

    public function status(){
        return $this->belongsTo(DietStatus::class, 'status');
    }

}
