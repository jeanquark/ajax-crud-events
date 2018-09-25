<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = [
        'name',
        'type',
        'date',
        'start_time',
        'end_time',
        'audience',
        'is_published'
    ];
}