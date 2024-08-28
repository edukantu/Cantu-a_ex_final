<?php
class AeropuertosController
{
    public function index()
    {
        $aeropuertos = Aeropuerto::all();
        view("aeropuertos.index", ["airports" => $aeropuertos, "user" => "Carlos Eduardo"]);
    }

    public function crear()
    {
        echo "Estamos en crear";
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->nombre_aero, $data->ciudad_aero, $data->capacidad_aero, $data->organizacion_aero)) {
            $aeropuerto = new Aeropuerto();
            $aeropuerto->nombre_aero = $data->nombre_aero;
            $aeropuerto->ciudad_aero = $data->ciudad_aero;
            $aeropuerto->capacidad_aero = $data->capacidad_aero;
            $aeropuerto->organizacion_aero = $data->organizacion_aero;
            $aeropuerto->save();

            echo json_encode($aeropuerto);
        } else {
            echo json_encode(['status' => false, 'message' => 'Faltan datos para crear el aeropuerto.']);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->id_aero)) {
            $aeropuerto = Aeropuerto::find($data->id_aero);

            if ($aeropuerto) {
                $aeropuerto->nombre_aero = $data->nombre_aero ?? $aeropuerto->nombre_aero;
                $aeropuerto->ciudad_aero = $data->ciudad_aero ?? $aeropuerto->ciudad_aero;
                $aeropuerto->capacidad_aero = $data->capacidad_aero ?? $aeropuerto->capacidad_aero;
                $aeropuerto->organizacion_aero = $data->organizacion_aero ?? $aeropuerto->organizacion_aero;
                $aeropuerto->save();

                echo json_encode($aeropuerto);
            } else {
                echo json_encode(['status' => false, 'message' => 'Aeropuerto no encontrado.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'ID de aeropuerto no proporcionado.']);
        }
    }

    public function delete($id)
    {
        try {
            $aeropuerto = Aeropuerto::find($id);
            if ($aeropuerto) {
                $aeropuerto->remove();
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false, 'message' => 'Aeropuerto no encontrado.']);
            }
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Error al eliminar el aeropuerto.']);
        }
    }

    public function find($id)
    {
        $aeropuerto = Aeropuerto::find($id);
        if ($aeropuerto) {
            echo json_encode($aeropuerto);
        } else {
            echo json_encode(['status' => false, 'message' => 'Aeropuerto no encontrado.']);
      }
  }
}
?>
