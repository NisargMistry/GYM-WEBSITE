<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GYM - Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
    <style>
        body { background: radial-gradient(#111, #071a1a); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="addtocart.php"><i class="fas fa-dumbbell"></i>&nbsp;&nbsp;GYM Store</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="../index.html"><i class="fas fa-home mr-1"></i>Home</a></li>
            <li class="nav-item"><a class="nav-link" href="addtocart.php"><i class="fas fa-list mr-1"></i>Packages</a></li>
            <li class="nav-item"><a class="nav-link" href="checkout.php"><i class="fas fa-money-check-alt mr-1"></i>Checkout</a></li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-item" class="badge badge-danger"></span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <?php if (isset($_SESSION['showAlert'])): ?>
            <div style="display:<?= $_SESSION['showAlert'] ?>" class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><?= htmlspecialchars($_SESSION['message'] ?? '') ?></strong>
            </div>
            <?php unset($_SESSION['showAlert'], $_SESSION['message']); endif; ?>

            <div class="table-responsive mt-2">
                <table class="table table-bordered table-striped text-center">
                    <thead style="color:white;">
                        <tr>
                            <td colspan="7"><h4 class="text-info m-0">Packages in your cart</h4></td>
                        </tr>
                        <tr>
                            <th>ID</th><th>Image</th><th>Package</th><th>Price</th>
                            <th>Quantity</th><th>Total</th>
                            <th>
                                <a href="action.php?clear=all" class="badge badge-danger p-1"
                                   onclick="return confirm('Clear entire cart?');">
                                    <i class="fas fa-trash"></i> Clear Cart
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'config.php';
                        $stmt   = $conn->prepare('SELECT * FROM cart');
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $grand_total = 0;
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td style="color:white;"><?= $row['id'] ?></td>
                            <input type="hidden" class="pid"    value="<?= $row['id'] ?>">
                            <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                            <td><img src="../assets/images/<?= htmlspecialchars($row['product_image']) ?>" width="50" alt="product"></td>
                            <td style="color:white;"><?= htmlspecialchars($row['product_name']) ?></td>
                            <td style="color:white;"><i class="fas fa-rupee-sign"></i> <?= number_format($row['product_price'], 2) ?></td>
                            <td><input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style="width:75px;" min="1"></td>
                            <td style="color:white;"><i class="fas fa-rupee-sign"></i> <?= number_format($row['total_price'], 2) ?></td>
                            <td>
                                <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead"
                                   onclick="return confirm('Remove this item?');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $grand_total += $row['total_price']; endwhile; ?>
                        <tr>
                            <td colspan="3">
                                <a href="addtocart.php" class="btn btn-success">
                                    <i class="fas fa-cart-plus"></i> Continue Shopping
                                </a>
                            </td>
                            <td style="color:white;" colspan="2"><b>Grand Total</b></td>
                            <td style="color:white;"><b><i class="fas fa-rupee-sign"></i> <?= number_format($grand_total, 2) ?></b></td>
                            <td>
                                <a href="checkout.php" class="btn btn-info <?= ($grand_total > 0) ? '' : 'disabled' ?>">
                                    <i class="far fa-credit-card"></i> Checkout
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {

    $(".itemQty").on('change', function () {
        var $el    = $(this).closest('tr');
        var pid    = $el.find(".pid").val();
        var pprice = $el.find(".pprice").val();
        var qty    = $(this).val();

        $.ajax({
            url: 'action.php',
            method: 'post',
            cache: false,
            data: { qty, pid, pprice },
            success: function () { location.reload(true); }
        });
    });

    loadCartCount();

    function loadCartCount() {
        $.ajax({
            url: 'action.php',
            method: 'get',
            data: { cartItem: 'cart_item' },
            success: function (response) { $("#cart-item").html(response); }
        });
    }
});
</script>
</body>
</html>
