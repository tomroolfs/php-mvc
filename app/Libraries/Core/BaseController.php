<?php

namespace App\Libraries\Core;

use Twig\Environment;
use App\Libraries\Core\Core;

/**
 * Base Controller class for handling common functionality for controllers
 */
class BaseController
{
  /**
   * The Twig environment instance
   *
   * @var Environment
   */
  protected Environment $twig;

  /**
   * The data that will be passed to the view
   *
   * @var array
   */
  protected array $data = [];

  /**
   * The data that will be passed to javascript
   * Do not use this for sensitive data
   * 
   * @var array
   */
  protected array $jsData = [];

  /**
   * Redirect the client to a different page
   *
   * @param string $url The url to redirect to
   * @return void
   */
  public function redirect(string $url, int $wait = 0): void
  {
    header('Refresh: ' . $wait . '; URL=' . $url);
  }

  /**
   * Render a Twig template and output the result
   *
   * @param string $template The name of the Twig template to render
   * @return void
   */
  public function view(string $template): void
  {
    // get the Twig environment instance
    $this->twig = Core::getTwig();

    // add the jsData to the data array
    $this->data['jsData'] = $this->jsData;

    // render the templates
    echo $this->twig->render($template . '.twig', $this->data);
  }

  /**
   * Send a JSON response to the client
   * 
   * @param array $data The data to be sent as JSON
   * @return void
   */
  public function json(array $data): void
  {
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  /**
   * Set the data that will be passed to the view
   *
   * @param array $data The data to be set
   * @return void
   */
  protected function setData(array $data): void
  {
    $this->data = $data;
  }

  /**
   * Add data to the existing data array that will be passed to the view
   *
   * @param array $data The data to be added
   * @return void
   */
  public function addData(array $data): void
  {
    $this->data = array_merge($this->data, $data);
  }

  /**
   * Get the data that will be passed to the view
   *
   * @return array The data to be passed to the view
   */
  public function getData(): array
  {
    return $this->data;
  }

  /**
   * Set the data that will be passed to javascript
   *
   * @param array $data The data to be set
   * @return void
   */
  protected function setJsData(array $data): void
  {
    $this->jsData = $data;
  }

  /**
   * Add data to the existing data array that will be passed to javascript
   *
   * @param array $data The data to be added
   * @return void
   */
  public function addJsData(array $data): void
  {
    $this->jsData = array_merge($this->jsData, $data);
  }

  /**
   * Get the data that will be passed to javascript
   *
   * @return array The data to be passed to javascript
   */
  public function getJsData(): array
  {
    return $this->jsData;
  }
}
