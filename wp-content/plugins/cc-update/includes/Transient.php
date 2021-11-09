<?php

/*
    Copyright (C) 2018 by Clearcode <https://clearcode.cc>
    and associates (see AUTHORS.txt file).

    This file is part of CC-Update.

    CC-Update is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    CC-Update is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with CC-Update; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace Clearcode\Update;
use Clearcode\Update;

use Clearcode\Framework\v3\Singleton;

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( __NAMESPACE__ . '\Transient' ) ) {
    class Transient {
        use Singleton;

        protected $types        = [];
        protected $plugins      = [];
        protected $themes       = [];
        protected $translations = [];

        protected function __construct() {
            if ( $option = $this->get() )
                foreach( $this->get_class_vars() as $key => $value )
                    if ( ! empty( $option[$key] ) ) $this->$key = $option[$key];
        }

        public function __set( $name, $value ) {
            if ( isset( $this->$name ) ) {
                $this->$name = $value;
                return true;
            }
            return false;
        }

        public function __get( $name ) {
            return isset( $this->$name ) ? $this->$name : false;
        }

        public function get_class_vars( $return = '' ) {
            $vars = get_class_vars( self::class );
            if ( 'names'  === $return ) return array_keys(   $vars );
            if ( 'values' === $return ) return array_values( $vars );
            return $vars;
        }

        public function get_object_vars( $return = '' ) {
            $vars = get_object_vars( $this );
            if ( 'names'  === $return ) return array_keys(   $vars );
            if ( 'values' === $return ) return array_values( $vars );
            return $vars;
        }

        public function get() {
            return get_transient( Update::get( 'slug' ) );
        }

        public function add() {
            if ( $this->get() ) return $this->update();
            return set_transient( Update::get( 'slug' ), $this->get_object_vars() );
        }

        public function update() {
            if ( ! $this->get() ) return $this->add();
            $transient = $this->get();
            $this->delete();
            return set_transient( Update::get( 'slug' ), $transient + $this->get_object_vars() );
        }

        public function delete() {
            if ( ! $this->get() ) return false;
            return delete_transient( Update::get( 'slug' ) );
        }
    }
}
