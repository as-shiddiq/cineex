<@php

namespace {namespace};
<?php if ($for == 'api'): ?>

{useStatement}
<?php endif;?>

class {class} extends {extends}
{
<?php if ($for != 'api'): ?>
    public $url = '{controller}';
    private $title = '{controller}';

    public function __construct(){
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data['title']= $this->title;
        $data['page']= 'Data '.$this->title;
        $data['url']= $this->url;
        $data['now']= __FUNCTION__;
        $data['render'] = '<?=$for?>';
        $data['view']= ucfirst($this->url).'/'.ucwords(__FUNCTION__).'View';
        return renderView($this->module,$data);
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    
    public function detail($id='')
    {
        $data['id']= $id;
        $data['title']= $this->title;
        $data['page']= 'Detail '.$this->title;
        $data['url']= $this->url;
        $data['now']= __FUNCTION__;
        $data['render'] = '<?=$for?>';
        $data['view']= ucfirst($this->url).'/'.ucwords(__FUNCTION__).'View';
        return renderView($this->module,$data);
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    
    public function form($id='')
    {
        $data['id']= $id;
        $data['title']= $this->title;
        $data['page']= 'Form '.$this->title;
        $data['url']= $this->url;
        $data['now']= __FUNCTION__;
        $data['render'] = '<?=$for?>';
        $data['view']= ucfirst($this->url).'/'.ucwords(__FUNCTION__).'View';
        return renderView($this->module,$data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function print($id='')
    {
        $data['id']= $id;
        $data['title']= $this->title;
        $data['page']= 'Print '.$this->title;
        $data['url']= $this->url;
        $data['now']= __FUNCTION__;
        $data['render'] = '<?=$for?>';
        $data['view']= ucfirst($this->url).'/'.ucwords(__FUNCTION__).'View';
        return renderView($this->module,$data);
    }

<?php else: ?>
    protected $format = 'json';
    private $url;
    private $table;
    private $primaryKey;
    private $fillable;
    protected $helpers = ['app', 'nform', 'ntanggal', 'responsedata','auth'];

    public function __construct()
    {

    } 
    
    public function index()
    {
        //
    }
<?php endif ?>
}
