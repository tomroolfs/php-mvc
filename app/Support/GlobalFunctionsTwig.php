<?php

namespace App\Support;

use Twig\TwigFunction;

/**
 * GlobalFunctionsTwig is a class that extends the \Twig\Extension\AbstractExtension class in order to define global functions for use in Twig templates. 
 * 
 * The GlobalFunctionsTwig class is intended to be used in conjunction with the Twig templating engine, and its purpose is to provide a way to define functions that can be called from any Twig template without having to pass them as parameters to the template rendering function. 
 *
 * @package App\Support
 */
class GlobalFunctionsTwig extends \Twig\Extension\AbstractExtension
{
  /**
   * Returns a list of global functions to add to the existing list of global functions.
   *
   * @return TwigFunction[]
   */
  public function getFunctions(): array
  {
    return [
      new TwigFunction('vite', [$this, 'vite']),
      new TwigFunction('path', [$this, 'path']),
      new TwigFunction('hydrate', [$this, 'hydrate']),
    ];
  }

  /**
   * Returns a list of global functions to add to the existing list of global functions.
   *
   * @return string
   */
  public function vite(string|array $filenames = [], string $path = 'dist'): string
  {
    if (is_string($filenames)) {
      $filenames = [$filenames];
    }
    if ($_ENV['APP_ENV'] === 'dev') {
      $scripts = '<script type="module" src="http://localhost:5173/@vite/client"></script>';
      foreach ($filenames as $filename) {
        // $scripts .= '<script type="module" src="http://localhost:3000/@vite/client"></script>';
        $scripts .= '<script type="module" src="http://localhost:5173/' . $filename . '"></script>';
      }
    } else {
      $scripts = '';
      // read manifest.json
      $manifest = json_decode(file_get_contents(__DIR__ . '/../../public/dist/manifest.json'), true);
      foreach ($filenames as $filename) {
        // get the file extension from the filename
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // if the file extension is js, then add a script tag
        if ($ext === 'js' || $ext === 'mjs' || $ext === 'ts') {
          $scripts .= '<script type="module" src="/' . $path . '/' . $manifest[$filename]['file'] . '"></script>';
        }
        // if the file extension is css, then add a link tag
        if ($ext === 'css' || $ext === 'scss' || $ext === 'sass') {
          $scripts .= '<link rel="stylesheet" href="/' . $path . '/' . $manifest[$filename]['file'] . '">';
        }


        // $scripts .= '<script type="module" src="/'. $path .'/' . $manifest[$filename]['file'] . '"></script>';
      }
    }
    // dump($scripts, $manifest ?? '', $filename);
    return $scripts;
  }

  /**
   * Returns a string with the application's base url prepended to the given path.
   * 
   * @param string $path
   * @return string
   */
  public function path(string|array $path): string
  {
    if (is_string($path)) {
      $path = [$path];
    }
    return $_ENV['APP_URL'] . '/' . implode('/', $path);
  }

  public function hydrate(string $id, $data): string
  {
    return "<script>hydrate('$id', " . json_encode($data) . ")</script>";
  }
}
