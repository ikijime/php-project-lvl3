<?php

namespace App\Models;

use App\Models\Check;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Url extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urls';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    public function run()
    {
        Url::factory()->create();
    }

    public function checks()
    {
        return $this->hasMany(Check::class);
    }
}
