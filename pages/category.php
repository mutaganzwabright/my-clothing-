<?php
// Product category/filtering page
$category = $_GET['category'] ?? 'all';
?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-4xl font-bold mb-8 text-center text-slate-900">Categories</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <a href="?page=shop" class="bg-white p-6 rounded-lg shadow-md border-2 border-blue-600 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-4">👕</div>
            <h3 class="font-semibold text-slate-900">All Products</h3>
        </a>
        <a href="?page=shop&search=shirt" class="bg-white p-6 rounded-lg shadow-md border-2 border-slate-200 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-4">👔</div>
            <h3 class="font-semibold text-slate-900">Shirts & Tops</h3>
        </a>
        <a href="?page=shop&search=pants" class="bg-white p-6 rounded-lg shadow-md border-2 border-slate-200 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-4">👖</div>
            <h3 class="font-semibold text-slate-900">Pants & Bottoms</h3>
        </a>
        <a href="?page=shop&search=dress" class="bg-white p-6 rounded-lg shadow-md border-2 border-slate-200 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-4">👗</div>
            <h3 class="font-semibold text-slate-900">Dresses</h3>
        </a>
        <a href="?page=shop&search=shoes" class="bg-white p-6 rounded-lg shadow-md border-2 border-slate-200 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-4">👠</div>
            <h3 class="font-semibold text-slate-900">Shoes</h3>
        </a>
        <a href="?page=shop&search=jacket" class="bg-white p-6 rounded-lg shadow-md border-2 border-slate-200 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-4">🧥</div>
            <h3 class="font-semibold text-slate-900">Jackets</h3>
        </a>
        <a href="?page=shop&search=hat" class="bg-white p-6 rounded-lg shadow-md border-2 border-slate-200 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-4">🧢</div>
            <h3 class="font-semibold text-slate-900">Hats & Accessories</h3>
        </a>
        <a href="?page=shop&search=sweater" class="bg-white p-6 rounded-lg shadow-md border-2 border-slate-200 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-4">🧶</div>
            <h3 class="font-semibold text-slate-900">Sweaters</h3>
        </a>
    </div>
</div>
