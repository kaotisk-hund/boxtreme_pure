<?php

namespace BoxTreme\Core;
//use BoxTreme\Gui;
/*
 * Because this class happens to be huge now and will grow even more I decided
 * to start commenting its functions so you can read and I can develop further
 * without conflicts. Happy reading!
 */



/*
 * Class Gui
 * 
 * I think it soon will be more to say
 * 
 */
class Gui{
    /*
    * GUI_DIR
    * Default: ROOT_DIR.'/gui'
    */
    const GUI_DIR = ROOT_DIR.'/gui';

    /*
     * TEMPLATE_FILENAME
     * Default: '/template.php'
     */
    const TEMPLATE_FILENAME = self::GUI_DIR.'/template.php';
    
    /*
     * @param string $title The site title;
     */
    private $title;
    
    /*
     * @param string $charset The charset
     */
    private $charset = 'utf-8';
    
    /*
     * @param string $viewport Viewport
     */
    private $viewport;
    
    /*
     * @param array $css Array of css files to load
     */
    private $css = array();
    
    /*
     * @param array $head_scripts Array of script files to load
     */
    private $head_scripts = array();
    
    /*
     * @param string $template Template file contents
     */
    private $template = 'null';
    
    /*
     * @param 
     */
    private $body_elements = null;
    
    /*
     * @param array $footer_elements Array of elements for footer
     */
    private $footer_elements = null;
    
    /*
     * @param int $last_div_id Id of last div
     */
    private $last_div_id = 1;
    
    /*
     * @param array $tmp_array A temporary array for the class
     */
    private $tmp_array = [];
    
    /*
     * @param String $language The language tag for html
     */
    private $language = null;
    
    /*
     * @param Array $topbarmenu
     */
    static private $topbarmenu = [];
    
    /*
     * @param Array $messages
     */
    static private $messages = [];
    
    /*
     * @param Array $body
     */
    static private $body = [];
    
    /*
     * @param mySQL $mySQL
     */
    private $mySQL;
    
    /*
     * @param Array $settings
     */
    private $settings;
    
    private $state;

    /*
     * @param Script?! $script
     */
    private $script;
    
    
    /*
     * As we make the new object we also start the gui (read more at startGui()
     * 
     */
    public function __construct($language){
        $this->language = $language;
        $this->init();
        
    }
    
    /* 
     * The classic init() function :)
     */
    function init(){
        $this->mySQL = new MySQL(SQL_USER, SQL_PASS, SQL_DB, SQL_HOST);
        $this->mySQL->select("bx_Settings");
        if(isset($this->mySQL->return_data)){
            foreach( $this->mySQL->return_data as $key => $data ){
                $this->settings[$data['what']] = $data['data'];
            }
        }
        // Get template contents
        $this->template = file_get_contents(self::TEMPLATE_FILENAME);
    }


    /*
     * Just outputs an array to string
     */
    function justEchoing($array){
        $a = '';
        if(is_array($array)){
            for ($i = 0; $i < count($array); $i++){
                $a .= '<p>'.$array[$i].'</p>';
            }
        } else {
            $a .= '<p>'.$array.'</p>';
        }
        
        return $a;
    }
    
/*    public function startDiv($class,$id){
//        ?><div class="<?php echo $class;?>" id="<?php echo $id;?>"><?php
//    }
//    
//    public function endDiv(){
//        ?></div><?php
/    }*/
            
    public function headIt($size,$data){
        echo '<h'.$size.'>'.$data.'</h'.$size.'>';
    }
    
    public function imgIt($fullfilename) {
        return '<img src=\''.$fullfilename.'\'>';
    }
    

    
    function script($src = '',$data = ''){
        $output = '';
        if ($src != ''){
            $output = '<script src="'.$src.'">';
        } else {
            $output = '<script>';
        }
        if ($data != ''){
            $output .= $data;
        }
        if ($output != ''){
            $output .= '</script>';
        }
        return $output;
    }
    

    
    /*
     * This was the constructor function at Head.class that was removed and became
     * a function here :)
     * 
     * @param string $title
     * @param string $charset
     * @param string $viewport
     * @param string $css
     * @param string $script
     */
    public function head($charset, $viewport, $css, $script) {
        $this->title = $this->settings['site_title'];
        $this->charset = $charset;
        $this->viewport = $viewport;
        if(is_array($css)){
            foreach ($css as $key => $value) {
                if(!is_array($css[$key])){
                    $this->css[$key] = $css[$key];
                }
            }
        }
        else{
            $this->css = $css;
        }
        $this->script = $script; // Script lines should do too
        
        
        
    }
    
   
    
    // We make a special loader for css for independance later
    function loadCSS(){
        echo "<!-- CSS elements are loaded here -->\n";
        if(is_array($this->css)){
            foreach ($this->css as $key => $value) {
                if(!is_array($this->css[$key])){
                    echo "<link rel=\"stylesheet\" href=\"{$this->css[$key]}\"/>\n";
                }
            }
        }
        else{
            echo "<link rel=\"stylesheet\" href=\"{$this->css}\"/>";
            
        } 
    }
    
    /*
     * Loads metadata to the output page.
     */
    function loadMeta(){
        echo "<!-- Metadata here -->\n";
            ?>
<meta charset="<?php echo $this->charset;?>"/>
<meta name="viewport" content="<?php echo $this->viewport;?>"/>
<?php
    }
    
    /*
     * Loads script that are loaded at <head> section.
     */
    function headScripts(){
        echo "<!-- Head scripts here -->\n";
        ?>
<script src="<?php echo $this->script;?>"></script>
<?php
    }
    
    /*
     * Loads the page title.
     */
    function loadTitle(){
        echo $this->settings['site_title'];
    }

