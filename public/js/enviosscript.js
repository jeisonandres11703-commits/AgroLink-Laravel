// script de la interfaz de envio - Versión corregida

// Funcionalidad para aceptar viajes
document.querySelectorAll('.btn-aceptar').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault(); // Prevenir envío normal del formulario
        
        const form = this.closest('form');
        const card = this.closest('.card-viaje');
        const purchaseId = form.action.split('/').pop(); // Obtener ID de la URL

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
                
                // Mostrar mensaje de éxito
                showAlert('¡Viaje aceptado correctamente!', 'success');
            } else {
                throw new Error(data.message || 'Error al aceptar el viaje');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.innerHTML = originalText;
            this.disabled = false;
            showAlert(error.message || 'Error al aceptar el viaje', 'error');
        });
    });
});

// Slider de peso
const slider = document.querySelector('.peso-slider');
const valueDisplay = document.querySelector('.valor-peso');

if (slider && valueDisplay) {
    slider.addEventListener('input', function () {
        valueDisplay.textContent = this.value + ' kg';

        // Cambia el color del badge según el valor
        const value = parseInt(this.value);
        valueDisplay.classList.remove('bg-primary', 'bg-warning', 'bg-danger');

        if (value > 10000) {
            valueDisplay.classList.add('bg-danger');
        } else if (value > 5000) {
            valueDisplay.classList.add('bg-warning');
        } else {
            valueDisplay.classList.add('bg-primary');
        }
    });
}

// Función para mostrar alertas
function showAlert(message, type = 'info') {
    // Crear o usar un sistema de alertas existente
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.prepend(alertDiv);
    
    // Auto-eliminar después de 5 segundos
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
            if (cardWeight > weight) {
                card.style.display = 'none';
            } else {
                card.style.display = 'block';
            }
        }
    });
}