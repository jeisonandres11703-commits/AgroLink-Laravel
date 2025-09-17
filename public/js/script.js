// Función para crear una nueva tarjeta
function crearTarjeta(titulo, ubicacion, descripcion) {
    const nuevaTarjeta = `
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-body view-mode">
              <h5 class="card-title">${titulo}</h5>
              <p class="card-text"><strong>Ubicación:</strong> ${ubicacion}</p>
              <p class="card-text"><strong>Descripción:</strong> ${descripcion}</p>
              <div class="d-flex gap-2">
                <button class="btn btn-success edit-btn">Editar Servicio</button>
                <button class="btn btn-danger delete-btn">Eliminar</button>
              </div>
            </div>
            <div class="card-body edit-mode">
              <form class="edit-form">
                <div class="mb-3">
                  <input type="text" class="form-control" value="${titulo}" required>
                </div>
                <div class="mb-3">
                  <input type="text" class="form-control" value="${ubicacion}" required>
                </div>
                <div class="mb-3">
                  <textarea class="form-control" rows="3" required>${descripcion}</textarea>
                </div>
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      `;

    document.getElementById('contenedor-tarjetas').insertAdjacentHTML('beforeend', nuevaTarjeta);
    asignarEventosATarjeta(document.getElementById('contenedor-tarjetas').lastElementChild);
}

// Función para asignar eventos a una tarjeta
function asignarEventosATarjeta(tarjeta) {
    // Editar
    tarjeta.querySelector('.edit-btn')?.addEventListener('click', (e) => {
        const card = e.target.closest('.card');
        card.querySelector('.view-mode').style.display = 'none';
        card.querySelector('.edit-mode').style.display = 'block';
    });

    // Cancelar edición
    tarjeta.querySelector('.cancel-btn')?.addEventListener('click', (e) => {
        const card = e.target.closest('.card');
        card.querySelector('.edit-mode').style.display = 'none';
        card.querySelector('.view-mode').style.display = 'block';
    });

    // Guardar cambios
    tarjeta.querySelector('.edit-form')?.addEventListener('submit', (e) => {
        e.preventDefault();
        const card = e.target.closest('.card');
        const inputs = e.target.querySelectorAll('input, textarea');

        card.querySelector('.card-title').textContent = inputs[0].value;
        card.querySelectorAll('.card-text')[0].innerHTML = `<strong>Ubicación:</strong> ${inputs[1].value}`;
        card.querySelectorAll('.card-text')[1].innerHTML = `<strong>Descripción:</strong> ${inputs[2].value}`;

        card.querySelector('.edit-mode').style.display = 'none';
        card.querySelector('.view-mode').style.display = 'block';
    });

    // Eliminar tarjeta
    tarjeta.querySelector('.delete-btn')?.addEventListener('click', (e) => {
        if (confirm('¿Estás seguro de eliminar este servicio?')) {
            e.target.closest('.col-md-6').remove();
        }
    });
}

// Evento para el formulario de publicación
document.getElementById('formPublicar').addEventListener('submit', (e) => {
    e.preventDefault();
    const titulo = e.target.querySelector('input[placeholder="Título del servicio"]').value;
    const ubicacion = e.target.querySelector('input[placeholder="Ubicación"]').value;
    const descripcion = e.target.querySelector('textarea').value;

    if (titulo && ubicacion && descripcion) {
        crearTarjeta(titulo, ubicacion, descripcion);
        e.target.reset();
    } else {
        alert('Por favor completa todos los campos requeridos.');
    }
});

// Asignar eventos a las tarjetas existentes al cargar la página
document.querySelectorAll('.col-md-6').forEach(tarjeta => {
    asignarEventosATarjeta(tarjeta);
});





