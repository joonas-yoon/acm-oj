<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;
use Illuminate\Pagination\LengthAwarePaginator;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = 20;
        $currentPage = Input::get('page', 1);

        $users = User::all();
        $users = $users->sortByDesc(function($item){
            return [
                $item->getAcceptCount(),
                - $item->getSubmitCount()
            ];
        })
        ->values();

        $total = $users->count();
        $users = $users->forPage($currentPage, $perPage);

        $rankNumber = ($currentPage-1)*$perPage+1;

        $paginator = new LengthAwarePaginator(
            $users, $total, $perPage, $currentPage,
            [
                'path'  => \Request::url(),
                'query' => \Request::query(),
            ]
        );

        return view('rank.index', compact('users', 'rankNumber', 'paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
