<?php
/**
 * Admin Dashboard - Finish Setup
 *
 * @package     WooCommerce\Admin
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_Admin_Dashboard_Finish_Setup', false ) ) :

	/**
	 * WC_Admin_Dashboard_Setup Class.
	 */
	class WC_Admin_Dashboard_Finish_Setup {

		/**
		 * A list of  tasks.
		 *
		 * @var array
		 */
		private $tasks = array(
			'store_details' => array(
				'completed'   => false,
				'description' => 'store_details',
				'button_text' => 'store_details',
			),
			'products'      => array(
				'completed'   => false,
				'description' => 'products',
				'button_text' => 'store_details',
			),
			'tax'           => array(
				'completed'   => false,
				'description' => 'tax',
				'button_text' => 'store_details',
			),
			'shipping'      => array(
				'completed'   => false,
				'description' => 'shipping',
				'button_text' => 'store_details',
			),
			'appearance'    => array(
				'completed'   => false,
				'description' => 'appearance',
				'button_text' => 'store_details',
			),
		);

		/**
		 * WC_Admin_Dashboard_Finish_Setup constructor.
		 */
		public function __construct() {
			$this->populate_tasks();
			! $this->all_tasks_completed() && $this->hook_meta_box();
		}

		/**
		 * Hook meta_box
		 */
		public function hook_meta_box() {
			add_meta_box(
				'wc_admin_dasbharod_finish_setup',
				__( 'WooCommerce Setup', 'woocommerce' ),
				array( $this, 'render_meta_box' ),
				'dashboard',
				'normal',
				'high'
			);
		}

		/**
		 * Render meta box output.
		 */
		public function render_meta_box() {
			$total_number_of_steps = count( $this->tasks );
			$current_step          = $this->get_current_step();
			$current_index         = $current_step['index'];
			write_log( $current_index );
			$current_task = $current_step['task'];
			$description  = $current_task['description'];
			$button_text  = $current_task['button_text'];

			require_once __DIR__ . '/views/html-admin-dashboard-finish-setup.php';
		}

		/**
		 * Populate tasks from the database.
		 */
		private function populate_tasks() {
			$tasks = get_option( 'woocommerce_task_list_tracked_completed_tasks', array() );
			foreach ( $tasks as $task ) {
				if ( isset( $this->tasks[ $task ] ) ) {
					$this->tasks[ $task ]['completed'] = true;
				}
			}
		}

		/**
		 * Check to see if all the tasks have been completed.
		 *
		 * @return bool returns true if all tasks are completed.
		 */
		private function all_tasks_completed() {
			$completed_tasks = array_filter(
				$this->tasks,
				function( $task ) {
					return $task['completed'];
				}
			);

			return count( $completed_tasks ) === count( $this->tasks );
		}

		/**
		 * Get the current task.
		 *
		 * @return array
		 */
		private function get_current_step() {
			$current_step = 0;
			foreach ( $this->tasks as $task ) {
				if ( false === $task['completed'] ) {
					return array(
						'index' => ++$current_step,
						'task'  => $task,
					);
				}
				$current_step++;
			}

			return first( $this->tasks );
		}
	}

endif;

return new WC_Admin_Dashboard_Finish_Setup();
