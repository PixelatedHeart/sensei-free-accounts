<?php

/**
* Main Class
* This is the place where magic happens.
*/
class MainClass {
	public function sendEmails( $data ) {
		$results = [];

		if( !$data['email_text'] || !$data['emails'] || !$data['product'] || !$data['course'] || !$data['title'] || !$data['content_title'] ) {
			return $this->responseArray( 'error', $data, 'Make sure all fields are filled' );
			exit;
		}

		// Emails validate
		$emails = explode( ',', $data['emails'] );
		foreach ( $emails as $email ) {
			if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
				return $this->responseArray( 'error', $data, 'One or more emails are incorrect. Check the format: "email@email.com"' );
				exit;
			}
		}

		foreach ( $emails as $email ) {
			$password = wp_generate_password( 6, false, false );
			$user_id  = wc_create_new_customer( $email, '', $password );

			if( $user_id->errors ) {
				return $this->responseArray( 'error', $data, end( $user_id->errors )[0] );
				exit;
			}

			$user = get_user_by( 'id', $user_id );

			// Let's create a new Order for that user
			$new_order = wc_create_order(array(
				'customer_id'   => $user_id,
				'status'        => 'completed',
				'customer_note' => 'Gift course.',
				'created_via'   => 'ls_free_account_manager'
			));

			$new_order->set_address( array( 'email' => $email ) );

			// Add the product to the Order
			$product = new WC_Product( $data['product'] );
			$product_added = $new_order->add_product( $product, 1 );

			// Now let's add the user to the course
			if( !$new_order ) {
				return $this->responseArray( 'error', $data, 'There was an error. Please contact support.' );
				exit;
			}

			// At this point all went good, proceed to log results.
			$results[] = array(
				'user_id'  => $user_id,
				'order_id' => $new_order->id
			);

			// Send the email
			$email_template = getEmailTemplate( $data['content_title'], $data['email_text'], $user->data->user_login, $password );
			wp_mail( $email, $data['title'], $email_template, array( 'Content-Type: text/html; charset=UTF-8' ) );
		}

		return $this->responseArray( 'updated', null, 'Accounts created. Emails sent.', $results );
		exit;
	}

	/**
	 * Get all shop products
	 * No susbcription related
	 * @return array
	 */
	public function getAllProductsNoSubscriptions() {
		$products = get_posts( array(
			'numberposts' => -1,
			'post_type'   => 'product',
			'post_status' => 'publish'
		) );

		$result = [];
		foreach ( $products as $product ) {
			if( !WC_Subscriptions_Product::is_subscription( $product->ID ) ) {
				$result[] = $product;
			}
		}

		return $result;
	}

	/**
	 * Get all Courses
	 * No free courses
	 * @return array
	 */
	public function getAllCourses() {
		$result = [];

		switch_to_blog( '2' );

		$query = new WP_Query( array(
			'post_type'        => 'course',
			'post_status'      => 'publish',
			'posts_per_page'   => -1,
			'caller_get_posts' => 1
		) );

		foreach ( $query->posts as $post ) {
			if( !$this->isFreeCourse( $post->ID ) ) {
				$result[$post->ID] = $post->post_title;
			}
		}

		restore_current_blog();

		return $result;
	}

	/**
	 * Check if a course is free
	 * @param course_id
	 * @return boolean
	 */
	private function isFreeCourse( $course_id ) {
		$isFreeCourse = false;

		if( get_the_terms( $course_id, 'course-category' ) ) {
			foreach ( get_the_terms( $course_id, 'course-category' ) as $term ) {
				if( $term->slug == 'free-course' ) {
					$isFreeCourse = true;
				}
			}
		}

		return $isFreeCourse;
	}

	public function responseArray( $status, $data, $message, $results = null ) {
		return array(
			'data'    => $data,
			'status'  => $status,
			'message' => $message,
			'results' => $results
		);
	}
}
