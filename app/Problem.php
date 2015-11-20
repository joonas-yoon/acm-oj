<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use GrahamCampbell\Markdown\Facades\Markdown;

class Problem extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'problems';

    protected $fillable = [
        'title',
        'description',
        'input',
        'output',
        'sample_input',
        'sample_output',
        'hint',
        'time_limit',
        'memory_limit'
    ];

    public function getMdDescription(){
        return Markdown::convertToHtml($this->description);
    }
    public function getMdInput(){
        return Markdown::convertToHtml($this->input);
    }
    public function getMdOutput(){
        return Markdown::convertToHtml($this->output);
    }
    public function getMdHint(){
        return Markdown::convertToHtml($this->hint);
    }

    public function contributors() {
        //return $this->belongsTo('App\
    }
}
