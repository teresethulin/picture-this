<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$postID = $post['id'];

die(var_dump($post));

$query = sprintf('DELETE FROM post WHERE id = %d', $postID);


redirect('/');
