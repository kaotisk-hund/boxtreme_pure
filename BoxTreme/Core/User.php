<?php
/*
 * This is the User class, a class that handles users. It has some properties
 * $username, $password and $email.
 */

namespace BoxTreme\Core;

class User extends Generic{
    
    /*
     * param int $id The user's id
     */
    private $id;
    
    /*
     * param String $username The username
     */
    private $username;
    
    /*
     * param String $password The password
     */
    private $password;
    
    /*
     * param String $email The email :P
     */
    private $email;
    
    /*
     * param String $prefs_id Preferences id for user's preferences
     */
    private $prefs_id;
    
    
    /*
     * param Array $data Just a data array (messed up i think now)
     */
    private $data = ["id"=>'',
        "username"=>'',
        "password"=>'',
        "email"=>'',
        "prefs_id"=>''
        ];
    
    
    /*
     * param Boolean $loggedIn
     */
    static private $loggedIn = false;
    
            
    
    /*
     * param MySQL $mySQL 
     */
    private $mySQL;
    
    private $table = 'bx_User';
    
    private $menu = [];
    private $request_data = null;
    
    const CLASSNAME = 'user';

    
    
    /*
     * Function to create menu
     */
    function menuCreate(){
        $this->menu = [
            'account' => ['link'=>'?account', 'title'=>$GLOBALS['topbar']['hi'].', '.$this->username.'!'],
            'user_logout' => ['link'=>'?user_logout','title'=>$GLOBALS['topbar']['logout']],
            'user_login' => ['link'=>'?user_login', 'title'=>$GLOBALS['topbar']['login']],
            'user_register' => ['link'=>'?user_register', 'title'=> $GLOBALS['topbar']['register']]
        ];
            Gui::setTopbarMenu($this->menu['account'], 'logged', 'left');
            Gui::setTopbarMenu($this->menu['user_logout'], 'logged', 'right');
            Gui::setTopbarMenu($this->menu['user_login'], 'out',  'right');
            Gui::setTopbarMenu($this->menu['user_register'], 'out', 'right');
    }
    
    /*
     * Standar init function :)
     */
    function init(){
        $this->mySQL = new MySQL(SQL_USER, SQL_PASS, SQL_DB, SQL_HOST);
        session_start();
        
        
        
        Controller::register(self::CLASSNAME,'user_login');
        Controller::register(self::CLASSNAME,'user_logout');
        Controller::register(self::CLASSNAME,'user_register');
        Controller::register(self::CLASSNAME,'account');
        Controller::register(self::CLASSNAME,'menu_create');
        $this->check();
        $this->menuCreate();
    }
    
    /*
     * Check if the session has already logged in or requested to log out
     */
    function check(){
        if(isset($_SESSION["bxtreme_user"])){
            $this->login($_SESSION["bxtreme_user"],$_SESSION["bxtreme_pass"]);
        } else{
            $this->guest();
        }
        return self::$loggedIn;
    }
    
    /* 
     * We get a signal from the controller
     */
    function signal($request, $data = null){
        if($data != null){
            $this->request_data = $data;
        }
        
        switch ($request){
            case 'user_login':
                if($this->request_data["user_action"]=="Login"){
                    $username = $this->request_data["username"];
                    $password = $this->request_data["password"];
                    $this->login($username,$password);
                    $this->loginQuestion();
                } else {
                    Gui::setBody(file_get_contents('gui/user/loginForm.php'));
                }
                break;
            case 'user_register':
                if($this->request_data["user_action"]=="Register"){
                    $this->username = $this->request_data["username"];
                    $this->password = $this->request_data["password"];
                    $this->email = $this->request_data["email"];
                    $this->register();
                    
                    Gui::setBody('Great success!!!');
                } else {
                    Gui::setBody(file_get_contents('gui/user/registerForm.php'));
                }
                break;
            case 'user_logout':
                $this->logout();
                break;
            case 'account':
                $this->account();
                break;
            case 'menu_create':
                $this->menuCreate();
                break;
            default :
                break;
        }
        
    }

    /*
     * When the instance calls register() we just pack the properties to an
     * array and return it.
     */
    function register(){
        
        $this->data = [$this->username,$this->password,$this->email,$this->prefs_id];
        $this->mySQL->select($this->table,'*','username',$this->username);
        if(isset($this->mySQL->return_data)){
            echo "User exists";
        }
        else{
            $this->mySQL->insert($this->table,$this->data);
        }
        
    }
    
    /*
    * User login
    */
    function login($username,$password){

        $this->mySQL->select($this->table,'*','username',$username);

        if(isset($this->mySQL->return_data)){
            if(is_array($this->mySQL->return_data)){
                $this->data = $this->mySQL->return_data;
                $this->username = $this->data[0]['username'];
                $this->password = $this->data[0]['password'];
                $this->id = $this->data[0]['id'];
                $this->email = $this->data[0]['email'];
                $this->prefs_id = $this->data[0]['prefs_id'];

                $this->checkPassword($password);
            }
            else{
                Gui::setMessage('User::login(Invalid data!)');
            } 
        }
        else{
            Gui::setMessage('Wrong username/password');
        }
        if(self::isLoggedIn()){
            $this->isAdmin();
        }
    }
    
    /*
     * Returns success of fail on login!
     * 
     */
    function loginQuestion(){
        if(self::isLoggedIn()){
            Gui::setBody('Great success!!!');
        }
        else {
            Gui::setBody('Fission Mailed!');
        }
    }
    
    
    /*
     * Has to destroy session
     */
    function logout(){
        unset($_SESSION["bxtreme_id"]);
        unset($_SESSION["bxtreme_user"]);
        unset($_SESSION["bxtreme_pass"]);
        session_destroy();
        self::$loggedIn = false;
        $this->guest();
        Gui::setBody("
            <h1>Have a nice day!</h1>
            <small>-- ".SITE_NAME."</small>");
    }
    
    
    /*
     *  When not logged in you are a guest xD
     */
    function guest(){
        $this->username = 'guest';
        $this->password = '';
        $this->email = 'example@example.com';
        self::$loggedIn = FALSE;
    }
    
    /*
     * @function showProfile()
     * @returns Array $this->data
     */
    function showProfile(){
        return $this->data;
    }
    
    /*
     * Not sure that it has to be here
     */
    function isAdmin(){
        $this->mySQL->select('bx_Admin','*','user_id', $this->id);
        // Bug...!!! Created when not successfully logged in.
        if(isset($this->mySQL->return_data)){
            global $administrator;
            $administrator = new Administrator($this->mySQL);
        }
    }
    
    /*
     * A simple password check function
     * 
     * @function checkPassword()
     * @param String $password The password to be checked
     */
    private function checkPassword($password){
        if(md5($password) == md5($this->password)){
        self::$loggedIn = true;
        $_SESSION["bxtreme_user"]=$this->username;
        $_SESSION["bxtreme_pass"]=$this->password;
        $_SESSION["bxtreme_id"]=$this->id;
        } else {
            Gui::setMessage("Wrong username/password");
            self::$loggedIn = false;
        }
    }
    
    /*
     * User account settings
     */
    function account(){
        Gui::setBody('<h1>Not implemented</h1>');
    }
    
    static function isLoggedIn(){
        return self::$loggedIn;
    }

    /*
     * Get current username
     * return String $username
     */
    function getUsername(){
        return $this->username;
    }
    
   
}