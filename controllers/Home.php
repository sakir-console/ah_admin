<?php
class Home{

    #[Method("GET")]
    public function admin()
    {
      include APP_PATH.'themes/admin/index.html';
    }


}
