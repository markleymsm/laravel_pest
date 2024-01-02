<?php

use App\Mail\SendingEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\post;

test('an email was send', function () {
  Mail::fake();

  $user = User::factory()->create();

  post(route('sending-email', $user))->assertOk();

  Mail::assertSent(SendingEmail::class);
});

test('an email was send user:x', function () {
  Mail::fake();

  $user = User::factory()->create();

  post(route('sending-email', $user))->assertOk();

  Mail::assertSent(SendingEmail::class, fn (SendingEmail $email) => $email->hasTo($user->email));
});

test('emails subject should contain the user name', function () {
  $user = User::factory()->create();

  $mail = new SendingEmail($user);

  expect($mail)->assertHasSubject('Thank you ' . $user->name);
});

test('emails content should contain user email with a text', function () {
  $user = User::factory()->create();

  $mail = new SendingEmail($user);

  expect($mail)
  ->assertSeeInHtml($user->email)
  ->assertSeeInHtml('Confirmando seu email: ' . $user->email);
});
