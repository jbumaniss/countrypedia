<?php

namespace Domain\Region\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class SubRegion extends Model
{
    use HasFactory;

    protected $guarded = [];

}