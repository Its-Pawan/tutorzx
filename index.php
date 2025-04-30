<?php
include "components/header.php"; 
include "components/faq.php";



$faqs = [
    [
        'question' => 'What is the duration of each tuition session?',
        'answer' => 'Each session typically lasts 1 hour. However, it may vary depending on the subject and student’s requirement.'
    ],
    [
        'question' => 'Are the classes live or pre-recorded?',
        'answer' => 'We offer live interactive classes to ensure real-time doubt solving and better engagement.'
    ],
    [
        'question' => 'Can I choose my preferred tutor?',
        'answer' => 'Yes, students can select their tutor based on availability and subject expertise.'
    ],
    [
        'question' => 'What subjects are available for online tuition?',
        'answer' => 'We provide online tuition for Mathematics, Science, English, Social Studies, and many more from Class 1 to 12.'
    ],
    [
        'question' => 'Is there a free trial class available?',
        'answer' => 'Yes, we offer one free demo class so you can experience our teaching methodology before enrolling.'
    ],
    [
        'question' => 'How do I join a class after enrollment?',
        'answer' => 'You will receive a class link and schedule via email or WhatsApp after successful enrollment.'
    ],
    [
        'question' => 'What if I miss a class?',
        'answer' => 'Recorded sessions or makeup classes can be arranged based on tutor availability.'
    ],
];  
?>

<section class="hero-section">
    <div class="">
        <div class="carousel slide carousel-fade" id="hero-slider" data-bs-ride="true" data-bs-touch="false">
            <div class="carousel-inner">
                <div class="carousel-item position-relative active">
                    <img src="<?php echo "/assets/images/h1.jpg" ?>" alt="Learning at your pace" class="d-block w-100">
                    <div
                        class="carousel-caption d-none d-md-flex bg-white text-black w-fit position-absolute justify-content-center align-items-start flex-column">
                        <h5 class="fs-2 text-danger">Learn at Your Own Pace</h5>
                        <p class="text-gray">Explore high-quality tutorials tailored just for you. Start your journey
                            now!</p>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item position-relative">
                    <img src="<?php echo "/assets/images/h2.jpg" ?>" alt="Expert tutors" class="d-block w-100">
                    <div
                        class="carousel-caption d-none d-md-flex bg-white text-black w-fit position-absolute justify-content-center align-items-start flex-column">
                        <h5 class="fs-2 text-danger">Expert Tutors, Real Results</h5>
                        <p class="text-gray">Our certified instructors help you achieve academic excellence and
                            confidence.</p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item position-relative">
                    <img src="<?php echo "/assets/images/h3.jpg" ?>" alt="Flexible learning" class="d-block w-100">
                    <div
                        class="carousel-caption d-none d-md-flex bg-white text-black w-fit position-absolute justify-content-center align-items-start flex-column">
                        <h5 class="fs-2 text-danger">Anytime, Anywhere Learning</h5>
                        <p class="text-gray">Access your classes 24/7 from any device. Learning made convenient.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#hero-slider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#hero-slider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<section class="courses">
    <div class="container py-5">
        <h1 class="text-center mb-5">Our Courses</h1>
      <?php 
        include "./components/all-courses.php"
      ?>
    </div>

</section>


<section class="why-us">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose Us</h2>
            <p class="text-muted">We bring quality learning to your fingertips with unmatched features</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="text-center bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="mb-3 fs-1 text-primary">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">Expert Tutors</h5>
                    <p class="text-muted small">Learn from experienced educators with proven teaching skills.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="text-center bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="mb-3 fs-1 text-success">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">Flexible Schedule</h5>
                    <p class="text-muted small">Attend classes when it works best for you — anytime, anywhere.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="text-center bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="mb-3 fs-1 text-warning">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">Affordable Pricing</h5>
                    <p class="text-muted small">High-quality education at student-friendly rates.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="text-center bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="mb-3 fs-1 text-danger">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">Interactive Learning</h5>
                    <p class="text-muted small">Engaging live classes, quizzes, and instant doubt clearing.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact">
    <div class="container">

        <?php
        include "components/contact.php";
        ?>
    </div>
</section>


<section class="faq">
    <t class="container py-5">
        <h1 class="text-center mb-5">Our Courses</h1>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="accordion" id="faqAccordion">
                    <?php
                    foreach ($faqs as $index => $faq) {
                        echo faqs($faq['question'], $faq['answer'], $index === 0);
                    }
                    ?>
                </div>
            </div>
        </div>
    </t>
</section>

<?php
include "components/footer.php";
?>