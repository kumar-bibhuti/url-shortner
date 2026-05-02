<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['email', 'company_id', 'token', 'status', 'role'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
