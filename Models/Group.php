<?php

    namespace Skype\Models;

    class Group extends Model {

        /**
         * Group ID
         * @var int
         */
        protected $id;

        /**
         * The display name of the group
         * @var string
         */
        protected $displayName;

        /**
         * An array of users included in this group
         * @var Array
         */
        protected $users;


        /**
         * Creates a new group model
         *
         * @param $id
         */
        public function __construct($id) {
            $this->id = $id;
        }

        /**
         * Returns the ID
         *
         * @return int
         */
        public function getId() {
            return $this->id;
        }

        /**
         * @return string
         */
        public function getDisplayName() {

            if (empty($this->displayName)) {
                $groupName = explode(' ', $this->skype->raw('GET GROUP %d DISPLAYNAME', $this->getId()));
                $this->displayName = $groupName[3];
            }

            return $this->displayName;

        }

        public function getUsers() {

            if (!is_array($this->users)) {
                $this->skype->raw('GET GROUP %d USERS', $this->getId());
                var_dump($this->skype->getReply());
            }

        }



    }