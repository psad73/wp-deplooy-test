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

use WP_List_Table;

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( __NAMESPACE__ . '\Table' ) ) {
    class Table extends WP_List_Table {
        public function __construct() {
            parent::__construct( [
                'singular' => Update::get( 'slug' ) . '-logs',
                'plural'   => Update::get( 'slug' ) . '-logs',
                'ajax'     => false
            ] );
        }

        public function get_columns() {
            return [
                'id'   => Update::__( '#' ),
                'date' => Update::__( 'Date' ),
                'data' => Update::__( 'Data' ),
            ];
        }

        public function column_default( $item, $column_name ) {
            if ( 'data' === $column_name ) return Update::render( 'pre', [ 'content' => $item[$column_name] ] );
            return isset( $item[$column_name] ) ? $item[$column_name] : print_r( $item, true );
        }

        public function no_items() {
            echo Update::__( 'No logs available.' );
        }

        public function get_orderby() {
            return isset( $_REQUEST['orderby'] ) ? sanitize_sql_orderby( $_REQUEST['orderby'] ) : 'id';
        }

        public function get_order() {
            if ( isset( $_REQUEST['order'] ) and in_array( strtoupper( $_REQUEST['order'] ), [ 'ASC', 'DESC' ] ) )
                return strtoupper( $_REQUEST['order'] );
            return 'DESC';
        }

        public function prepare_items() {
            $per_page     = $this->get_items_per_page( 'logs_per_page', 20 );
            $current_page = $this->get_pagenum();
            $orderby      = $this->get_orderby();
            $order        = $this->get_order();
            $total_items  = DB::count();

            // TODO wrong pagination
            $this->set_pagination_args( [
                'total_items' => $total_items,
                'per_page'    => $per_page
            ] );

            $columns  = $this->get_columns();
            $hidden   = [];
            $sortable = [];
            $this->_column_headers = [ $columns, $hidden, $sortable ];

            $this->items = DB::select( $per_page, $current_page, $orderby, $order );
        }
    }
}
