<?php
    namespace Zima\Data;

    /**
     * Class API
     * 
     * @author Arin Zima <arin@arinzima.com>
     * 
     * TODO: Add all HTTP request methods.
     */
    class API implements APIInterface
    {
        private const NOT_ENABLED = "ConfigError: \"API\" is set to false.";
        private const FAILED = "APIError: An unexpected error occured.";

        /**
         * Perform a GET request
         */
        public function get(string $url) {
            $call = self::call("GET", $url);

            return json_decode($call, true);
        }

        /**
         * Perform a POST request
         */
        public function post(string $url, $data = false) {
            $data = json_encode($data);
            $call = self::call("POST", $url, $data);

            return json_decode($call, true);
        }

        /**
         * Perform a PATCH request
         */
        public function patch(string $url, $data = false) {
            $data = json_encode($data);
            $call = self::call("PATCH", $url, $data);

            return json_decode($call, true);
        }

        /**
         * Perform a DELETE request
         */
        public function delete(string $url) {
            $call = self::call("DELETE", $url);

            return json_decode($call, true);
        }

        /**
         * PRIVATE FUNCTION
         * 
         * Make the actual call.
         */
        private static function call(string $method, string $url, $data = false) {
            if(API === true) {
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
                    case "DELETE":
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                        if($data)
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        break;
                    default:
                        if($data)
                            $url = sprintf("%s?%s", $url, http_build_query($data));
                };

                curl_setopt($curl, CURLOPT_URL, API_BASE . $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                    "Content-Type: application/json",
                    "Authorization: " . API_AUTH
                ]);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

                $result = curl_exec($curl);
                if(!$result) {
                    die(self::FAILED);
                }
                curl_close($curl);
                return $result;
            } else {
                die(self::NOT_ENABLED);
            }
        }
    }