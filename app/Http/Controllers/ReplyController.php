<?php

namespace App\Http\Controllers;

use App\Models\Reply;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\User as userModel;
use App\Helper\Helper;

class ReplyController extends Controller
{

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeReply(Request $request)
    {
        $request->validate([
            'reply'=>'required',
            'steamid'=>'required'
        ]);

        if($request->steamid == Auth::user()->steamid){
            Reply::create(request()->except(['_token']));
            return redirect()->back()->with('success','Reply successfully submitted! Thank you!');
        } else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }

    }

    public function show(Request $request, $id)
    {
        $reply =  Reply::find($id);

		if ($reply['steamid'] == Auth::user()->steamid) {
			$test = session()->previousUrl();
	        $request->session()->put('testUrl', $test);

	        $reply['steam'] = userModel::where('steamid', $reply['steamid'])->get();
	        unset($reply['steamid']);

			return view('reply.edit')->with('reply', $reply);
		} else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }
    }

    public function delete(Request $request, $id)
    {
        $reply = Reply::find($id);

        if ($reply['steamid'] == Auth::user()->steamid) {
	        $redirectURL = session()->previousUrl();
	        $request->session()->put('testUrl', $redirectURL);

	        $reply['steam'] = userModel::where('steamid', $reply['steamid'])->get();
	        unset($reply['steamid']);

			return view('reply.delete')->with('reply', $reply);
		} else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }
    }

    public function update(Request $request)
    {
        $redirectUrl = $request->session()->get('testUrl');

        $request->validate([
            'reply' => 'required',
            'steamid' => 'required'
        ]);

        $id = $request->input('id');

        unset($request['_token']);
        unset($request['steamname']);
        unset($request['name']);
        unset($request['id']);

        if ($request->steamid == Auth::user()->steamid) {
            unset($request['steamid']);
            Reply::where('id',$id)->update($request->all());
            return redirect($redirectUrl)->with('success','Reply successfully updated!');
        } else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }
    }

    public function destroy(Request $request)
    {
        $redirectUrl = $request->session()->get('testUrl');

        $id = $request->input('id');

        if ($request->steamid == Auth::user()->steamid) {
            Reply::where('id',$id)->delete();
            return redirect($redirectUrl)->with('success','Reply successfully deleted!');
        } else {
            return redirect()->back()->with('error_steam_id',"Steam-ID does not match authenticated user. Login and try again.");
        }
    }
}
