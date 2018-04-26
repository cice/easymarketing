<?php
/**
 * 2018 Easymarketing AG
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@easymarketing.de so we can send you a copy immediately.
 *
 * @author    silbersaiten www.silbersaiten.de <info@silbersaiten.de>
 * @copyright 2014 Easymarketing AG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

class EmarketingLeadModuleFrontController extends ModuleFrontController
{
    public $display_header = false;
    public $display_footer = false;

    public function initContent()
    {
        $log_type = 'lead';
        $response = null;
        $headers = array();

        $message = "\r\n\r\n".'===== '.date('Y.m.d h:i:s').' ====='."\r\n";
        $message .= "\r\n".'Request GET: '.print_r($_GET, true);
        $message .= "\r\n".'Request POST: '.print_r($_POST, true);

        $input_put_data = null;

        if (($_SERVER['REQUEST_METHOD'] == 'PUT'))
        {
            $putresource = fopen("php://input", "r");
            while ($put_data = fread($putresource, 1024))
                $input_put_data .= $put_data;
            fclose($putresource);
        }
        $message .= "\r\n".'Request PUT: '.print_r($input_put_data, true);



        if (!Tools::getIsset('lang') ||
            (Tools::getIsset('lang') && ($id_lang = Language::getIdByIso(Tools::getValue('lang'))) == false)
        ) {
            $id_lang = Configuration::get('PS_LANG_DEFAULT');
        }


        if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION'] != '' && $_SERVER['HTTP_AUTHORIZATION'] == Configuration::get(Emarketing::$conf_prefix.'SHOP_TOKEN')) {
            $data = null;
            if ($input_put_data != null) {
                $data = Tools::jsonDecode($input_put_data, true);
            }
            if ($data == null || !isset($data['snippet'])) {
                $headers[] = $_SERVER['SERVER_PROTOCOL'].' 400 Bad Request';
            } else {
                // do something / save
                Configuration::updateValue(Emarketing::$conf_prefix.'LEAD_TRACKER', $input_put_data);
                $headers[] = $_SERVER['SERVER_PROTOCOL'].' 200 OK';
            }
        } else {
            $headers[] = $_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized';
        }

        header('Content-Type: application/json');

        if (is_array($headers)) {
            foreach ($headers as $param_value) {
                header($param_value);
            }
        }

        $message .= "\r\n".'Response: '.print_r($response, true);
        Emarketing::logToFile($message, $log_type);
        if ($response != null) {
            echo Tools::jsonEncode($response);
        }
        ob_end_flush();
    }

    public function display()
    {
        return true;
    }
}
