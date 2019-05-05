<?php

class DOIFDAdminFormTable extends DOIFD_List_Table {

    function __construct() {
        global $status, $page;

        //Set parent defaults
        parent::__construct( array(
            'singular' => 'form', //singular name of the listed records
            'plural' => 'forms', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ) );
    }

    function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'Form Name':
            case 'Date / Time':
                return $item[ $column_name ];
        }
    }

    function column_name( $item ) {

        $title = 'Edit Form';
        $buttonAction = 'update_form';
        $nonce = 'doifd-edit-form-nonce';
        $formID = 'doifd_admin_edit_form_form';
        $buttonTxt = 'Update Form';
                
        $doifd_lab_nonce = wp_create_nonce( 'doifd-delete-form-nonce' );
        //Build row actions
        $actions = array(
           'delete' => sprintf( '<a href="?page=%s&action=%s&name=%s&_wpnonce=%s&id=%s" class="confirm" >' . __( 'Delete',  $this->plugin_slug ) . '</a>', $_REQUEST[ 'page' ], 'delete', 'delete', $doifd_lab_nonce, $item[ 'doifd_form_id' ] ),
           'edit'=>sprintf ( '<a href="admin.php?page=doifd-admin-menu_manage_forms&formID=%s&task=%s&buttoncmd=%s&nonce=%s&&buttonTxt=%s" >' . __ ( 'Edit', $this->plugin_slug ) . '</a>', $item[ 'doifd_form_id' ], $title, $buttonAction, $nonce, $buttonTxt ) ,
        );

        //Return the title contents
        return sprintf( '%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
                /* $1%s */ $item[ 'doifd_name' ],
                /* $2%s */ $item[ 'doifd_form_id' ],
                /* $4%s */ $this->row_actions( $actions )
        );
    }

    function column_form_name( $item ) {

        //Return the title contents
        return sprintf( '%1$s',
                /* $1%s */ $item[ 'dofid_form_name' ]
        );
    }

    function column_time( $item ) {

        //Return the title contents
        return sprintf( '%1$s',
                /* $1%s */ $item[ 'time' ]
        );
    }

    function column_cb( $item ) {

        return sprintf(
                '<input type="checkbox" name="id[]" value="%1$s" />',
                /* $1%s */ $item[ 'doifd_form_id' ] //The value of the checkbox should be the record's id
        );
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'name' => __( 'Form Name',  $this->plugin_slug ),
            'time' => __( 'Date / Time',  $this->plugin_slug )
        );
        return apply_filters( 'doifd_form_table_headers', $columns );
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array( 'name', false ), //true means it's already sorted
            'time' => array( 'time', false )
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action() {

        global $wpdb;

        $table_name = $wpdb->prefix . 'doifd_lab_forms'; // do not forget about tables prefix
        //Detect when a bulk action is being triggered...
        if( 'delete' === $this->current_action() ) {
            $ids = isset( $_REQUEST[ 'id' ] ) ? $_REQUEST[ 'id' ] : array( );
            if( is_array( $ids ) ) $ids = implode( ',', $ids );

            // delete subscriber from subscriber table
            if( !empty( $ids ) ) {
                $wpdb->query( "DELETE FROM $table_name WHERE doifd_form_id IN($ids)" );
                $deleteCSS = DOIFD_DIR . 'public/assets/css/form' . $ids . '.css';
                unlink($deleteCSS);
            }
        }
    }

    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 5;

        $columns = $this->get_columns();
        $hidden = array( );
        $sortable = $this->get_sortable_columns();


        $this->_column_headers = array( $columns, $hidden, $sortable );

        $this->process_bulk_action();

        $sql = "SELECT * FROM " . $wpdb->prefix . "doifd_lab_forms" ;
        $doifd_lab_form_results = $wpdb->get_results ( $sql , ARRAY_A ) ;

        $data = $doifd_lab_form_results;

        function usort_reorder( $a, $b ) {
            $orderby = (!empty( $_REQUEST[ 'orderby' ] )) ? $_REQUEST[ 'orderby' ] : 'time'; //If no sort, default to title
            $order = (!empty( $_REQUEST[ 'order' ] )) ? $_REQUEST[ 'order' ] : 'desc'; //If no order, default to desc
            $result = strcmp( $a[ $orderby ], $b[ $orderby ] ); //Determine sort order
            return ($order === 'asc') ? $result : -$result; //Send final sort direction to usort
        }

        usort( $data, 'usort_reorder' );

        $current_page = $this->get_pagenum();

        $total_forms = count( $data );

        $data = array_slice( $data, (($current_page - 1) * $per_page ), $per_page );

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_forms, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil( $total_forms / $per_page )   //WE have to calculate the total number of pages
        ) );
    }

}
