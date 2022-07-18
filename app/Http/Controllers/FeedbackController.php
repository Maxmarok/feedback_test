<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactsRequest;
use App\Jobs\SendContactsJob;
use App\Models\User;

class FeedbackController extends Controller
{
    public function send(ContactsRequest $request)
    {
        $data = $request->validated();

        $user = $this->getAdmin();
        SendContactsJob::dispatch($user, $data);

        return response('success', 200);
    }

    protected function getAdmin()
    {
        return User::first();
    }

}
