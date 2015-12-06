<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProblemStatistics;
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
        'status',
        'total_submit'
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

    public function solutions() {
        return $this->hasMany('App\Solution')->where('is_hidden', 0);
    }

    public function solutionsAccept() {
        return $this->solutions()->where('result_id', \App\Result::getAcceptCode());
    }

    public function problemStatistics() {
        return $this->hasMany('App\ProblemStatistics');
    }

    public function statistics() {
        return $this->hasMany('App\Statistics');
    }


    public function getSubmitCount() {
        return $this->total_submit;
    }

    public function getAcceptCount() {
        return Statistics::getCountOrZero($this->problemStatistics()->where('result_id', Result::getAcceptCode())->first());
    }

    public function getRate() {
        $submitCnt = $this->getSubmitCount();
        return $submitCnt > 0 ? 100 * $this->getAcceptCount() / $submitCnt : 0;
    }

    public function isAccepted() {
        if( ! \Auth::check() ) return false;
        return Statistics::getCountOrZero($this->statistics()
            ->where('user_id', \Auth::user()->id)->where('result_id', Result::getAcceptCode())->first()) > 0;
    }

    public function isTried() {
        if( ! \Auth::check() ) return false;
        return ($this->statistics()->where('user_id', \Auth::user()->id)
            ->where('result_id', '!=', Result::getAcceptCode())->count()) > 0;
    }

    public function scopeGetOpenProblemOrFail($query, $id) {
        return $query->where('status', true)->findOrFail($id);
    }

    public function scopeList($query) {
        return $query->select('id', 'title', 'total_submit', 'status');
    }

    public function scopeGetOpenProblems($query) {
        return $query->list()->where('status', true);
    }

    public function scopeGetHiddenProblemOrFail($query, $id) {
        return $query->where('status', 0)->findOrFail($id);
    }

    public function scopeGetHiddenProblems($query) {
        return $query->list()->where('status', 0);
    }

    public function scopeGetNewestProblems($query, $takes) {
        return $query->list()->latest('created_at')->latest('id')
                    ->where('status', 1)
                    ->take($takes)->get();
    }

    public function scopeGetProblemsCreateByUser($query, $user_id) {
        return $query->list()->join('problem_thank', function($join) {
            $join->on('problems.id', '=','problem_thank.problem_id');
        })->where('thank_id', Thank::getAuthorId())->where('user_id', $user_id);
    }

    public static function createProblem(array $values, $user_id) {
        $problem = new Problem($values);
        $problem->save();

        $thanks = new ProblemThank;
        $thanks['problem_id'] = $problem->id;
        $thanks['thank_id'] = Thank::getAuthorId();
        $thanks['user_id'] = $user_id;
        $thanks->save();
        return $problem;
    }

    public function updateStatus($status) {
        $this['status'] = $status;
        $this->save();
        return $this;
    }
}
