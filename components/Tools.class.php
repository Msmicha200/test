<?php

class Tools
{
  public static function render($name, $param = []) {
    return include ROOT."/views/$name.php";
  }
}
