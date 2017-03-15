<?php
	$main_class = new MainClass();

	if ( $_POST ) {
		$send_status = $main_class->sendEmails( $_POST );
	}
?>

<div class="wrap">
	<h1>Free Accounts Manager</h1>
	<p>Here you can give the free access to new users, just need a text for the mail and the the emails address of course.</p>
	<p>Then, click <strong>"Send!"</strong> and we will handle the rest.</p>

	<?php if( $send_status['results'] ) { ?>
		<hr>
		<strong>Emails sent!</strong>
		<p>List of created users:</p>
		<ul>
			<?php foreach ( $send_status['results'] as $result ) { ?>
				<li>User ID: <strong><?php echo $result['user_id']; ?></strong> | Order ID: <strong><?php echo $result['order_id']; ?></strong></li>
			<?php } ?>
		</ul>
		<hr>
	<?php } ?>

	<?php if( $send_status['status'] ) { ?>
		<div class="<?php echo $send_status['status']; ?>">
			<p><?php echo $send_status['message']; ?></p>
		</div>
	<?php } ?>

	<br>
	<form method="POST">
		<h3>Email and Content Title | <small>Email title is the main one, while Content title is the first thing inside the content.</small></h3>
		<input type="text" name="title" id="title" placeholder="Email Title" value="<?php if( $send_status['data'] ) { echo $send_status['data']['title']; }; ?>">
		<br><br>
		<input type="text" name="content_title" id="content_title" placeholder="Content Title" value="<?php if( $send_status['data'] ) { echo $send_status['data']['content_title']; }; ?>">

		<br><br>
		<h3>Email Text | <small>Users will see this along with their credentials in the email.</small></h3>
		<?php
			$textarea_content = $send_status['data']['email_text']
				? $send_status['data']['email_text']
				: '';

			echo wp_editor( $textarea_content, 'text', array(
				'textarea_rows' => 5,
				'media_buttons' => false,
				'textarea_name' => 'email_text',
				'quicktags'     => array( 'buttons' => 'strong,em,ul,ol,li' )
			) );
		?>

		<br>
		<h3>Users List | <small>Write all emails you want to enter the course for free.</small></h3>

		<input name="emails" id="emails" value="<?php if( $send_status['data'] ) { echo $send_status['data']['emails']; }; ?>" />

		<br>
		<h3>Product | <small>Choose one product. Used when creating a fake order for the user.</small></h3>
		<div class="box">
			<?php
				$products = $main_class->getAllProductsNoSubscriptions();
				foreach ( $products as $product ) {
					$selected = false;
					if( $send_status['data'] ) {
						$selected = $send_status['data']['product'] == $product->ID;
					}
			?>
				<label for="product_<?php echo $product->ID; ?>">
					<input <?php if( $selected ) { echo 'checked'; } ?> type="radio" name="product" id="product_<?php echo $product->ID; ?>" value="<?php echo $product->ID; ?>">
					<?php echo $product->post_title; ?>
				</label>
			<?php } ?>
		</div>

		<br>
		<h3>Course | <small>Now select the course.</small></h3>
		<div class="box">
			<?php
				$courses = $main_class->getAllCourses();
				foreach ( $courses as $course_id => $course_title ) {
					$selected = false;
					if( $send_status['data'] ) {
						$selected = $send_status['data']['course'] == $course_id;
					}
			?>
				<label for="course_<?php echo $course_id; ?>">
					<input <?php if( $selected ) { echo 'checked'; } ?> type="radio" name="course" id="course_<?php echo $course_id; ?>" value="<?php echo $course_id; ?>">
					<?php echo $course_title; ?>
				</label>
			<?php } ?>
		</div>

		<br>
		<button type="submit" class="button button-primary button-large">Send</button>
	</form>
</div>

<script>
	var $ = jQuery;
	
	$(document).ready(function() {
		var tagSelect = $('#emails');
		tagSelect.tagsInput({
			'minChars'            : 0,
			'removeWithBackspace' : true,
			'interactive'         : true,
			'width'               :'100%',
			'height'              :'100px',
			'delimiter'           : [','],
			'defaultText'         :'Add user emails'
		});
	})
</script>

<style>
	#emails_tag {
		width: 108px !important;
	}

	#emails_tagsinput {
		box-sizing: border-box;
	}

	.box label:first-child {
		margin-right: 15px;
	}

	#title, #content_title {
		width: 100%;
	}
</style>
