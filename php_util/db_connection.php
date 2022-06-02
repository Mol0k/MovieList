<?php
  /**
   * Returns a mysqli object or prints a full HTML error page and ceases execution.
   */
  function get_db_connection_or_die() {
    $mysqli = new mysqli('localhost', 'root', '', 'moviedb');
    if ($mysqli->connect_error) {
      echo "<!DOCTYPE html>";
      echo "<html>";
      echo "<head><meta charset='UTF8'></head>";
      echo "<body>";
      echo "<p>Parece que ha habido un error inesperado con la conexión a la base de datos.</p>";
      echo "</body>";
      echo "</html>";
      die();
    }
    return $mysqli;
  }
//REMOTE DATABASE CONNECTION
  // function get_db_connection_or_die() {
  //   $mysqli = new mysqli('remotemysql.com', 'tuuKCfPJkL', 'wy9b5PbOaB', 'tuuKCfPJkL');
  //   if ($mysqli->connect_error) {
  //     echo "<!DOCTYPE html>";
  //     echo "<html>";
  //     echo "<head><meta charset='UTF8'></head>";
  //     echo "<body>";
  //     echo "<p>Parece que ha habido un error inesperado con la conexión a la base de datos.</p>";
  //     echo "</body>";
  //     echo "</html>";
  //     die();
  //   }
  //   return $mysqli;
  // }
?>
