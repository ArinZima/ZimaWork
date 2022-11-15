<?php
    namespace Zima\TTV;

    use Zima\TTV\Twitch;

    /**
     * Class User
     * 
     * @author Arin Zima <arin@arinzima.com>
     * 
     * !! THIS CLASS HAS NOT BEEN TESTED YET. PROCEED WITH EXTREME CAUTION.
     */
    class User extends Twitch implements UserInterface
    {
        /**
         * Check if config value is set to "true"
         */
        public function __construct()
        {
            if(TWITCH === false) {
                die(Twitch::NOT_ENABLED);
            }
        }

        /**
         * Fetch the currently authorized user
         */
        public function fetch()
        {
            $twitch = new Twitch();
            $call = $twitch->request(Twitch::USER);

            return $call["data"][0];
        }
    }