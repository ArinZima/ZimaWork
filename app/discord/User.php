<?php
    class User extends Discord {
        public static function Fetch() {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[User::Fetch] Fetching user");
                $user = Discord::Request(Discord::$user);
    
                Debug::BackEnd("[User::Fetch] Returning user");
                return $user;
            } else {
                $message = 'USE_DISCORD set to false';
                Base::debug($message);
                die($message);
            }
        }

        public static function DisplayAvatarURL($user, $params = array()) {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[User::DisplayAvatarURL] Setting options");
                $format = isset($params['format']) ? $params['format'] : 'png';
                $size = isset($params['size']) ? $params['size'] : 1024;
                
                Debug::BackEnd("[User::DisplayAvatarURL] Returning link");
                return "https://cdn.discordapp.com/avatars/{$user->id}/{$user->avatar}.{$format}?size={$size}";
            } else {
                $message = 'USE_DISCORD set to false';
                Base::debug($message);
                die($message);
            }
        }

        public static function DisplayBannerURL($user, $params = array()) {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[User::DisplayBannerURL] Setting options");
                $format = isset($params['format']) ? $params['format'] : 'png';
                $size = isset($params['size']) ? $params['size'] : 1024;
                
                Debug::BackEnd("[User::DisplayBannerURL] Returning URL");
                return "https://cdn.discordapp.com/banners/{$user->id}/{$user->banner}.{$format}?size={$size}";
            } else {
                $message = 'USE_DISCORD set to false';
                Base::debug($message);
                die($message);
            }
        }
    }