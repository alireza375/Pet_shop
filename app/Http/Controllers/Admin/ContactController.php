<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactRequest;
use App\Http\Resources\Pagination\BasePaginationResource;
use App\Http\Services\Admin\ContactService;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    private $ContactService;

    public function __construct(ContactService $ContactService)
    {
        $this->ContactService = $ContactService;
    }

    public function GetContact(Request $request){
        // return $this->ContactService->GetContact();
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = Contact::select('id as _id', 'firstName', 'lastName', 'email', 'phone',
        'subject', 'message', 'created_at as createdAt', 'updated_at as updatedAt')->paginate($per_page);
        return successResponse(__('Contacts fetched successfully.'),
        new BasePaginationResource($data));

    }


    public function Store(ContactRequest $request){
        return $this->ContactService->Store($request);
    }

    public function show(Request $request){
        return $this->ContactService->show($request);
    }

    public function ContactReply(Request $request){
        return $this->ContactService->ContactReply($request);
    }


    public function delete(Request $request){
        return $this->ContactService->delete( $request);
    }
}
