<?php

/*
 * Example PHP implementation used for the REST example.
 * This file defines a DTEditor class instance which can then be used, as
 * required, by the CRUD actions.
 */

// DataTables PHP library
include( dirname(__FILE__)."/../../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

	
// Build our Editor instance and process the data coming from _POST
$out = Editor::inst( $db, 'tbl_complains' )
	->fields(
		Field::inst( 'id' )->set(false),
		Field::inst( 'regionname' ),
		Field::inst( 'districtname' ),
		Field::inst( 'wardname' ),
		Field::inst( 'villagename' ),			
		Field::inst( 'comp_desc' ),
		Field::inst( 'eng_comment'),
	    Field::inst( 'appeal_note'),
	    Field::inst( 'appeal_date'),
	    Field::inst( 'status')
	    
	    
	)
	->where('cust_name',$_GET['kampuni'],'=')
	->where('status','closed','=')
	->process( $_POST )
	    ->data();
 
// On 'read' remove the DT_RowId property so we can see fully how the `idSrc`
// option works on the client-side.
if ( Editor::action( $_POST ) === Editor::ACTION_READ ) {
    for ( $i=0, $ien=count($out['data']) ; $i<$ien ; $i++ ) {
        unset( $out['data'][$i]['DT_RowId'] );
    }
}
 
// Send it back to the client
echo json_encode( $out );
 
// On 'read' remove the DT_RowId property so we can see fully how the `idSrc`
// option works on the client-side.
