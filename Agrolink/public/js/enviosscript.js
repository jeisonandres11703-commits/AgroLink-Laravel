
document.addEventListener("DOMContentLoaded", () => {
    
    // BOTÓN ACEPTAR VIAJE (AJAX)
    document.querySelectorAll('.btn-aceptar').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault(); // Prevenir envío normal del formulario

            const form = this.closest('form');
            const card = this.closest('.card-viaje');

            // Mostrar loading
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';
            this.disabled = true;

            // Enviar petición AJAX al servidor
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Actualizar interfaz
                    card.querySelector('.badge-estado').className = 'badge bg-success badge-estado mb-2';
                    card.querySelector('.badge-estado').textContent = 'Asignado';
                    this.innerHTML = '<i class="fas fa-check-circle me-2"></i>Viaje aceptado';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-secondary');

                    showAlert('¡Viaje aceptado correctamente!', 'success');
                } else {
                    throw new Error(data.message || 'Error al aceptar el viaje');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.innerHTML = originalText;
                this.disabled = false;
                showAlert(error.message || 'Error al aceptar el viaje', 'danger');
            });
        });
    });

    // ================================
    // SLIDER DE PESO + FILTRO
    // ================================
    const slider = document.querySelector('.peso-slider');
    const valueDisplay = document.querySelector('.valor-peso');

    if (slider && valueDisplay) {
        slider.addEventListener('input', function () {
            valueDisplay.textContent = this.value + ' kg';

            const value = parseInt(this.value);
            valueDisplay.classList.remove('bg-primary', 'bg-warning', 'bg-danger');

            if (value > 10000) {
                valueDisplay.classList.add('bg-danger');
            } else if (value > 5000) {
                valueDisplay.classList.add('bg-warning');
            } else {
                valueDisplay.classList.add('bg-primary');
            }

            // 🔹 Filtrar viajes automáticamente
            filterByWeight(value);
        });
    }

    // ================================
    // FILTRO POR CIUDAD (Origen/Destino)
    // ================================
    const locationInput = document.querySelector('input[name="ubicacion"]');
    if (locationInput) {
        locationInput.addEventListener('input', function () {
            const filterValue = this.value.toLowerCase();
            document.querySelectorAll('.card-viaje').forEach(card => {
                const origin = card.querySelector('.info-vendedor')?.innerText.toLowerCase() || '';
                const destination = card.querySelector('.info-cliente')?.innerText.toLowerCase() || '';

                if (origin.includes(filterValue) || destination.includes(filterValue)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});

// ================================
// FUNCIONES AUXILIARES
// ================================

// Mostrar alertas
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = "2000";
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Filtrar viajes por peso
function filterByWeight(weight) {
    document.querySelectorAll('.card-viaje').forEach(card => {
        const weightElement = card.querySelector('li:first-child');
        if (weightElement) {
            const cardWeight = parseInt(weightElement.textContent.replace('Peso: ', '').replace(' kg', ''));
            card.style.display = cardWeight > weight ? 'none' : 'block';
        }
    });
}
