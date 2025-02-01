<script>
// ...existing code...

// تحميل المنتجات من السيرفر
async function loadProducts() {
    try {
        const response = await fetch('/api/products.php');
        const products = await response.json();
        localStorage.setItem('products', JSON.stringify(products));
        updateProductsList();
    } catch (error) {
        console.error('Error loading products:', error);
    }
}

// تعديل دالة حفظ المنتج
async function saveProduct(productData) {
    try {
        const response = await fetch('/api/products.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(productData)
        });
        await loadProducts(); // إعادة تحميل المنتجات
        return true;
    } catch (error) {
        console.error('Error saving product:', error);
        return false;
    }
}

// تعديل دالة حذف المنتج
async function deleteProduct(id) {
    if (confirm('هل أنت متأكد من حذف هذا المنتج؟')) {
        try {
            await fetch(`/api/products.php?id=${id}`, {
                method: 'DELETE'
            });
            await loadProducts(); // إعادة تحميل المنتجات
        } catch (error) {
            console.error('Error deleting product:', error);
        }
    }
}

// تحميل المنتجات عند بدء التطبيق
document.addEventListener('DOMContentLoaded', loadProducts);
</script>
