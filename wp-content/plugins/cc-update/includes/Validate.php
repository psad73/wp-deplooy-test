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

use WP_Error;

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( __NAMESPACE__ . '\Validate' ) ) {
    class Validate {
        static public function git( $path ) {
            if ( ! is_executable( $path ) )
                return new WP_Error( 'is_executable', sprintf(
                    Update::__( 'Wrong git path: %s. This is not the file or is not executable.' ), $path ) );

            return true;
        }

        static public function repository( $path ) {
            if ( ! file_exists( $path . '.git' ) )
                return new WP_Error( 'file_exists', sprintf(
                    Update::__( 'Wrong repository path: %s.' ), $path ) );

            if ( ! chdir( $path ) )
                return new WP_Error( 'chdir', sprintf(
                    Update::__( 'Failed to change directory to: %s.' ), $path ) );

            return true;
        }

        static public function interval( $interval ) {
            if ( ! is_numeric( $interval ) or (int)$interval < 0 )
                return new WP_Error( 'is_numeric', sprintf(
                    Update::__( 'Interval value: %s must be a number.' ), $interval ) );

            return true;
        }

        static public function email( $email ) {
            if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) )
                return new WP_Error( 'filter_var', sprintf(
                    Update::__( 'Wrong email address: %s.' ), $email ) );

            return true;
        }
    }
}
