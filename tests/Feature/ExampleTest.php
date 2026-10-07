<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/')->assertRedirect(route('dashboard'));

        $this->get('/dashboard')->assertRedirect(route('login'));
    }
}
