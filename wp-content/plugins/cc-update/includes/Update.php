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

namespace Clearcode;

use Clearcode\Update\Option;
use Clearcode\Update\Settings;
use Clearcode\Update\Transient;
use Clearcode\Update\DB;
use Clearcode\Update\Cron;

use Clearcode\Framework\v3\Plugin;

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( __NAMESPACE__ . '\Update' ) ) {
    class Update extends Plugin {
        public function action_plugins_loaded() {
            Option::instance();
            Transient::instance();
            Cron::instance();
            Settings::instance();
        }

        public function activation() {
            DB::install();
            Cron::instance()->install();
        }

        public function deactivation() {
            Transient::instance()->delete();
            Option::instance()->delete();
            DB::uninstall();
            Cron::instance()->uninstall();
        }

        // https://developer.wordpress.org/reference/hooks/pre_auto_update/
        // public function action_pre_auto_update( $type, $item, $context ) {}

        // https://developer.wordpress.org/reference/hooks/automatic_updates_complete/
        // public function action_automatic_updates_complete( $results ) {}

        // https://developer.wordpress.org/reference/hooks/upgrader_pre_install/
        //public function filter_upgrader_pre_install( $response, $hook_extra ) {}

        // https://developer.wordpress.org/reference/hooks/upgrader_post_install/
        //public function filter_upgrader_post_install( $response, $extra, $result ) {}

        // https://developer.wordpress.org/reference/hooks/upgrader_package_options/
        //public function filter_upgrader_package_options( $options ) {}

        // https://developer.wordpress.org/reference/hooks/upgrader_process_complete/
        public function action_upgrader_process_complete( $upgrader, $extra ) {
            if ( ! isset( $extra['type'] ) ) return;
            $types   = Transient::instance()->types;
            $types[] = $extra['type'];

            $plugins      = Transient::instance()->plugins;
            $themes       = Transient::instance()->themes;
            $translations = Transient::instance()->translations;

            switch ( $extra['type'] ) {
                case 'plugin' :
                    if ( isset( $extra['plugins'] ) and is_array( $extra['plugins'] ) )
                        $plugins = array_merge( $plugins, $extra['plugins'] );
                    break;
                case 'theme' :
                    if ( isset( $extra['themes'] ) and is_array( $extra['themes'] ) )
                        $themes = array_merge( $themes, $extra['themes'] );
                    break;
                case 'translation' :
                    if ( isset( $extra['translations'] ) and is_array( $extra['translations'] ) )
                        $translations = array_merge( $translations, [ $extra['translations'] ] );
                    break;
            }

            Transient::instance()->types        = $types;
            Transient::instance()->plugins      = $plugins;
            Transient::instance()->themes       = $themes;
            Transient::instance()->translations = $translations;
            Transient::instance()->add();
        }

        public function filter_automatic_updater_disabled() {
            return false;
        }

        public function filter_automatic_updates_is_vcs_checkout() {
            return false;
        }

        public function filter_allow_minor_auto_core_updates() {
            return true;
        }

        public function filter_allow_major_auto_core_updates() {
            return true;
        }

        public function filter_auto_update_core() {
            return true;
        }

        public function filter_auto_update_plugin() {
            return true;
        }

        public function filter_auto_update_theme() {
            return true;
        }

        public function filter_auto_update_translation() {
            return true;
        }

        public function filter_plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {
            if ( empty( static::get( 'name' ) ) ) return $actions;
            if ( empty( $plugin_data['Name']  ) ) return $actions;
            if ( static::get( 'name' ) == $plugin_data['Name'] )
                array_unshift( $actions, static::render( 'link', [
                    'url'  => get_admin_url( null, sprintf( Settings::URL, static::get( 'slug' ) . '-settings' ) ),
                    'link' => static::__( 'Settings' )
                ] ) );

            return $actions;
        }

        public function filter_plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
            if ( empty( static::get( 'name' ) ) ) return $plugin_meta;
            if ( empty( $plugin_data['Name']  ) ) return $plugin_meta;
            if ( static::get( 'name' ) == $plugin_data['Name'] ) {
                $plugin_meta[] = static::__( 'Author' ) . ' ' . static::render( 'link', [
                    'url'  => 'http://piotr.press/',
                    'link' => 'PiotrPress'
                ] );
            }

            return $plugin_meta;
        }
    }
}
