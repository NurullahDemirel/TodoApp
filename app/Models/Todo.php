<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Todo extends Model
{
    use Searchable,HasFactory;
    protected $table='todos';
    protected $fillable=['title','body','created_by'];
    protected $casts=[
      'created_at'=>'date:Y-m-d'
    ];
    public function searchableAs()
    {
        return 'body';
    }
}
