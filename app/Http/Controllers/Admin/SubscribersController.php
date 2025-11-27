<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\Contact;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Mail;
use App\Mail\EmailContact;

class SubscribersController extends Controller
{
    // Newsletter Start
    public function index()
    {
        $newsletters = Newsletter::get();

        return view('admin.contacts.newsletters', compact('newsletters'));
    } 

    public function quick_promotion(Request $request)
    {
        $id = $request->id;
        $newsletters = Newsletter::where('id', $id)->get(); 
        $output['email_data'] = '';
        foreach($newsletters as $newsletter) {
            $output['email_data'] = '<label>Email</label>';
            $output['email_data'] .='<input type="text" name="email"  class="form-control"  placeholder="Email" id="" value="'.$newsletter->email.'" readonly="">';
        }
        echo json_encode($output);
    }
    // Newsletter End

    // Contacts Management

    public function contacts()
    {
        $contacts = Contact::get();

        return view('admin.contacts.contacts', compact('contacts'));
    } 

    public function view_contact(Request $request)
    {
        $id = $request->id;
        $contacts = Contact::where('id', $id)->get(); 
        foreach($contacts as $contact) {
            $output['view_name'] = '<label class="mr-4 mb-3">Họ và Tên</label>';
            $output['view_name'] .='<span>'.$contact->name.'</span>';
            $output['view_phone'] = '<label class="mr-4 mb-3">Số điện thoại</label>';
            $output['view_phone'] .='<span>'.$contact->phone.'</span>';
            $output['view_email'] = '<label class="mr-4 mb-3">Email</label>';
            $output['view_email'] .='<span>'.$contact->email.'</span>';
            $output['view_message'] = '<label class="mr-4 mb-3">Lời Nhắn</label>';
            $output['view_message'] .='<p>'.$contact->message.'</p>';
        }
        echo json_encode($output);
    }

    public function reply_contact(Request $request)
    {
        $id = $request->id;
        $contacts = Contact::where('id', $id)->get(); 
        foreach($contacts as $contact) {
            $output['email_data'] = '<label>Email</label>';
            $output['email_data'] .='<input type="text" name="email"  class="form-control"  placeholder="Email" id="" value="'.$contact->email.'" readonly="">';
        }
        echo json_encode($output);
    }

    public function sendEmail (Request $request) 
    {
        dd($request->all());die;
        try {
            $request->validate([
                'message' => 'required',
            ]);

            $data = [
                'email' => $request->email,
                'message' => $request->message
            ];

            Mail::to($request->email)->send(new EmailContact($data));
            return back()->with(['message' => 'Đã gửi Email thành công!']);
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Gửi Email thất bại!']);
        } 
    }


    public function del_contact(Contact $contact, $id)
    {

        Contact::where('id', $id)->delete();

        return back();
    }
}
