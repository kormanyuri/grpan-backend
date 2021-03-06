<?php

namespace App\Http\Controllers;

use App\Game;
use App\GameCategory;
use Illuminate\Http\Request;

/**
 * Class GameController
 * @package App\Http\Controllers
 */
class GameController extends Controller
{
    /**
     * GameCategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $locale = $request->get('locale', "EN");
        $games = Game::where('locale', $locale)->get();
        return view('admin/game/items', [
            'games' => $games,
            'locale' => $locale
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $categories = GameCategory::all();
        $game = new Game();
        return view('admin/game/form', [
            'game' => $game,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $request->validate([
            'name'   => 'required',
            'url'    => 'required',
            'image'  => 'required',
            'locale' => 'required'
        ]);

        $path = $request->file('image')->store('public/images');
        $path_2x = $request->file('image_2x')->store('public/images');
        $categoryId = $request->get('category');

        $category = GameCategory::find($categoryId);

        $game = new Game([
            'name'  => $request->get('name'),
            'url'    => $request->get('url'),
            'image'  => $path,
            'image_2x'  => $path_2x,
            'locale' => $request->get('locale')
        ]);
        $game->category()->associate($category);
        $game->save();

        return redirect('/admin/game?locale=' . $request->get('locale'))->with('success', 'Stock has been added');
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
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $categories = GameCategory::all();

        $game = Game::find($id);
        return view('admin/game/form', [
            'game' => $game,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $request->validate([
            'name'   => 'required',
            'url'    => 'required',
            'locale' => 'required'
        ]);

        if ($request->file('image')) {
            $path = $request->file('image')->store('public/images');
        }

        if ($request->file('image_2x')) {
            $path_2x = $request->file('image_2x')->store('public/images');
        }

        $categoryId = $request->get('category');

        $category = GameCategory::find($categoryId);

        $game = Game::find($id);
        $game->name = $request->get('name');
        $game->url = $request->get('url');
        if ($request->file('image')) {
            $game->image = $path;
        }

        if ($request->file('image_2x')) {
            $game->image_2x = $path_2x;
        }
        $game->locale = $request->get('locale');
        $game->category()->associate($category);
        $game->save();

        return redirect('/admin/game')->with('success', 'Game has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::find($id);
        $locale = $game->locale;
        $game->delete();

        return redirect('/admin/game?locale=' . $locale)->with('success', 'Game has been delete');
    }
}
