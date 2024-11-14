<?php

include '../methods/post.php';
include './virus-total.php';

header('Content-Type: application/json');

echo getUrlReport($data['url']);
