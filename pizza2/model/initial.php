<?php

// reestablish initial database contents
// Don't change this, or put it back this way for delivery

// Turns out that putting multiple commands in one big string hides
// which action causes an error, so this is better coding

function initial_db($db) {
    db_command($db, 'delete from order_topping;');
    db_command($db, 'delete from pizza_orders;');
    db_command($db, 'delete from menu_sizes;');
    db_command($db, 'delete from menu_toppings;');
    db_command($db, 'delete from shop_users;');
    db_command($db, 'delete from pizza_sys_tab;');
    db_command($db, 'insert into pizza_sys_tab values (1);');
    db_command($db, "insert into menu_toppings values (1,'Pepperoni');");
    db_command($db, "insert into menu_sizes values (1,'Small');");
    db_command($db, "insert into menu_sizes values (2,'Large');");
    db_command($db, "insert into shop_users values (1,'joe', 6);");
    db_command($db, "insert into shop_users values (2,'sue', 3);");
    db_command($db, 'delete from undelivered_orders;');
    db_command($db, 'delete from inventory;');
    db_command($db, "insert into inventory values (11,'flour', 100);");
    db_command($db, "insert into inventory values (12,'cheese', 100);");
}

function db_command($db, $command) {
    $statement = $db->prepare($command);
    $statement->execute();
}
