<?php

namespace App\Http\Services\Admin;

use App\Models\Contact;
use Exception;
use Illuminate\Database\Eloquent\Casts\Json;

class ContactService
{
    public function makeData($request){
        $data = [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            // 'reply' => $request->reply,
        ];
    }

    // public function GetContact(){

    // }

    public function Store($request){
        $checkEmail = Contact::where('email', $request->email)->first();
        if ($checkEmail) {
            return errorResponse(__('Email already exists.'));
        }
        try {
            // Create a new contact
            $contact = Contact::create($request->all());
            // Set the reply field to null for new contacts
            $contact->reply = null;
            $contact->save();

            return successResponse(__('Contact created successfully.'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function show($request){
        if($request->_id){
            $contact = Contact::find($request->_id);
            if($contact){
                $data = [
                    '_id' => $contact->id,
                    'firstName' => $contact->firstName,
                    'lastName' => $contact->lastName,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'subject' => $contact->subject,
                    'message' => $contact->message,
                    'createdAt' => $contact->created_at->toIso8601String(),
                    'updatedAt' => $contact->updated_at->toIso8601String(),
                    'reply' => $contact->reply,
                ];
                // Include reply if it exists
                $reply = json_decode($contact->reply);
                // return $reply;
                if($contact->reply){
                    $data['reply'] = [
                        'emai' => $reply->email,
                        'message' => $reply->message,
                        'subject' => $reply->subject,
                        '_id' => $contact->id,
                    ];
                }
                return successResponse(__('Contact Fatch SuccessFully'), $data);
            }
        }

        return errorResponse(__('Contact Not Fount'));
    }

    public function ContactReply($request){
        $request->validate([
            '_id' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);
        // Find the contact by ID
        $contact = Contact::find($request->_id);

        if ($contact) {
            // Check if a reply already exists for this contact
            if ($contact->reply) {
                return errorResponse(__('Message already replied'));
            }
            // Update the reply column in the contacts table
            $contact->reply = [
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message
            ];
            $contact->save();
            // Optionally, update the status of the contact to indicate it has been replied to
            $contact->status = true;
            $contact->save();
            return successResponse(__('Message has been sent successfully.'),);
        }
        return errorResponse(__('Contact not found.'));
    }

    public function delete($request){

        if ($request->_id) {
            $data = Contact::where('id', $request->_id)->delete();
            if (!$data) {
                return errorResponse(__('Contact not found.'));
            }
            return successResponse(__('Contact deleted successfully.'));
        } else {
            return errorResponse(__('Contact not found.'));
        }
    }
}
