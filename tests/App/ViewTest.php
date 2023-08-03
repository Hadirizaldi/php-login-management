<?php

namespace Hadirizaldi\PhpMvc\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
  public function testRender()
  {
    View::render("Home/index", ["PHP Login Managemenet"]);

    $this->expectOutputRegex('[PHP Login Management]');
    $this->expectOutputRegex('[html]');
    $this->expectOutputRegex('[body]');
    $this->expectOutputRegex('[Login Management]');
    $this->expectOutputRegex('[Login]');
    $this->expectOutputRegex('[Register]');
  }
}
