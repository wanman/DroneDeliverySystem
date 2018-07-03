<?php include VIEW_LAYOUT . 'header.php'; ?>

<style>
    /* GOOGLE MAPS STYLE START */
    #map {
        height: 400px;
    }
</style>

<?php

    if (empty($this->view_data['orders_arr'])) {
        header('Location: /deliverySystem');
    }

    // set location for google maps
    $location_data = "[";

    $location_data .= "['Starting point', -33.711242, 19.585154, 3],";
    $location_data .= "['Client 1: {$this->view_data['orders_arr']->client1}', {$this->view_data['orders_arr']->client1_lat}, {$this->view_data['orders_arr']->client1_lng}, 2],";
    $location_data .= "['Client 2: {$this->view_data['orders_arr']->client2}', {$this->view_data['orders_arr']->client2_lat}, {$this->view_data['orders_arr']->client2_lng}, 1]";
    
    $location_data .= "];";

?>

<div class="container">
    <div class="row">
        <div id="map"></div>
    </div>

    <div class="row">
        <a href="/deliverySystem" class="btn btn-primary mt-3">Back</a>
    </div>
</div>    

<?php include VIEW_LAYOUT . 'footer.php'; ?>