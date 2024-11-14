<?php
$head = [
    'title' => 'Home',
    'route-name' => 'home',
    'style' => ['/user.css'],
    'script' => [
        '/user/script.js',
        '/user/home.js',
        // '/user/home.js',
    ],
];

include './parts/content_start.php';
include './user/get_review.php';
include './helpers/index.php';

?>

<main class="container-fluid flex-grow-1">
    <section class="text-center mx-auto" style="max-width: 768px; margin: 14% 0;">
        <h1>Protect Your Online Presence <br> with PhishShield</h1>
        <p>
            PhishShield is your first line of defense against phishing websites. Whether you're browsing for
            work or leisure, our extension safeguards your personal data by detecting and <br>blocking malicious
            websites in real-time.
        </p>
        <div>
            <a href="<?php echo isset($_SESSION['ps_user_id']) ? $host . '/download/PhishShield.zip' : $host . '/login.php' ?>" class="primary-button">
                Download Now
            </a>
        </div>
    </section>


    <!-- Search -->
    <section class="mx-auto" style="max-width: 1024px; margin: 25% 0;">
        <h2>Phishing Detection</h2>
        <form id="scannerForm" class="my-4 d-flex gap-3" action="<?php echo $host . '/user/scan_website.php' ?>" method='POST'>
            <div class="flex-grow-1">
                <label for="search" class="form-label d-none">Scan</label>
                <input type="search" class="w-100" id="search" name="search"
                    placeholder="http://www.example.com">
                <div id="response" style="display: none;">The Link is Safe!</div>
            </div>
            <div class="flex-shrink-0">
                <!-- Submit Button -->
                <button type="submit" class="primary-button" disabled>
                    Detect
                </button>
            </div>
        </form>
    </section>


    <!-- Reviews -->
    <section class="mx-auto" style="max-width: 1024px; margin-bottom: 5%;">
        <h2>Browser Users Feedbacks and Ratings</h2>

        <!-- Reviews Carousel -->
        <div class="my-4">
            <div class="reviews swiper">
                <div class="swiper-wrapper mb-5">
                    <?php

                    foreach ($review_list as $key => $value) {
                        $stars = '';

                        for ($i = 0; $i < 5; $i++) {
                            if ($i < $value['rating']) {
                                $stars .= '&#9733;';
                            } else {
                                $stars .= '&#9734;';
                            }
                        }
                    ?>
                        <div class="swiper-slide p-3 mb-2">
                            <div class="d-flex">
                                <img src="<?php echo $host . '/uploads/' . ($value['profile'] ?: 'user.png') ?>" alt="Profile" width="50" height="50"
                                    class="rounded-circle me-2 object-fit-cover">
                                <div class="ms-3">
                                    <h6 class="mb-0"><?php echo $value['display_name'] ?></h6>

                                    <p class="mt-3 mb-1"><?php echo $value['message'] ?></p>

                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="review-stars">
                                    <div><?php echo $stars ?></div>
                                </span>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <?php if (isset($_SESSION['ps_user_id'])) { ?>
                    <button class="primary-button" style="float: right;">
                        Write a review
                    </button>
                <?php } else { ?>
                    <a href="<?php echo $host . '/login.php' ?>" class="primary-button" style="float: right;">
                        Write a review
                    </a>
                <?php } ?>
            </div>
        </div>


        <?php if (isset($_SESSION['ps_user_id'])) { ?>
            <div class="row" id="write_review_form_container">
                <div class="col">
                    <div class="py-4">
                        <h2 class="mb-3">Write a Review</h2>
                        <form id="reviewForm" class="mb-4" action="<?php echo $host . '/user/add_review.php' ?>" method='POST'>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['ps_account_id'] ?>">

                            <!-- Rating Input (Stars) -->
                            <div class="mb-3">
                                <label for="rating" class="form-label d-none">Your Rating <span class="text-danger">*</span></label>
                                <div id="rating" class="d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input d-none" type="radio" name="rating" id="rating1"
                                            value="1">
                                        <label class="form-check-label" for="rating1">
                                            <span class="star-filled d-none">&#9733;</span>
                                            <span class="star-outline d-none">&#9734;</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input d-none" type="radio" name="rating" id="rating2"
                                            value="2">
                                        <label class="form-check-label" for="rating2">
                                            <span class="star-filled d-none">&#9733;</span>
                                            <span class="star-outline d-none">&#9734;</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input d-none" type="radio" name="rating" id="rating3"
                                            value="3">
                                        <label class="form-check-label" for="rating3">
                                            <span class="star-filled d-none">&#9733;</span>
                                            <span class="star-outline d-none">&#9734;</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input d-none" type="radio" name="rating" id="rating4"
                                            value="4">
                                        <label class="form-check-label" for="rating4">
                                            <span class="star-filled d-none">&#9733;</span>
                                            <span class="star-outline d-none">&#9734;</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input d-none" type="radio" name="rating" id="rating5"
                                            value="5">
                                        <label class="form-check-label" for="rating5">
                                            <span class="star-filled d-none">&#9733;</span>
                                            <span class="star-outline d-none">&#9734;</span>
                                        </label>
                                    </div>
                                </div>
                                <small class="error-message text-danger"></small>
                            </div>

                            <!-- Review Textarea -->
                            <div class="mb-3">
                                <label for="review" class="form-label d-none">Your Review <span class="text-danger">*</span></label>
                                <textarea id="review" class="w-100" rows="4"
                                    placeholder="Write your review here..."></textarea>
                                <small class="error-message text-danger"></small>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="primary-button">Submit Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>

</main>

<?php
include './parts/content_end.php';
