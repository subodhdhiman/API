<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class UserCallingDetails extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $fillable = [
        'phone_no', 'calling_mobile', 'calling_mobile', 'calling_mobile_exist', 'contact_list_name',
        'calling_mobile_exist', 'contact_list_name', 'incoming_message', 'case_Type', 'alert_sent',
        'trained', 'kb_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function period()
    {
        return true;
    }
}
