<?php

class Router
{
  private $routes;
  private $emptyRoute;
  private $notFoundRoute;
  private $uri;

  public static function getUri()
  {
    if (!empty($_SERVER["REQUEST_URI"]))
    {
      $str = trim($_SERVER["REQUEST_URI"], "/");
      if ($pos = strpos($str, "?")) {
        $str = substr($str, 0, $pos);				
      }
      return $str;
    }
    return null;
  }

  public function __construct()
  {
    $this->routes
    = include(ROOT."/config/routes.config.php");
  }

  public function setEmptyRoute($route)
  {
    $this->emptyRoute = $route;
  }

  public function setNotFoundRoute($route)
  {
    $this->notFoundRoute = $route;
  }

  public function run()
  {
    $this->uri = Router::getUri();
    if (strlen($this->uri) == 0)
    {
      return $this->root();
    }
    foreach ($this->routes as $pattern => $path)
    {
      if (preg_match("~$pattern~", $this->uri))
      {
        return $this->call($pattern, $path);
      }
    }
    return $this->unmatch();
  }

  private function unmatch()
  {
    if ($this->notFoundRoute == null)
      return false;
    if ($this->call(
      array_keys($this->notFoundRoute),
      array_values($this->notFoundRoute)) != null)
      return true;
    return false;
  }

  private function root()
  {
    header("Location: /main");
    die();

    if ($this->emptyRoute == null)
      return false;
    if ($this->call(
      array_keys($this->emptyRoute),
      array_values($this->emptyRoute)) != null)
      return true;
    return false;
  }

  private function call($pattern, $path)
  {
    $internal = preg_replace("~$pattern~", $path,
      $this->uri);
    $segments = explode("/", $internal);
    $controllerName = ucfirst(
      array_shift($segments)."Controller");
    $actionName = "action".ucfirst(
      array_shift($segments));
    $controllerFile =
    ROOT."/controllers/".$controllerName.".php";
    if (file_exists($controllerFile))
    {
      include_once($controllerFile);
    }
    $controller = new $controllerName;
    return call_user_func_array(
      array($controller, $actionName),
      $segments);
  }
}
