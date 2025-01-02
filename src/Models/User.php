<?php

namespace MeuProjeto\Models;

class User extends BaseModel
{
    protected $table = 'users';

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }
}
