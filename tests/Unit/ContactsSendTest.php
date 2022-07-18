<?php

namespace Tests\Unit;

use App\Mail\SendContactsMail;
use Tests\TestCase;

class ContactsSendTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_email()
    {
        $data = [
            'name' => 'Имя',
            'email' => 'maxmarok@gmail.com',
            'phone' => '12345678',
        ];

        $mailable = new SendContactsMail($data);

        $mailable->assertSeeInHtml($data['name']);
        $mailable->assertSeeInHtml($data['email']);
        $mailable->assertSeeInHtml($data['phone']);
    }
}
