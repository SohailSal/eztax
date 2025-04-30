<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Notice;

class NoticeController extends Controller
{

    public function index()
    {

        $notices = null;
        $search = null;
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

        $notices = Notice::all();
        return view('notices.index', compact('notices','search'));
    }

    public function create()
    {
        return view('notices.create');
    }

    public function store()
    {
        Notice::create(
            Request::validate([
            'client_id' => ['required'],
            'tax_authority' => ['required'],
            'tax_office' => ['required'],
            'notice_heading' => ['required'],
            'tax_year' => ['required'],
            'receiving_date' => ['required'],
            ])
        );
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

        return Redirect::route('notices')->with('success', 'Notice updated.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return Redirect::back()->with('success', 'Notice deleted.');
    }

}
