<?php

class Memory
{

  private $db;
  private $id;
  private $title;
  private $content;
  private $date;
  private $image;
  private $video;

  public function __construct($dbhandler, $id = 0)
  {
    $this->db = $dbhandler;
    if ($id !== 0) {
      $this->id = $id;
      $query = $this->db->prepare('SELECT * FROM memories WHERE id = ?');
      $execute = $query->execute([$id]);
      if ($execute) {
        if ($query->rowCount()) {
          $memory = $query->fetch(PDO::FETCH_ASSOC);
          $this->title = $memory['title'];
          $this->content = $memory['content'];
          $this->date = $memory['date'];
          $this->image = $memory['image'];
          $this->video = $memory['video'];
        }
      }
      return [];
    }
  }

  public function saveMemory($title, $content, $date, $image, $video, $update = false)
  {
    $date = new DateTime($date);
    $executeArray = [
      $title,
      $content,
      $date->format('Y-m-d'),
      $image,
      $video
    ];
    $sql = '';
    $sql .= $update === true ? 'UPDATE ' : 'INSERT INTO ';
    $sql .= 'memories SET
    title = ?,
    content = ?,
    date = ?,
    image = ?,
    video = ?';
    if ($update === true) {
      array_push($executeArray, $this->id);
    }
    $sql .= $update === true ? ' WHERE id = ?' : null;
    $query = $this->db->prepare($sql);
    $execute = $query->execute($executeArray);
    if ($execute) {
      if ($update === false) {
        return $this->db->lastInsertId();
      } else {
         return $this->id;
      }
    }
    return false;
  }

  public function getMemory()
  {
    return [
      'title' => $this->title,
      'content' => $this->content,
      'date' => $this->date,
      'image' => $this->image,
      'video' => $this->video,
    ];
  }

  public function deleteMemory($id)
  {
    $query = $this->db->prepare('DELETE FROM memories WHERE id = ?');
    $execute = $query->execute([$id]);
    if ($execute)
      return true;
    return false;
  }
}
