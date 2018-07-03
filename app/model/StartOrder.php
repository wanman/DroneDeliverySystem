<?php

class StartOrder {

    protected $message_arr = [];

    public function generate_clients () {

        if (file_exists(DATA . 'persons.txt')) {

            $person = db::select_array('SELECT * FROM client');

            if (empty($person)) {
                $client_arr = file(DATA . 'persons.txt');

                foreach ($client_arr as $client) {
                    db::insert("client", array(
                        "client_name" => explode(",", $client)[0], 
                        "client_location_lat" => explode(",", $client)[1], 
                        "client_location_lng" => explode(",", $client)[2])
                    );
                }

            }
        }            

    }

    public function StartProcess () {
        // $get_drone = db::select_obj("SELECT * FROM drones $pending_drones ORDER BY RAND() LIMIT 1");

        // check which drones is currently busy
        $pending_drones = $this->pending_drones();

        $available_drone_arr = db::select_array("SELECT * FROM drones $pending_drones");
       
        // check which clients is currently busy
        $pending_clients_order = $this->pending_orders_client();

        // get first 2 availabel clients for new processing
        $get_clients = db::select_array("SELECT * FROM client $pending_clients_order LIMIT 2");

        // if clients is available start processing
        if(!empty($get_clients)) {
            $closest_drone = $this->calculate_nearest_drone($get_clients, $available_drone_arr);

            // set drone location to first clients location
            db::update("UPDATE drones SET drone_location_lat = '{$get_clients[0]->client_location_lat}', drone_location_lng = '{$get_clients[0]->client_location_lng}' WHERE drone_id = '{$closest_drone['drone_id']}'");

            // insert new process
            db::insert("orders", array(
                "order_ref_drone" => $closest_drone['drone_id'],
                "order_ref_client1" => $get_clients[0]->client_id,
                "order_status_client_1" => "Pending",
                "order_distance_client_1" => $closest_drone['distance'],
                "order_ref_client2" => $get_clients[1]->client_id,
                "order_status_client_2" => "Pending",
                "order_departure_time" => date('Y-m-d H:i:s')
            ));

            $this->message_arr['started'] = "Process have started";
        } else {
            $this->message_arr['busy'] = "All clients is currenlty busy with processing, please try again in a few moments";
        }

    }

    public function pending_orders_client() {
        $pending_cleints_arr = db::select_array("SELECT order_ref_client1, order_ref_client2 FROM orders WHERE order_status_client_1 = 'Pending' OR order_status_client_2 = 'Pending'");

        $pending_person = [];
        if (!empty($pending_cleints_arr)) {
            foreach ($pending_cleints_arr as $pending_cleints) {
                $pending_person[] = $pending_cleints->order_ref_client1;
                $pending_person[] = $pending_cleints->order_ref_client2;
            }
        }

        if (!empty($pending_person)) {
            return "WHERE client_id NOT IN (" . implode(",", $pending_person) . ")";
        }
    
    }

    public function pending_drones() {
        $pending_drone_arr = db::select_array("SELECT order_ref_drone FROM orders WHERE order_status_client_1 = 'Pending' OR order_status_client_2 = 'Pending'");

        $pending_drone_ids = [];
        if (!empty($pending_drone_arr)) {
            foreach ($pending_drone_arr as $pending_drone_val) {
                $pending_drone_ids[] = $pending_drone_val->order_ref_drone;
            }
        }

        if (!empty($pending_drone_ids)) {
            return "WHERE drone_id NOT IN (" . implode(",", $pending_drone_ids) . ")";
        }
    }

    public function message () {
        return $this->message_arr;
    }

    public function calculate_nearest_drone ($person, $drones_arr) {

        $drone_start_lat = -33.71124237811725;
        $drone_start_lng = 19.58515486283045;

        $distance_arr = [];

        foreach ($drones_arr as $drones) {
            if (empty(trim($drones->drone_location_lat)) && empty(trim($drones->drone_location_lng))) {
                $drone_lat = $drone_start_lat;
                $drone_lng = $drone_start_lng;
            } else {
                $drone_lat = $drones->drone_location_lat;
                $drone_lng = $drones->drone_location_lng;
            }

            $distance_arr[] = array('drone_id' => $drones->drone_id, "distance" => round($this->calcualte_location(floatval($person[0]->client_location_lat), floatval($person[0]->client_location_lng), floatval($drone_lat), floatval($drone_lng), "K"), 0));
            
        }
       
        // Define the custom sort function
        function custom_sort($a,$b) {
            return $a['distance'] > $b['distance'];
        }

        usort($distance_arr, "custom_sort");

        return $distance_arr[0];

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