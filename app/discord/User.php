<?php
    require './app/main/Base.php';

    class User extends Discord {
        public static function fetch() {
            if(USE_DISCORD === true) {
                $user = Discord::request(Discord::$user);
    
                return $user;
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }

        public static function displayAvatarURL($user, $params = array()) {
            if(USE_DISCORD === true) {
                $format = isset($params['format']) ? $params['format'] : 'png';
                $size = isset($params['size']) ? $params['size'] : 1024;
                
                return "https://cdn.discordapp.com/avatars/{$user->id}/{$user->avatar}.{$format}?size={$size}";
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }

        public static function displayBannerURL($user, $params = array()) {
            if(USE_DISCORD === true) {
                $format = isset($params['format']) ? $params['format'] : 'png';
                $size = isset($params['size']) ? $params['size'] : 1024;
                
                return "https://cdn.discordapp.com/banners/{$user->id}/{$user->banner}.{$format}?size={$size}";
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }
    }