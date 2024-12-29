<?php
/**
 * Plugin Name:       EmailIt Interface
 * Plugin URI:        https://github.com/stingray82/
 * Description:       Interface for configuring EmailIt SMTP settings.
 * Version:           1.2.1
 * Author:            Stingray82
 * Author URI:        https://github.com/stingray82/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       emailit-interface
 * Domain Path:       /languages
 */

// Hardcoded SMTP settings
define( 'EMAILIT_HOST', 'smtp.emailit.com' );
define( 'EMAILIT_USERNAME', 'emailit' );

/**
 * Register plugin settings.
 */
function emailit_register_settings() {
    register_setting( 'emailit_options', 'emailit_port' );
    register_setting( 'emailit_options', 'emailit_api_key' );
    register_setting( 'emailit_options', 'emailit_from_name' );
    register_setting( 'emailit_options', 'emailit_from_email' );
    register_setting( 'emailit_options', 'emailit_debug' );
}
add_action( 'admin_init', 'emailit_register_settings' );

/**
 * Add a settings page under Tools.
 */
function emailit_menu() {
    add_management_page(
        'EmailIt Settings',
        'EmailIt Settings',
        'manage_options',
        'emailit-settings',
        'emailit_settings_page'
    );
}
add_action( 'admin_menu', 'emailit_menu' );

/**
 * Render the settings page.
 */
function emailit_settings_page() {
    $default_port = 587; // Default Port
    $smtp_ports = [
        '25'   => '25 (STARTTLS)',
        '465'  => '465 (SMTPS)',
        '587'  => '587 (STARTTLS)',
        '2525' => '2525 (STARTTLS)',
    ];
    ?>
    <div class="wrap">
        <h1>
            <svg id="Layer_2" class="h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 53.02 45.95" style="height: 30px; vertical-align: middle; margin-left: 10px;">
                <g id="Layer_1-2">
                    <g id="mail-send-envelope--envelope-email-message-unopened-sealed-close">
                        <g id="Subtract">
                            <path d="m7.83,45.41c3.85.27,9.96.55,18.68.54,8.72,0,14.84-.29,18.68-.56,3.85-.27,6.9-3.18,7.25-7.06.29-3.34.58-8.38.57-15.36,0-.44,0-.88,0-1.3-3.14,1.45-6.31,2.83-9.51,4.13-2.95,1.19-6.15,2.39-9.11,3.29-2.91.89-5.74,1.55-7.88,1.55s-4.98-.66-7.88-1.55c-2.96-.9-6.16-2.1-9.11-3.29C6.31,24.5,3.14,23.13,0,21.68c0,.43,0,.86,0,1.31,0,6.98.29,12.02.58,15.36.34,3.89,3.4,6.79,7.25,7.06Z" fill="#15c182" stroke-width="0"></path>
                            <path d="m.05,17.8c.1-4.37.31-7.74.52-10.19C.91,3.73,3.97.83,7.82.56,11.67.29,17.78,0,26.5,0c8.72,0,14.84.28,18.68.54,3.85.27,6.91,3.17,7.25,7.06.22,2.45.43,5.81.53,10.19-.04.02-.08.03-.12.05l-.05.02-.16.08c-.98.46-1.95.91-2.94,1.35-2.48,1.12-4.98,2.19-7.51,3.22-2.9,1.17-6,2.33-8.82,3.19-2.87.88-5.27,1.4-6.85,1.4s-3.98-.52-6.85-1.39c-2.82-.86-5.92-2.02-8.82-3.19-3.52-1.42-7.01-2.95-10.45-4.56l-.16-.08-.05-.02s-.08-.04-.12-.05h0Z" fill="#007b5e" stroke-width="0"></path>
                        </g>
                    </g>
                </g>
            </svg>
            <span>emailIt Setup</span>
        </h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'emailit_options' );
            do_settings_sections( 'emailit_options' );
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="emailit_port">SMTP Port</label></th>
                    <td>
                        <select id="emailit_port" name="emailit_port" class="regular-text">
                            <?php foreach ( $smtp_ports as $value => $label ) : ?>
                                <option value="<?php echo esc_attr( $value ); ?>" <?php selected( get_option( 'emailit_port', $default_port ), $value ); ?>>
                                    <?php echo esc_html( $label ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="emailit_api_key">API Key</label></th>
                    <td><input type="password" id="emailit_api_key" name="emailit_api_key" value="<?php echo esc_attr( get_option( 'emailit_api_key' ) ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="emailit_from_name">From Name</label></th>
                    <td><input type="text" id="emailit_from_name" name="emailit_from_name" value="<?php echo esc_attr( get_option( 'emailit_from_name' ) ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="emailit_from_email">From Email</label></th>
                    <td><input type="email" id="emailit_from_email" name="emailit_from_email" value="<?php echo esc_attr( get_option( 'emailit_from_email' ) ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="emailit_debug">Enable Debugging</label></th>
                    <td>
                        <input type="checkbox" id="emailit_debug" name="emailit_debug" value="1" <?php checked( get_option( 'emailit_debug', 0 ), 1 ); ?> />
                        <p class="description">Enable detailed SMTP debugging output (check error logs for details).</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


/**
 * Configure SMTP settings for outgoing mail.
 */
function emailit_configure_smtp( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = EMAILIT_HOST;
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = get_option( 'emailit_port', 587 ); // Default to 587
    $phpmailer->Username   = EMAILIT_USERNAME;
    $phpmailer->Password   = get_option( 'emailit_api_key' );
    $phpmailer->SMTPSecure = 'tls'; // STARTTLS default

    // Enable debugging if the option is checked
    $debug = get_option( 'emailit_debug', 0 );
    if ( $debug ) {
        $phpmailer->SMTPDebug  = 3; // Enable detailed debug output
        $phpmailer->Debugoutput = function( $str, $level ) {
            error_log( "SMTP Debug: $str" );
        };
    }
}
add_action( 'phpmailer_init', 'emailit_configure_smtp' );

/**
 * Force emails to use the specified From Email.
 */
function emailit_set_from_email( $email ) {
    return get_option( 'emailit_from_email', '' );
}
add_filter( 'wp_mail_from', 'emailit_set_from_email' );

/**
 * Force emails to use the specified From Name.
 */
function emailit_set_from_name( $name ) {
    return get_option( 'emailit_from_name');
}
add_filter( 'wp_mail_from_name', 'emailit_set_from_name' );
