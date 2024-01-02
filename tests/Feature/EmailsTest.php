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
