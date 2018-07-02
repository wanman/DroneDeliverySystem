<?php

class viewOrder {

    public function get_order_details ($id) {

        $orders = db::select_obj("
            SELECT
                drones.drone_name, 
                c1.client_name AS client1, 
                c2.client_name AS client2,
                c1.client_location_lat AS client1_lat,
                c1.client_location_lng AS client1_lng,
                c2.client_location_lat AS client2_lat,
                c2.client_location_lng AS client2_lng,
                orders.order_status_client_1,
                orders.order_status_client_2,
                orders.order_departure_time,
                orders.order_distance_client_1,
                orders.order_distance_client_2,
                orders.order_id
            FROM orders
                LEFT JOIN drones ON drones.drone_id = orders.order_ref_drone
                LEFT JOIN client c1 ON c1.client_id = orders.order_ref_client1
                LEFT JOIN client c2 ON c2.client_id = orders.order_ref_client2
            WHERE orders.order_id = '$id'    
        ");

        if (is_object($orders)) {
            return $orders;
        }

    }

}