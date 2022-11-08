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
        public function __construct()
        {
            if(TWITCH === false) {
                die(Twitch::NOT_ENABLED);
            }
        }

        public function fetch()
        {
            $twitch = new Twitch();
            $call = $twitch->request(Twitch::USER);

            return json_decode($call, true);
        }
    }