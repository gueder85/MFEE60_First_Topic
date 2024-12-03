<div class="container py-3 d-flex justify-content-between">
    <a href="product-list.php"><img src="/img/Hero-Logo.png" alt="" class="logo"></a>
    <div>
        <?php
        $cart=$_SESSION["cart"] ?? [];
        $cartCount=count($cart);
        ?>

        <a href="cart.php" class="cart-btn link-dark position-reletive pt-4 pe-2">
            <i class="fa-solid fa-cart-shopping"></i>
            <div class="link-count text-bg-danger position-absolute" id="cartCount"><?=$cartCount?></div>
        </a>
    </div>
</div>