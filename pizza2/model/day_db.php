<?php


function get_current_day($db) {
    $query = 'SELECT * FROM pizza_sys_tab';    
    $statement = $db->prepare($query);
    $statement->execute();    
    $currentday = $statement->fetch();
    $statement->closeCursor();    
    $current_day = $currentday['current_day'];
    return $current_day;
}

function increment_day($db){
    $query = 'UPDATE pizza_sys_tab SET current_day=current_day + 1';    
    $statement = $db->prepare($query);
    $statement->execute();    
    $statement->closeCursor();    
}

function finish_orders_for_day($db, $day) {
    $query = 'UPDATE pizza_orders SET status=\'Finished\' WHERE day=:current_day';
    $statement = $db->prepare($query);
    $statement->bindValue(':current_day',$day);
    $statement->execute();
    $statement->closeCursor(); 
}

