<?php if ( ! defined( 'ABSPATH' ) ) exit();

if ( ! class_exists( 'Bakery_License' ) ) {
	class Bakery_License {
		private $theme_info = array();

		function __construct() {
			$this->theme_info = array(
				'id' => '11112118',
				'name' => 'bakery',
				'version' => BAKERY_THEME_VERSION,
				'url' => 'http://themeforest.net/item/bakery-wordpress-bakery-cakery-food-theme/11112118'
			);

			add_action( 'init', array( $this, 'init' ) );

			if ( ! self::is_valid() ) {
				add_action( 'admin_notices', array( $this, 'admin_notice' ) );
			}

			add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ) );
			add_action( 'switch_theme', array( $this, 'switch_theme' ) );

			add_action( 'wp_dashboard_setup', array($this, 'widget' ) );
			add_action( 'wp_ajax_bakery_save_purchase_code', array( $this, 'save_purchase_code' ) );
			add_action( 'wp_ajax_bakery_remove_purchase_code', array( $this, 'remove_purchase_code' ) );
		}

		public function init() {
			if ( get_option( '_bakery_theme_info' ) == false ) {
				update_option( '_bakery_theme_info', json_encode( $this->theme_info ), true );
			}

			$purchase_code = get_option( '_bakery_theme_license' );

			if ( ! empty( $purchase_code ) && strlen( $purchase_code ) == 36 ) {
				$resposne = self::verify_purchase_code( $purchase_code, 'activate' );

				if ( isset( $resposne['status'] ) && ! empty( $resposne['status'] ) && $resposne['status'] == 'success' ) {
					delete_option( '_bakery_theme_license' );

					update_option( 'envato_purchase_code_11112118', $purchase_code, true );
				}
			}
		}

		public function admin_notice() {
			$screen = get_current_screen();

			if ( $screen->id == 'dashboard' ) {
				return;
			}
			
			ob_start(); ?>
				<style scoped>
					#vu_bakery-license-notice { position: relative; }
				</style>

				<script type="text/javascript">
					(function($) {
						$(document).ready(function() {
							$('#vu_bakery-license-notice .notice-dismiss').on('click', function() {
								var $this = $(this),
									$notice = $this.closest('#vu_bakery-license-notice');

								$notice.slideUp(400, function() {
									$notice.remove();
								});
							});
						});
					})(jQuery);
				</script>

				<div id="vu_bakery-license-notice" class="error">
					<p>
						<strong><?php echo esc_html__( 'Theme license validation:', 'bakery' ); ?></strong>
						<?php echo wp_kses( sprintf( __( 'In order to make the theme fully functional, you need to enter your purchase code <a href="%s#bakery_license_widget_focus">here</a>.', 'bakery' ), esc_url( get_dashboard_url() ) ), array( 'a' => array('href' => array() ) ) ); ?>
					</p>

					<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__( 'Dismiss this notice.', 'bakery' ); ?></span></button>
				</div>
			<?php echo ob_get_clean();
		}

		public function after_switch_theme() {
			if ( get_option( '_bakery_theme_info' ) == false ) {
				update_option( '_bakery_theme_info', json_encode( $this->theme_info ), true );
			}
		}

		public function switch_theme() {
			$resposne = self::verify_purchase_code( self::get_purchase_code(), 'deactivate' );

			if ( isset( $resposne['status'] ) && ! empty( $resposne['status'] ) && $resposne['status'] == 'success' ) {
				delete_option( 'envato_purchase_code_11112118' );
			}

			delete_option( '_bakery_theme_info' );
		}

		public function widget() {
			add_meta_box( 'bakery_license_widget', esc_html__( 'Theme License', 'bakery' ), array( $this, 'widget_content' ), 'dashboard', 'normal', 'high' );
		}

		public function widget_content() {
			$license = self::get_purchase_code();
			?>
				<div id="vu_theme-activation" data-status="<?php echo ( self::is_valid() ) ? 'valid' : 'invalid'; ?>">
					<?php 
						echo self::widget_css();
						echo self::widget_js();
					?>

					<div class="vu_ta-header">
						<p><?php echo wp_kses( sprintf( __( 'In order to enable all theme functionality including demo content installation, you first need to validate your theme license by entering the <a href="%s" target="_blank">purchase code</a> below.', 'bakery' ), 'https://d.pr/6z8Mhr' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></p>
					</div>

					<div class="vu_ta-content">
						<input type="text" class="regular-text" id="vu_ta-txt-purchase-code" autocomplete="off" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" value="<?php echo !empty($license) ? esc_attr($license) : ''; ?>">
					</div>

					<div class="vu_ta-footer">
						<a href="javascript:void(0);" id="vu_ta-btn-save-license" data-action="bakery_save_purchase_code" class="button button-primary"><?php echo esc_html__( 'Validate', 'bakery' ); ?></a>
						<a href="javascript:void(0);" id="vu_ta-btn-remove-license" data-action="bakery_remove_purchase_code" class="button button-secondary"><?php echo esc_html__( 'Remove License', 'bakery' ); ?></a>
						
						<div class="vu_ta-response-message"></div>
						<div class="vu_ta-ajax-loader"></div>
					</div>

					<div class="vu_ta-note">
						<?php echo wp_kses( sprintf( __( 'Note! One theme license per domain is allowed. For any issues with theme activation please refer to this <a href="%s" target="_blank">article</a>. If registered elsewhere please deactivate that license or <a href="%s" target="_blank">purchase</a> another theme copy.', 'bakery'), 'https://milingona.ticksy.com/article/13694/', 'http://go.milingona.co/buy-bakery-theme' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?>
					</div>
				</div>
			<?php 
		}

		public function widget_css() {
			?>
				<style scoped>
					#vu_theme-activation {
						position: relative;
					}
					#vu_theme-activation[data-status]:before {
						content: "";
						position: absolute;
						top: -41px;
						right: 74px;
						height: 24px;
						line-height: 24px;
						font-size: 10px;
						font-weight: bold;
						padding: 0 15px;
						border-radius: 2px;
						text-transform: uppercase;
					}
					#vu_theme-activation[data-status="valid"]:before {
						content: '<?php echo esc_html__( 'Valid', 'bakery' ); ?>';
						color: #fff;
						background-color: #27ae60;
					}
					#vu_theme-activation[data-status="invalid"]:before {
						content: '<?php echo esc_html__( 'Invalid', 'bakery' ); ?>';
						color: #fff;
						background-color: #e74c3c;
					}
					#vu_theme-activation .vu_ta-header {
						margin-bottom: 15px;
					}
					#vu_theme-activation .vu_ta-header p {
						margin: 0 !important;
					}
					#vu_theme-activation .vu_ta-content {
						margin-bottom: 12px;
					}
					#vu_theme-activation .vu_ta-content input {
						width: 100% !important;
						height: 30px;
						padding-top: 3px;
						box-sizing: border-box;
					}
					#vu_theme-activation .vu_ta-footer .button {
						margin-bottom: 2px;
					}
					#vu_theme-activation .vu_ta-footer .button:visible + .button {
						margin-left: 10px;
					}
					#vu_theme-activation .vu_ta-footer .button-secondary {
						color: #dc3232;
					}
					#vu_theme-activation[data-status="valid"] #vu_ta-btn-save-license {
						display: none !important;
					}
					#vu_theme-activation[data-status="invalid"] #vu_ta-btn-remove-license {
						display: none !important;
					}
					#vu_theme-activation .vu_ta-ajax-loader {
						display: none;
						float: right;
						padding: 0;
						margin: 3px 0 3px 20px;
						width: 24px;
						height: 24px;
						background-size: cover;
						background-position: center;
						background-repeat: no-repeat;
						background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHdpZHRoPScyOHB4JyBoZWlnaHQ9JzI4cHgnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIiBjbGFzcz0idWlsLXJpbmctYWx0Ij48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0ibm9uZSIgY2xhc3M9ImJrIj48L3JlY3Q+PGNpcmNsZSBjeD0iNTAiIGN5PSI1MCIgcj0iNDAiIHN0cm9rZT0iI2RkZCIgZmlsbD0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxMCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L2NpcmNsZT48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI0MCIgc3Ryb2tlPSIjNDQ0NDQ0IiBmaWxsPSJub25lIiBzdHJva2Utd2lkdGg9IjYiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCI+PGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ic3Ryb2tlLWRhc2hvZmZzZXQiIGR1cj0iMnMiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIiBmcm9tPSIwIiB0bz0iNTAyIj48L2FuaW1hdGU+PGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ic3Ryb2tlLWRhc2hhcnJheSIgZHVyPSIycyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIHZhbHVlcz0iMTUwLjYgMTAwLjQ7MSAyNTA7MTUwLjYgMTAwLjQiPjwvYW5pbWF0ZT48L2NpcmNsZT48L3N2Zz4=);
					}
					#vu_theme-activation .vu_ta-response-message {
						display: none;
						float: right;
						max-width: calc(100% - 150px);
						height: 30px;
						line-height: 30px;
						white-space: nowrap;
						text-overflow: ellipsis;
						padding: 0 12px;
						margin: 0;
						cursor: default;
						border: none;
						border-radius: 2px;
						background-color: #f9f9f9;
					}
					#vu_theme-activation .vu_ta-response-message.success {
						color: #27ae60;
					}
					#vu_theme-activation .vu_ta-response-message.error {
						color: #e74c3c;
					}
					#vu_theme-activation .vu_ta-note {
						opacity: 0.75;
						margin: 15px -12px -12px;
						padding: 12px 12px;
						border-top: 1px solid #eee;
						background-color: #fafafa;
					}
				</style>
			<?php 
		}

		public function widget_js() {
			?>
				<script type="text/javascript">
					(function ($) {
						$(document).ready(function(e) {
							try {
								if ( window.location.hash.indexOf('#bakery_license_widget_focus') != -1 ) {
									$('#vu_ta-txt-purchase-code').focus();
								}
							} catch(err) {}

							$('#vu_ta-btn-save-license, #vu_ta-btn-remove-license').on('click', function(e) {
								e.preventDefault();

								var $this = $(this),
									$container = $this.closest('#vu_theme-activation'),
									$loader = $container.find('.vu_ta-ajax-loader'),
									$message = $container.find('.vu_ta-response-message'),
									ajaxurl = '<?php echo esc_url(admin_url("admin-ajax.php")); ?>',
									nonce = '<?php echo esc_attr(wp_create_nonce('vu_ta-nonce')); ?>',
									action = $this.data('action') || 'bakery_save_purchase_code',
									purchase_code = $('#vu_ta-txt-purchase-code').val();

								$message.hide().removeClass('error').removeClass('success').text('');
								$loader.show();

								$.post(ajaxurl, {'purchase_code' : purchase_code, '_wpnonce' : nonce, 'action' : action}, function(response) {
									$loader.hide();

									if ( response.message ) {
										$message.text(response.message).fadeIn();
									}

									if ( response.status && response.status == 'success' ) {
										$message.addClass('success');

										if ( action == 'bakery_save_purchase_code' ) {
											$container.attr({'data-status': 'valid'});
											setTimeout(function() {
												location.reload();
											}, 1000);
										} else {
											$container.attr({'data-status': 'invalid'});
										}
									} else {
										$message.addClass('error');
										$container.attr({'data-status': 'invalid'});
									}

									setTimeout(function(){
										$message.trigger('click');
									}, 5000);
								}, 'json');
							});

							$('.vu_ta-response-message').on('click', function(e) {
								e.preventDefault();

								$(this).fadeOut(400, function() {
									$(this).removeClass('error').removeClass('success').text('');
								});
							})
						});
					})(jQuery);
				</script>
			<?php 
		}

		public static function is_valid() {
			$license = self::get_purchase_code();

			if ( ! empty( $license ) && strlen( $license ) == 36 ) {
				return true;
			}

			return false;
		}

		public static function get_purchase_code() {
			$purchase_code = get_option( 'envato_purchase_code_11112118', '', true );
			$purchase_code = $purchase_code ?? get_option( '_bakery_theme_license', '', true );

			return $purchase_code;
		}

		public function save_purchase_code() {
			if ( isset( $_POST['purchase_code'] ) && ! empty( $_POST['purchase_code'] ) && strlen( $_POST['purchase_code'] ) == 36 && isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'vu_ta-nonce' ) ) {
				$resposne = self::verify_purchase_code( $_POST['purchase_code'], 'activate' );

				if ( isset( $resposne['status'] ) && ! empty( $resposne['status'] ) && $resposne['status'] == 'success' ) {
					update_option( 'envato_purchase_code_11112118', $_POST[ 'purchase_code' ], true );
				}

				echo json_encode( $resposne ); exit();
			}

			echo json_encode(
				array(
					'status' => 'error',
					'message' => esc_html__( 'Invalid purchase code!', 'bakery' )
				)
			);

			exit();
		}

		public function remove_purchase_code() {
			if ( isset( $_POST['purchase_code'] ) && ! empty( $_POST['purchase_code'] ) && strlen( $_POST['purchase_code'] ) == 36 && isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'vu_ta-nonce' ) ) {
				$resposne = self::verify_purchase_code($_POST['purchase_code'], 'deactivate');

				if ( isset( $resposne['status'] ) && ! empty( $resposne['status'] ) && $resposne['status'] == 'success' ) {
					update_option( 'envato_purchase_code_11112118', '', true );
				}

				echo json_encode( $resposne ); exit();
			}

			echo json_encode(
				array(
					'status' => 'error',
					'message' => esc_html__( 'Invalid purchase code!', 'bakery' )
				)
			);

			exit();
		}

		private function get_ip() {
			$ip = getenv( 'REMOTE_ADDR' );

			if ( ! in_array( $ip, array( 'localhost', '127.0.0.1', '::1' ) ) ) {
				return $ip;
			} else {
				$response = wp_remote_get( 'https://api.ipify.org/' );

				if ( is_array( $response ) && ! is_wp_error( $response ) ) {
					return $response['body'];
				} else {
					return $ip;
				}
			}
		}

		private function verify_purchase_code( $purchase_code, $action = 'activate' ) {
			$data = array(
				'action' => $action,
				'site' => esc_url( home_url() ),
				'email' => get_option( 'admin_email' ),
				'ip' => self::get_ip(),
				'purchase_code' => $purchase_code
			);

			$response = wp_remote_post(
				'http://apps.milingona.co/theme-activation/',
				array(
					'body' => array(
						'data' => serialize( $data )
					)
				)
			);

			if ( ! is_wp_error( $response ) ) {
				return json_decode( wp_remote_retrieve_body( $response ), true );
			} else {
				return $response->get_error_message();
			}
		}
	}
}

$Bakery_License = new Bakery_License();
