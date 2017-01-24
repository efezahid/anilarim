<?php

class Memories
{
  private $db;

  public function __construct($dbhandler)
  {
    $this->db = $dbhandler;
  }

  public function getMemories($limit = 0)
  {
    $sql = 'SELECT * FROM memories ORDER BY date DESC';
    $sql .= $limit > 0 ? ' LIMIT 0, ' . $limit : '';
    $query = $this->db->prepare($sql);
    $execute = $query->execute();
    if ($execute) {
      if ($query->rowCount() > 0)
        return $query->fetchAll(PDO::FETCH_ASSOC);
      else
        return [];
    }

    return false;
  }
}
