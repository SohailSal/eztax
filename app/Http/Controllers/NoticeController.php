<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as req;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Notice;

class NoticeController extends Controller
{

    public function index(req $request)
    {

        $notices = null;
        $search = null;
        $client = $request->input('client') ? (int)$request->input('client'): 0;
        if($client){
            $notices = Notice::where('client_id', $client)->get();
        }
        else{
            $notices = Notice::all();
        }
        // if($request->input('search')){
        //     $account = null;
        //     $id = null;
        //     if(Account::where('head_of_account', 'LIKE', '%' . $request->input('search') . '%')->first()) {
        //         $account = Account::where('head_of_account', 'LIKE', '%' . $request->input('search') . '%')->first();
        //         $id = $account->id;
        //     }
        //     $invoices = Invoice::where('ref', 'LIKE', '%' . $request->input('search') . '%')->orWhere('account_id', '=', $id )->orderBy('created_at', 'DESC')->paginate(10)->appends(request()->query());
        //     $search = $request->input('search');
        // }
        // else{
        //     $invoices = Invoice::orderBy('created_at', 'DESC')->paginate(10)->appends(request()->query());
        // }
        // return view('invoices.index', compact('invoices','search'));
        $years = Notice::distinct()->get(['tax_year']);
        return view('notices.index', compact('notices','client', 'years', 'search'));
    }

    public function create()
    {
        return view('notices.create');
    }

    public function store()
    {
        $notice = Notice::create(
            Request::validate([
            'client_id' => ['required'],
            'tax_authority' => ['required'],
            'tax_office' => ['required'],
            'notice_heading' => ['required'],
            'commissioner' => [],
            'tax_year' => ['required'],
            'receiving_date' => ['required'],
            'due_date' => [],
            'hearing_date' => [],
            'notice' => ['required','max:1024','mimes:pdf,jpg'],
            ])
        );

	    if(Request::file()){
            $name = time() . '_' . Request::file('notice')->getClientOriginalName();
            $path = Request::file('notice')->storeAs('uploads', $name, 'public');
			$notice->update([
				'notice_name' => $name,
				'notice_path' => $path,
			]);
		}
        return Redirect::route('notices')->with('success', 'Notice created.');
    }

    public function edit(Notice $notice)
    {
        return view('notices.edit', compact('notice'));
    }

    public function update(Notice $notice)
    {
        $notice->update(
            Request::validate([
            'client_id' => ['required'],
            'tax_authority' => ['required'],
            'tax_office' => ['required'],
            'notice_heading' => ['required'],
            'tax_year' => ['required'],
            'receiving_date' => ['required'],
            'reply' => ['max:1024','mimes:pdf,jpg'],
            'order' => ['max:1024','mimes:pdf,jpg'],
            ])
        );


	    if(Request::file('reply')){
            $name = time() . '_' . Request::file('reply')->getClientOriginalName();
            $path = Request::file('reply')->storeAs('uploads', $name, 'public');
			$notice->update([
				'reply_name' => $name,
				'reply_path' => $path,
			]);
		}

	    if(Request::file('order')){
            $name = time() . '_' . Request::file('order')->getClientOriginalName();
            $path = Request::file('order')->storeAs('uploads', $name, 'public');
			$notice->update([
				'order_name' => $name,
				'order_path' => $path,
			]);
		}
        return Redirect::route('notices')->with('success', 'Notice updated.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return Redirect::back()->with('success', 'Notice deleted.');
    }

}
