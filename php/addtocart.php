<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Nisarg Mistry">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GYM - Packages</title>
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
    <div id="message"></div>
    <div class="row mt-2 pb-3">
        <?php
        include 'config.php';
        $stmt = $conn->prepare('SELECT * FROM product');
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()):
        ?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
            <div class="card p-2 border-secondary mb-2">
                <img src="../assets/images/<?= htmlspecialchars($row['product_image']) ?>" class="card-img-top" height="250" alt="<?= htmlspecialchars($row['product_name']) ?>">
                <div class="card-body p-1">
                    <h4 class="card-title text-center text-info"><?= htmlspecialchars($row['product_name']) ?></h4>
                    <h5 class="card-text text-center text-danger">
                        <i class="fas fa-rupee-sign"></i>&nbsp;<?= number_format($row['product_price'], 2) ?>/-
                    </h5>
                </div>
                <div class="card-footer p-1">
                    <form class="form-submit">
                        <div class="row p-2">
                            <div class="col-md-6 py-1 pl-4"><b>Quantity:</b></div>
                            <div class="col-md-6">
                                <input type="number" class="form-control pqty" value="<?= $row['product_qty'] ?>" min="1">
                            </div>
                        </div>
                        <input type="hidden" class="pid"    value="<?= $row['id'] ?>">
                        <input type="hidden" class="pname"  value="<?= htmlspecialchars($row['product_name']) ?>">
                        <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                        <input type="hidden" class="pimage" value="<?= htmlspecialchars($row['product_image']) ?>">
                        <input type="hidden" class="pcode"  value="<?= htmlspecialchars($row['product_code']) ?>">
                        <button class="btn btn-info btn-block addItemBtn">
                            <i class="fas fa-cart-plus"></i>&nbsp;Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {

    $(".addItemBtn").click(function (e) {
        e.preventDefault();
        var $form  = $(this).closest(".form-submit");
        var pid    = $form.find(".pid").val();
        var pname  = $form.find(".pname").val();
        var pprice = $form.find(".pprice").val();
        var pimage = $form.find(".pimage").val();
        var pcode  = $form.find(".pcode").val();
        var pqty   = $form.find(".pqty").val();

        $.ajax({
            url: 'action.php',
            method: 'post',
            data: { pid, pname, pprice, pqty, pimage, pcode },
            success: function (response) {
                $("#message").html(response);
                window.scrollTo(0, 0);
                loadCartCount();
            }
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
