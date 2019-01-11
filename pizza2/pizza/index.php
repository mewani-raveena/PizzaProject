<?php

require('../util/main.php');
require('../model/database.php');
require('../model/order_db.php');
require('../model/topping_db.php');
require('../model/size_db.php');
require('../model/day_db.php');
require('../model/user_db.php');
require('../model/inventory_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'student_welcome';
    }
}
$user_id = filter_input(INPUT_POST,'user_id',FILTER_VALIDATE_INT);
if ($user_id == NULL) {
    $user_id = filter_input(INPUT_GET, 'user_id');
    }
$username = get_username($db, $user_id);
$users = get_users($db);
if ($action == 'student_welcome'|| $action == 'set_user') {
    try {
        $sizes = get_sizes($db);
        $toppings = get_toppings($db);

    if (!empty($user_id)) {
    $user_preparing_orders = get_preparing_orders_by_user($db, $user_id);
    $user_baked_orders = get_baked_orders_by_user($db, $user_id);
    }
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    include('student_welcome.php');
} else if ($action == 'order_pizza') {
    try {
        $sizes = get_sizes($db);
        $toppings = get_toppings($db);
        $display_error = "";
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    include ('order_pizza.php');
} elseif ($action == 'add_order') {
    $size = filter_input(INPUT_POST, 'pizza_size');
    $n = filter_input(INPUT_POST, 'n', FILTER_VALIDATE_INT);
    error_log('seeing n = ' . $n);
    if (empty($n)) {
        $n = 1; // no input: default to old single order case
    }
    $topping_ids = filter_input(INPUT_POST, 'pizza_topping', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    if ($size == NULL || $size == FALSE || $topping_ids == NULL) {
        // string $e will be displayed as is--see errors.php
        $e = "Invalid size or topping data size =$size";
        include('../errors/error.php');
        exit();
    }
    try {
        $current_day = get_current_day($db);
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    $status = 'Preparing';
    try {
        //check inventory first and then order
        $inventory = get_inventory_details($db);
        //  echo '<pre>';
        //  print_r($inventory);
        //  echo '</pre>';
        if ($inventory[0]['quantity'] >= $n && $inventory[1]['quantity'] >= $n) {
            for ($i = 0; $i < $n; $i++) {
                add_order($db, $user_id, $size, $current_day, $status, $topping_ids);
                //decrease inverntory amount by 1 unit each
                decrease_inventory($db);
            }
        } else {
            $display_error = "Not enough inventory for $n pizzas! Try lesser quantity.";
            try {
                $sizes = get_sizes($db);
                $toppings = get_toppings($db);
            } catch (Exception $e) {
                include('../errors/error.php');
                exit();
            }
            include ('order_pizza.php');
            exit();
        }
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    header("Location: .?user_id=$user_id");
} elseif ($action == 'update_order_status') {
    try {
        update_to_finished($db, $user_id);
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    header("Location: .?user_id=$user_id");
}
?>
