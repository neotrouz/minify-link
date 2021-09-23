<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $hash
 * @property string $url
 */
class Link extends Model
{

    /**
     * @var string table name
     */
    protected $table = 'link';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'url'
    ];

}
