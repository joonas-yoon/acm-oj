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
        'time_limit',
        'memory_limit',
        'input',
        'output',
        'sample_input',
        'sample_output',
        'hint',
        'status'
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

    public function contributeProblems() {
        return $this->hasMany('App\Problem');
    }

    public function solutions() {
        return $this->hasMany('App\Solution')->where('is_hidden', 0);
    }

    public function solutionsAccept() {
        return $this->solutions()->where('result_id', \App\Result::getAcceptCode());
    }
    public function getSubmitCount() {
        return $this->solutions->count();
    }
    public function getAcceptCount() {
        return $this->solutionsAccept->count();
    }
    public function getRate() {
        $submitCnt = $this->getSubmitCount();
        return $submitCnt > 0 ? 100 * $this->getAcceptCount() / $submitCnt : 0;
    }

    public function scopeGetOpenProblemOrFail($query, $id) {
        return $query->where('status', true)->findOrFail($id);
    }

    public function scopeGetOpenProblems($query) {
        return $query->select('id', 'title')->where('status', true);
    }

    public function scopeGetHiddenProblemOrFail($query, $id) {
        return $query->where('status', false)->findOrFail($id);
    }

    public function scopeGetHiddenProblems($query) {
        return $query->select('id', 'title')->where('status', false);
    }

    public function scopeGetNewestProblems($query, $takes) {
        return $query->select('id', 'title')->latest('created_at')->latest('id')
                    ->where('status', true)
                    ->take($takes)->get();
    }
}
