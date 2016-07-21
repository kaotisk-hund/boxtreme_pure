<?php
namespace BoxTreme\Core;
use BoxTreme\Settings;

class Administrator{
    // Well, I have not think of it in general but I think it'll be needed.
    private $mySQL;

    private $settings = [];
    
    private $footer = [];
    
    const CLASSNAME = 'administrator';
    
    static private $isAdmin = false;


    
    function __construct(MySQL $mysql){
        $this->mySQL = $mysql;
        $this->mySQL->select('bx_Admin','*','user_id', $_SESSION["bxtreme_id"]);
        if(isset($this->mySQL->return_data)){

            $this->init();
        }
        else{
            $this->__destruct();
        }
        
        
    }
    function init(){
        $this->settings = Settings\BoxTremeSettings::getSettings();
        $this->menuCreate();
        self::$isAdmin = true;
        Controller::register(self::CLASSNAME,'admin');
        Controller::register(self::CLASSNAME, 'update');
        Controller::register(self::CLASSNAME, 'status');
        Controller::register(self::CLASSNAME, 'site_name');
        Controller::register(self::CLASSNAME, 'home_post_id');
        Controller::register(self::CLASSNAME, 'site_title');
        Controller::register(self::CLASSNAME, 'favicon_path');
    }
    
    function menuCreate(){
        Gui::setTopbarMenu(['link'=>'?admin','title'=>'Administrator'], 'admin', 'right');
    }
    
    function signal($request, $data = null){
        
        
        if($data != null){
            $request_data = $data;
        }
        switch ($request) {
            case 'admin':
                $this->show();
                break;
            case 'site_name':
                $this->setSiteName($request_data['site_name']);
                break;
            case 'home_post_id':
                $this->setHomePageId($request_data['home_post_id']);
                break;
            case 'site_title':
                $this->setSiteTitle($request_data['site_title']);
                break;
            case 'favicon_path':
                $this->setFavicon($request_data['favicon_path']);
                break;
            case 'update':
                $this->gitUpdate();
                break;
            case 'status':
                $this->gitStatus();
                break;
            default:
                break;
        }
    }
    
    function setHomePageId($id){
        $home_id = $id;
        Settings\BoxTremeSettings::setSettings('home_post_id', $home_id);
        Gui::setMessage('Site home post changed to: '.$home_id .' !');
    }
    
    function setSiteName($name){
        $site_name = $name;
        Settings\BoxTremeSettings::setSettings('site_name', $site_name);
        Gui::setMessage('Site name changed to: '.$site_name .' !');
    }
    
    function setSiteTitle($title){
        $site_title = $title;
        Settings\BoxTremeSettings::setSettings('site_title', $site_title);
        Gui::setMessage('Site title changed to: '.$site_title .' !');
    }

    function setFavicon($path){
        $favicon_path = $path;
        Settings\BoxTremeSettings::setSettings('favicon_path', $favicon_path);
        Gui::setMessage('Favicon changed to: '.$favicon_path .' !');
    }

    function setSettings($data){
        $this->mySQL->update('bx_Settings', 1, $data);
    }
    
    function getFooter(){
        $this->mySQL->select('bx_Footer');
        if(isset($this->mySQL->return_data)){
            $this->footer = $this->mySQL->return_data;
        }
        return $this->footer;
    }
    
    function footerForm(){
        $tmp = [];
        foreach($this->footer as $key => $value){
            $tmp[] = $value['text'];
        }
        global $gui;
        return $gui->div_elements($tmp);
        
    }
    
    function show(){
        $this->getFooter();
        // $admin_template = file_get_contents('gui/admin.php');
        Gui::setBody('

<div id="admin">
    <h2>Administration panel</h2>
    <div class="row collapse">
        <div class="medium-3 columns">
            <ul class="tabs vertical" id="admin-vert-tabs" data-tabs>
                <li class="tabs-title is-active"><a href="#name-title" aria-selected="true">Name & Title</a></li>
                <li class="tabs-title"><a href="#favicon">Favicon</a></li>
                <li class="tabs-title"><a href="#homepage">Homepage</a></li>
                <li class="tabs-title"><a href="#widget">Widget</a></li>
                <li class="tabs-title"><a href="#footer-settings">Footer</a></li>
                <li class="tabs-title"><a href="#update">Update</a></li>
            </ul>
        </div>
        <div class="medium-9 columns">
            <div class="tabs-content vertical" data-tabs-content="admin-vert-tabs">
                <div class="tabs-panel is-active" id="name-title">
                    <p>
                        <form action="index.php?admin&site_name" method="post">
                            <h4>Site name change option</h4>
                            <input name="site_name" type="text" placeholder="'.$this->settings['site_name'].'"/>
                            <input class="small button" type="submit" value= "Change"/>
                        </form>
                    </p>
                    <p>
                        <form action="index.php?admin&site_title" method="post">
                            <h4>Site title change option</h4>
                            <input name="site_title" type="text" placeholder="'.$this->settings['site_title'] .'"/>
                            <input class="small button" type="submit" value= "Change"/>
                        </form>
                    </p>
                </div>
                <div class="tabs-panel" id="favicon">
                    <form action="index.php?admin&favicon_path" method="post">
                        <h4>Favicon settings</h4>
                        <p>Note: The desired favicon should be already on server. You can\'t upload from here yet. Maybe it never be allowed.</p>
                        <input name="favicon_path" type="text" placeholder="'.$this->settings['favicon_path'] .'"/>
                         <input class="small button" type="submit" value= "Change"/>
                    </form>
                </div>
                <div class="tabs-panel" id="homepage">
                    <h4>Homepage settings</h4>
                    <form action="index.php?admin&home_post_id" method="post">
                        <input name="home_post_id" type="text" placeholder="'. $this->settings['home_post_id'] .'"/>
                        <input class="small button" type="submit" value= "Change"/>
                    </form>
                </div>
                <div class="tabs-panel" id="widget">
                    <h4>Widget settings</h4>
                    <p>Soon to come! :)</p>
                </div>
                <div class="tabs-panel" id="footer-settings">
                    <h4>Footer settings</h4>
                    <table>
                        <tr>
                            <th>Footer elements</th>
                            <th>Add/Remove</th>
                        </tr>
                        <tr>
                            <td>'.$this->footerForm().'</td>
<td>aa</td>
</tr>
</table>
</div>
<div class="tabs-panel" id="update">
    <h4>Latest commit</h4>
    <div class="callout">'.$this->gitChangelog().'</div>
    <a class="button disabled" href="?update">Update using git</a>
</div>
</div>
</div>
</div>
</div>
');
    }
    
    /* 
     * Gets git status
     */
    function gitChangelog(){
        $status_command = 'git log -n 1';
        exec($status_command, $output);
        global $gui;
        
        return $gui->justEchoing($output);
    }
    
    function gitUpdate(){
        $update_command = 'sh ./bin/boxtreme-update';
        exec($update_command, $output='');
        Gui::setMessage($output);
        
    }
    
    static function isAdmin(){
        return self::$isAdmin;
        
    }


}