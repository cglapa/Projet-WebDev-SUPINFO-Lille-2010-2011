<?php
class Pdo_Customer extends Pdo_Manager {
    
    public function add_customer($customer){
        $query = $this->pdo->prepare('INSERT INTO customers(lname, fname, phone, structure, function, address) VALUES (:lname, :fname, :phone, :structure, :function, :address)');
        $query->bindValue(':lname', $customer->getLname());
        $query->bindValue(':fname', $customer->getFname());
        $query->bindValue(':phone', $customer->getPhone());
        $query->bindValue(':structure', $customer->getStructure());
        $query->bindValue(':function', $customer->getFunction());
        $query->bindValue(':address', $customer->getAddress());
        $query->execute();
        return $this->pdo->lastInsertId();
    }

    public function edit_customer($customer){
        $query = $this->pdo->prepare('UPDATE customers SET lname = :lname, fname = :fname, phone = :phone, structure = :structure, function = :function, address = :address WHERE id = :id');
        $query->bindValue(':id', $customer->getId());
        $query->bindValue(':lname', $customer->getLname());
        $query->bindValue(':fname', $customer->getFname());
        $query->bindValue(':phone', $customer->getPhone());
        $query->bindValue(':structure', $customer->getStructure());
        $query->bindValue(':function', $customer->getFunction());
        $query->bindValue(':address', $customer->getAddress());
        $query->execute();
    }

    public function delete_customer($id){
        $query = $this->pdo->prepare('DELETE FROM customers WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
    
    public function getCustomer($id) {
        $query = $this->pdo->prepare("SELECT * FROM customers WHERE id = :id");
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllCustomers() {
        $query = $this->pdo->prepare("SELECT id FROM customers");
        $query->execute();
        $array = array();
        while($value = $query->fetch(PDO::FETCH_ASSOC)) {
            $customer = new Model_Customer($value['id']);
            array_push($array, $customer);
        }
        return $array;
    }
}
?>
