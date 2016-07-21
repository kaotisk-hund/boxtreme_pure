<?php

namespace BoxTreme;

use BoxTreme\Core;

class Post extends Core\Generic{
    
    private $date;
    
    private $content;
    
    private $title;

    private $id = null;
    
    private $mySQL;
    
    private $public;
    
    private $table = 'bx_Posts';
    
    private $data = [];
    
    
    private $category;
    
    private $category_id;
    
    const CLASSNAME = 'post';


    
    /* 
     * @function menuCreate() To create menu
     * 
     */
    function menuCreate(){
        Core\Gui::setTopbarMenu(['link'=>'?post_view','title'=>'Posts'], 'all', 'right');
        Core\Gui::setTopbarMenu(['link'=>'?post_add','title'=>'Add post'], 'logged', 'right');
    }
    
    function setControllers(){
        Core\Controller::register(self::CLASSNAME,'post_add');
        Core\Controller::register(self::CLASSNAME,'post_edit');
        Core\Controller::register(self::CLASSNAME,'post_view');
        Core\Controller::register(self::CLASSNAME,'post_delete');
        Core\Controller::register(self::CLASSNAME,'menu_create');
    }
    
    /*
     * @function init() You know already this function :)
     */
    function init(){
        $this->mySQL = new Core\MySQL(SQL_USER, SQL_PASS, SQL_DB, SQL_HOST);
        $this->category = new Category();
        $this->menuCreate();
        $this->setControllers();
        if(isset($_GET['post_id']) && is_numeric($_GET['post_id'])){$this->id = $_GET['post_id'];}
    }
    
    /*
     * @function signal() Called by Controller class when it's needed
     * @param String $request The request!
     */
    function signal($request,$data = null){
        switch ($request){
            case 'post_edit':
                if(isset($_SESSION["bxtreme_user"])){
                    $this->edit($data);
                } else {
                    Core\Gui::setBody("Permission denied! You are not logged in");
                }
                break;
            case 'post_add':
                if(isset($_SESSION["bxtreme_user"])){
                    $this->add($data);
                } else {
                    Core\Gui::setBody("Permission denied! You are not logged in");
                }
                break;
            case 'post_view':
                $this->show();
                break;
            
            case 'post_delete':
                if(isset($_SESSION["bxtreme_user"])){
                    $this->delete();
                } else {
                    Core\Gui::setBody("Permission denied! You are not logged in");
                }
                break;
            case 'menu_create':
                $this->menuCreate();
                break;
            default :
                
                break;
        }
    }
    
    /*
     * This is the edit function of our Post class. It needs further developing
     * as it has problems on displaying the post's to be edited contents in the
     * edit form.
     * 
     * @function edit()
     * 
     */
    function edit(){
        if($this->id!=null){
            $this->mySQL->select($this->table,'*','id',$this->id);
            if(is_array($this->mySQL->return_data)){
                $this->data = $this->mySQL->return_data;
            }
        }
        
        if(isset($_POST['post']) && $_POST['post']== 'edit'){
            $this->user_id = $_SESSION["bxtreme_id"];
            $this->date = date('Y-m-d');
            $this->title = $_POST['title'];
            $this->content = $_POST['content'];
            if($_POST['public']=="on"){
                $this->public = '1';
            }
            $this->data = ['user_id' => $this->user_id,
                'public' => $this->public,
                'date' => $this->date,
                'title' => $this->title,
                'content' => $this->content ];
            $this->mySQL->update($this->table,$this->id,$this->data);
            Core\Gui::setBody('Post updated successfully');
        } else {
            Core\Gui::setBody('<h3>Edit post</h3>'
                    . '<form action="" method="post">'
                    . '<input type="text" placeholder="title" value="'. $this->data[0]['title'] .'" name="title"/>'
                    . '<textarea name="content" placeholder="">'. $this->data[0]['content'].'</textarea>'
                    . '<input type="checkbox" name="public"/>'
                    . '<input type="submit" class="button" value="edit" name="post"/>'
                    . '</form>');
        }
        
    }
    
