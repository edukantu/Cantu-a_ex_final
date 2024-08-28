<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de diferentes aeropuertos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <style>
    body {
      background-color: #f0f8ff;
      font-family: 'Arial', sans-serif;
    }
    .container {
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
    h1 {
      color: #004d99;
      font-size: 2.5rem;
      font-weight: bold;
    }
    .btn-success {
      background-color: #004d99;
      color: #f0f8ff;
      border: #004d99;
    }
    .btn-success:hover {
      background-color: blue;
      color: #f9f9f9;
    }
    .table {
      border-radius: 8px;
      overflow: hidden;
    }
    thead {
      background-color: #004d99;
      color: #ffffff;
    }
    tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    tbody tr:nth-child(odd) {
      background-color: #ffffff;
    }
    .btn-warning {
      background-color: #004d99;
      color: #f0f8ff;
      border: #004d99;
    }
    .btn-warning:hover {
      background-color: blue;
      color: #f9f9f9;
    }
    .btn-danger {
      background-color: gray;
      border-color: gray;
    }
    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
    .btn-primary {
      background-color: #004d99;
      color: #f0f8ff;
      border: #004d99;
    }
    .btn-primary:hover {
      background-color: blue;
      color: #f9f9f9;
    }
    .btn-secondary {
      background-color: gray;
      border-color: gray;
    }
    .btn-secondary:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
    .modal-content {
      border-radius: 8px;
    }
    .modal-header {
      background-color: #004d99;
      color: #ffffff;
    }
    .modal-footer .btn {
      border-radius: 4px;
  }
</style>
</head>

<body>
  <div class="container">
    <h1 class="mt-5">Lista de diferentes aeropuertos</h1>
    <button class="btn btn-success" data-action="create">Agregar</button>
    <table class="table table-striped mt-4" id="table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Ciudad</th>
          <th>Capacidad</th>
          <th>Organización</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($airports as $airport) : ?>
          <tr data-id="<?php echo $airport->id_aero; ?>">
            <td><?php echo $airport->id_aero; ?></td>
            <td><?php echo $airport->nombre_aero; ?></td>
            <td><?php echo $airport->ciudad_aero; ?></td>
            <td><?php echo $airport->capacidad_aero; ?></td>
            <td><?php echo $airport->organizacion_aero; ?></td>
            <td>
              <button class="btn btn-warning btnEditar">Editar</button>
              <button class="btn btn-danger btnEliminar">Eliminar</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="modal fade" id="aeropuertosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Aeropuerto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-floating mb-3">
            <input type="text" id="nombre_aero" class="form-control" placeholder="Nombre">
            <label for="nombre_aero">Nombre</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" id="ciudad_aero" class="form-control" placeholder="Ciudad">
            <label for="ciudad_aero">Ciudad</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" id="capacidad_aero" class="form-control" placeholder="Capacidad">
            <label for="capacidad_aero">Capacidad</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" id="organizacion_aero" class="form-control" placeholder="Organización">
            <label for="organizacion_aero">Organización</label>
          </div>
        </div>
        <input type="hidden" id="identificador" value="">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary btn-guardar">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let myModal = new bootstrap.Modal(document.getElementById('aeropuertosModal'));

    const fetchAeropuerto = (event) => {
      let id = event.target.closest('tr').dataset.id;
      axios.get(`http://localhost/Cantuña_ex_final/aeropuertos/find/${id}`).then((res) => {
        console.log(res.data);
        let info = res.data;
        if (info) {
          document.querySelector("#exampleModalLabel").textContent = "Editar Aeropuerto";
          document.querySelector('#nombre_aero').value = info.nombre_aero || '';
          document.querySelector('#ciudad_aero').value = info.ciudad_aero || '';
          document.querySelector('#capacidad_aero').value = info.capacidad_aero || '';
          document.querySelector('#organizacion_aero').value = info.organizacion_aero || '';
          document.querySelector('#identificador').value = id;
          myModal.show();
        } else {
          console.error('No se recibieron datos válidos.');
        }
      }).catch((error) => {
        console.error('Error al obtener el aeropuerto:', error);
      });
    }

    const deleteAeropuerto = (event) => {
      let id = event.target.closest('tr').dataset.id;
      axios.delete(`http://localhost/Cantuña_ex_final/aeropuertos/delete/${id}`).then((res) => {
        let info = res.data;
        if (info.status) {
          document.querySelector(`tr[data-id="${id}"]`).remove();
        }
      }).catch((error) => {
        console.error('Error al eliminar el aeropuerto:', error);
      });
    }

    document.querySelector('.btn-success')
      .addEventListener('click', () => {
        document.querySelector("#exampleModalLabel").textContent = "Crear Aeropuerto";
        document.querySelector('#nombre_aero').value = "";
        document.querySelector('#ciudad_aero').value = "";
        document.querySelector('#capacidad_aero').value = "";
        document.querySelector('#organizacion_aero').value = "";
        document.querySelector('#identificador').value = "";
        myModal.show();
      });

    document.querySelector('.btn-guardar')
      .addEventListener('click', () => {
        let nombre_aero = document.querySelector('#nombre_aero').value;
        let ciudad_aero = document.querySelector('#ciudad_aero').value;
        let capacidad_aero = document.querySelector('#capacidad_aero').value;
        let organizacion_aero = document.querySelector('#organizacion_aero').value;
        let id = document.querySelector('#identificador').value;
        
        if (nombre_aero && ciudad_aero && capacidad_aero && organizacion_aero) {
          axios.post(`http://localhost/Cantuña_ex_final/aeropuertos/${id ? 'update' : 'create'}`, {
              nombre_aero,
              ciudad_aero,
              capacidad_aero,
              organizacion_aero,
              id
            })
            .then((res) => {
              let info = res.data;
              if (!id) {
                let tr = document.createElement("tr");
                tr.setAttribute('data-id', info.id_aero);
                tr.innerHTML = `<td>${info.id_aero}</td>
                                <td>${info.nombre_aero}</td>
                                <td>${info.ciudad_aero}</td>
                                <td>${info.capacidad_aero}</td>
                                <td>${info.organizacion_aero}</td>
                                <td><button class='btn btn-warning btnEditar'>Editar</button>
                                <button class='btn btn-danger btnEliminar'>Eliminar</button></td>`;
                document.getElementById("table").querySelector("tbody").append(tr);
                tr.querySelector('.btnEditar').addEventListener('click', fetchAeropuerto);
                tr.querySelector('.btnEliminar').addEventListener('click', deleteAeropuerto);
              } else {
                let tr = document.querySelector(`tr[data-id="${id}"]`);
                let cols = tr.querySelectorAll("td");
                cols[1].textContent = info.nombre_aero;
                cols[2].textContent = info.ciudad_aero;
                cols[3].textContent = info.capacidad_aero;
                cols[4].textContent = info.organizacion_aero;
              }
              myModal.hide();
            }).catch((error) => {
              console.error('Error al guardar el aeropuerto:', error);
            });
        } else {
          alert('Por favor, complete todos los campos.');
        }
      });
    document.querySelectorAll('.btnEditar').forEach(button => {
      button.addEventListener('click', fetchAeropuerto);
    });

    document.querySelectorAll('.btnEliminar').forEach(button => {
      button.addEventListener('click', deleteAeropuerto);
    });
  </script>
</body>

</html>