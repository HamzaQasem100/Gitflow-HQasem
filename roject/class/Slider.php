<?php

include_once __DIR__ . '/../dpconfig/dbConnect.php';
include_once 'CRUD.php';

class Slider implements crud {
    
    function __construct() {
        $database = new dbConnect();
        $this->db = $database->connect();
    }

    function __destruct() {
        try {
            $this->database = null;
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    
    function readAll() {
        $stmt = $this->db->prepare(" SELECT slider.id,slider.image_id ,slider.userID ,slider.caption ,slider.link,images.logo,users.username 
        FROM slider 
        JOIN images ON slider.image_id = images.id
        JOIN users  ON slider.userID = users.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function readById($id) {
        $stmt = $this->db->prepare("SELECT slider.id,slider.image_id ,slider.userID ,slider.caption ,slider.link,images.logo,users.username FROM
        slider 
        JOIN images on slider.image_id = images.id
        JOIN users on slider.userID = users.id
        WHERE slider.id = $id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function deleteAll() {
        $stmt = $this->db->prepare("DELETE FROM slider");
        $stmt->execute();
        return $stmt;
    }
     
    function deleteById($id) {
        $stmt = $this->db->prepare("DELETE FROM slider WHERE slider.id = $id");
        $stmt->execute();
        return $stmt;
    }

    function update($id,$data) {
        $stmt = $this->db->prepare("UPDATE slider SET slider.image_id =:image_id , slider.userID =:userID , slider.caption =:caption , slider.link =:link WHERE slider.id = $id");
        $stmt->bindParam(":image_id", $data['image_id']);
        $stmt->bindParam(":userID", $data['userID']);
        $stmt->bindParam(":caption", $data['caption']);
        $stmt->bindParam(":link", $data['link']);
        $stmt->execute();
        return $stmt;
    }
    
    function create($data) {
        $stmt = $this->db->prepare("INSERT INTO slider VALUES(null,:image_id,:userID,:caption,:link)");
        $stmt->bindParam(":image_id", $data['image_id']);
        $stmt->bindParam(":userID", $data['userID']);
        $stmt->bindParam(":caption", $data['caption']);
        $stmt->bindParam(":link", $data['link']);
        $stmt->execute();
        return $stmt;
    }
}




