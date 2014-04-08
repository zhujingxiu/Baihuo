<?php

class ClearcacheController extends CommonController {
    public function index() {
        //清除缓存
        clearCache();
        $this->home=HOME_PATH;
        $this->m="../".M_PATH;
        $this->display();
    }
    
}

?>
