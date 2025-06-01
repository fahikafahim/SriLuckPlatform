<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar Component -->
        <x-sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 p-6 bg-gray-50 overflow-auto">
            <!-- Header with Title and Button -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Product Management</h1>

                <!-- Button to Show Product Creation Form - moved to right -->
                <button id="showFormBtn"
                    class="flex items-center bg-navy-800 hover:bg-navy-900 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 hover:shadow-md">
                    <i class="fas fa-plus-circle mr-2"></i>Add New Product
                </button>
            </div>

            <!-- Product Creation / Editing Form Popup (Initially Hidden) -->
            <div id="productFormOverlay"
                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
                <div id="productFormContainer"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 id="formTitle" class="text-xl font-bold text-gray-800">Add New Product</h2>
                            <button id="closeFormBtn" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form id="productForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="productId">

                            <!-- Form Fields for Product Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product
                                        Name</label>
                                    <input type="text" id="name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy-500 focus:border-navy-500 transition-all">
                                </div>
                                <div>
                                    <label for="price"
                                        class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                    <input type="number" step="0.01" id="price"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy-500 focus:border-navy-500 transition-all">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea id="description" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy-500 focus:border-navy-500 transition-all"></textarea>
                                </div>
                                <div>
                                    <label for="color"
                                        class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                                    <input type="text" id="color"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy-500 focus:border-navy-500 transition-all">
                                </div>
                                <div>
                                    <label for="size"
                                        class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                                    <input type="text" id="size"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy-500 focus:border-navy-500 transition-all">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="edit-image" class="block text-sm font-medium text-gray-700 mb-1">Product
                                        Image</label>
                                    <div class="flex items-center space-x-4">
                                        <div class="relative flex-1">
                                            <input type="file" id="edit-image" name="image" accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            <div
                                                class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                                <span class="text-sm text-gray-700">Choose file</span>
                                            </div>
                                        </div>
                                        <span id="file-name" class="text-sm text-gray-500 truncate flex-1">No file
                                            chosen</span>
                                    </div>
                                    <small class="text-gray-500">Max file size: 2MB (JPEG, PNG, JPG, GIF)</small>

                                    <!-- Preview Container for Current or New Image -->
                                    <div id="current-image-container" class="mt-4">
                                        <p class="text-sm text-gray-600 mb-2">Image Preview:</p>
                                        <div
                                            class="w-32 h-32 border border-gray-200 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                                            <img id="current-image-preview" src="#" alt="Preview"
                                                class="w-full h-full object-cover hidden">
                                            <p id="no-current-image" class="text-gray-400 text-sm">No image selected</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Action Buttons -->
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" id="cancelFormBtn"
                                    class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 text-sm font-medium text-white bg-navy-600 hover:bg-navy-700 rounded-lg transition-colors focus:ring-2 focus:ring-navy-500 focus:ring-offset-2">
                                    Save Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table Displaying List of Products -->
            <div class="bg-white rounded-lg shadow border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-navy-900">
                            <tr>
                                <!-- Table Headers -->
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Color</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Size</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productsTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Product rows will be populated here dynamically via JS -->
                        </tbody>
                    </table>
                    <p id="no-products-message" class="text-gray-500 text-center py-4 hidden">No products found.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .bg-navy-50 {
        background-color: #f0f4f8;
    }

    .bg-navy-100 {
        background-color: #d9e2ec;
    }

    .bg-navy-200 {
        background-color: #bcccdc;
    }

    .bg-navy-300 {
        background-color: #9fb3c8;
    }

    .bg-navy-400 {
        background-color: #829ab1;
    }

    .bg-navy-500 {
        background-color: #627d98;
    }

    .bg-navy-600 {
        background-color: #486581;
    }

    .bg-navy-700 {
        background-color: #334e68;
    }

    .bg-navy-800 {
        background-color: #243b53;
    }

    .bg-navy-900 {
        background-color: #102a43;
    }

    .text-navy-500 {
        color: #627d98;
    }

    .text-navy-600 {
        color: #486581;
    }

    .text-navy-700 {
        color: #334e68;
    }

    .text-navy-800 {
        color: #243b53;
    }

    .text-navy-900 {
        color: #102a43;
    }

    .border-navy-500 {
        border-color: #627d98;
    }

    .focus\:ring-navy-500:focus {
        --tw-ring-color: #627d98;
    }

    .focus\:border-navy-500:focus {
        border-color: #627d98;
    }

    .hover\:bg-navy-700:hover {
        background-color: #334e68;
    }

    .hover\:bg-navy-800:hover {
        background-color: #243b53;
    }

    .hover\:bg-navy-900:hover {
        background-color: #102a43;
    }

    .bg-navy-600 {
        background-color: #486581;
    }

    /* Animation for the add button */
    #showFormBtn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Improved table styling */
    table {
        border-collapse: separate;
        border-spacing: 0;
    }

    th {
        position: sticky;
        top: 0;
    }

    tr:last-child td {
        border-bottom: 0;
    }
