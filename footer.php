<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateCartDropdown() {
        fetch('cart_items.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('cartDropdownMenu').innerHTML = data;
                updateCartItemCount();
                attachRemoveButtons();
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

    function attachRemoveButtons() {
        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                fetch('remove_from_cart.php?id_produk=' + encodeURIComponent(productId), {
                    method: 'GET'
                })
                .then(response => response.text())
                .then(() => {
                    updateCartDropdown(); 
                })
                .catch(error => console.error('Error:', error));
            });
        });
    }

    updateCartDropdown(); 
});

$(document).ready(function(){
    $('.product-carousel').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});
</script>
</body>
</html>
