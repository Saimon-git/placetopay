<?php

namespace App;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    const SUPERADMIN = 'Super Administrator';
    const ADMIN = 'Administrator';
    const USER = 'User';
}
