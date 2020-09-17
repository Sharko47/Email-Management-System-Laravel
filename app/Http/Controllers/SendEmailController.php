<?php

namespace App\Http\Controllers;

use App\ContactList;
use App\Email;
use App\Mail\SendEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    //Class Variables to be used in all functions
    public $path_for_db = '';
    public $to;
    public $subject = '';
    public $message = '';
    public $is_important = 0;
    public $email_id_to_be_sent_from_draft = 0;

    public function sendEmail(Request $request, $id)
    {
        $isDrafted = 0;//Checking if message is to drafted

        if($request->has('from-draft-to-sent')){
            //Getting a email table id if the user sent email from draft editor
            $this->email_id_to_be_sent_from_draft = $request->get('from-draft-to-sent');
        }
        if ($request->hasFile('email-attachments')) {
            //Checking if the email has attachments
            $this->uploadFile($request);
        }

        if($request->has('is-important')){
            //Checking if the email is to be marked as important.
            $this->is_important = 1;
        }
        

        //Getting inputs from Request
        $this->to = $request->input('to-email');
        $this->subject = $request->input('subject');
        $this->message =  $request->input('message');
        

        //Calling a function which returns true if user does not exists in the db.
        //By passing inputs that is to be saved in the db in both cases such as drafting or sending.
        $userExits = $this->saveEmailToDB($id, $this->to, $this->subject, $this->message, $isDrafted);

        
        //Array to be sent to the mailer class.
        $data = [
            'title' => $this->subject,
            'body' => $this->message,
            'email-attachments' => $this->path_for_db,
        ];

        if($userExits){
            //If the return value is true then we don't save in the db and send mail just return with message.
            return redirect('home')->with('user-not-exists-error', "Email address doesn't exits. Please try something other.");
        }

        //Mail class which help in sending mail using custom mailer class we've created
        Mail::to($this->to)->send(new SendEmail($data));

        //Successful Email Sent Message.
        return redirect('home')->with('email-sent-success', "Email has been sent successfully");
    }
        
    public function saveToDraft(Request $request, $id)
    {
        if ($request->hasFile('email-attachments')) {
            //Checking if the draft message has an attachments.
            $this->uploadFile($request);
        }

        $this->to = $request->input('to-email');
        $this->subject = $request->input('subject');
        $this->message =  $request->input('message');

        //To be drafted hence value is true i.e 1
        $isDrafted = 1;

        //Same as send email function checking if the user exists or not.
        $userExists = $this->saveEmailToDB($id, $this->to, $this->subject, $this->message, $isDrafted);

        if($userExists){
            //Return if a user does not exists in the db.
            return redirect('home')->with('user-not-exists-error', "Email address doesn't exits. Please try something other.");
        }
        //Else return with the message
        return redirect('home')->with('save-draft-success', "Saved to draft successfully");
    }

    public function saveEmailToDB($id, $to, $subject, $message, $isDrafted)
    {
        
        $checkUserExists = new User();

        //Checking if a user exists or not.
        if ((count($checkUserExists->where('email', $to)->get())) > 0) {
            $saveInEmailTable = new Email();
            if($this->email_id_to_be_sent_from_draft){
                //This block will only be executed when user send an email from draft editor
                $updateDraftValue = $saveInEmailTable->find($this->email_id_to_be_sent_from_draft);
                if($updateDraftValue) {
                    //Checking if Draft message exists or not.
                    $updateDraftValue->is_drafted = 0;
                    if($this->is_important){
                        //If a user marked email as important then change value.
                        $updateDraftValue->is_important = 1;
                    }
                    else{
                        //Else keep it same.
                        $updateDraftValue->is_important = 0;
                    }
                    
                    $updateDraftValue->save();
                }
                //Returning in the case of draft email so it does not create same mail with new id.
                return false;
            }

            //Saving all the information in the Email Eloquent modal that is to be saved in the db.
            $saveInEmailTable->user_id = $id;
            $saveInEmailTable->from = Auth::user()->email;
            $saveInEmailTable->to = $to;
            $saveInEmailTable->subject = $subject;
            $saveInEmailTable->message = $message;
            $saveInEmailTable->email_attachments = $this->path_for_db;
            $saveInEmailTable->is_drafted = $isDrafted;
            $saveInEmailTable->is_important = $this->is_important;
            $saveInEmailTable->save();

            //Saving the receiver email in the contact table so that we can give suggestion while typing emails to the user.
            $saveInContactTable = new ContactList();
            $saveInContactTable->user_id = $id;
            $saveInContactTable->contact_email = $to;

            //Checking if the contact mail already saved so we dont save it again by another id which leads to data redundancy
            $checkIfContactAlreadySaved = $saveInContactTable->select('contact_email')->where('contact_email', $to)->where('user_id', $id)->get();
            if (! count($checkIfContactAlreadySaved) > 0) {
                //Only save when contact does not exists.
                $saveInContactTable->save();
            }
            return false;
        } else {
            return true;
        }
    }

    public function uploadFile()
    {
        //File uploading codes.
        $email_attachment = request()->file('email-attachments');
        //Generating random number then concatenating the number with file name.extention .
        $attachment_name = rand().''.$email_attachment->getClientOriginalName();
        
        //Uploads path if not exists it'll create one.
        $attachment_path = public_path('/uploads/');

        //Moving to the uploads folder
        $email_attachment->move($attachment_path, $attachment_name);

        //Saving the whole path to the class variable that is been used to save the path in the db.
        $this->path_for_db = $attachment_path.$attachment_name;
    }
}
