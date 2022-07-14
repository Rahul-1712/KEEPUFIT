

$(document).ready(function() {
    $('#order_sort').change(function() {
        sort_by = jQuery("#order_sort").val();
        
        if (sort_by == 1){
            window.location.href = 'orders.php?sort_by=new';
        }
        if (sort_by == 2){
            window.location.href = 'orders.php?sort_by=pending';
        }
        if (sort_by == 3){
            window.location.href = 'orders.php?sort_by=processing';
        }
        if (sort_by == 4){
            window.location.href = 'orders.php?sort_by=shipped';
        }
        if (sort_by == 5){
            window.location.href = 'orders.php?sort_by=cancelled';
        }
        if (sort_by == 6){
            window.location.href = 'orders.php?sort_by=completed';
        }
        if (sort_by == 7){
            window.location.href = 'orders.php?sort_by=cod';
        }
        if (sort_by == 8){
            window.location.href = 'orders.php?sort_by=payu';
        }
        if (sort_by == 9){
            window.location.href = 'orders.php?sort_by=payment_pending';
        }
        if (sort_by == 10){
            window.location.href = 'orders.php?sort_by=payment_completed';
        }
    })
})