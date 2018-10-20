<?php

/**
 * Plugin Name: Import/Export CPD Records
 * Plugin URI: http://www.wabar.asn.au
 * Description: Import/Export your CPD Records.
 * Version: 1.0.0
 * Author: WA BAR
 * Author URI: http://www.wabar.asn.au
 */

/**
 * Enqueue custom scripts and styles
 */
function wabar_admin_style() {
	wp_enqueue_style('admin-styles', plugins_url('assets/admin.css', __FILE__));
	wp_enqueue_script('admin-scripts', plugins_url('assets/scripts.js', __FILE__));
	// wp_enqueue_script('admintabletoCSV-scripts', plugins_url('assets/jquery.tabletoCSV.js', __FILE__));
}
add_action('admin_enqueue_scripts', 'wabar_admin_style');

/**
 * Add button on cpd_record list page
 */
function add_cpd_import_export_button() {
	global $current_screen, $pagenow;
	if ('cpd_record' != $current_screen->post_type && $pagenow != 'edit.php') return;

	$import_section = '<div class="section-toggle import_csv_section" style="display: none;"> <form method="POST" id="upload_cpd_form" action="' . get_admin_url() . 'admin-post.php"> <h2>Upload CPD Records CSV</h2> <input id="upload_cpd_file" type="file" name="upload_cpd_file" accept=".csv"> <button id="upload_cpd_btn" class="button button-primary button-large add-field" disabled="disabled" type="submit">Import</button> <em>Please delete the empty rows from the csv.</em> <div class="loader"> <div class="loader-spinner"></div> <div class="loader-text">Importing the CPD Records, this may take some time, do not refresh the page...</div> </div> <div class="message"></div> </form> </div>';

	$export_section = '<div class="section-toggle export_csv_section" style="display: none;"> <form method="POST" id="export_cpd_form" action="' . get_admin_url() . 'admin-post.php"> <h2>Do you want to export all the CPD Records?</h2> <button id="export_cpd_btn" class="button button-primary button-large" type="button">Click here to export</button> <div class="loader"> <div class="loader-spinner"></div> <div class="loader-text">Preparing the CPD Records, this may take some time, do not refresh the page...</div> </div> <div class="message"></div> </div> </div>'; ?>

	<script type="text/javascript">
		var import_section = '<?php echo $import_section; ?>';
		var export_section = '<?php echo $export_section; ?>';
		jQuery(document).ready( function($) {
			var button_div = '<div class="cpd-tools"><a href="javascript:void(0);" class="add-new-h2" id="import_cpd_csv" data-toggle=".import_csv_section">Import All CPD Records from CSV</a><a href="javascript:void(0);" class="add-new-h2" id="export_cpd_csv" data-toggle=".export_csv_section">Export All CPD Records as CSV</a></div>' + import_section + export_section;
			$($(button_div)).insertAfter(".wp-header-end");
		});
	</script>
	<?php
}
add_action('admin_head-edit.php','add_cpd_import_export_button');

/**
 * Ajax function to handle CSV import/export
 */
function admin_imp_exp_cpd_csv() {
	if(isset($_POST['export'])){
		$csv_data = generate_cpd_csv();
		wp_die(json_encode($csv_data));
	} else {
		$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
		if (isset($_FILES['upload_cpd_file']) && $_FILES['upload_cpd_file']['error'] == 0) {
			if(in_array($_FILES['upload_cpd_file']['type'], $mimes)) {
				$files = $_FILES['upload_cpd_file'];
			} else {
				$data = json_encode(array('error' => 'Sorry, file type not allowed. Please upload .csv file.'));
				wp_die($data);
			}
		} else {
			$data = json_encode(array('error' => 'No csv file uploaded!'));
			wp_die($data);
		}
		$fileObj = [
			'upload' => $files,
			'tmp_name' => $files['tmp_name']
		];
		$parsedCPD = parse_cpd_csv($fileObj['tmp_name']);
		wp_die(json_encode($parsedCPD));
	}
	die;
}
add_action('wp_ajax_admin_imp_exp_cpd_csv', 'admin_imp_exp_cpd_csv');

function get_all_cpd_records() {
	$cpd_query = new WP_Query(array(
		'post_type' => 'cpd_record',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'nopaging' => true,
		'meta_key' => 'date',
		'orderby' => array( 'author' => 'ASC', 'meta_value' => 'DESC' )
	));
	return $cpd_query;
}

