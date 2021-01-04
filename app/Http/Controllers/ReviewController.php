<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\User as userModel;
use App\Models\Reply as replyModel;
use App\Helper\Helper;


class ReviewController extends Controller
{

    // public function index()
    // {
    //     $data = Review::orderBy('id','desc')->paginate(10)->setPath('contacts');
    //     return view('admin.contacts.index', $data);
    // }

    // public function create()
    // {
    //     return view('admin.contacts.create');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'review' => 'required',
            'stars' => 'required',
            'steamid' => 'required'
        ]);

        if ($request->steamid == Auth::user()->steamid) {
            Review::create(request()->except(['_token']));
            return redirect()->back()->with('success','Review successfully submitted! Thank you!');
        } else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }
    }

    public function show(Request $request, $id)
    {
        $review =  Review::find($id);

        if ($review['steamid'] == Auth::user()->steamid) {
            $test = session()->previousUrl();
            $request->session()->put('testUrl', $test);

            $review['steam'] = userModel::where('steamid', $review['steamid'])->get();
            unset($review['steamid']);
            if (date('d/m/Y') == $review['created_at']->format('d/m/Y')) {
                $review['ago'] = Helper::time_elapsed_string($review['created_at']);
                unset($review['created_at']);
            }

            return view('review.edit')->with('review', $review);
        } else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }
    }

    public function delete(Request $request, $id)
    {
        $review =  Review::find($id);

        if ($review['steamid'] == Auth::user()->steamid) {
            $test = session()->previousUrl();
            $request->session()->put('testUrl', $test);

            $review['steam'] = userModel::where('steamid', $review['steamid'])->get();
            unset($review['steamid']);
            if (date('d/m/Y') == $review['created_at']->format('d/m/Y')) {
                $review['ago'] = Helper::time_elapsed_string($review['created_at']);
                unset($review['created_at']);
            }

            return view('review.delete')->with('review', $review);
        } else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }
    }

    public function update(Request $request)
    {
        $redirectUrl = $request->session()->get('testUrl');

        $request->validate([
            'review' => 'required',
            'stars' => 'required',
            'steamid' => 'required'
        ]);

        $id = $request->input('id');

        unset($request['_token']);
        unset($request['steamname']);
        unset($request['name']);
        unset($request['id']);
        unset($request['appid']);

        if ($request->steamid == Auth::user()->steamid) {
            unset($request['steamid']);
            Review::where('id',$id)->update($request->all());
            return redirect($redirectUrl)->with('success','Review successfully updated!');
        } else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }
    }

    public function destroy(Request $request)
    {
        $redirectUrl = $request->session()->get('testUrl');

        $id = $request->input('id');
        $review_id = $id;

        if ($request->steamid == Auth::user()->steamid) {
            Review::where('id',$id)->delete();
            replyModel::where('review_id',$review_id)->delete();
            return redirect($redirectUrl)->with('success','Review successfully deleted!');
        } else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }
    }

}
