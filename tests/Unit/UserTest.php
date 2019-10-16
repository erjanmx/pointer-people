<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @dataProvider correctEmailsProvider
     * @param $email
     */
    public function testCorrectEmailRegExp($email)
    {
        $this->assertRegExp(User::EMAIL_REGEXP, $email);
    }

    /**
     * @dataProvider incorrectEmailsProvider
     * @param $email
     */
    public function testIncorrectEmailRegExp($email)
    {
        $this->assertNotRegExp(User::EMAIL_REGEXP, $email);
    }

    public function correctEmailsProvider()
    {
        return [
            ['test@pointerbp.nl'],
            ['test@pointerbp.com'],
            ['1@pointerbp.com'],
            ['a.test@pointerbp.nl'],
        ];
    }

    public function incorrectEmailsProvider()
    {
        return [
            ['test@gmail.com'],
            ['test@yahoo.com'],
            ['1@test.nl'],
            ['a.test@pointerbp.dot.uk'],
            ['a.test@pointerbp.be'],
        ];
    }

    public function testHasEmailTrue()
    {
        $user = new User([
            'email' => 'a@b.c',
        ]);

        $this->assertTrue($user->hasEmail());
    }

    public function testHasEmailFalse()
    {
        $this->assertFalse((new User())->hasEmail());
    }
}
