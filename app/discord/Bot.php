<?php
    class Bot extends Discord {
        public static function FetchUser(string $id) {
            Debug::BackEnd("[Bot::FetchUser] Executing Discord::RequestBot");
            $call = Discord::RequestBot("https://discord.com/api/users/{$id}");

            Debug::BackEnd("[Bot::FetchUser] Returning array");
            return $call;
        }

        public static function FetchGuild(string $id) {
            Debug::BackEnd("[Bot::FetchUser] Executing Discord::RequestBot");
            $call = Discord::RequestBot("https://discord.com/api/guilds/{$id}");

            Debug::BackEnd("[Bot::FetchUser] Returning array");
            return $call;
        }

        public static function GuildMembers(string $guild) {
            Debug::BackEnd("[Bot::FetchUser] Executing Discord::RequestBot");
            $call = Discord::RequestBot("https://discord.com/api/guilds/{$guild}/members");

            Debug::BackEnd("[Bot::FetchUser] Returning array");
            return $call;
        }

        public static function FetchGuildMember(string $guild, string $user) {
            Debug::BackEnd("[Bot::FetchUser] Executing Discord::RequestBot");
            $call = Discord::RequestBot("https://discord.com/api/guilds/{$guild}/members/{$user}");

            Debug::BackEnd("[Bot::FetchUser] Returning array");
            return $call;
        }

        public static function GuildChannels(string $guild) {
            Debug::BackEnd("[Bot::FetchUser] Executing Discord::RequestBot");
            $call = Discord::RequestBot("https://discord.com/api/guilds/{$guild}/channels");

            Debug::BackEnd("[Bot::FetchUser] Returning array");
            return $call;
        }
    }