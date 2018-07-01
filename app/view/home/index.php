<?php include VIEW . 'header.php'; ?>

<div class="container-fluid">

    <div class="row">
        <h1>Processing Table</h1>
    </div>

    <div class="row">
        <p>Order time take 1 seconds = 1 km to deliver to Client</p>
    </div>

     <div class="row">
        <p>Current time: <b><?= date("Y-m-d H:i:s"); ?></b></p>
    </div>

    <div class="row mb-5">

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Drone</th>
                    <th>Client 1</th>
                    <th>Status</th>
                    <th>Excpecting delivery time</th>
                    <th>Distance travel(km)</th>
                    <th>Client 2</th>
                    <th>Status</th>
                    <th>Excpecting delivery time</th>
                    <th>Distance travel(km)</th>
                    <th>Drone departure</th>
                </tr>
            </thead>
            <tbody>

                <?php

                if (!empty($this->view_data['orders_arr'])) {
                    $count=1;
                    foreach ($this->view_data['orders_arr'] as $orders) {

                        $client_1_delivery_time = date("Y-m-d H:i:s", strtotime("$orders->order_departure_time + $orders->order_distance_client_1 seconds"));
                        
                        $client_2_delivery_time = "-";
                        if ($orders->order_distance_client_2 != "null" && $orders->order_distance_client_2 != "") {
                            $client_2_delivery_time = date("Y-m-d H:i:s", strtotime("$client_1_delivery_time + $orders->order_distance_client_2 seconds"));
                        }
                        
                        $class="";
                        if ($orders->order_status_client_1 == 'Delivered' &&  $orders->order_status_client_2 == 'Delivered') {
                            $class = "alert-success";
                        } else if ($orders->order_status_client_1 != 'Pending' ||  $orders->order_status_client_1 == 'Pending') {
                            $class = "alert-warning";
                        }

                        ?>

                        <tr class="<?= $class ?>">
                            <td><?= $count; ?></td>
                            <td><?= $orders->drone_name; ?></td>
                            <td><?= $orders->client1; ?></td>
                            <td><?= $orders->order_status_client_1; ?></td>
                            <td><?= $client_1_delivery_time; ?></td>
                            <td><?= $orders->order_distance_client_1." km"; ?></td>
                            <td><?= $orders->client2; ?></td>
                            <td><?= $orders->order_status_client_2; ?></td>
                            <td><?= $client_2_delivery_time; ?></td>
                            <td><?= ($orders->order_distance_client_2 != "null" && $orders->order_distance_client_2 != "") ? "$orders->order_distance_client_2 km" : "-"; ?></td>
                            <td><?= $orders->order_departure_time; ?></td>
                        </tr>

                        <?php
                        $count++;
                    }   
                } else {
                    ?>

                    <tr>
                        <td colspan="7">There is currently no orders</td>
                    </tr>

                    <?php
                }
                ?>

            </tbody>
        </table>

        <form action="\deliverySystem\StartOrder\index" method="post">
            <input type="submit" class="btn btn-primary" value="Start order" >
        </form>
    </div>
</div>

<?php include VIEW . 'footer.php'; ?>