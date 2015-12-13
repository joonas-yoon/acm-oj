<?php

namespace App\Services;

use App\Repositories\TagRepository,
    App\Repositories\UserTagRepository,
    App\Repositories\ProblemTagRepository;

use DB;

class TagService
{
    protected $tagRepository;
    protected $userTagRepository;
    protected $problemTagRepository;
    
    public function __construct
    (
        TagRepository $tagRepository,
        UserTagRepository $userTagRepository,
        ProblemTagRepository $problemTagRepository
    )
    {
        $this->tagRepository = $tagRepository;
        $this->userTagRepository = $userTagRepository;
        $this->problemTagRepository = $problemTagRepository;
    }
    
    /**
     * 해당 문제의 인기있는 태그 목록 가져오기
     *
     * @param int   $problem_id
     * @param int   $take
     * @return array of App\Models\Tag
     */
    public function getPopularTags($problem_id, $take = 3)
    {
        $tagIds = $this->problemTagRepository->getPopularTags($problem_id, $take);
        
        $tags = [];
        foreach($tagIds as $tag)
            array_push($tags, $tag->tags);
        
        return $tags;
    }
    
    /**
     * 해당 문제의 전체 태그 목록 가져오기
     *
     * @param int   $problem_id
     * @return array of App\Models\Tag
     */
    public function getTags($problem_id)
    {
        return $this->getPopularTags($problem_id, 0);
    }
    
    
    /**
     * 해당 문제의 해당 유저가 추가한 모든 태그 제거하기
     *
     * @param int   $user_id
     * @param int   $problem_id
     * @return boolean
     */
    public function deleteTags($user_id, $problem_id)
    {
        $userTags = $this->userTagRepository->getUserTagsByProblem($user_id, $problem_id);
        
        foreach($userTags as $userTag) {
            DB::beginTransaction();
            
            try {
                
                $this->problemTagRepository
                     ->subProblemTag($userTag->problem_id, $userTag->tag_id);
                
                
                // I think this approach is bad. but using for performance.
                // origin code : $this->userTagRepository->delete($userTag->id);
                $userTag->delete();

            } catch(\Exception $e) {
                DB::rollback();
                return false;
            }
            
            DB::commit();
        }
        
        return true;
    }


    /**
     * 해당 문제의 해당 유저가 선택한 태그 추가하기. 이미 존재하는것은 제거
     *
     * @param int   $user_id
     * @param int   $problem_id
     * @param array $tags
     * @return boolean
     */
    public function insertTags($user_id, $problem_id, array $tags)
    {
        
        $this->deleteTags($user_id, $problem_id);
        
        foreach($tags as $tag_id) {
            $problemTag = $this->problemTagRepository->getOrCreate([
                'problem_id' => $problem_id,
                'tag_id' => $tag_id
            ]);
            
            DB::beginTransaction();
            
            try {
                
                $this->userTagRepository->create([
                    'user_id' => $user_id,
                    'problem_id' => $problem_id,
                    'tag_id' => $tag_id
                ]);
                
                // I think this approach is bad. but using for performance.
                $problemTag->addTag();
                
            } catch(\Exception $e) {
                DB::rollback();
                return false;
            }
            
            DB::commit();
        }
        
        return true;
    }
    
    /**
     * 태그 상태 업데이트
     *
     * @param int   $tag_id
     * @param int   $status
     * @return boolean
     */
    public function updateTag($tag_id, $status)
    {
        return $this->tagRepository->update($tag_id, ['status' => $status]);
    }
    
    /**
     * 태그 추가하기
     *
     * @param string   $name
     * @return boolean
     */
    public function createTag($name)
    {
        return $this->tagRepository->create(['name' => $name]);
    }
    
    /**
     * 이름으로 태그 가져오기
     *
     * @param string   $name
     * @return App\Models\Tag
     */
    public function getTagByName($name)
    {
        return $this->tagRepository->getTag('name', $name);
    }
    
    /**
     * 해당 태그를 가지고 있는 문제 목록을 카운트 순으로 가져오기
     *
     * @param int   $tag_id
     * @return paginate of Tag with problem
     */
    public function getTagWithProblem($tag_id)
    {
        if($this->tagRepository->get($tag_id)->status != Tag::openCode)
            abort(404);
            
        return $this->problemTagRepository
                    ->getTagWithProblem($tag_id)
                    ->paginate($this->paginateCount);
    }
}

?>