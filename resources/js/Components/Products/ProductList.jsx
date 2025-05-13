import React, { useState, useEffect } from "react";
import axios from "axios";

export default function ProductList() {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Fetch products from Laravel API
        axios
            .get("/api/products")
            .then((response) => {
                setProducts(response.data);
                setLoading(false);
            })
            .catch((error) => {
                console.error("Error loading products:", error);
                setLoading(false);
            });
    }, []);

    if (loading) return <div>Loading...</div>;

    return (
        <div className="mt-6">
            <h2 className="text-xl font-bold">Products</h2>
            <div className="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {products.map((product) => (
                    <div key={product.id} className="border p-4 rounded">
                        <h3 className="font-bold">{product.name}</h3>
                        <p>{product.description}</p>
                        <p className="text-sm text-gray-500">
                            {product.category
                                ? product.category.name
                                : "No category"}
                        </p>
                    </div>
                ))}
            </div>
        </div>
    );
}
