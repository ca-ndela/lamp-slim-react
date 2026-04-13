<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function coca(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $stmt = $mysqli_connection->prepare("SELECT * FROM alunni WHERE id = ?");
    $stmt->bind('i', (int)$args['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_array(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }
  
  public function ina(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $data = json_decode($request->getBody(), true);
    $nomeBello = $data['nome'];
    $cognomeBello = $data['cognome'];

    $stmt = $mysqli_connection->prepare("INSERT INTO alunni(nome, cognome) VALUES (?, ?)");
    $stmt->bind('ss', $nomeBello, $cognomeBello);
    $stmt->execute();
    $result = $stmt->get_result();

    return $response->withStatus(200);
  }

  public function mara(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $data = json_decode($request->getBody(), true);
    $id = $args['id'];
    $nomeBello = $data['nome'];
    $cognomeBello = $data['cognome'];

    $stmt = $mysqli_connection->prepare("UPDATE alunni SET nome = ?, cognome = ? WHERE id = ?");
    $stmt->bind('ssi', $nomeBello, $cognomeBello, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $response->withStatus(200);
  }

  public function dona(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $stmt = $mysqli_connection->prepare("DELETE FROM alunni WHERE id = ?");
    $stmt->bind('i', $args['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      return $response->withStatus(404);
    }
    return $response->withStatus(200);
  }
}
