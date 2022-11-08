<?php
    namespace Zima\Discord;

    use Zima\Discord\Discord;

    /**
     * Class User (Discord)
     * 
     * @author Arin Zima (arin@arinzima.com)
     * 
     * !! THIS CLASS HAS NOT BEEN TESTED YET. PROCEED WITH EXTREME CAUTION.
     */
    class User extends Discord implements UserInterface
    {
        public function __construct()
        {
            if(DISCORD === false)
            {
                die("ConfigError: \"DISCORD\" is set to false.");
            }
        }

        public function fetch()
        {
            $discord = new Discord();

            $user = $discord->request($discord::USER);

            return $user;
        }

        public function display_avatar_url(array $user, ?array $params = null)
        {
            $format = isset($params['format']) ? $params['format'] : 'png';
            $size = isset($params['size']) ? $params['size'] : 1024;

            return "https://cdn.discordapp.com/avatars/{$user['id']}/{$user['avatar']}.{$format}?size={$size}";
        }

        public function display_banner_url(array $user, ?array $params = null)
        {
            $format = isset($params['format']) ? $params['format'] : 'png';
            $size = isset($params['size']) ? $params['size'] : 1024;

            return "https://cdn.discordapp.com/banners/{$user['id']}/{$user['banner']}.{$format}?size={$size}";
        }
    }