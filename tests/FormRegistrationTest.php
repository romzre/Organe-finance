<?php

namespace App\Tests;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\Test\TypeTestCase;

class FormRegistrationTest extends TypeTestCase
{
    public function testRightDataInForm(): void
    {
        $formData = [
            'email' => 'user@test.com',
            'username' => 'userTest',
            'password' => 'userpasswordTest',
            'confirm_password' => 'userpasswordTest',
            'AgreeTerms' => '1',
        ];

        $model = new User();
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(RegistrationFormType::class, $model);

        $expected = new User();

        $expected->setEmail('user@test.com')
                 ->setUsername('userTest')
                 ->setPassword('userpasswordTest')
                 ->setConfirm_password('userpasswordTest')
                 ->setAgreeTerms('1');
        // ...populate $expected properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }

    public function testCustomFormView()
    {
        $user = new User();
        $user->setEmail('user@test.com')
        ->setUsername('userTest')
        ->setPassword('userpasswordTest')
        ->setConfirm_password('userpasswordTest')
        ->setAgreeTerms('1');
        // ... prepare the data as you need

        // The initial data may be used to compute custom view variables
        $view = $this->factory->create(RegistrationFormType::class, $user)
            ->createView();
        
        $this->assertSame($user, $view->vars['value']);
    }

    public function testWrongInForm(): void
    {
        $formData = [
            'email' => 'user@test.com',
            'username' => 'userTest',
            'password' => 'user',
            'confirm_password' => 'user',
            'AgreeTerms' => '1',
        ];

        $model = new User();
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(RegistrationFormType::class, $model);

        $expected = new User();

        $expected->setEmail('user@test.com')
                 ->setUsername('userTest')
                 ->setPassword('userpasswordTest')
                 ->setConfirm_password('userpasswordTest')
                 ->setAgreeTerms('1');
        // ...populate $expected properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertNotEquals($expected, $model);
    }
}
