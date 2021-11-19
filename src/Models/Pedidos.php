<?php

namespace App\Models;

class Pedidos
{
  private static $table = 'pedidos';

  public static function get($id)
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'SELECT * FROM '.self::$table.' WHERE id = :id';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0)
    {
      $data = $stmt->fetch(\PDO::FETCH_ASSOC);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }
    else
    {
      throw new \Exception("Nenhum pedido encontrado!");
    }
  }

  public static function getAll()
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'SELECT * FROM '.self::$table;
    $stmt = $connectionPDO->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
      $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      echo json_encode($data, JSON_PRETTY_PRINT);
    }
    else
    {
      throw new \Exception("Nenhum pedido encontrado!");
    }
  }

  public static function insert($data)
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $sql = 'SELECT quantidade FROM produtos WHERE id = :ps';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':ps', $data["produto_id"]);
    $stmt->execute();
    
    $quantidadeDisponivel = $stmt->fetch(\PDO::FETCH_ASSOC)["quantidade"];
    $quantidadeAtual = $quantidadeDisponivel -  $data['quantidade'];
    
    $sql = 'UPDATE produtos SET quantidade = :qa WHERE id = :ps';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':qa', $quantidadeAtual);
    $stmt->bindValue(':ps', $data["produto_id"]);
    $stmt->execute();

    $sql = 'INSERT INTO '.self::$table.' (nome, quantidade, rua, numero, cep, complemento, telefone, bairro, status, usuario_id, produto_id) VALUES (:nm, :qt, :ru, :nu, :cp, :ct, :ph, :br, 1, :ur, :ps)';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':nm', $data['nome']);
    $stmt->bindValue(':qt', $data['quantidade']);
    $stmt->bindValue(':ru', $data['rua']);
    $stmt->bindValue(':nu', $data['numero']);
    $stmt->bindValue(':cp', $data['cep']);
    $stmt->bindValue(':ct', $data['complemento']);
    $stmt->bindValue(':ph', $data['telefone']);
    $stmt->bindValue(':br', $data['bairro']);
    $stmt->bindValue(':ur', $data['usuario_id']);
    $stmt->bindValue(':ps', $data['produto_id']);
    $stmt->execute();
  }
  
  public static function inativarAtivar($id, $status)
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
    
    $sql = 'SELECT quantidade, produto_id FROM '.self::$table.' WHERE id = :id';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
      
    $data = $stmt->fetch(\PDO::FETCH_ASSOC);
      
    $quantidadeSolicitada  = $data["quantidade"];
    $idDoProdutoSolicitado = $data["produto_id"];
      
    $sql = 'SELECT quantidade FROM produtos WHERE id = :id';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':id', $idDoProdutoSolicitado);
    $stmt->execute();
    
    $data = $stmt->fetch(\PDO::FETCH_ASSOC);
    $quantidadeDisponivel = $data["quantidade"];
        
    if ($status === "1")
    {
      $quantidadeAtual = $quantidadeDisponivel - $quantidadeSolicitada;
    }
    else if ($status === "0")
    {
      $quantidadeAtual = $quantidadeDisponivel + $quantidadeSolicitada;
    }

    $sql = 'UPDATE produtos SET quantidade = :qa WHERE id = :id';
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':qa', $quantidadeAtual);
    $stmt->bindValue(':id', $idDoProdutoSolicitado);
    $stmt->execute();
  }
  
  public static function update($id, $data)
  {    
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    $get_status  = 'SELECT status from '.self::$table.' WHERE id = :id';
    $stmt_status = $connectionPDO->prepare($get_status);
    $stmt_status->bindValue(':id', $id);
    $stmt_status->execute();
    $data_status = $stmt_status->fetch(\PDO::FETCH_ASSOC);
    
    $data["status"] = isset($data["status"]) ? $data["status"] : $data_status["status"];

    foreach ($data as $key => $value)
    {     
      $sql = 'UPDATE '.self::$table.' SET '.$key.' = :vl WHERE id = :id';
      $stmt = $connectionPDO->prepare($sql);
      $stmt->bindValue(':vl', $value);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
    }
    self::inativarAtivar($id, $data["status"]);
  }
  
  public static function delete($id)
  {
    $connectionPDO = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
    
    $sql = 'UPDATE '.self::$table.' SET status = 0 WHERE id = :id';
    
    $stmt = $connectionPDO->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    
    self::inativarAtivar($id, "0");
  }
}
