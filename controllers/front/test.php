<?php

class EmarketingTestModuleFrontController extends ModuleFrontController
{
    public $display_header = false;
    public $display_footer = false;

    public function initContent()
    {
        //$this->testProducts();
        //$this->testConversion();
        //$this->testCategories();
    }

    public function display()
    {
        return true;
    }

    public function testCategories() {
        $crl = curl_init('http://vostok-zapad.de/2010_intern/ps_1.7.3.0_dhli/en/module/emarketing/categories?id=2');

        $headr = array();
        $headr[] = 'Content-length: 0';
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: 1';

        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER,1);
        $rest = curl_exec($crl);

        curl_close($crl);

        echo $rest;
    }

    public function testProducts() {
        $crl = curl_init('http://vostok-zapad.de/2010_intern/ps_1.7.3.0_dhli/en/module/emarketing/products?offset=0&limit=10');

        $headr = array();
        $headr[] = 'Content-length: 0';
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: 1';

        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER,1);
        $rest = curl_exec($crl);

        curl_close($crl);

        echo $rest;
    }

    public function testLead() {
        $crl = curl_init('http://vostok-zapad.de/2010_intern/ps_1.7.3.0_dhli/en/module/emarketing/lead');

        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: 1';

        $data = array(
            'snippet' => "<!-- Event snippet for 86urrt conversion page -->\n<script>\n  gtag('event', 'conversion', {\n      'send_to': 'AW-823gsgsdf123123',\n      'transaction_id': ''\n  });\n</script>",
            'tag' => "<!-- Global site tag (gtag.js) - Google AdWords: 12345678 -->\n<script async src=\"https://www.googletagmanager.com/gtag/js?id=AW-12345678\"></script>\n<script>\n  window.dataLayer = window.dataLayer || [];\n  function gtag(){dataLayer.push(arguments);}\n  gtag('js', new Date());\n\n  gtag('config', 'AW-12345678');\n</script>"
        );
        $data_json = json_encode($data);
        $headr[] = 'Content-Length: ' . strlen($data_json);

        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($crl, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER,1);
        $rest = curl_exec($crl);

        curl_close($crl);

        echo $rest;
    }

    public function testConversion() {
        $crl = curl_init('http://vostok-zapad.de/2010_intern/ps_1.7.3.0_dhli/en/module/emarketing/conversion');

        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: 1';

        $data = array(
            'snippet' => "<!-- Event snippet for 86urrt conversion page -->\n<script>\n  gtag('event', 'conversion', {\n      'send_to': 'AW-823gsgsdf123123',\n      'transaction_id': ''\n  });\n</script>",
            'tag' => "<!-- Global site tag (gtag.js) - Google AdWords: 12345678 -->\n<script async src=\"https://www.googletagmanager.com/gtag/js?id=AW-12345678\"></script>\n<script>\n  window.dataLayer = window.dataLayer || [];\n  function gtag(){dataLayer.push(arguments);}\n  gtag('js', new Date());\n\n  gtag('config', 'AW-12345678');\n</script>"
        );
        $data_json = json_encode($data);
        $headr[] = 'Content-Length: ' . strlen($data_json);

        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($crl, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($crl, CURLOPT_VERBOSE, 1);
        //curl_setopt($crl, CURLOPT_HEADER, 1);

        $rest = curl_exec($crl);



        print_r(curl_getinfo($crl));

        curl_close($crl);

        echo $rest;
    }
}


