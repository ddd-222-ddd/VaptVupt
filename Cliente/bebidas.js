function adjustQuantity(id, amount) {
    var quantityElement = document.getElementById('quantity-' + id);
    var inputElement = document.getElementById('input-' + id);
    var quantity = parseInt(quantityElement.textContent) + amount;
    if (quantity < 0) quantity = 0;
    quantityElement.textContent = quantity;
    inputElement.value = quantity;
}

function addToCart(name, price) {
    var quantity = document.getElementById('input-' + 'comida' + name).value;
    if (quantity > 0) {
        alert(name + ' adicionado ao carrinho por R$ ' + (price * quantity).toFixed(2));
        document.forms["menu-form"].submit(); // Submeter o formulário
    } else {
        alert("Selecione uma quantidade maior que zero.");
    }
}