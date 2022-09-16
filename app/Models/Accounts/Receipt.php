<?php

namespace App\Models\Accounts;

use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\EntryType;
use App\Models\User;
use App\Models\Contact\Contact;
use App\Models\AccountSettings\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function EntryType()
    {
        return $this->belongsTo(EntryType::class);
    }

    public function AccountManager()
    {
        return $this->hasMany(AccountManager::class);
    }

    public function Contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function Tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
