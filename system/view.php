<?php

/*
 * Description of Class Views
 * Copyright (c) 2013 - 2014 Tec-Dynamics 
 * 
 * This Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details. 
 * @category   PHP 
 * @package    Framework
 * @copyright  Copyright (c) 2013 - 2014 Tec-Dynamics L.T.D. (http://www.tec-dynamics.co.uk/webphp)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    0.1.5, 2014-12-22  
 */

class View {

    private $pageVars = array();
    private $template;
    private $css = '';
    private $js = '';

    public function __construct($template = 'errors/error404') {
       
        $this->template = BASE .  $this->checkTheExtension($template);
    }

    /**
     * @description Set A single var
     * @param type any $var
     * @param type any $val
     */
    public function set($var, $val) {
        $this->pageVars[$var] = $val;
    }

    /**
     * @description Set A template
     * @param type any $var 
     */
    public function setTemplate($val) {
        
        $this->template = BASE .$this->checkTheExtension($val);
    }

    /**
     * @description Set A array with vars
     * @param type array $var
     */
    public function setarray($var = array()) {
        foreach ($var as $key => $val) {
            $this->pageVars[$key] = $val;
        }
    }

    /**
     * Add a New Styleset to the template
     * Like myfolder/test (test.css) without extension
     * @param type $style string
     */
    public function addStyle($style) {
        $this->css = $style;
    }

    /**
     * Add a New Javascript to the template
     * Like myfolder/test (test.js) without extension
     * @param type $js string
     */
    public function addjs($js) {
        $this->js = $js;
    }

    /**
     * Rendering the template
     */
    public function render() {
        global $config;
        $this->addStyle('helpers/Pagination/css/pagenavi');
        $this->set('pagetitle', $config['pagetitle']);
        extract($this->pageVars);
        ob_start();
        require(BASE . 'include/header.php');
        require($this->template);
        require(BASE . 'include/footer.php');
        if (DEBUG_ENABLED === true) {
            $debug = new engine();
            $debug->debugScript();
        }
        echo ob_get_clean();
    }

    private function checkTheExtension($file) {
        $fileExt = explode('.', $file);
        $ext = count($fileExt) > 1 ? array_pop($fileExt) : $file;
        if (strtolower($ext) == 'php') {
             return $file;
        } else {
             return $file.'.php';
        }
    }

}

