<?php

/**
 * CC-Update
 *
 * @package     CC-Update
 * @author      PiotrPress
 * @copyright   2018 Clearcode
 * @license     GPL-3.0+
 *
 * @wordpress-plugin
 * Plugin Name: CC-Update
 * Plugin URI:  https://wordpress.org/plugins/cc-update
 * Description: This plugin allows you to automatically send changes to your GIT repository, immediately after any update is made on your site.
 * Version:     1.0.0
 * Author:      Clearcode
 * Author URI:  https://clearcode.cc
 * Text Domain: cc-update
 * Domain Path: /languages/
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt

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

use Clearcode\Framework\v3\Autoloader;
use Exception;

defined( 'ABSPATH' ) or exit;

try {
    require __DIR__ . '/vendor/autoload.php';
    new Autoloader( [ __NAMESPACE__ . '\\Update\\' => __DIR__ . '/includes' ] );

    require __DIR__ . '/includes/Update.php';
    Update::instance( __FILE__ );
} catch ( Exception $exception ) {
    if ( WP_DEBUG && WP_DEBUG_DISPLAY )
          echo $exception->getMessage();
    error_log( $exception->getMessage() );
}
