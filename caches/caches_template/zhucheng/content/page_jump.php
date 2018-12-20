<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php
if($child){
   $child_arrary=explode(',',$arrchildid);
   $to_url=$CATEGORYS[$child_arrary[0]][url];
   echo "<script>window.location.href='".$to_url."'</script>";
    }
?>