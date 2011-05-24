<?php
include_once('PdoManager.class.php');

class Pdo_Structure extends Pdo_Manager {
    
    public function add_structure($structure){
        $query = $this->pdo->prepare('INSERT INTO structures(name) VALUES (:name)');
        $query->bindValue(':id', $structure->getId());
        $query->bindValue(':name', $structure>getName());
        $query->execute();
        return $this->pdo->lastInsertId();
    }
    
    public function edit_structure($structure){
        $query = $this->pdo->prepare('UPDATE structures SET name = :name WHERE id = :id');
        $query->bindValue(':id', $structure->getId());
        $query->bindValue(':name', $structure>getName());
        $query->execute();
    }

    public function delete_structure($id){
        $query = $this->pdo->prepare('DELETE FROM structures WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
}
?>