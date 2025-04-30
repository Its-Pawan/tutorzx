<?php
if (isset($_POST['upload_course'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instructor = $_SESSION['username'];
    $instructor_id = $_SESSION['email'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $brochure = $_FILES['brochure']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $brochure_tmp = $_FILES['brochure']['tmp_name'];


    move_uploaded_file($image_tmp, "../../images/$image");
    move_uploaded_file($brochure_tmp, "../../pdf/$brochure");

    $image = "../../images/$image";
    $brochure = "../../pdf/$brochure";

    try {
        $stmt = $conn->prepare("INSERT INTO courses (title, description, instructor, instructor_id,brochure, price, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $instructor, $instructor_id, $brochure, $price, $image]);
        echo "<script>alert('Course uploaded successfully!')</script>";
        echo "<script>window.open('index.php?view_courses','_self')</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


}
?>

<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        text-align: center;
        margin-bottom: 30px;
        color: #343a40;
    }

    .file-upload {
        position: relative;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .file-upload-input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        width: 100%;
        height: 100%;
    }

    .file-upload-label {
        display: block;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
    }

    .file-upload-label:hover {
        background-color: #e9ecef;
    }

    .preview-image {
        max-width: 200px;
        max-height: 200px;
        margin-top: 10px;
        display: none;
    }
</style>
<div class="form-container">
    <h2 class="form-title"><i class="fas fa-book-open me-2"></i>Upload New Course</h2>

    <form id="courseUploadForm" enctype="multipart/form-data" method="post">
        <!-- Course Title -->
        <div class="mb-4">
            <label for="title" class="form-label">Course Title*</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <!-- Course Description -->
        <div class="mb-4">
            <label for="description" class="form-label">Description*</label>
            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>

        <div class="row">
            <!-- Course Price -->
            <div class="col-md-6 mb-4">
                <label for="price" class="form-label">Price ($)*</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                </div>
            </div>
        </div>

        <!-- Course Image Upload -->
        <div class="mb-4">
            <label class="form-label">Course Image*</label>
            <div class="file-upload">
                <label for="image" class="file-upload-label">
                    <i class="fas fa-image me-2"></i>Choose an image file
                    <input type="file" class="file-upload-input" id="image" name="image" accept="image/*" required>
                </label>
            </div>
            <img id="imagePreview" class="preview-image img-thumbnail" alt="Image preview">
        </div>

        <!-- Course Brochure Upload -->
        <div class="mb-4">
            <label class="form-label">Course Brochure (PDF)</label>
            <div class="file-upload">
                <label for="brochure" class="file-upload-label">
                    <i class="fas fa-file-pdf me-2"></i>Choose a PDF file
                    <input type="file" class="file-upload-input" id="brochure" name="brochure" accept=".pdf">
                </label>
            </div>
        </div>

        <!-- Form Buttons -->
        <div class="d-flex justify-content-between mt-5">
            <button type="reset" class="btn btn-outline-secondary">
                <i class="fas fa-undo me-2"></i>Reset Form
            </button>
            <button type="submit" name="upload_course" class="btn btn-primary">
                <i class="fas fa-upload me-2"></i>Upload Course
            </button>
        </div>
    </form>
</div>

<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                const preview = document.getElementById('imagePreview');
                preview.src = event.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>