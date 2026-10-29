<?php
session_start();
require 'config.php';

// Add product to cart
if (isset($_POST['pid'])) {
    $pid        = $_POST['pid'];
    $pname      = $_POST['pname'];
    $pprice     = $_POST['pprice'];
    $pimage     = $_POST['pimage'];
    $pcode      = $_POST['pcode'];
    $pqty       = $_POST['pqty'];
    $total_price = $pprice * $pqty;

    $stmt = $conn->prepare('SELECT product_code FROM cart WHERE product_code=?');
    $stmt->bind_param('s', $pcode);
    $stmt->execute();
    $res  = $stmt->get_result();
    $r    = $res->fetch_assoc();
    $code = $r['product_code'] ?? '';

    if (!$code) {
        $query = $conn->prepare('INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_code) VALUES (?,?,?,?,?,?)');
        $query->bind_param('ssssss', $pname, $pprice, $pimage, $pqty, $total_price, $pcode);
        $query->execute();
        echo '<div class="alert alert-success alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Item added to your cart!</strong>
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Item already in your cart!</strong>
              </div>';
    }
}

// Get cart item count
if (isset($_GET['cartItem']) && $_GET['cartItem'] == 'cart_item') {
    $stmt = $conn->prepare('SELECT * FROM cart');
    $stmt->execute();
    $stmt->store_result();
    echo $stmt->num_rows;
}

// Remove single item from cart
if (isset($_GET['remove'])) {
    $id   = (int) $_GET['remove'];
    $stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message']   = 'Item removed from the cart!';
    header('location: cart.php');
    exit;
}

// Clear entire cart
if (isset($_GET['clear'])) {
    $stmt = $conn->prepare('DELETE FROM cart');
    $stmt->execute();
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message']   = 'All items removed from the cart!';
    header('location: cart.php');
    exit;
}

// Update item quantity
if (isset($_POST['qty'])) {
    $qty    = (int) $_POST['qty'];
    $pid    = (int) $_POST['pid'];
    $pprice = $_POST['pprice'];
    $tprice = $qty * $pprice;

    $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE id=?');
    $stmt->bind_param('isi', $qty, $tprice, $pid);
    $stmt->execute();
}

// Process checkout order
if (isset($_POST['action']) && $_POST['action'] == 'order') {
    $name        = htmlspecialchars($_POST['name']);
    $email       = htmlspecialchars($_POST['email']);
    $phone       = htmlspecialchars($_POST['phone']);
    $products    = htmlspecialchars($_POST['products']);
    $grand_total = $_POST['grand_total'];
    $address     = htmlspecialchars($_POST['address']);
    $pmode       = htmlspecialchars($_POST['pmode']);

    $stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid) VALUES (?,?,?,?,?,?,?)');
    $stmt->bind_param('sssssss', $name, $email, $phone, $address, $pmode, $products, $grand_total);
    $stmt->execute();

    $stmt2 = $conn->prepare('DELETE FROM cart');
    $stmt2->execute();

    echo '<div class="text-center">
            <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
            <h2 class="text-success">Your Order Placed Successfully!</h2>
            <h4 class="bg-danger text-light rounded p-2">Items Purchased: ' . $products . '</h4>
            <h4 style="color:white;">Name: ' . $name . '</h4>
            <h4 style="color:white;">E-mail: ' . $email . '</h4>
            <h4 style="color:white;">Phone: ' . $phone . '</h4>
            <h4 style="color:white;">Total Amount Paid: ₹' . number_format($grand_total, 2) . '</h4>
            <h4 style="color:white;">Payment Mode: ' . $pmode . '</h4>
          </div>';
}
?>
