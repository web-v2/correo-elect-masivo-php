<?php
include_once 'db.php';

class Contactos extends db{
    private $nombres;
    private $correo;
    private $path;

    public function getContactos(){
        $query = $this->connect()->prepare('SELECT * FROM `contactos`');
        $query->execute();
        $this->close();
        while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
            return $this->nombres[]=$filas;
        }   return false;
    }

    public function getContactoById($id){
        $hr = new Tools();
        $query = $this->connect()->prepare('SELECT * FROM `contactos` WHERE id_cont = :id');
        $query->execute(['id' => $hr->limpiarCadena($id)]);
        $this->close();
        while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
            return $this->nombres[]=$filas;
        }   return false;
    }
   

    public function getNombre(){
        return $this->nombres;
    }

    public function getCorreo(){
        return $this->correo;
    }
    
    public function getPath(){
        return $this->path;
    }
}

?>