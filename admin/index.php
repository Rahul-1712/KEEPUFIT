<?php

require 'header.php';

?>

<div class="main">

    <div class="main-head">
        <h3>Hello <?php echo $_SESSION['ADMIN_USERNAME']; ?></h3>
    </div>
    <!-- 
    <div class="order-stats">
        <div class="order-delivered">
            <h3>678</h3>
            <span>ORDER</span><br>
            <span>DELIVERD</span>
        </div>
        <div class="order-pending">
        <h3>45</h3>
            <span>ORDER</span><br>
            <span>PENDING</span>
        </div>
        <div class="order-cancelled">
            <h3>23</h3>
            <span>ORDER</span><br>
            <span>CANCELED</span>
        </div>
    </div> -->

    <div class="row-section">
        <!-- <div class="col-section"> -->
            <div class="main-best-sellers">
                <h4>Best Sellers</h4>
                <hr>
                <ul class=item>
                    <li>
                        <img src="" alt="">
                        <span>Name </span>
                    </li>
                    <li>
                        <img src="" alt="">
                        <span>Name </span>
                    </li>
                    <li>
                        <img src="" alt="">
                        <span>Name </span>
                    </li>
                    <li>
                        <img src="" alt="">
                        <span>Name </span>
                    </li>
                    <li>
                        <img src="" alt="">
                        <span>Name </span>
                    </li>
                    <li>
                        <img src="" alt="">
                        <span>Name </span>
                    </li>
                    
                </ul>
            </div>
            <div class="main-best-sellers">
                <h4>Recent Reviews</h4>
                <hr>
                
            </div>
            <div class="main-best-sellers">
                <h4>Comments</h4>
                <hr>

            </div>
        <!-- </div> -->
    </div>


</div>

<?php

require 'footer.php';

?>