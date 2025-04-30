<style>
    .product-card {
        transition: all 0.3s ease;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
    }

    .product-image {
        transition: all 0.5s ease;
        height: 300px;
        object-fit: cover;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .badge-custom {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
    }

    .price {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .btn-custom {
        background: linear-gradient(45deg, #ff512f, #dd2476);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: linear-gradient(45deg, #dd2476, #ff512f);
        transform: translateX(5px);
        box-shadow: -5px 5px 15px rgba(46, 204, 113, 0.3);
    }
</style>


<?php