    /*
     * Loads the favicon.
     */
    function loadFavicon(){
        echo $this->settings['favicon_path'];
    }

    
    /*
     * @returns Boolean $headEnabled()
     */
    function headEnabled(){
        return $this->settings['head_enabled'];
    }


    /*
     * Loads the template
     */
    function body(){
        eval('?>'.$this->template);
    }
    
    /*
     * Returns divided elements of $GLOBALS['body'] array or 404
     */
    function get_body_elements(){
        if(isset($GLOBALS['body'])){
            return $this->div_elements($GLOBALS['body']);
        } else {
            return '404';
            
        }
    }
    

    
    
    /* 
     * Creates a group of div elements from array
     */
    function div_elements($array){
        $a = '';
        if(is_array($array)){
            for ($i = 0; $i < count($array); $i++){
                $a .= '<div id="'.$this->last_div_id++.'">'.$array[$i].'</div>';
            }
        } else {
            $a .= '<div id="'.$this->last_div_id++.'">'.$array.'</div>';
        }
        return $a;
    }
    
    /*
     * Just outputs an array to string
     */
    function arrayToString($array){
        $a = '';
        if(is_array($array)){
            for ($i = 0; $i < count($array); $i++){
                $a .= $array[$i];
            }
        } else {
            $a .= $array;
        }
        return $a;
    }
    
    /*
     * Creates a list element from array
     */
    function listElements($array){
        
        $array = '<li>' . implode('</li><li>', $array);
//        //$array = rtrim($array, "<li>");
        $array .= '</li>';
        
        return $array;
    }
    
    /*
     * Creates a table element
     */
    function table_element(){
        
    }
    
    /*
     * Creates a footer
     */
    function footer(){
        $this->getFooter();
        $tmp = [];
        foreach($this->footer_elements as $key => $value){
            $tmp[] = $value['text'];
        }
        $this->footer = '<div id="footer" class="large-12 columns">';
        $this->footer .= $this->div_elements($tmp);
        $this->footer .= '</div>';
        echo $this->footer;
    }
    
    function getFooter(){
        
        $this->mySQL->select('bx_Footer');
        if(isset($this->mySQL->return_data)){
            $this->footer_elements = $this->mySQL->return_data;
        }
        
    }
    
    function rowIt($data){
        return "<div class=\"row\">".$data."</div>";
    }
    
    function divIt($class,$data){
        return "<div class=\"".$class."\">".$data."</div>";
    }
    
    function linkIt($array){
        
        $output = [];
        if(is_array($array)){
            foreach($array as $pack){
                
                $output[]= "<a href=\"".$pack['link']."\">".$pack['title']."</a>";
                echo $pack[0]['link'];
            }
        } else {
            //
        }
        // var_dump($output);
        return $output;
    }
    
    static function setTopbarMenu($array, $who = 'all', $pos = 'left'){
        if($pos == 'left' || $pos == 'right'){
            self::$topbarmenu[$pos][$who][] = $array;
        }
        else {
            // set Default left
            $pos = 'left';
            self::$topbarmenu[$pos][$who][] = $array;
        }
        
    }
    
    function currentState(){
        if( User::isLoggedIn() && Administrator::isAdmin() ){
            $this->state = 'admin';
        }
        else if( User::isLoggedIn() ) {
            $this->state = 'logged';
        }
        else if( !User::isLoggedIn() ){
            $this->state = 'out';
        }
        else{
            throw new \Exception("Failed to setup state");
        }
        
        return $this->state;
    }
    
    function getTopbarMenu($pos){
        $prepare = [];
        if($pos == 'right' || $pos == 'left'){
            if(isset(self::$topbarmenu[$pos]['all'])){
                for($i = 0; $i<count(self::$topbarmenu[$pos]['all']); $i++){
                    $prepare[] = self::$topbarmenu[$pos]['all'][$i];
                }
            }
            if($this->currentState() == 'admin'){
                for($i = 0; $i<count(self::$topbarmenu[$pos][$this->currentState()]); $i++){
                    $prepare[] = self::$topbarmenu[$pos][$this->currentState()][$i];
                }
                for($i = 0; $i<count(self::$topbarmenu[$pos]['logged']); $i++){   
                    $prepare[] = self::$topbarmenu[$pos]['logged'][$i];
                }
            }
            else if($this->currentState() == 'logged'){
                for($i = 0; $i<count(self::$topbarmenu[$pos]['logged']); $i++){
                    $prepare[] = self::$topbarmenu[$pos]['logged'][$i];
                }
            }
            else {
                for($i = 0; $i<count(self::$topbarmenu[$pos]['out']); $i++){
                    $prepare[] = self::$topbarmenu[$pos]['out'][$i];
                }
            }
        }
        else {
            echo 'Probleeeem';
        }

        return $this->parseMenu($prepare);
    }
    
    
    /*
     * Creates menus!
     * 
     * @param array $array An array of links
     * 
     */
    function parseMenu($menu_pack){
        $this->menu = '';
        $this->tmp_array = null;
       
        for($i = 0; $i < count($menu_pack); $i++){
            $this->tmp_array[] = $menu_pack[$i] ;
        }

        $this->menu = $this->listElements($this->linkIt($this->tmp_array));
        return $this->menu;
    }
    
    /*
     * Holds the messages
     */
    static function setMessage($message = null){
        if($message != null){
            self::$messages[] = $message;
        }
    }
    
    /*
     * Gets the messages
     */
    function getMessages(){
        return $this->div_elements(self::$messages);
    }
    
    /*
     * Holds the body
     */
    static function setBody($body = null){
        if($body != null){
            self::$body[] = $body;
        }
    }
    
    /*
     * Gets the body
     */
    function getBody(){
        return $this->div_elements(self::$body);
    }
}