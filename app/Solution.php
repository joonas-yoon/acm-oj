<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Result;
use App\Language;
use App\Problem;
use App\User;
use DB;
use Sentinel;

class Solution extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'solutions';

    protected $fillable = [
        'id',
        'result_id',
        'lang_id',
        'problem_id',
        'user_id',
        'time',
        'memory',
        'size',
        'is_hidden',
        'created_at',
    ];

    protected $guarded = [];

    public function problem() {
        return $this->belongsTo('App\Problem');
    }

    public function problemAll() {
        return $this->belongsTo('App\Problem');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function language() {
        return $this->belongsTo('App\Language', 'lang_id' /* 이것과 연결 */);
    }

    public function code() {
        return $this->hasOne('App\Code', 'id');
    }

    public function result() {
        return $this->belongsTo('App\Result', 'result_id');
    }

    public function publishedResult() {
        return $this->result()->where('published', '!=', 0);
    }

    public function accepted() {
        return $this->result()->where('id', \App\Result::getAcceptCode())->first();
    }

    public function resultToHtml() {
        $result = Result::find($this->result_id);

        return "<span class=\"solution {$result->class_name}\">{$result->description}</span>";
    }

    public function scopeGetSolutionsByOption($query, array $inputs) {
        $query->select('solutions.*');

        // 채점번호의 역순, 공개된 제출만
        $query->latest('solutions.id')->where('is_hidden', false);

        // 채점하는 문제가 공개된 것일 경우만
        $query->join('problems', function($join) {
            $join->on('problems.id', '=', 'solutions.problem_id');
        })->where('status',1);

        // 문제번호로 검색
        $problem_id = array_get($inputs, 'problem_id', 0);
        if($problem_id > 0)
            $query->where('problem_id', $problem_id);

        // 유저이름으로 검색
        $username = array_get($inputs, 'username', '');
        if($username != '')
            $query->join('users', function($join) {
              $join->on('users.id', '=', 'solutions.user_id');
            })->where('name', $username);


        // 언어종류로 검색
        $lang_id = array_get($inputs, 'lang_id', 0);
        if($lang_id > 0)
            $query->where('lang_id', $lang_id);

        // 결과종류로 검색
        $result_id = array_get($inputs, 'result_id', 0);
        if($result_id > 0)
            $query->where('result_id', $result_id);

        return $query;
    }

    public function paginateFrom($topItem, $perPage = 20)
    {
        // $prev = $this;
        // if($topItem > 0) {

        //     $prev = $prev->where('solutions.id', '>', $topItem)->first();

        // }

        // $temp = clone $original;
        // $temp = $temp->where('solutions.id', '<=', $topItem)
        //              ->take($perPage+1)->get();
        // $nextItem = $temp->count() > $perPage ? $temp->last()->id : '';
        // var_dump('nextItem : '. $nextItem);

        // $original->whereBetween('solutions.id', [$nextItem, $topItem]);

        // $paginator = [
        //     'firstPage' => \Request::url() .'?'. \Request::getQueryString(),
        // ];

        // return $original;
    }

    public static function createSolution(array $request) {
        $code = new Code(['code' => $request['code']]);
        
        DB::beginTransaction();
        try {
            $solution = Solution::create($request);
            $solution->code()->save($code);

            // 코드가 들어가면 대기중으로 전환
            $user = User::find($request['user_id']);
            $user->addSubmit($request['problem_id']);
            $solution->update(['result_id'=>Result::getWaitCode()]);
        } catch(\Exception $e) {
            DB::rollback();
        }
        DB::commit();
        return $solution;
    }
}
