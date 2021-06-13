<?php

namespace App\Models;

use App\Models\Check;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function run(): void
    {
        Url::factory()->create();
    }

    public function checks(): HasMany
    {
        return $this->hasMany(Check::class);
    }
}