</style>

<script>
    // API URL and token for product management
    const API_URL = '/api/products'; // API endpoint for product CRUD operations
    const token = "2|mYfExj17m9OAbetA4aJgDMNEWLBQ3OOur84RS3vr2c2c0fd6"; // Authentication token for API access

    /* This script handel cookie but it's not working properly
     * It is commented out because it is not needed for the current implementation.
     * The token is hardcoded for simplicity, but in a real application, should handle authentication securely.
     */

    // const API_URL = '/api/products';
    //     // Function to get cookie by name
    // function getCookie(name) {
    //     const value = `; ${document.cookie}`;
    //     const parts = value.split(`; ${name}=`);
    //     if (parts.length === 2) return parts.pop().split(';').shift();
    // }

    // // Try to get token from cookie first, fall back to session if not set
    // let token = getCookie('admin_token') || "{{ session('admin_api_token') }}";

    // // If we got the token from session but not cookie, set it as a cookie
    // if ("{{ session('admin_api_token') }}" && !getCookie('admin_token')) {
    //     document.cookie = `admin_token=${"{{ session('admin_api_token') }}"}; path=/; max-age=${60 * 60 * 24 * 30}`; // 30 days expiration
    //     token = "{{ session('admin_api_token') }}";
    // }
    // DOM Elements
    const showFormBtn = document.getElementById('showFormBtn');
    const productFormOverlay = document.getElementById('productFormOverlay');
    const productFormContainer = document.getElementById('productFormContainer');
    const productForm = document.getElementById('productForm');
    const cancelFormBtn = document.getElementById('cancelFormBtn');
    const closeFormBtn = document.getElementById('closeFormBtn');
    const productsTableBody = document.getElementById('productsTableBody');
    const imageInput = document.getElementById('edit-image');
    const imagePreview = document.getElementById('current-image-preview');
    const noImageText = document.getElementById('no-current-image');
    const fileNameDisplay = document.getElementById('file-name');
    const formTitle = document.getElementById('formTitle');

    /*
     * Show the product form for creating a new product
     * Resets form fields and hides the image preview placeholder
     */
    showFormBtn.addEventListener('click', () => {
        productForm.reset();
        document.getElementById('productId').value = ''; // Clear hidden product ID
        imagePreview.src = '#';
        imagePreview.style.display = 'none'; // Hide image preview
        noImageText.style.display = 'block'; // Show 'No image' text
        fileNameDisplay.textContent = 'No file chosen';
        formTitle.textContent = 'Add New Product';
        productFormOverlay.style.display = 'flex';
    });

    /*
     * Close/Cancel button hides the product form without saving changes
     */
    function closeForm() {
        productFormOverlay.style.display = 'none';
    }

    cancelFormBtn.addEventListener('click', closeForm);
    closeFormBtn.addEventListener('click', closeForm);

    /*
     * Image preview: shows selected image thumbnail immediately after user selects a file
     */
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            fileNameDisplay.textContent = file.name;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    noImageText.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                noImageText.style.display = 'block';
            }
        } else {
            fileNameDisplay.textContent = 'No file chosen';
            imagePreview.style.display = 'none';
            noImageText.style.display = 'block';
        }
    });

    /*
     * On page load, fetch and display existing products from API
     */
    document.addEventListener('DOMContentLoaded', fetchProducts);

    async function fetchProducts() {
        try {
            const response = await fetch(API_URL, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to fetch products');

            const products = await response.json();
            renderProducts(products.data || products);
        } catch (error) {
            console.error('Error:', error);
            alert('Error fetching products');
        }
    }


    /*
     * Render product list in the table dynamically
     */
    function renderProducts(products) {
        productsTableBody.innerHTML = '';

        if (!products || !products.length) {
            document.getElementById('no-products-message').classList.remove('hidden');
            return;
        }

        document.getElementById('no-products-message').classList.add('hidden');

        products.forEach(product => {
            // Ensure consistent image URL formatting
            let imageUrl = product.image_url;
            if (imageUrl) {
                if (!imageUrl.startsWith('http') && !imageUrl.startsWith('/storage')) {
                    imageUrl = '/storage/' + imageUrl;
                }
                // Remove any duplicate storage prefixes
                imageUrl = imageUrl.replace(/^\/storage\/storage\//, '/storage/');
            }

            const row = document.createElement('tr');
            row.className = 'hover:bg-navy-50 transition-colors';
            row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${product.id}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${product.name}</td>
            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">${product.description || '-'}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                ${imageUrl ? `<img src="${imageUrl}" alt="${product.name}" class="w-16 h-16 object-cover rounded-md" onerror="this.onerror=null;this.parentElement.innerHTML='No image';">` : 'No image'}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rs. ${parseFloat(product.price).toFixed(2)}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${product.color || '-'}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${product.size || '-'}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                    <button onclick="editProduct(${product.id})"
                            class="text-navy-600 hover:text-navy-900 p-2 rounded-md hover:bg-navy-100 transition-colors"
                            title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteProduct(${product.id})"
                            class="text-red-600 hover:text-red-900 p-2 rounded-md hover:bg-red-100 transition-colors"
                            title="Delete">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        `;
            productsTableBody.appendChild(row);
        });
    }

    /*
     * Handle form submission for creating or updating a product
     */
    productForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData();
        const id = document.getElementById('productId').value;

        formData.append('name', document.getElementById('name').value);
        formData.append('price', document.getElementById('price').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('color', document.getElementById('color').value);
        formData.append('size', document.getElementById('size').value);

        if (imageInput.files[0]) {
            formData.append('image', imageInput.files[0]);
        }

        let url = API_URL;
        let method = 'POST';

        if (id) {
            url = `${API_URL}/${id}`;
            formData.append('_method', 'PUT');
        }

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Failed to save product');
            }

            closeForm();
            fetchProducts();
        } catch (error) {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        }
    });

    /*
     * Load existing product data into form for editing
     */
    async function editProduct(id) {
        try {
            const response = await fetch(`${API_URL}/${id}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to fetch product');
            }

            const product = await response.json();
            const productData = product.data || product; // Handle both wrapped and unwrapped responses

            // Populate form fields
            document.getElementById('productId').value = productData.id;
            document.getElementById('name').value = productData.name || '';
            document.getElementById('price').value = productData.price || '';
            document.getElementById('description').value = productData.description || '';
            document.getElementById('color').value = productData.color || '';
            document.getElementById('size').value = productData.size || '';

            // Update form title
            formTitle.textContent = 'Edit Product';

            // Handle image preview
            if (productData.image_url) {
                imagePreview.src = productData.image_url;
                imagePreview.style.display = 'block';
                noImageText.style.display = 'none';
                fileNameDisplay.textContent = 'Current image';
            } else {
                imagePreview.style.display = 'none';
                noImageText.style.display = 'block';
                fileNameDisplay.textContent = 'No file chosen';
            }

            // Clear file input
            imageInput.value = '';

            productFormOverlay.style.display = 'flex';
        } catch (error) {
            console.error('Error:', error);
            alert('Error loading product: ' + error.message);
        }
    }

    /*
     * Delete product after confirmation
     */
    async function deleteProduct(id) {
        if (!confirm('Are you sure you want to delete this product?')) return;

        try {
            const response = await fetch(`${API_URL}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to delete product');
            }

            fetchProducts();
        } catch (error) {
            console.error('Error:', error);
            alert('Error deleting product: ' + error.message);
        }
    }
</script>
