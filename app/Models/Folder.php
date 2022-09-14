<?php
/**
 *  Model for escort photo albums/folder
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    /**
     *  Folder Types
     *
     *  @const
     */
    const PUBLIC_FOLDER = 'M';
    const PRIVATE_FOLDER = 'P';

    /**
     *  The table associated with the model
     *
     *  @var String
     */
    protected $table = 'photo_folders';

    /**
     *  Indicates if the model should be timestamped.
     *
     *  @var bool
     */
    public $timestamps = true;

    /**
     *  The attributes that are mass assignable.
     *
     *  @var array
     */
    protected $fillable = [
        'user_id',      // contains the escort's uid
        'name',         // contains the name of the folder
        'type',         // indicates whether the image is public or private
        'path',         // contains the path to the folder
    ];
}
