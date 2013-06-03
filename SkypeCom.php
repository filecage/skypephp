<?php

    namespace Skype;

    class SkypeCom {

        /**
         * Command ID, required for raw commands
         * @var int
         */
        protected $cmdId = 0;

        /**
         * SkypeCOM pointer
         * @var COM
         */
        protected $com;

        /**
         * COM Reply string
         * @var string
         */
        protected $reply = '';


        /**
         * Opens a Skype4COM Connection
         */
        public function __construct() {
            $this->com = new \COM('Skype4COM.Skype');
        }

        /**
         * Executes a raw command in blocking mode, returning the result string
         *
         * @param string $commandStr
         * @param mixed $args An Array or a single value to be injected for vsprintf
         * @return string
         */
        public function raw($commandStr, $args = null) {

            // Convert single value to array
            if (!is_null($args) && !is_array($args)) {
                $args = Array($args);
            }

            // Convert string via vsprintf if we got arguments
            if (is_array($args)) {
                $commandStr = vsprintf($commandStr, $args);
            }

            $command = $this->com->Command($this->cmdId, $commandStr, substr($commandStr, strpos($commandStr, ' ') + 1), true);
            $this->com->SendCommand($command);

            $this->cmdId++;
            $this->reply = $command->Reply;

            return $command->Reply;
        }

        /**
         * @return string
         */
        public function getReply() {
            return $this->reply;
        }

    }