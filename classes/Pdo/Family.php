<?php
class Pdo_Family extends Pdo_Manager {

    public function add_family($family){
        $query = $this->pdo->prepare('INSERT INTO families(name, parentfamily) VALUES (:name, :parent_family)');
        $query->bindValue(':name', $family->getName());
        if($family->getParentfamily() != 0)
            $query->bindValue(':parent_family', $family->getParentfamily());
        else
            $query->bindValue(':parent_family', NULL);
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_family($family){
        $query = $this->pdo->prepare('UPDATE families SET name = :name, parentfamily = :parent_family WHERE id = :id');
        $query->bindValue(':id', $family->getId());
        $query->bindValue(':name', $family->getName());
        $query->bindValue(':parent_family', $family->getParentfamily());
        $query->execute();
    }

    public function delete_family($id){
        $query = $this->pdo->prepare('DELETE FROM families WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
    
    public function getAllFamilies() {
        $query = $this->pdo->prepare('SELECT * FROM families ORDER BY parentfamily');
        $query->execute();
        $array = array();
        while($value = $query->fetch(PDO::FETCH_ASSOC)) {
            $family = new Model_Family($value['id']);
            array_push($array, $family);
        }
        return $array;
    }
    
    public function familyWithId($id) {
        $query = $this->pdo->prepare("SELECT * FROM families WHERE id = :id");
        $query->bindValue(":id", $id);
        $query->execute();
        $value = $query->fetch(PDO::FETCH_ASSOC);
        return $value;
    }
    
    public function nameWithId($id) {
        $query = $this->pdo->prepare("SELECT name FROM families WHERE id = :id");
        $query->bindValue(":id", $id);
        $query->execute();
        $value = $query->fetch(PDO::FETCH_ASSOC);
        return $value['name'];
    }
    
    public function getDynamicFieldsIds($family_id) {
        $query = $this->pdo->prepare("SELECT id FROM dynamic_fields WHERE id_family = :id_family");
        $query->bindValue(":id_family", $family_id);
        $query->execute();
        $dynamic_fields = array();
        while($fetch = $query->fetch(PDO::FETCH_NUM)) {
            $dynamic_fields[] = $fetch[0];
        }
        return $dynamic_fields;
    }
}
?>
