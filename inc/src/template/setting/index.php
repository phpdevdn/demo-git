<?php
    $pages = [
        'general' => 'General'
    ]; 
    $cur_tab = (empty($_GET['tab'])) ? 'general' : $_GET['tab']; 
?>
<div class="olwrap pd0">
    <nav id="nav_black">
        <ul class="ls_nav">
            <?php
            foreach ($pages as $page_slug => $page_name):
                $link = $this->getLink(['tab'=>$page_slug]); 
                $class = $cur_tab === $page_slug ? 'active' : null;   
            ?>
                <li>
                    <a href="<?php echo $link; ?>" class="<?php echo $class; ?>">
                        <?php echo $page_name ?>
                    </a>
                </li>                
            <?php endforeach ?>
        </ul>
    </nav>
    <div class="olcontain">
    <?php 
        if(array_key_exists($cur_tab,$pages)){
            $this->view('setting/setting-'.$cur_tab);
        }
     ?>        
    </div>
</div>