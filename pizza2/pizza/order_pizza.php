<?php include '../view/header.php'; ?>

<main>
    <section>
    <h1>Welcome to the Pizza Shop</h1>
    <h2><?php echo $display_error?></h2>
    
    <form  action="index.php" method="post">
        <input type="hidden" name="action" value="add_order">
        <h3>Pizza Size:</h3>
        <?php foreach ($sizes as $size) : ?>
            <input type="radio" name="pizza_size"  value="<?php echo $size['size']; ?>" required="required">
            <label><?php echo $size['size']; ?> </label>
        <?php endforeach; ?><br>

        <h3>Toppings:</h3>
        <?php foreach ($toppings as $topping) : ?>
            <input type="checkbox" name="pizza_topping[]"  value="<?php echo $topping['id']; ?>" >
            <label><?php echo $topping['topping']; ?> </label><br>
        <?php endforeach;?> <br>
        
        <label>Username:</label>
        <select name="user_id" required="required">
                      <?php foreach ($users as $user) : ?>
                    <option   <?php
                    if ($user_id == $user['id']) {
                        echo 'selected = "selected"';
                    }
                    ?> 
                        value="<?php echo $user['id']; ?>" > <?php echo $user['username']; ?>
                    </option>
                <?php endforeach; ?> 
            </select>
        </select><br><br>
        
        <label>Quantity:</label> <input type='number' name="n" min="1" max="1000" value="1"><br><br>
        
        <input type="submit" value="Order Pizza" /> <br><br>
    </form>
    </section>
</main>
<?php include '../view/footer.php';
