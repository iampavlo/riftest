<?php

add_action( 'wp_ajax_riffchart_remote_credentials', 'riffchart_remote_credentials' );

function riffchart_remote_credentials() {
    // Load input fields for remote connection credentials into the settings page via AJAX
    $riffchart_remote_host = esc_attr(get_option( 'riffchart_remote_host' ));
    $riffchart_remote_database = esc_attr(get_option( 'riffchart_remote_database' ));
    $riffchart_remote_user = esc_attr(get_option( 'riffchart_remote_user' ));
    $riffchart_remote_password = esc_attr(get_option( 'riffchart_remote_password' ));

    $selected_db = $_POST['connection'];
   
    if ( $selected_db == 'local' ) {
        echo '<input type="hidden" name="riffchart_remote_host" value="' . $riffchart_remote_host . '"  />';
        echo '<input type="hidden" name="riffchart_remote_database"  value="' . $riffchart_remote_database . '"  />';
        echo '<input type="hidden" name="riffchart_remote_user"  value="' . $riffchart_remote_user . '"  />';
        echo '<input type="hidden" name="riffchart_remote_password"  value="' . $riffchart_remote_password . '"  />';
        exit();
    } else {
        echo '<div><label for="riffchart_remote_host"><span class="rifflabel" >Host name </span></label><input type="text" name="riffchart_remote_host" id="riffchart_remote_host" value="' . $riffchart_remote_host . '" placeholder="Host" /></div>';
        echo '<div><label for="riffchart_remote_database"><span class="rifflabel" >Database  </span></label><input type="text" name="riffchart_remote_database" id="riffchart_remote_database" value="' . $riffchart_remote_database . '" placeholder="Database" /></div>';
        echo '<div><label for="riffchart_remote_user"><span class="rifflabel" >User </span></label><input type="text" name="riffchart_remote_user" id="riffchart_remote_user" value="' . $riffchart_remote_user . '" placeholder="User" /></div>';
        echo '<div><label for="riffchart_remote_password"><span class="rifflabel" >Password </span></label><input type="text" name="riffchart_remote_password" id="riffchart_remote_password" value="' . $riffchart_remote_password . '" placeholder="Password" /></div>';
        exit();
    }
}

add_action( 'wp_ajax_nopriv_riffchart_get_data', 'riffchart_get_data' );
add_action( 'wp_ajax_riffchart_get_data', 'riffchart_get_data' );

function riffchart_get_data() {
    //creating array for Google Chart
    //Array would be returned to js script as string 

    global $wpdb;

    $selected_db = esc_attr( get_option( 'riffchart_local_remote' ) );

    require __DIR__ . '/sql/datequery.php';
    require __DIR__ . '/sql/chartquery_full.php';

    if ( $selected_db == 'remote' ) {
        $user = esc_attr( get_option( 'riffchart_remote_user' ) );
        $pass = esc_attr( get_option( 'riffchart_remote_password' ) );
        $db_name = esc_attr( get_option( 'riffchart_remote_database' ) );
        $host = esc_attr( get_option( 'riffchart_remote_host' ) );

        $mydb = new wpdb( $user, $pass, $db_name, $host );
        $rows1 = $mydb->get_results( $sql3 );
        $groups = $mydb->get_results( $sql2 );
        $rows2 = $mydb->get_results( $sql1 );
    } else {
        $rows1 = $wpdb->get_results( $sql3 );
        $groups = $wpdb->get_results( $sql2 );
        $rows2 = $wpdb->get_results( $sql1 );
    }

    //getting list of supergroups and array with groups id's as keys
    $goupsdata = array();
    $annotation = "['Groups',";
    foreach ( $groups as $group ) {
        $annotation .= "'" . $group->top_nameshort . "',";
        $goupsdata[ $group->pg_id ] = '0';
    }

    $annotation .= "{role: 'annotation'}]";
    $dataarray = array();
    //array with groups id's as keys for every day
    foreach ( $rows1 as $row ) {
        $dataarray[ $row->orderdate ] = $goupsdata;
    }

    foreach ( $dataarray as $key => $val ) {
        foreach ( $rows2 as $row ) {
            if ( $row->orderdate == $key ) {
                $dataarray[ $key ][ $row->pg_id ] = $row->tot;
            }
        }
    }

    $dataarray1 = array();

    foreach ( $dataarray as $key => $val ) {
        $dataarray1[ $key ] = "['" . $key . "'";
        foreach ( $val as $row ) {
            $dataarray1[ $key ] .= ", " . $row;
        }
        $dataarray1[ $key ] .= ",'']";
    }

    $result = "[" . $annotation;
    foreach ( $dataarray1 as $d1 ) {
        $result.= ", " . $d1;
    }
    $result.="]";
    echo $result;
    exit();
}
