<?php
class Aeropuerto extends DB
{
    public $id_aero;
    public $nombre_aero;
    public $ciudad_aero;
    public $capacidad_aero;
    public $organizacion_aero;

    public static function all()
    {
        $db = new DB();
        try {
            $prepare = $db->prepare("SELECT * FROM aeropuertos");
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_CLASS, Aeropuerto::class);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public static function find($id)
    {
        $db = new DB();
        try {
            $prepare = $db->prepare("SELECT * FROM aeropuertos WHERE id_aero=:id_aero");
            $prepare->execute([":id_aero" => $id]);
            return $prepare->fetchObject(Aeropuerto::class);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function save()
    {
        $db = new DB();
        $params = [
            ":nombre_aero" => $this->nombre_aero,
            ":ciudad_aero" => $this->ciudad_aero,
            ":capacidad_aero" => $this->capacidad_aero,
            ":organizacion_aero" => $this->organizacion_aero
        ];

        try {
            if (empty($this->id_aero)) {
                $prepare = $db->prepare("INSERT INTO aeropuertos (nombre_aero, ciudad_aero, capacidad_aero, organizacion_aero) VALUES (:nombre_aero, :ciudad_aero, :capacidad_aero, :organizacion_aero)");
                $prepare->execute($params);
    
                $this->id_aero = $db->lastInsertId();
            } else {
                $params[":id_aero"] = $this->id_aero;
                $prepare = $db->prepare("UPDATE aeropuertos SET nombre_aero=:nombre_aero, ciudad_aero=:ciudad_aero, capacidad_aero=:capacidad_aero, organizacion_aero=:organizacion_aero WHERE id_aero=:id_aero");
                $prepare->execute($params);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function remove()
    {
        $db = new DB();
        try {
            $prepare = $db->prepare("DELETE FROM aeropuertos WHERE id_aero=:id_aero");
            $prepare->execute([":id_aero" => $this->id_aero]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
