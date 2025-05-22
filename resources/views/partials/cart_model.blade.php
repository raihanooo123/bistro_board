<!-- Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addToCartForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Add to Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="item_id" id="item_id">

                    <div class="mb-3">
                        <label for="price" class="form-label">Price (USD)</label>
                        <input type="text" class="form-control" id="price" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="item_name" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="item_description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="item_description" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="size" class="form-label">Select Size</label>
                        <select class="form-select" id="size" name="size">
                            <option value="">Select size</option>
                            <option value="small">Small</option>
                            <option value="medium">Medium</option>
                            <option value="large">Large</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="crust" class="form-label">Select Crust</label>
                        <select class="form-select" id="crust" name="crust">
                            <option value="">Select crust</option>
                            <option value="thin">Thin</option>
                            <option value="thick">Thick</option>
                            <option value="stuffed">Stuffed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add to Cart</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>






<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalElement = document.getElementById('cartModal');
    const modal = new bootstrap.Modal(modalElement);
    let currentUnitPrice = 0;

    const itemIdInput = document.getElementById('item_id');
    const itemNameInput = document.getElementById('item_name');
    const itemDescriptionInput = document.getElementById('item_description');
    const priceInput = document.getElementById('price');
    const sizeSelect = document.getElementById('size');
    const crustSelect = document.getElementById('crust');
    const quantityInput = document.getElementById('quantity');

    function updateDisplayedPrice() {
        const qty = parseInt(quantityInput.value) || 1;
        const totalPrice = qty * currentUnitPrice;
        priceInput.value = `$${totalPrice.toFixed(2)}`;
    }

    quantityInput.addEventListener('input', updateDisplayedPrice);

    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.dataset.itemId;
            const itemName = this.dataset.itemName;
            const itemDescription = this.dataset.itemDescription;
            const itemPrice = parseFloat(this.dataset.itemPrice);

            currentUnitPrice = itemPrice;
            itemIdInput.value = itemId;
            itemNameInput.value = itemName;
            itemDescriptionInput.value = itemDescription;

            sizeSelect.value = "";
            crustSelect.value = "";
            quantityInput.value = "1";

            updateDisplayedPrice();
            modal.show();
        });
    });

    document.getElementById('addToCartForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = {
            item_id: itemIdInput.value,
            size: sizeSelect.value,
            crust: crustSelect.value,
            quantity: quantityInput.value,
            unit_price: currentUnitPrice,
        };

        // 🔍 DEBUG: Log the form data before sending
        console.log('Collected formData before sending:', formData);

        fetch("{{ route('cart.add') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(formData)
        })
        .then(async response => {
            const contentType = response.headers.get('content-type');
            if (!response.ok) {
                const errorText = await response.text();
                console.error('[ERROR] Server responded with non-OK status');
                console.error('[ERROR] Raw response:', errorText);
                throw new Error('Server error');
            }
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                const text = await response.text();
                console.warn('[WARN] Server did not return JSON:', text);
                throw new Error('Unexpected response format');
            }
        })
        .then(data => {
            console.log('[SUCCESS] Item added to cart:', data);
            modal.hide();

            // Show the toast
            const toastEl = document.getElementById('cartSuccessToast');
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        })
        .catch(error => {
            console.error('[ERROR] Failed to add to cart:', error);
        });
    });
});
</script>


















<!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = new bootstrap.Modal(document.getElementById('cartModal'));

        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.dataset.itemId;
                const itemName = this.dataset.itemName;
                const itemDescription = this.dataset.itemDescription;
                const itemPrice = this.dataset.itemPrice;

                console.log('Item Clicked:', {
                    itemId,
                    itemName,
                    itemDescription,
                    itemPrice
                });

                document.getElementById('item_id').value = itemId;
                document.getElementById('item_name').value = itemName;
                document.getElementById('item_description').value = itemDescription;

                document.getElementById('price').value = itemPrice;

                // document.getElement('item_price').value = `$${parseFloat(itemPrice).toFixed(2)}`;


                console.log('the value for price is', itemPrice)
                // Reset other inputs
                document.getElementById('size').value = "";
                document.getElementById('crust').value = "";
                document.getElementById('quantity').value = "";


                modal.show();
            });
        });

        document.getElementById('addToCartForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            console.log('here is the formData', formData);
            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('here is the posted data',data);
                modal.hide();


            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script> -->


