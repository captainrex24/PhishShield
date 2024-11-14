<?php include '../parts/content_start.php'; ?>

<main>
    <form id="scanner-form" class="form" method="post" accept="#">

        <div class="logo-wrapper">
            <img src="../assets/logo.png" alt="Logo" class="logo">
        </div>

        <!-- Search -->
        <div class="scanner-input">
            <label for="search" class="hide">Search</label>
            <input type="search" id="search" name="search" class="w-100" placeholder="Scan here">

            <button type="submit" class="btn primary-btn w-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Scan
            </button>
        </div>
    </form>
</main>

<?php
include '../parts/content_end.php';
