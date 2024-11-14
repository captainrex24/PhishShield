<?php

function summary_card($title, $count, $icon)
{
?>
    <div class="card bg-primary-50 radius-0">
        <div class="card-content">
            <div class="card-body text-center">
                <h3 class="display-6"><?php echo number_format($count) ?></h3>
                <small class="text-uppercase text-white"><?php echo $title ?></small>
            </div>
        </div>
    </div>
<?php
}
