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

            // Immediately promote our interface to receive incoming replies
            $this->raw('PING');
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
         * Applies an event handler to the COM object and injects the SkypeCom object
         *
         * @param object $eventHandler
         * @return bool
         */
        public function applyEventHandler($eventHandler) {
            $eventHandler->injectSkypeCom($this);
            return com_event_sink($this->com, $eventHandler, '_ISkypeEvents');
        }

        /**
         * @return string
         */
        public function getReply() {
            return $this->reply;
        }

    }