<?php
    if (!empty($menu))
    {
        foreach ($menu as $k=>$item)
        {
            if ($k) echo ' | ';
            echo '<a href="'.$item['url'].'">';
            $text = $item['name'];
            if ($item['current']) $text = '<strong style="color:red">'.$text.'</strong>';
            echo $text;
            echo '</a>';
        }
        echo '<hr />';
    }
?>