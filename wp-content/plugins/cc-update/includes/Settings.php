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

if ( ! class_exists( __NAMESPACE__ . '\Settings' ) ) {
    class Settings {
        use Singleton;

        const URL = 'admin.php?page=%s';

        protected function __construct() {
            new Filterer( $this );
        }

        public function action_admin_init() {
            register_setting(     Update::get( 'slug' ), Update::get( 'slug' ),  [ $this, 'sanitize' ] );
            add_settings_section( Update::get( 'slug' ), Update::__( 'Update' ), [ $this, 'section'  ], Update::get( 'slug' ) );

            add_settings_field( 'git', Update::__( 'Git' ), [ __CLASS__, 'input' ], Update::get( 'slug' ), Update::get( 'slug' ), [
                'name'  => Update::get( 'slug' ) . '[git]',
                'value' => Option::instance()->git,
                'desc'  => Update::__( 'The path to the git executable.' ) . '<br />' .
                           Update::__( 'Default' ) . ': ' .
                           Update::render( 'code', [ 'content' => '/usr/bin/git' ] )
            ] );

            add_settings_field( 'dir', Update::__( 'Dir' ), [ __CLASS__, 'input' ], Update::get( 'slug' ), Update::get( 'slug' ), [
                'name'  => Update::get( 'slug' ) . '[dir]',
                'value' => Option::instance()->dir,
                'desc'  => Update::__( 'The path to your repository.' ) . '<br />' .
                           Update::__( 'Default' ) . ': ' .
                           Update::render( 'code', [ 'content' => 'ABSPATH' ] )
            ] );

            add_settings_field( 'interval', Update::__( 'Interval' ), [ __CLASS__, 'input' ], Update::get( 'slug' ), Update::get( 'slug' ), [
                'name'  => Update::get( 'slug' ) . '[interval]',
                'value' => Option::instance()->interval,
                'desc'  => Update::__( 'The frequency to check for updates.' ) . '<br />' .
                           Update::__( 'Default' ) . ': ' .
                           Update::render( 'code', [ 'content' => '1' ] ),
                'after' => Update::__( 'minutes' ),
                'type'  => 'number',
                'class' => 'small-text'
            ] );

            add_settings_field( 'emails', Update::__( 'Emails' ), [ $this, 'emails' ], Update::get( 'slug' ), Update::get( 'slug' ) );
            add_settings_field( 'test',   Update::__( 'Test'   ), [ $this, 'test'   ], Update::get( 'slug' ), Update::get( 'slug' ) );
            add_settings_field( 'status', Update::__( 'Status' ), [ $this, 'status' ], Update::get( 'slug' ), Update::get( 'slug' ) );
        }

        public function action_admin_menu_999() {
            add_menu_page(
                Update::__( 'Update' ),
                Update::__( 'Update' ),
                'manage_options',
                Update::get( 'slug' ) . '-logs',
                [ $this, 'logs' ],
                'dashicons-update',
                2
            );

            add_submenu_page(
                Update::get( 'slug' ) . '-logs',
                Update::__( 'Logs' ),
                Update::__( 'Logs' ),
                'manage_options',
                Update::get( 'slug' ) . '-logs',
                [ $this, 'logs' ]
            );

            add_submenu_page(
                Update::get( 'slug' ) . '-logs',
                Update::__( 'Settings' ),
                Update::__( 'Settings' ),
                'manage_options',
                Update::get( 'slug' ) . '-settings',
                [ $this, 'settings' ]
            );
        }

        public function action_admin_bar_menu_999( $wp_admin_bar ) {
            $wp_admin_bar->add_node( [
                'id'    => Update::get( 'slug' ),
                'title' => Update::render( 'admin-bar', [ 'content' => Update::__( 'Update' ) ] ),
                'href'  => get_admin_url( null, sprintf( self::URL, Update::get( 'slug' ) . '-logs' ) )
            ] );
        }

        protected function enqueue_style( $style ) {
            wp_register_style( Update::get( 'slug' ) . '-' . $style, Update::get( 'url' ) . 'assets/css/'  . $style . '.css', [], Update::get( 'version' ) );
            wp_enqueue_style(  Update::get( 'slug' ) . '-' . $style );
        }

        public function action_admin_enqueue_scripts( $page ) {
            if ( false !== strpos( $page, Update::get( 'slug' ) . '-logs' ) ) $this->enqueue_style( 'logs' );
            if ( is_admin_bar_showing() ) $this->enqueue_style( 'admin-bar' );
        }

        public function action_wp_enqueue_scripts() {
            if ( ! is_admin_bar_showing() ) return;
            $this->enqueue_style( 'admin-bar' );
        }

        public function logs() {
            $table = new Table();
            $table->prepare_items();

            echo Update::render( 'logs', array(
                'header' => Update::__( 'Update Logs' ),
                'table'  => $table,
            ) );
        }

        public function settings() {
            echo Update::render( 'page', [
                'settings'     => Update::get( 'slug' ),
                'option_group' => Update::get( 'slug' ),
                'page'         => Update::get( 'slug' )
            ] );

            if ( ! defined( 'DISABLE_WP_CRON' ) || true !== DISABLE_WP_CRON ) {
                $config = 'wp-config.php';
                if ( file_exists( $file = ABSPATH . $config ) ) :
                elseif ( file_exists( $file = dirname( ABSPATH ) . '/' . $config ) ) :
                else : $file = $config;
                endif;

                echo sprintf(
                    Update::__( 'Preferred method is to disable %s and add a task to cron on the server.' ),
                    Update::render( 'code', [ 'content' => 'wp_cron' ] )
                ) . '<br /><br />';

                echo Update::render( 'config', [
                    'message' => Update::__( 'Add following constant to' ),
                    'file'    => $file
                ] ) . '<br /><br />';

                echo Update::render( 'cron', [
                    'message' => Update::__( 'Add the following task to your cron jobs' ),
                    'domain'  => $this->domain( null, true )
                ] );
            }
        }

        public function domain( $url = '', $scheme = false ) {
            // wp-admin/includes/network.php get_clean_basedomain()
            return $scheme ? get_site_url( null, $url ) : preg_replace( '|https?://|', '', get_site_url( null, $url ) );
        }

        public function section() {
            echo Update::render( 'section', [
                'content' => Update::__( 'Settings' )
            ] );
        }

        public function emails() {
            $emails   = Option::instance()->emails;
            $emails[] = '';
            foreach( $emails as $id => $email )
                self::input( [
                    'type'  => 'email',
                    'name'  => Update::get( 'slug' ) . "[emails][$id]",
                    'value' => $email,
                    'after' => '<br />'
                ] );
        }

        public function test() {
            self::input( [
                'type'  => 'checkbox',
                'name'  => Update::get( 'slug' ) . '[send]',
                'after' => Update::__( 'Send test email' )
            ] );
            echo '<br />';
            self::input( [
                'type'  => 'checkbox',
                'name'  => Update::get( 'slug' ) . '[push]',
                'after' => Update::__( 'Force' ) . ' ' . Update::render( 'code', [ 'content' => 'git push' ] )
            ] );
        }

        public function status() {
            foreach( array_reverse( [ Update::__( 'Disable' ), Update::__( 'Enable' ) ], true ) as $value => $name )
                self::input( [
                    'type'    => 'radio',
                    'name'    => Update::get( 'slug' ) . '[status]',
                    'value'   => (string)$value,
                    'checked' => checked( Option::instance()->status, (bool)$value, false ),
                    'after'   => $name . '<br />'
                ] );
        }

        static public function input( $args ) {
            $args = wp_parse_args( $args, [
                'type'  => 'input',
                'class' => 'regular-text'
            ] );
            extract( $args, EXTR_SKIP );

            echo Update::render( 'input', [
                    'atts' => self::implode( [
                            'type'  => isset( $type )  ? $type  : '',
                            'class' => isset( $class ) ? $class : '',
                            'name'  => isset( $name )  ? $name  : '',
                            'value' => isset( $value ) ? $value : ''
                        ]
                    ),
                    'checked' => isset( $checked ) ? $checked : '',
                    'before'  => isset( $before )  ? $before  : '',
                    'after'   => isset( $after )   ? $after   : '',
                    'desc'    => isset( $desc )    ? $desc    : ''
                ]
            );
        }

        static public function implode( $atts = [] ) {
            array_walk( $atts, function ( &$value, $key ) {
                $value = sprintf( '%s="%s"', $key, esc_attr( $value ) );
            } );

            return implode( ' ', $atts );
        }

        public function sanitize( $option ) {
            array_walk( $option, 'sanitize_text_field' );
            extract( $option, EXTR_SKIP );

            if ( is_wp_error( $error = Validate::git( $git ) ) ) {
                add_settings_error(
                    Update::get( 'slug' ),
                    'settings_updated',
                    str_replace( $git, Update::render( 'code', [ 'content' => $git ] ), $error->get_error_message() ),
                    'error'
                );
                $git = Option::instance()->git;
            }

            $dir = trailingslashit( $dir );
            if ( is_wp_error( $error = Validate::repository( $dir ) ) ) {
                add_settings_error(
                    Update::get( 'slug' ),
                    'settings_updated',
                    str_replace( $dir, Update::render( 'code', [ 'content' => $dir ] ), $error->get_error_message() ),
                    'error'
                );
                $dir = Option::instance()->dir;
            }

            if ( is_wp_error( $error = Validate::interval( $interval ) ) ) {
                add_settings_error(
                    Update::get( 'slug' ),
                    'settings_updated',
                    str_replace( $interval, Update::render( 'code', [ 'content' => $interval ] ), $error->get_error_message() ),
                    'error'
                );
                $interval = Option::instance()->interval;
            }

            $sanitized_emails = [];
            foreach( $emails as $email )
                if ( ! empty( $email ) )
                    if ( is_wp_error( $error = Validate::email( $email ) ) )
                        add_settings_error(
                            Update::get( 'slug' ),
                            'settings_updated',
                            str_replace( $email, Update::render( 'code', [ 'content' => $email ] ), $error->get_error_message() ),
                            'error'
                        );
                    else $sanitized_emails[] = $email;

            $settings = [
                'git'      => $git,
                'dir'      => $dir,
                'interval' => (int)$interval,
                'emails'   => $sanitized_emails,
                'status'   => (bool)$status
            ];

            if ( isset( $send ) and ! empty( $emails ) ) {
                $subject = '[' . Update::__( 'Update' ) . '] ' . get_site_url() . ' ' . Update::__( 'Test' );
                $message = Update::render( 'pre', [ 'content' => print_r( $settings, true ) ] );

                $mail = new Mail( $emails, $subject, $message );
                if ( $mail->send() )
                    add_settings_error(
                        Update::get( 'slug' ),
                        'settings_updated',
                        sprintf( Update::__( 'Email sent successfully to all recipients: %s.' ),
                            Update::render( 'code', [ 'content' => implode( ', ', $sanitized_emails ) ] ) ),
                        'updated'
                    );
                else
                    add_settings_error(
                        Update::get( 'slug' ),
                        'settings_updated',
                        sprintf( Update::__( 'Something went wrong when sending email to recipients: %s.' ),
                            Update::render( 'code', [ 'content' => implode( ', ', $sanitized_emails ) ] ) ),
                        'error'
                    );
            }

            if ( isset( $push ) ) {
                if ( ! Cron::instance()->schedule() )
                    add_settings_error(
                        Update::get( 'slug' ),
                        'settings_updated',
                        sprintf( Update::__( 'Something went wrong when executing: %s command.' ) . '<br/>' .
                            Update::__( 'Check %s for more details.' ),
                            Update::render( 'code', [ 'content' => 'git push' ] ),
                            Update::render( 'link', [
                                'url' => get_admin_url( null, sprintf( self::URL, Update::get( 'slug' ) . '-logs' ) ),
                                'link' => Update::__( 'logs' ) ] ) ),
                        'error'
                    );
            }

            if ( empty( get_settings_errors( Update::get( 'slug' ) ) ) )
                add_settings_error(
                    Update::get( 'slug' ),
                    'settings_updated',
                    Update::__('Settings saved.' ),
                    'updated'
                );

            return $settings;
        }
    }
}
