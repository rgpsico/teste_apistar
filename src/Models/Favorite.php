<?php

namespace MeuProjeto\Models;

class Favorite extends BaseModel
{
    protected $table = 'favorites';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
