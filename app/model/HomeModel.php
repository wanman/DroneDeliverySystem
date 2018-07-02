<?php

class HomeModel {

    protected $orders_arr = [];

    public function getOrders () {
        return $this->orders_arr = db::select_array("
                                        SELECT
                                            drones.drone_name, 
                                            c1.client_name AS client1, 
                                            c2.client_name AS client2,
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
                                    ");
    }

    public function checkOrder () {
        $pending_orders = db::select_array("SELECT * FROM orders WHERE (order_status_client_1 = 'Pending' OR order_status_client_2 = 'Pending')");

        if (!empty($pending_orders)) {
            foreach ($pending_orders as $order) {
                
                $time_now = date("Y-m-d H:i:s");
                $arrival_cleint1_time = date("Y-m-d H:i:s", strtotime("$order->order_departure_time + $order->order_distance_client_1 seconds"));

                $arrival_client2_time = date("Y-m-d H:i:s", strtotime("$arrival_cleint1_time + $order->order_distance_client_2 seconds"));
                
                if ($order->order_status_client_1 == 'Pending' && $time_now > $arrival_cleint1_time) {

                    $cleint_1_location = db::select_obj("SELECT * FROM client WHERE client_id = '$order->order_ref_client1'");
                    
                    $cleint_2_location = db::select_obj("SELECT * FROM client WHERE client_id = '$order->order_ref_client2'");
                    
                    $distance_to_client_2 = round($this->calcualte_location(floatval($cleint_1_location->client_location_lat), floatval($cleint_2_location->client_location_lng), floatval($cleint_2_location->client_location_lat), floatval($cleint_2_location->client_location_lng), "K"), 0);

                    // set distance from client 1 to client 2
                    db::update("UPDATE orders SET order_distance_client_2 = '$distance_to_client_2' WHERE order_id = $order->order_id");

                    // set drone location to second clients location
                    db::update("UPDATE drones SET drone_location_lat = '{$cleint_2_location->client_location_lat}', drone_location_lng = '{$cleint_2_location->client_location_lng}' WHERE drone_id = '$order->order_ref_drone'");
                    
                    db::update("UPDATE orders SET order_status_client_1 = 'Delivered' WHERE order_id = $order->order_id");
                }

                if ($order->order_distance_client_2 != "null" && $order->order_distance_client_2 != "") {

                    if ($order->order_status_client_2 == 'Pending' && $time_now > $arrival_client2_time) {
                        db::update("UPDATE orders SET order_status_client_2 = 'Delivered' WHERE order_id = $order->order_id");
                    }
                }
                
            }
        }
    }

    public function calcualte_location ($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }

    }
    
}