<?php
// the try/catch for these actions is in the caller, index.php

function get_sizes($db) {
    $query = 'SELECT id, size FROM menu_sizes';
    $statement = $db->prepare($query);
    $statement->execute();
    $sizes = $statement->fetchAll();
    return $sizes;    
}
