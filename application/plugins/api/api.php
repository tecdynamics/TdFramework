<?php


/**
 * Description of checker
 *
 * @author Mike
 */
class Api {
    public $_action = null,
            $_func = '',
            $_allow = array();
    
    public function __construct($func) {
        $this->_func = $func;
        $arrStr = explode("/", $this->_func);
        $arrStr = array_reverse($arrStr);
         if ($arrStr[0] !== 'getInfo') {
            $this->startApi();
        }
    }

    public function startApi() {
        $method = $_SERVER['REQUEST_METHOD'];
        $request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
        !isset($request) ? $request = '' : '';
        //if(!==__FUNCTION__){     
      //  echo $request;
        switch ($method) {
            case 'PUT':
                $this->setAction(array('method' => strtolower($method),
                    'request' => $this->checkRequest(),
                    'query' => $request));
                break;
            case 'POST':
                $this->setAction(array('method' => strtolower($method),
                    'request' => $this->checkRequest(),
                    'query' => $request));
                break;
            case 'GET':
                $this->setAction(array('method' => strtolower($method),
                    'request' => $this->checkRequest(),
                    'query' => $request));
                break;
            case 'HEAD':
                $this->setAction(array('method' => strtolower($method),
                    'request' => $this->checkRequest(),
                    'query' => $request));
                break;
            case 'DELETE':
                $this->setAction(array('method' => strtolower($method),
                    'request' => $this->checkRequest(),
                    'query' => $request));
                break;
            case 'OPTIONS':
                $this->setAction(array('method' => strtolower($method),
                    'request' => $this->checkRequest(),
                    'query' => $request));
                break;
            default:
                $this->setAction(array('method' => 'purge',
                    'request' => $this->checkRequest(),
                    'query' => $request));
                break;
        }
    }
    public function __call($method, $args) {

        print_r($method);

    }

    /**
     * want to present the comments
     * stracture is on front @ the name of the field.
     * stracture is on front - the value of the field.
     *  * @param type $info string the Path of the file that you
     * @return type XML with all the Coments as description
     */
    public function getInfo($info) {
        $com = array();
        $comments = token_get_all(file_get_contents($info));
        $search = array('/', '*');
        foreach ($comments as $coment) {
               $messages = array();
            if ($coment[0] == T_COMMENT || $coment[0] == T_DOC_COMMENT) {
             $s = str_replace($search, '', $coment[1]);
                foreach (explode('@', $s) as $desc => $info) {
                    if (!empty($desc)) {
                        $in = explode('-', $info);
                        $messages[trim($in[0])] = trim($in[1]);
                    }
                }
            }
            if (!empty($messages)) {
                $com[] = $messages;
            }
          
        }
        return $this->createXml($com);
    }

    /**
     * @cheking if the request is JSON
     * @return boolean|string
     */
    public function checkRequest() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return 'json';
        }
        return false;
    }
    /**
     * Seting the acction of the requested file
     * @param type $action array()
     */
    public function setAction($action) {
        $this->_action = $action;
        $act = 'api_' . $action['method'];
        
        if (false !== (array_search(strtolower($action['method']), array_map('strtolower', $this->_allow)))) {
            $this->{$act}($action['query']);
    } else {
            echo'not Allow';
            print_r($this->_allow);
        }
    }

    public function getAction() {
        return $this->_action;
    }
    
    public function setAllow($allow) {
        $this->_allow = $allow;
    }

    public function getAllow() {
        return $this->_allow;
    }
            /**
     * Genarating an xml file for the response
     * @param type $data array()
     * @return type XML
     */
    public function createXml($data = array()) { 
        $xml = "<data>"; 
        $xml .="<content>";
        foreach ($data as $element) { 
            foreach ($element as $key => $val) {
                if (!empty($key)) {
                    $xml .="<content_data>";
                    $xml .= "<" . trim($key) . ">" . trim($val) . "</" . trim($key) . ">";
                     $xml .="</content_data>";
                }
                         }
        }
        $xml.="</content>";
        $xml.="</data>";
        $xmlobj = new SimpleXMLElement($xml);
        return $xmlobj->asXML();
    }

    //put your code here
}
