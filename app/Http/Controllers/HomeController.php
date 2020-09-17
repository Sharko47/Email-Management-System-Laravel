<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Showing all the inbox mail except drafted ones.
        $inboxData = Email::where('user_id',Auth::user()->id)
        ->where('to',Auth::user()->email)
        ->where('is_drafted','0')->paginate(8);
        return view('home',compact('inboxData'));
    }

    public function viewEmail($id){
        //Called when user clicks view button. Returning particular email data.
        $viewEmailData = Email::where('id',$id)->limit(1)->get();

        return view('viewEmail',compact('viewEmailData'));
    }

    public function fetchSentEmails(){
        //Fetching all the sent emails from the db.
        $sentEmailData = Email::where('user_id',Auth::user()->id)
        ->where('from',Auth::user()->email)
        ->where('is_drafted','0')
        ->paginate(8);
        
        return view('sentEmails',compact('sentEmailData'));
    }


    public function fetchDraftEmails(){
        //Fetching all the drafted emails.
        $draftEmailData = Email::where('user_id',Auth::user()->id)
        ->where('from',Auth::user()->email)
        ->where('is_drafted','1')
        ->paginate(8);
        
        return view('draftEmails',compact('draftEmailData'));
    }

    public function fetchImportantEmails(){
        //Fetching all the important emails.
        $importantEmailData = Email::where('user_id',Auth::user()->id)
        ->where('from',Auth::user()->email)
        ->where('is_important','1')
        ->paginate(8);
        
        return view('importantEmails',compact('importantEmailData'));
    }

    public function fetchDeletedEmails(){
        //Fetching all the deleted emails that can be restored if user wants to.
        $deletedEmailData = Email::where('user_id',Auth::user()->id)
        ->onlyTrashed()
        ->paginate(8);
        
        return view('deletedEmails',compact('deletedEmailData'));
    }

    public function deleteEmail($email_id){
        //Called when user want to delete an email.
        $data = Email::find($email_id);
        if ($data != null) {
            $data->delete();
            return redirect()->back()->with('email-deleted-success',"Email deleted successfully. To access deleted mail check trash.");
        } 
        else {   
            return redirect()->back()->with('email-deleted-error',"Record not Found");
        }
    }

    public function restoreEmail($id)
    {
        //Called from the trash view when user want to restore the deleted email.
        Email::onlyTrashed()->find($id)->restore();

        return redirect()->back()->with('email-restore-success',"Email has been restored successfully.");
    }

    public function permanentDeleteEmail($id)
    {
        //Called only if user want to permanently deleted email.
        Email::onlyTrashed()->find($id)->forceDelete();

        return redirect()->back()->with('email-p-delete-success',"Email has been permanently deleted successfully.");
    }

    public function sendDraftEmailDataToModal($id){
        //Called when user clicks edit button from draft view for editing the draft.
        $draftedEmailData = Email::where('id',$id)->limit(1)->get();

        return view('draftEditorView', compact('draftedEmailData'));
    }
}
