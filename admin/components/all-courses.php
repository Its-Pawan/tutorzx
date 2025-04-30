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

    .date-custom {
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



function courseCard($title, $description, $price, $image, $date, $brochure)
{
    $words = explode(" ", $description);
    if (count($words) > 50) {
        $description = implode(" ", array_slice($words, 0, 50)) . "...";
    }

    // Optional fallback if $description is empty
    if (empty($description)) {
        $description = 'No description available';
    }
    $date = strlen($date) > 0 ? "<span class='date bg-success text-white px-3 py-1 rounded-pill date-custom'>$date</span>" : '';
    $overPrice = $price + rand(99, 999);
    return '
        <div class="col-md-4 d-flex">
            <div class="card product-card border-0 rounded-4 h-100">
                <div class="position-relative">
                    ' . $date . '
                    <div class="overflow-hidden">
                        <img src="' . $image . '" class="card-img-top product-image" alt="Product Image">
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title mb-3 fw-bold">' . $title . '</h5>
                    <p class="card-text text-muted mb-4 ">' . $description . '</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted me-2 text-decoration-line-through">&#8377;' . $overPrice . '</span>
                            <span class="price">&#8377;' . $price . '</span>
                        </div>
                        <a href=' . $brochure . ' download class="btn btn-custom text-white px-4 py-2 rounded-pill">
    Know Brochure <i class="fa-solid fa-download"></i>
</a>
                    </div>
                </div>
            </div>
        </div>
    ';
}

$sql = "SELECT * FROM `courses`";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['created_at'] ?? '';
    $date = substr($date, 0, 10);
    echo courseCard($row['title'], $row['description'], $row['price'], $row['image'], $date, $row['brochure']);
}

?>