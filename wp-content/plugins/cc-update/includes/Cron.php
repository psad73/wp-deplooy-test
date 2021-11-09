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
use Clearcode\Framework\v3\Filterer;

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( __NAMESPACE__ . '\Cron' ) ) {
    class Cron {
        const EVENT    = 'cc_update';
        const INTERVAL = 'cc_update_interval';

        use Singleton;

        protected function __construct() {
            new Filterer( $this );
            add_action( self::EVENT, [ $this, 'schedule' ] );
        }

        public function install() {
            if ( ! wp_next_scheduled( self::EVENT ) )
                wp_schedule_event( current_time( 'timestamp' ), self::INTERVAL, self::EVENT );
        }

        public function uninstall() {
            wp_clear_scheduled_hook( self::EVENT );
            remove_action( self::EVENT, [ $this, 'schedule' ] );
        }

        public function schedule() {
            // TODO check global $upgrading;

            $status = Option::instance()->status;
            $types  = Transient::instance()->types;
            if ( empty( $status ) and self::EVENT === current_filter() ) return false;
            if ( empty( $types  ) and self::EVENT === current_filter() ) return false;

            $git = Option::instance()->git;
            if ( is_wp_error( $error = Validate::git( $git ) ) ) {
                DB::insert(  $error->get_error_message() );
                $this->mail( $error->get_error_message() );
                return false;
            }

            $dir = trailingslashit( Option::instance()->dir );
            if ( is_wp_error( $error = Validate::repository( $dir ) ) ) {
                DB::insert(  $error->get_error_message() );
                $this->mail( $error->get_error_message() );
                return false;
            }

            if ( ! chdir( $dir ) ) {
                DB::insert(  $message = sprintf( Update::__( "Can't change directory to: %s" ), $dir ) );
                $this->mail( $message );
                return false;
            }

            $diff = [];
            exec( $git . ' status --porcelain 2>&1', $diff );
            if ( empty( $diff ) and self::EVENT === current_filter() ) {
                Transient::instance()->delete();
                return true;
            }

            $message  = Update::__( 'Updated' ) . ': ';
            $message .= $this->implode( ', ', Transient::instance()->types );
            $message  = trim( $message );

            $return = true;
            $logs   = [];
            foreach ( [
                'add -A',
                sprintf( 'commit -m "%s"', $message ),
                'push'
            ] as $command ) {
                $logs[] = '$ ' . $git . ' ' . $command;
                exec( $git . ' ' . $command . ' 2>&1', $logs, $code );
                if ( $code ) $return = false;
            }

            DB::insert(  $this->implode( "\n", $logs ) );
            $this->mail( $this->implode( "\n", $logs ) );

            if ( $return ) Transient::instance()->delete();
            return $return;
        }

        public function filter_cron_schedules( $schedules ) {
            if ( is_wp_error( Validate::interval( Option::instance()->interval ) ) )
                $interval = 1;
            else $interval = (int)Option::instance()->interval;

            $schedules[self::INTERVAL] = [
                'interval' => $interval * 60,
                'display'  => Update::get( 'name' ) . ' ' . Update::__( 'Interval' )
            ];
            return $schedules;
        }

        protected function mail( $message ) {
            $emails = [];
            foreach( Option::instance()->emails as $email )
                if ( ! empty( $email ) )
                    if ( is_wp_error( $error = Validate::email( $email ) ) )
                        DB::insert( $error->get_error_message() );
                    else $emails[] = $email;

            if ( ! empty( $emails ) ) {
                $subject = '[' . Update::__( 'Update' ) . '] ' . get_site_url();
                $message = Update::render( 'pre', [ 'content' => $message ] );
                $mail    = new Mail( $emails, $subject, $message );
                $mail->send();
            }
        }

        protected function implode( $delimiter, $array ) {
            if ( empty( $array ) )      return '';
            if ( ! is_array( $array ) ) return '';

            return implode( $delimiter, $array );
        }
    }
}
