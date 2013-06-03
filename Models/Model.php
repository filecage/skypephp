<?php

    namespace Skype\Models;
    use Skype\Exception\TypeException;

    /**
     * Class Model
     * @package Skype\Models
     */

    class Model {

        /**
         * The Skype4COM connection, injected when Model is being constructed
         * @var \Skype\SkypeCom
         */
        protected $skype;

        /**
         * @param \Skype\SkypeCom $skypeCom
         * @throws \Skype\Exception\TypeException
         */
        public function injectSkypeCom($skypeCom) {
            if ((!$skypeCom instanceof \Skype\SkypeCom)) {
                throw new TypeException();
            }

            $this->skype = $skypeCom;
        }

        /**
         * @see \Skype\SkypeCom::raw()
         * @param string $commandStr
         * @param mixed $args
         * @return string
         */
        protected function raw($commandStr, $args = null) {
            return $this->skype->raw($commandStr);
        }

    }