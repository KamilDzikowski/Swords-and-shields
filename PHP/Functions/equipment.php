<?php
function is_equipped($ownership_id)
{
      if($ownership_id == $_SESSION['hero']['armor'] || $ownership_id == $_SESSION['hero']['hand_right'] || $ownership_id == $_SESSION['hero']['hand_left'] || $ownership_id == $_SESSION['hero']['ammo'] || $ownership_id == $_SESSION['hero']['tool'] ) return true;
      else return false;
}
?>