/**
 * Converting data to CSV
 */
function generate_cpd_csv() {
	$filename = 'CPD-Records-Export-'.date('Ymd').'.csv';
	$data_rows = array();
	$header_row = array('CPD Record ID', 'Member ID', 'First Name', 'Last Name', 'Event Date', 'Provider', 'Activity', 'Points Competency 1', 'Points Competency 1_1', 'Points Competency 2', 'Points Competency 2_1', 'Points Competency 3', 'Points Competency 3_1', 'Points Competency 4', 'Points Competency 4_1');

	$cpd_records_query = get_all_cpd_records();
	if($cpd_records_query->have_posts()):
		while($cpd_records_query->have_posts()): $cpd_records_query->the_post();
			$points_competency_1   = get_field('points_competency_1');
			$points_competency_1_1 = get_field('points_competency_1_1');
			$points_competency_2   = get_field('points_competency_2');
			$points_competency_2_1 = get_field('points_competency_2_1');
			$points_competency_3   = get_field('points_competency_3');
			$points_competency_3_1 = get_field('points_competency_3_1');
			$points_competency_4   = get_field('points_competency_4');
			$points_competency_4_1 = get_field('points_competency_4_1');

			if(empty($points_competency_1)) { $points_competency_1 = '-'; }
			if(empty($points_competency_1_1)) { $points_competency_1_1 = '-'; }
			if(empty($points_competency_2)) { $points_competency_2 = '-'; }
			if(empty($points_competency_2_1)) { $points_competency_2_1 = '-'; }
			if(empty($points_competency_3)) { $points_competency_3 = '-'; }
			if(empty($points_competency_3_1)) { $points_competency_3_1 = '-'; }
			if(empty($points_competency_4)) { $points_competency_4 = '-'; }
			if(empty($points_competency_4_1)) { $points_competency_4_1 = '-'; }

			$date = get_field('date');
			$cpd_date = date('d-m-Y', strtotime(str_replace('/', '-', $date)));
			
			$row = array(
				get_the_ID(),
				get_the_author_meta('ID'),
				get_the_author_meta('first_name'),
				get_the_author_meta('last_name'),
				$cpd_date,
				get_field('provider'),
				get_field('activity'),
				$points_competency_1,
				$points_competency_1_1,
				$points_competency_2,
				$points_competency_2_1,
				$points_competency_3,
				$points_competency_3_1,
				$points_competency_4,
				$points_competency_4_1
			);
			$data_rows[] = $row;

		endwhile;
	endif;
	wp_reset_postdata();

	/*$fh = @fopen( 'php://output', 'w' );
	fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
	fputcsv( $fh, $header_row );
	foreach ( $data_rows as $data_row ) {
		fputcsv( $fh, $data_row );
	}
	fclose( $fh );
	ob_end_flush();*/

	$csv_output = '';
	$hcol_cnt = count($header_row);
	$hdr_row = implode(',', $header_row);
	$csv_output = $csv_output . $hdr_row . ",\n";

	foreach ($data_rows as $data_row) {
		for ($dcol_cnt = 0; $dcol_cnt < $hcol_cnt; $dcol_cnt++) {
			$csv_output .= $data_row[$dcol_cnt] . ",";
		}
		$csv_output .= "\n";
	}

	return array('file_name' => $filename, 'csv_data' => $csv_output);
}

/**
 * Handle CSV data import
 */
