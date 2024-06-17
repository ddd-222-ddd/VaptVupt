let total = 0;

    function showContent(section) {
      const sections = document.querySelectorAll('.content');
      sections.forEach((sec) => sec.style.display = 'none');
      document.getElementById(section).style.display = 'block';
    }

    function adjustQuantity(id, increment, price) {
      const quantityElement = document.getElementById(`quantity-${id}`);
      let quantity = parseInt(quantityElement.textContent);
      quantity += increment;
      if (quantity < 0) quantity = 0;
      quantityElement.textContent = quantity;

      total += increment * price;
      if (total < 0) total = 0;
      document.getElementById('total-value').textContent = `Total: R$${total.toFixed(2)}`;

    }