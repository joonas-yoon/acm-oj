<?php

namespace App\Services;

use App\Services\Protects\TagServiceProtected;

use App\Models\Tag;

class TagService extends BaseService
{
    public function __construct
    (
        TagServiceProtected $tagServiceProtected
    )
    {
        $this->service = $tagServiceProtected;
    }
    
    
    /**
     * 태그 추가 개수 제한
     *
     * @return int
     */
    public function getLimitTagCount()
    {
        return $this->service->getLimitTagCount();
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
        return $this->service->getPopularTags($problem_id, $take);
    }
    
    /**
     * 해당 문제의 전체 태그 목록 가져오기
     *
     * @param int   $problem_id
     * @return array of App\Models\Tag
     */
    public function getTags($problem_id)
    {
        return $this->service->getTags($problem_id);
    }
    
    
    /**
     * 해당 문제의 해당 유저가 추가한 모든 태그 제거하기
     *
     * @param int   $problem_id
     * @return boolean
     */
    public function deleteTags($problem_id)
    {
        return $this->service->deleteTags($problem_id);
    }


    /**
     * 해당 문제의 해당 유저가 선택한 태그 추가하기. 이미 존재하는것은 제거
     *
     * @param int   $problem_id
     * @param array $tags
     * @return boolean
     */
    public function insertTags($problem_id, array $tags)
    {
        return $this->service->insertTags($problem_id, $tags);
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
        return $this->service->updateTag($tag_id, $status);
    }
    
    /**
     * 태그 추가하기
     *
     * @param string   $name
     * @return boolean
     */
    public function createTag($name)
    {
        return $this->service->createTag($name);
    }
    
    /**
     * 이름으로 태그 가져오기
     *
     * @param string   $name
     * @return App\Models\Tag
     */
    public function getTagByName($name)
    {
        return $this->service->getTagByName($name);
    }
    
    /**
     * 해당 태그를 가지고 있는 문제 목록을 카운트 순으로 가져오기
     *
     * @param int   $tag_id
     * @return paginate of Tag with problem
     */
    public function getTagWithProblem($tag_id)
    {
        if(Tag::findOrFail($tag_id)->status != Tag::openCode)
            return abort(404);
        return $this->service->getTagWithProblem($tag_id);
    }
    
    /**
     * 모든 열린 태그와 그 태그를 가지고 있는 문제 목록을 가져오기
     *
     * @param int   $tag_id
     * @return paginate of Tag with problem
     */
    public function getOpenTagsWithProblem()
    {
        return $this->service->getOpenTagsWithProblem();
    }
}
