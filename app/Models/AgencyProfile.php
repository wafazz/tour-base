<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'company_name', 'motac_reg_no', 'contact_person',
        'company_address', 'company_phone', 'company_logo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