    /*
     * Our add function. Simply adds a post or creates a form in order to add a
     * post.
     * 
     * @function add()
     * 
     */
    function add(){
        if(isset($_POST['post']) && $_POST['post']== 'Add'){
            $this->user_id = $_SESSION["bxtreme_id"];
            $this->date = date('Y-m-d');
            $this->title = $_POST['title'];
            $this->content = $_POST['content'];
            $this->category_id = $this->category->getId($_POST['category']);
            
            if($_POST['public']=="on"){
                $this->public = '1';
            }
            $this->data = [$this->user_id,$this->public, $this->date, $this->title, $this->content, $this->category_id ];
            $this->mySQL->insert($this->table,$this->data);
            Core\Gui::setBody('Post successfully sent');
        } else {
            Core\Gui::setBody('<h3>Add a post</h3>'
                        . '<form action="?post_add" method="post">'
                        . '<input type="text" placeholder="Title" name="title"/>'
                        . '<textarea name="content" placeholder="Your text goes here"></textarea>'
                        . 'Public? '
                        . '<input type="checkbox" name="public"/><input name="category" placeholder="Category" type="text"/><br>'
                        . '<input type="submit" class="button" value="Add" placeholder="" name="post"/>'
                        . '</form>');
        }
        
    }
    
    /*
     * Finds a user from the database in order to display the author name. Maybe
     * this function has to be global in order to let everyone search in DB but
     * not sure yet.
     * 
     * @function findUser()
     * @param Int $id User id
     * @returns String $username
     */
    function findUser($id){
        $this->user_id = $id;
        $this->mySQL->select('bx_User','*','id', $this->user_id);
        return $this->mySQL->return_data[0]['username'];
    }
    
    /*
     * Has problem!!!
     * @function show()
     * @return String to $globals['body']
     */
    function show(){
        $this->getPosts();
        
        foreach ($this->data as $value) {
            $this->user_id = $value['user_id'];
            /*
             * Show posts that either are public or belong to the logged in user xD
             */
            if($value['public'] || $_SESSION["bxtreme_user"] == $this->findUser($this->user_id)){
                Core\Gui::setBody("
                <!-- Post template -->
                <!-- Post title -->
                <div id=\"post\" class=\"row\">
                <h3>
                    <a href=\"?post_view&amp;post_id={$value['id']}\">{$value['title']}</a>
                </h3>".

                /*
                 *  Show edit option only to users that are logged in and owners of the post
                 */
                (isset($_SESSION["bxtreme_user"]) && $_SESSION["bxtreme_user"] == $this->findUser($this->user_id) ?
                    "<a alt=\"Edit\" href=\"?post_edit&post_id={$value['id']}\"><i class=\"step fi-page-edit size-24\"></i></a>"
                    . "<a alt=\"Delete\" href=\"?post_delete&post_id={$value['id']}\"><i class=\"step fi-page-delete size-24\"></i></a>" : '').
                "<!-- Date posted -->                
                <small>{$value['date']}</small>
                <!-- Author -->
                <p>Written by {$this->findUser($this->user_id)}</p>
                <!-- Post content -->
                <div id=\"post-content\">
                    <p>{$value['content']}</p>
                </div>
                <!-- Category print :) -->
                <div id=\"category\">
                
                <a href=\"?category={$value['category_id']}\">{$this->category->getCategory($value['category_id'])}</a>"
                ."</div>"
            . "</div><br>");
            }
        }
    }
    
    /*
     * Gets requested posts
     * @function getPosts()
     * @returns Array $this->data
     */
    function getPosts(){
        if($this->id!=null){
            $this->mySQL->select($this->table,'*','id',$this->id);
        }
        else{
            $this->mySQL->select($this->table,'*');
        }
        if(isset($this->mySQL->return_data)){
            if(is_array($this->mySQL->return_data)){
                $this->data = $this->mySQL->return_data;
            }
            else{
                Core\Gui::setBody('Wrong data');
            }
        }
        else {
            Core\Gui::setBody('No post found');
        }
    }
    
    function setId($id){
        $this->id = $id;
    }
    
    function delete(){
        if($this->id!=null){
            $this->mySQL->delete($this->table,$this->id);
            Core\Gui::setBody('Post deleted successfully!');
        }
        else {
            Core\Gui::setBody('No post found to delete. Nothing happened.');
        }
    }
}