function parse_cpd_csv($csvFile) {
	$error_rows = array();
	$success_rows = 0;
	$row_i = 1; // csv row index start
	$csv_file = fopen($csvFile, 'r');
	while (($row = fgetcsv($csv_file)) !== FALSE) {
		if ($row_i === 1) {
			$row_i++;
			continue;
		}
		$cpd_id = $user_id = 0;
		/* for cpd id */
		if(!empty(trim($row[0])) && is_numeric($row[0])) {
			$cpd_id = trim($row[0]);
		}
		/* for author id */
		if(!empty(trim($row[1])) && is_numeric($row[1])) {
			$user_id = trim($row[1]);
		}
		$cpd_date = '';
		$date = !empty(trim($row[4])) ? trim($row[4]) : '';
		if(!empty($date)){
			$clean_date = str_replace('/', '-', $date);
			$cpd_date = date('Y-m-d', strtotime($clean_date));
		}
		$provider = !empty(trim($row[5])) ? trim(esc_html($row[5])) : '';
		$activity = !empty(trim($row[6])) ? trim(esc_html($row[6])) : '';
		$ca_1     = !empty(trim($row[7])) && trim($row[7]) != '-' ? trim($row[7]) : 0;
		$ca_1_1   = !empty(trim($row[8])) && trim($row[8]) != '-' ? trim($row[8]) : 0;
		$ca_2     = !empty(trim($row[9])) && trim($row[9]) != '-' ? trim($row[9]) : 0;
		$ca_2_1   = !empty(trim($row[10])) && trim($row[10]) != '-' ? trim($row[10]) : 0;
		$ca_3     = !empty(trim($row[11])) && trim($row[11]) != '-' ? trim($row[11]) : 0;
		$ca_3_1   = !empty(trim($row[12])) && trim($row[12]) != '-' ? trim($row[12]) : 0;
		$ca_4     = !empty(trim($row[13])) && trim($row[13]) != '-' ? trim($row[13]) : 0;
		$ca_4_1   = !empty(trim($row[14])) && trim($row[14]) != '-' ? trim($row[14]) : 0;

		if(empty($cpd_id) && !empty($user_id)) { // insert new record
			if(!empty($cpd_date) && !empty($provider) && !empty($activity)) {
				$args = array(
					'post_type' => 'cpd_record',
					'post_author' => $user_id,
					'post_status' => 'publish',
				);
				$new_cpd_id = wp_insert_post($args);
				update_field('date', $cpd_date, $new_cpd_id);
				update_field('provider', $provider, $new_cpd_id);
				update_field('activity', $activity, $new_cpd_id);
				update_field('points_competency_1', $ca_1, $new_cpd_id);
				update_field('points_competency_1_1', $ca_1_1, $new_cpd_id);
				update_field('points_competency_2', $ca_2, $new_cpd_id);
				update_field('points_competency_2_1', $ca_2_1, $new_cpd_id);
				update_field('points_competency_3', $ca_3, $new_cpd_id);
				update_field('points_competency_3_1', $ca_3_1, $new_cpd_id);
				update_field('points_competency_4', $ca_4, $new_cpd_id);
				update_field('points_competency_4_1', $ca_4_1, $new_cpd_id);
				$success_rows++;
			} else {
				$error_rows[] = $row_i;
			}
		} elseif(!empty($cpd_id) && !empty($user_id)) { // update record by post id and user id
			$cpd_record = get_post($cpd_id);
			if(!empty($cpd_record) && $cpd_record->post_author == $user_id && !empty($cpd_date) && !empty($provider) && !empty($activity)) {
				update_field('date', $cpd_date, $cpd_id);
				update_field('provider', $provider, $cpd_id);
				update_field('activity', $activity, $cpd_id);
				update_field('points_competency_1', $ca_1, $cpd_id);
				update_field('points_competency_1_1', $ca_1_1, $cpd_id);
				update_field('points_competency_2', $ca_2, $cpd_id);
				update_field('points_competency_2_1', $ca_2_1, $cpd_id);
				update_field('points_competency_3', $ca_3, $cpd_id);
				update_field('points_competency_3_1', $ca_3_1, $cpd_id);
				update_field('points_competency_4', $ca_4, $cpd_id);
				update_field('points_competency_4_1', $ca_4_1, $cpd_id);
				$success_rows++;
			} else {
				$error_rows[] = $row_i;
			}
		} else {
			$error_rows[] = $row_i;
		}
		$row_i++;
	}
	fclose($csv_file);
	if($success_rows > 0){
		$success_msg = 'CPD records imported successfully. Totally ' . $success_rows . ' record(s) affected. Please click here to <a href="'.get_admin_url().'edit.php?post_type=cpd_record">refresh</a> the records list.';
	} else {
		$success_msg = 'No CPD records imported!';
	}
	$response['success'] = $success_msg;
	$err_cnt = count($error_rows);
	if($err_cnt > 0){
		$error_msg = 'Please note that the following CPD record(s) cannot import. Row number(s) [ ' . implode(', ', $error_rows) . ' ] - this may contain empty cells or error in data supplied.';
		$response['error'] = $error_msg;
	}
	return $response;
}
?>