//eval(base64_decode('Y2xhc3MgVmlldyB7DQoNCiAgICBwcml2YXRlICRwYWdlVmFycyA9IGFycmF5KCk7DQogICAgcHJpdmF0ZSAkdGVtcGxhdGU7DQogICAgcHJpdmF0ZSAkY3NzPScnOw0KICAgIHByaXZhdGUgJGpzID0gJyc7DQoNCiAgICBwdWJsaWMgZnVuY3Rpb24gX19jb25zdHJ1Y3QoJHRlbXBsYXRlKSB7DQogICAgICAgICR0aGlzLT5wYWdlVmFyc1sncGFnZWluZm8nXSA9ICR0ZW1wbGF0ZTsNCiAgICAgICAgJHRoaXMtPnRlbXBsYXRlID0gQkFTRSAuICR0ZW1wbGF0ZSAuICcucGhwJzsNCg0KICAgIH0NCg0KICAgIC8qKg0KICAgICAqIEBkZXNjcmlwdGlvbiBTZXQgQSBzaW5nbGUgdmFyIA0KICAgICAqIEBwYXJhbSB0eXBlIGFueSAkdmFyDQogICAgICogQHBhcmFtIHR5cGUgYW55ICR2YWwNCiAgICAgKi8NCiAgICBwdWJsaWMgZnVuY3Rpb24gc2V0KCR2YXIsICR2YWwpIHsNCiAgICAgICAgJHRoaXMtPnBhZ2VWYXJzWyR2YXJdID0gJHZhbDsNCiAgICB9DQoNCiAgICAvKioNCiAgICAgKiBAZGVzY3JpcHRpb24gU2V0IEEgYXJyYXkgd2l0aCB2YXJzIA0KICAgICAqIEBwYXJhbSB0eXBlIGFycmF5ICR2YXIgDQogICAgICovDQogICAgcHVibGljIGZ1bmN0aW9uIHNldGFycmF5KCR2YXIgPSBhcnJheSgpKSB7DQogICAgICAgIGZvcmVhY2ggKCR2YXIgYXMgJGtleSA9PiAkdmFsKSB7DQogICAgICAgICAgICAkdGhpcy0+cGFnZVZhcnNbJGtleV0gPSAkdmFsOw0KICAgICAgICB9DQogICAgfQ0KICAgIC8qKg0KICAgICAqIEFkZCBhIE5ldyBTdHlsZXNldCB0byB0aGUgdGVtcGxhdGUNCiAgICAgKiBMaWtlIG15Zm9sZGVyL3Rlc3QgKHRlc3QuY3NzKSB3aXRob3V0IGV4dGVuc2lvbg0KICAgICAqIEBwYXJhbSB0eXBlICRzdHlsZSBzdHJpbmcNCiAgICAgKi8NCiAgICBwdWJsaWMgZnVuY3Rpb24gYWRkU3R5bGUoJHN0eWxlKXsNCiAgICAgICAgJHRoaXMtPmNzcz0kc3R5bGU7DQogICAgfQ0KICAgIC8qKg0KICAgICAqIEFkZCBhIE5ldyBKYXZhc2NyaXB0IHRvIHRoZSB0ZW1wbGF0ZQ0KICAgICAqIExpa2UgbXlmb2xkZXIvdGVzdCAodGVzdC5qcykgd2l0aG91dCBleHRlbnNpb24NCiAgICAgKiBAcGFyYW0gdHlwZSAkanMgc3RyaW5nDQogICAgICovDQogICAgcHVibGljIGZ1bmN0aW9uIGFkZGpzKCRqcyl7DQogICAgICAgICR0aGlzLT5qcz0kanM7DQogICAgfQ0KICAgIC8qKg0KICAgICAqIFJlbmRlcmluZyB0aGUgdGVtcGxhdGUgDQogICAgICovDQogICAgcHVibGljIGZ1bmN0aW9uIHJlbmRlcigpIHsgICAgICAgDQogICAgICAgICR0aGlzLT5hZGRTdHlsZSgnaGVscGVycy9QYWdpbmF0aW9uL2Nzcy9wYWdlbmF2aScpOw0KICAgICAgICBleHRyYWN0KCR0aGlzLT5wYWdlVmFycyk7DQogICAgICAgICR0aGlzLT5kZWNvZCgpOw0KICAgICAgICBvYl9zdGFydCgpOw0KICAgICAgICByZXF1aXJlKEJBU0UgLiAnaW5jbHVkZS9oZWFkZXIucGhwJyk7DQogICAgICAgIHJlcXVpcmUoJHRoaXMtPnRlbXBsYXRlKTsNCiAgICAgICAgcmVxdWlyZShCQVNFIC4gJ2luY2x1ZGUvZm9vdGVyLnBocCcpOw0KICAgaWYgKERFQlVHX0VOQUJMRUQgPT09IHRydWUpIHsNCiAgICAgICAgICAgICRkZWJ1ZyA9IG5ldyBlbmdpbmUoKTsNCiAgICAgICAgJGRlYnVnLT5kZWJ1Z1NjcmlwdCgpOw0KICAgICAgICB9DQogICAgICAgIGVjaG8gb2JfZ2V0X2NsZWFuKCk7DQogICAgfQ0KICAgIHB1YmxpYyBmdW5jdGlvbiBkZWNvZCgpIHsNCiAgICAgICAgLy8gZXZhbChiYXNlNjRfZGVjb2RlKCdJSEpsZEhWeWJpQmxlR2wwS0NrNycpKTsNCiAgICB9DQoNCn0='));
