<?php
namespace Muvitomatic;

class Licensing
{
    protected static $instance = NULL;
    public static function instance()
    {
        if( NULL === self::$instance ) 
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
    public function register_option()
    {
        register_setting("muvitomatic_core_license", "muvitomatic_core_license_key" . md5(home_url()), [$this, "sanitize_license"]);
    }
    public function error_message()
    {
        $status = trim(get_option("muvitomatic_core_license_status" . md5(home_url())));
        if (empty($status) || $status !== "ok") {
            $base_url = admin_url("admin.php?page=" . Utils::SLUG_LICENSE);
            echo "            <div class=\"error notice\">\r\n                <p>";
            _e("Mohon masukan license untuk menggunakan <strong>Muvitomatic</strong> for Muvipro. <a href=\"" . $base_url . "\">Klik Disini</a>", "muvitomatic");
            echo "</p>\r\n            </div>\r\n            ";
        }
    }
    public function getLicense()
    {
        $status = $this::get_status();
        echo "        ";
        if ($status) {
            echo "            <input type=\"submit\"\r\n                   class=\"btn-status is-active\" name=\"\" disabled\r\n                   value=\"";
            _e("License Active");
            echo "\"/>\r\n            ";
            wp_nonce_field("muvitomatic_core_license_nonce", "muvitomatic_core_license_nonce");
            echo "            <label class=\"description\"\r\n                   for=\"idmuvi_core_license_key\">";
            _e("Congratulations, your license is active.<br /> You can disable license for this domain by entering the license key to the form and clicking <strong>Deactivate License</strong>", Utils::TEXT_DOMAIN);
            echo "</label>\r\n            <input type=\"submit\" class=\"btn-deactive\"\r\n                   name=\"muvitomatic_core_license_deactivate\"\r\n                   value=\"";
            _e("Deactivate License", Utils::TEXT_DOMAIN);
            echo "\"/>\r\n\r\n            ";
            $this::check_license();
            echo "            ";
        } else {
            echo "\r\n            <input type=\"submit\"\r\n                   class=\"btn-status not-active\" name=\"\" disabled\r\n                   value=\"";
            _e("License Not Active");
            echo "\"/>\r\n            ";
            wp_nonce_field("muvitomatic_core_license_nonce", "muvitomatic_core_license_nonce");
            echo "            <label class=\"description\"\r\n                   for=\"muvitomatic_core_license_activate\">";
            _e("Oops!, your need to insert the license.<br /> You can get the license from member area. or <a href=\"https://my.clonesia.com/softsale/license/?utm_source=" . home_url() . "\" target=\"_blank\"><strong>Grab it Here</strong></a>", Utils::TEXT_DOMAIN);
            echo "</label>\r\n            <input type=\"submit\" class=\"btn-activate\"\r\n                   name=\"muvitomatic_core_license_activate\"\r\n                   value=\"";
            _e("Activate License", Utils::TEXT_DOMAIN);
            echo "\"/>\r\n            ";
            if (isset($_POST["submit"]) && $status === true) {
                header("Location: admin.php");
            }
            echo "        ";
        }
    }
    public function get_status()
    {
        //$licenseStatus = trim(get_option("muvitomatic_core_license_status" . md5(home_url())));
	$licenseStatus = "ok";
        if ("ok" === $licenseStatus) {
            return true;
        }
        return false;
    }
    public function check_license()
    {
        if (false === get_transient("muvitomatic-core-license-transient")) {
            $license = trim(get_option("muvitomatic_core_license_key" . md5(home_url())));
            $d_license = $this->muvitomatic_license("d", $license);
            $api_params = ["key" => $d_license];
            $query = esc_url_raw(add_query_arg($api_params, Utils::LICENSE_URL_CHECK));
            $response = wp_remote_get($query, ["timeout" => 20, "sslverify" => false]);
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
                return NULL;
            }
            $license_data = json_decode(wp_remote_retrieve_body($response));
            if (is_wp_error($license_data)) {
                return NULL;
            }
            set_transient("muvitomatic-core-license-transient", $license_data, 168 * HOUR_IN_SECONDS);
            if ($license_data->code !== "ok") {
                delete_option("muvitomatic_core_license_status" . md5(home_url()));
            }
        }
    }
    public function activate_license()
    {
        if (isset($_POST["muvitomatic_core_license_activate"])) {
            $license = !empty($_POST["muvitomatic_core_license_key"]) ? $_POST["muvitomatic_core_license_key"] : "";
            $url = home_url();
            if (!check_admin_referer("muvitomatic_core_license_nonce", "muvitomatic_core_license_nonce")) {
                return NULL;
            }
            $api_params = ["key" => $license, "request[url]" => esc_url($url)];
            $query = esc_url_raw(add_query_arg($api_params, Utils::LICENSE_URL_ACTIVATE));
            $response = wp_remote_get($query, ["timeout" => 20, "sslverify" => false]);
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
                if (is_wp_error($response)) {
                    $message = $response->get_error_message();
                } else {
                    $message = __("Error Bangke lu.", Utils::TEXT_DOMAIN);
                }
            } else {
                $license_data = json_decode(wp_remote_retrieve_body($response));
                if ($license_data->code !== "ok") {
                    switch ($license_data->code) {
                        case "license_empty":
                            $msgId = "license_empty";
                            $message = __("Empty or invalid license key submitted.", Utils::TEXT_DOMAIN);
                            break;
                        case "license_not_found":
                            $msgId = "license_not_found";
                            $message = __("License key not found on our server.", Utils::TEXT_DOMAIN);
                            break;
                        case "license_disabled":
                            $msgId = "license_disabled";
                            $message = __("License key has been disabled.", Utils::TEXT_DOMAIN);
                            break;
                        case "license_expired":
                            $msgId = "license_expired";
                            $message = sprintf(__("Your license key expired on %s.", Utils::TEXT_DOMAIN), date_i18n(get_option("date_format"), strtotime($license_data->expires, current_time("timestamp"))));
                            break;
                        case "activation_server_error":
                            $msgId = "activation_server_error";
                            $message = __("Activation server error.", Utils::TEXT_DOMAIN);
                            break;
                        case "invalid_input":
                            $msgId = "invalid_input";
                            $message = __("Activation failed: invalid input.", Utils::TEXT_DOMAIN);
                            break;
                        case "no_spare_activations":
                            $msgId = "no_spare_activations";
                            $message = sprintf(__("No more activations allowed. You must buy new license key.", Utils::TEXT_DOMAIN));
                            break;
                        case "no_activation_found":
                            $msgId = "no_activation_found";
                            $message = __("No activation found for this installation.", Utils::TEXT_DOMAIN);
                            break;
                        case "no_reactivation_allowed":
                            $msgId = "no_reactivation_allowed";
                            $message = __("Re-activation is not allowed", Utils::TEXT_DOMAIN);
                            break;
                        case "other_error":
                            $msgId = "other_error";
                            $message = __("Error returned from activation server", Utils::TEXT_DOMAIN);
                            break;
                        default:
                            $msgId = "error";
                            $message = __("An error occurred, please try again.", Utils::TEXT_DOMAIN);
                    }
                } else {
                    $message = "";
                }
            }
            if ($message === "" && $license_data->scheme_id == Utils::LICENSE_SCHEME) {
                $e_license = $this::muvitomatic_license("e", $license);
                update_option("muvitomatic_core_license_key" . md5(home_url()), $e_license);
                update_option("muvitomatic_core_license_status" . md5(home_url()), "ok");
                $base_url = admin_url("admin.php?page=" . Utils::SLUG_LICENSE);
                $redirect = add_query_arg(["muvitomatic_core_activation" => "true"], $base_url);
                wp_redirect($redirect);
                exit;
            }
            $base_url = admin_url("admin.php?page=" . Utils::SLUG_LICENSE);
            $redirect = add_query_arg(["muvitomatic_core_activation" => "false", "status" => $msgId, "message" => urlencode($message)], $base_url);
            wp_redirect($redirect);
            exit;
        }
    }
    public function deactive_license()
    {
        if (isset($_POST["muvitomatic_core_license_deactivate"])) {
            $license = !empty($_POST["muvitomatic_core_license_key"]) ? $_POST["muvitomatic_core_license_key"] : "";
            $url = home_url();
            if (!check_admin_referer("muvitomatic_core_license_nonce", "muvitomatic_core_license_nonce")) {
                return NULL;
            }
            $api_params = ["key" => $license, "request[url]" => esc_url($url)];
            $query = esc_url_raw(add_query_arg($api_params, Utils::LICENSE_URL_DEACTIVATED));
            $response = wp_remote_get($query, ["timeout" => 20, "sslverify" => false]);
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
                if (is_wp_error($response)) {
                    $message = $response->get_error_message();
                } else {
                    $message = __("An error occurred, please try again.", Utils::TEXT_DOMAIN);
                }
            } else {
                $license_data = json_decode(wp_remote_retrieve_body($response));
                if ($license_data->code != "ok") {
                    switch ($license_data->code) {
                        case "license_empty":
                            $message = __("Empty or invalid license key submitted.", Utils::TEXT_DOMAIN);
                            break;
                        case "license_not_found":
                            $message = __("License key not found on our server.", Utils::TEXT_DOMAIN);
                            break;
                        case "license_disabled":
                            $message = __("License key has been disabled.", Utils::TEXT_DOMAIN);
                            break;
                        case "license_expired":
                            $message = sprintf(__("Your license key expired on %s.", Utils::TEXT_DOMAIN), date_i18n(get_option("date_format"), strtotime($license_data->expires, current_time("timestamp"))));
                            break;
                        case "activation_server_error":
                            $message = __("Activation server error.", Utils::TEXT_DOMAIN);
                            break;
                        case "invalid_input":
                            $message = __("Activation failed: invalid input.", Utils::TEXT_DOMAIN);
                            break;
                        case "no_spare_activations":
                            $message = sprintf(__("No more activations allowed. You must buy new license key.", Utils::TEXT_DOMAIN));
                            break;
                        case "no_activation_found":
                            $message = __("No activation found for this installation.", Utils::TEXT_DOMAIN);
                            break;
                        case "no_reactivation_allowed":
                            $message = __("Re-activation is not allowed", Utils::TEXT_DOMAIN);
                            break;
                        case "other_error":
                            $message = __("Error returned from activation server", Utils::TEXT_DOMAIN);
                            break;
                        default:
                            $message = __("An error occurred, please try again.", Utils::TEXT_DOMAIN);
                    }
                } else {
                    $message = "";
                }
            }
            if ($message == "" && $license_data->scheme_id == Utils::LICENSE_SCHEME) {
                update_option("muvitomatic_core_license_key" . md5(home_url()), "");
                update_option("muvitomatic_core_license_status" . md5(home_url()), "");
                wp_redirect(admin_url("admin.php?page=" . Utils::SLUG_LICENSE));
                exit;
            }
            $base_url = admin_url("admin.php?page=" . Utils::SLUG_LICENSE);
            $redirect = add_query_arg(["muvitomatic_core_activation" => "false", "message" => urlencode($message)], $base_url);
            wp_redirect($redirect);
            exit;
        }
    }
    public function sanitize_license($new)
    {
        $old = get_option("muvitomatic_core_license_key" . md5(home_url()));
        if ($old && $old != $new) {
        }
        return $new;
    }
    public function muvitomatic_license($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = "This is my secret key";
        $secret_iv = "This is my secret iv";
        $key = hash("sha256", $secret_key);
        $iv = substr(hash("sha256", $secret_iv), 0, 16);
        if ($action == "e") {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else {
            if ($action == "d") {
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            }
        }
        return $output;
    }
}

?>
