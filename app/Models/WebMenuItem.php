<?php

namespace App\Models;

use App\Traits\Positionable;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;

class WebMenuItem extends Model
{
    use Positionable, Slugable;

    protected $table = 'web_menu_items';

    protected string $slugField = 'label';
    protected string $slugColumn = 'key';

    public $timestamps = false;

    protected $fillable = [
        'label',
        'route',
        'icon',
        'has_children',
        'parent_id',
    ];
}
