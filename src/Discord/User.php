<?php
    namespace Zima\Discord;

    use Zima\Discord\Discord;

    /**
     * Class User (Discord)
     * 
     * @author Arin Zima (arin@arinzima.com)
     */
    class User extends Discord implements UserInterface
    {
        /**
         * Check if config value is set to "true"
         */
        public function __construct()
        {
            if(DISCORD === false)
            {
                die("ConfigError: \"DISCORD\" is set to false.");
            }
        }

        /**
         * Fetch the currently authorized user
         */
        public function fetch()
        {
            $discord = new Discord();

            $user = $discord->request($discord::USER);

            return $user;
        }

        /**
         * Return the avatar URL of a user
         */
        public function display_avatar_url(array $user, ?array $params = null)
        {
            $format = isset($params['format']) ? $params['format'] : 'png';
            $size = isset($params['size']) ? $params['size'] : 1024;

            return "https://cdn.discordapp.com/avatars/{$user['id']}/{$user['avatar']}.{$format}?size={$size}";
        }

        /**
         * Return the banner URL of a user, if any.
         */
        public function display_banner_url(array $user, ?array $params = null)
        {
            $format = isset($params['format']) ? $params['format'] : 'png';
            $size = isset($params['size']) ? $params['size'] : 1024;

            if(empty($user['banner'])) {
                return null;
            } else {
                return "https://cdn.discordapp.com/banners/{$user['id']}/{$user['banner']}.{$format}?size={$size}";
            }
        }
    }