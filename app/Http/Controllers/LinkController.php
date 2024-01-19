<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $links = Link::with('user')->latest()->get();

        return response()->json([
            "links" => $links
        ]);
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
       
        
        $link = new Link;
        $link->long = $request->long;
        $link->short = Str::random(5);
        
        if($link->save()) {
            return response()->json([
                'status' => 'created',
                'data' => $link,
            ]);
        } 
        else {
            return response()->json([
                'status' => 'error',
                'data' => null,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        
        return response()->json([
            "link" => $link
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $link = Link::findOrFail($id);
        $link->long = $request->long;
        $link->short = Str::random(5);
        
        if($link->save()) {
            return response()->json([
                'status' => 'created',
                'data' => $link,
            ]);
        } 
        else {
            return response()->json([
                'status' => 'error',
                'data' => null,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return redirect(route('links.index'));
    }

    public function shortLink($short)
    {
        $link = Link::where('short', $short)->first();
        $link->increment('visits');
        return redirect($link->long);
    }
}
