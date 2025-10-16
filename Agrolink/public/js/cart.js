function addToCart(productId, quantity = 1) {
    console.log('Intentando agregar al carrito:', { productId, quantity });
    fetch(`/cart/add-with-quantity/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ quantity })
    })
    .then(response => {
        console.log('Respuesta fetch:', response);
        return response.json();
    })
    .then(data => {
        console.log('Datos recibidos:', data);
        alert(data.message);
        // Actualiza el contador del carrito flotante
        if (typeof data.cart_count !== 'undefined') {
            const cartFloatCount = document.getElementById('cart-float-count');
            if (cartFloatCount) {
                cartFloatCount.textContent = data.cart_count;
            }
        }
        // Opcional: redirigir después de un tiempo
        setTimeout(() => {
            window.location.href = '/cart';
        }, 1000);
    })
    .catch(error => {
        console.error('Error al agregar al carrito:', error);
        showToast('Hubo un problema al agregar el producto.');
    });
}