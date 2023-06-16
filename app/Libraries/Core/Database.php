<?php

namespace App\Libraries\Core;

use PDO;
use PDOException;
use PDOStatement;

/**
 * A class that provides an easy way to interact with a MySQL database using PDO.
 */
class Database
{
  private ?PDO $dbHandler;
  private ?PDOStatement $statement;
  public function __construct()
  {
    $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4';
    $options = [
      PDO::ATTR_PERSISTENT => true, // Persistent connection
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw PDOException on error
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Set default fetch mode to object
    ];

    try {
      $this->dbHandler = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], $options);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  /**
   * Prepares a SQL query to be executed.
   *
   * @param string $sql The SQL query to prepare.
   */
  public function query(string $sql): void
  {
    $this->statement = $this->dbHandler->prepare($sql);
  }

  /**
   * Binds a value to a parameter in the prepared statement.
   *
   * @param string $parameter The name of the parameter to bind the value to.
   * @param mixed  $value     The value to bind to the parameter.
   * @param int    $type      The data type of the parameter. Defaults to PDO::PARAM_STR if not specified.
   */
  public function bind(string $parameter, mixed $value, ?int $type = null): void
  {
    $type ??= match (true) {
      is_int($value) => PDO::PARAM_INT,
      is_bool($value) => PDO::PARAM_BOOL,
      is_null($value) => PDO::PARAM_NULL,
      default => PDO::PARAM_STR,
    };
    $this->statement->bindValue($parameter, $value, $type);
  }

  /**
   * Executes the prepared statement.
   *
   * @return bool Whether the statement executed successfully or not.
   */
  public function execute(): bool
  {
    return $this->statement->execute();
  }

  /**
   * Returns the result set of the executed query.
   *
   * @return array An array of objects representing the rows returned by the query.
   */
  public function all(): array
  {
    $this->execute();
    return $this->statement->fetchAll();
  }

  /**
   * Returns the first row of the result set of the executed query.
   *
   * @return object|false An object representing the first row returned by the query, or false if there were no results.
   */
  public function first(): object|false
  {
    $this->execute();
    return $this->statement->fetch();
  }

  /**
   * Returns the number of rows affected by the last executed query.
   *
   * @return int The number of rows affected by the last executed query.
   */
  public function count(): int
  {
    return $this->statement->rowCount();
  }
}
