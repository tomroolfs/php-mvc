<?php

namespace App\Controllers;

use App\Libraries\Core\BaseController;

class Homepages extends BaseController
{
  public function index(): void
  {
    $this->setData([
      'title' => 'Landing Page',
    ]);

    $this->view('homepages/index');
  }
}
