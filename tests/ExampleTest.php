<?php

namespace Tests;

use Silex\WebTestCase;

class ExampleTest extends WebTestCase
{
    public function createApplication()
    {
        return require __DIR__.'/../src/app.php';
    }

    public function testFooBar()
    {
        echo "Working PHPUnit example test.";
    }
}
