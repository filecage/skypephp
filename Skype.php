<?php

    namespace Skype;
    use Skype\Models\Group;

    /**
     * Class Skype
     * Core Class for Skype API Wrapper, uses Skype4COM
     *
     * @package Skype
     */

    class Skype {

        /**
         * Skype COM Class
         * @var \Skype\SkypeCom
         */
        protected $skype;

        /**
         * Creates an instance for communicating with Skype
         */
        public function __construct() {
            $this->skype = new SkypeCom();
        }

        /**
         * Returns an array containing all groups
         *
         * @return \Skype\Models\Group[]
         */
        public function getGroups() {

            $groups   = Array();
            $groupStr = $this->skype->raw('SEARCH GROUPS');
            $groupIDs = explode(', ', substr($groupStr, strpos($groupStr, ' ') + 1));

            foreach ($groupIDs as $groupID) {
                $group = new Group($groupID);
                $group->injectSkypeCom($this->skype);

                $groups[] = $group;
            }

            return $groups;

        }

    }