<?php

namespace App\Modules\Auth\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Modules\Auth\tests\TestCase;

class BasicPermissionTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_obvious()
    {
        $this->assertTrue(true);
    }


}
