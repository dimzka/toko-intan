document.addEventListener('DOMContentLoaded', function() {
    function updateCartDropdown() {
        fetch('cart_items.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('cartDropdownMenu').innerHTML = data;
                updateCartItemCount();
            })
            .catch(error => console.error('Error:', error));
    }

    function updateCartItemCount() {
        fetch('cart_item_count.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('cartItemCount').textContent = data;
            })
            .catch(error => console.error('Error:', error));
    }

    document.querySelectorAll('.btn-primary').forEach(button => {
        button.addEventListener('click', function() {
            setTimeout(updateCartDropdown, 500); // Delay to ensure cart is updated after the button click
        });
    });

    updateCartDropdown(); // Initial load
});
