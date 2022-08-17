<?php
    class API {
        public static function Get(string $url) {
            Debug::BackEnd("[API::Get] GET Request Pending");
            $call = self::CallAPI("GET", $url);

            Debug::BackEnd("[API::Get] Returning Array");
            return json_decode($call, true);
        }

        public static function Post(string $url, array $data) {
            Debug::BackEnd("[API::Post] Encoding Data");
            $data = json_encode($data);

            Debug::BackEnd("[API::Post] POST Request Pending");
            $call = self::CallAPI("POST", $url, $data);

            Debug::BackEnd("[API::Post] Returning Array");
            return json_decode($call, true);
        }

        public static function Put(string $url, array $data) {
            Debug::BackEnd("[API::Put] Encoding Data");
            $data = json_encode($data);

            Debug::BackEnd("[API::Put] PUT Request Pending");
            $call = self::CallAPI("PUT", $url, $data);

            Debug::BackEnd("[API::Put] Returning Array");
            return json_decode($call, true);
        }

        public static function Patch(string $url, array $data) {
            Debug::BackEnd("[API::Patch] Encoding Data");
            $data = json_encode($data);

            Debug::BackEnd("[API::Patch] PATCH Request Pending");
            $call = self::CallAPI("PATCH", $url, $data);

            Debug::BackEnd("[API::Patch] Returning Array");
            return json_decode($call, true);
        }

        public static function Delete(string $url) {
            Debug::BackEnd("[API::Delete] DELETE Request Pending");
            $call = self::CallAPI("DELETE", $url);

            Debug::BackEnd("[API::Delete] Returning Array");
            return json_decode($call, true);
        }

        private static function CallAPI($method, $url, $data=false) {
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
                    $message = "API Connection failed.";
                    Debug::Error($message);
                    die($message);
                }
                curl_close($curl);
                return $result;
            } else {
                $message = 'USE_API set to false';
                Debug::Error($message);
                die($message);
            }
        }
    }
?>