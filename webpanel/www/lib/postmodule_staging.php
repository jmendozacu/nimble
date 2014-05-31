<?php
// This is ran after every module.
$xtpl->restart(BASEPATH.'/template/overall.tpl');


$xtpl->parse('footer');
$xtpl->out('footer');


// Do end of script clean up, like closing mysql connections
$ob_content = ob_get_contents();
ob_end_clean();
echo $ob_content;

// Stop the connection to our db, we're done.
$db->close();
