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

class EmarketingProductsModuleFrontController extends ModuleFrontController
{
    public $display_header = false;
    public $display_footer = false;

    public function initContent()
    {
        //parent::initContent();

        $log_type = 'products';
        $response = null;
        $headers = array();

        $message = "\r\n\r\n".'===== '.date('Y.m.d h:i:s').' ====='."\r\n";
        $message .= "\r\n".'Request: '.print_r($_GET, true);
        $message .= "\r\n".'Request: '.print_r($_POST, true);



        if (!Tools::getIsset('lang')
            || (Tools::getIsset('lang')
                && ($id_lang = Language::getIdByIso(Tools::getValue('lang'))) == false)) {
            $id_lang = Configuration::get('PS_LANG_DEFAULT');
        }
    
        $requestToken = "";
        if (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            if (isset($requestHeaders['Authorization'])) {
                $requestToken = $requestHeaders['Authorization'];
            }
        } else {
            $requestHeaders = $_SERVER;
            if (isset($requestHeaders['HTTP_AUTHORIZATION'])) {
                $requestToken = $requestHeaders['HTTP_AUTHORIZATION'];
            }
        }
    
        if (!empty($requestToken) && $requestToken == Configuration::get(Emarketing::$conf_prefix.'SHOP_TOKEN')) {

            if (Tools::getIsset('offset') && Tools::getIsset('limit') &&
                Validate::isInt(Tools::getValue('offset')) && Validate::isInt(Tools::getValue('limit'))
            ) {
                $offset = Tools::getValue('offset');
                $limit = Tools::getValue('limit');

                $products = $this->module->getProducts(
                    $id_lang,
                    $offset,
                    $limit,
                    'id_product',
                    'ASC',
                    false,
                    true,
                    null
                );
                $currency = $this->module->getCurrency();
                $shipping_carriers = $this->module->getShippingCarriers($id_lang);

                if (count($products) > 0) {
                    $response = array(
                        'products' => array(),
                    );

                    foreach ($products as $product) {
                        $response['products'][] = $this->module->getProductInfo(
                            $product,
                            $shipping_carriers,
                            $id_lang,
                            $currency
                        );
                    }
                }
            } else {
                $headers[] = $_SERVER['SERVER_PROTOCOL'].' 400 Bad Request';
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
