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
function courseCard($title, $description, $price, $image, $badge, $badge_class)
{
    $badge = strlen($badge) > 0 ? "<span class='badge $badge_class badge-custom'>$badge</span>" : '';
    $overPrice = $price + rand(99, 999);
    return '
        <div class="col-md-4 d-flex">
            <div class="card product-card border-0 rounded-4 h-100">
                <div class="position-relative">
                    ' . $badge . '
                    <div class="overflow-hidden">
                        <img src="' . $image . '" class="card-img-top product-image" alt="Product Image">
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title mb-3 fw-bold">' . $title . '</h5>
                    <p class="card-text text-muted mb-4">' . $description . '</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted me-2 text-decoration-line-through">&#8377;' . $overPrice . '</span>
                            <span class="price">&#8377;' . $price . '</span>
                        </div>
                        <button class="btn btn-custom text-white px-4 py-2 rounded-pill">
                            Learn More <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    ';
}
