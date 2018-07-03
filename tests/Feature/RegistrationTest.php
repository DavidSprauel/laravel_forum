<?php


namespace Tests\Feature;


use Forum\Mail\PleaseConfirmYourEmail;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function a_confirmed_email_is_sent_upon_registration() {
        Mail::fake();
        
        $this->post(route('register'), [
            'name'                  => 'John',
            'email'                 => 'john@example.com',
            'password'              => 'foobar',
            'password_confirmation' => 'foobar',
            'confirmed'             => false,
        ]);
        
        Mail::assertQueued(PleaseConfirmYourEmail::class);
    }
    
    /** @test */
    public function user_can_fully_confirm_their_addresses() {
        Mail::fake();
        
        $this->post(route('register'), [
            'name'                  => 'John',
            'email'                 => 'john@example.com',
            'password'              => 'foobar',
            'password_confirmation' => 'foobar',
            'confirmed'             => false,
        ]);
        
        $user = User::whereName('John')->first();
        
        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);
        
        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))
            ->assertRedirect(route('threads.index'));
        
        tap($user->fresh(), function($user) {
            $this->assertTrue($user->confirmed);
            $this->assertNull($user->confirmation_token);
        });
    }
    
    /** @test */
    public function confirming_an_invalid_token() {
        $this->get(route('register.confirm', ['token' => 'invalid']))
            ->assertRedirect(route('threads.index'))
            ->assertSessionHas('flash', 'Unknown token.');
    }
    
}