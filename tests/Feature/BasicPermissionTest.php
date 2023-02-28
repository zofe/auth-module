<?php

namespace Uania\BasicPermission\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Uania\BasicPermission\Tests\TestCase;

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
