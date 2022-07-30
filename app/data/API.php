<?php
    require './app/main/Base.php';
    require './app/main/Utils.php';

    class API {
        public function __construct() {}

        public function get(string $url) {
            $call = self::callAPI("GET", $url);
            return json_decode($call, true);
        }

        public function post(string $url, array $data) {
            $data = json_encode($data);

            $call = self::callAPI("POST", $url, $data);
            return json_decode($call, true);
        }

        public function put(string $url, array $data) {
            $data = json_encode($data);

            $call = callAPI("PUT", $url, $data);
            return json_decode($call, true);
        }

        public function patch(string $url, array $data) {
            $data = json_encode($data);

            $call = self::callAPI("PATCH", $url, $data);
            return json_decode($call, true);
        }

        public function delete(string $url) {
            $call = self::callAPI("DELETE", $url);
            return json_decode($call, true);
        }

        private static function callAPI($method, $url, $data=false) {
            if(USE_API === true) {
                $curl = curl_init();
                switch($method) {
                    case "POST":
                        curl_setopt($curl, CURLOPT_POST, 1);
                        if($data)
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        break;
                    case "PATCH":
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
                        if($data)
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        break;
                    case "PUT":
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                        if($data)
                            curl_setopt(CURLOPT_POSTFIELDS, $data);
                        break;
                    case "DELETE":
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                        if($data)
                            curl_setopt(CURLOPT_POSTFIELDS, $data);
                        break;
                    default:
                        if($data)
                            $url = sprintf("%s?%s",$url,http_build_query($data));
                }
        
                curl_setopt($curl, CURLOPT_URL, API_BASE . $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: ' . API_AUTH
                ]);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

                $result = curl_exec($curl);
                if(!$result) {
                    die("API Connection failed.");
                }
                curl_close($curl);
                return $result;
            } else {
                $base = new Base();

                $message = 'Config: USE_API set to false';
                $base::debug($message);
                die($message);
            }
        }
    }
?>