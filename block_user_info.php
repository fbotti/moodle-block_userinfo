<?php //$Id: block_user_info.php,v 0.5 2011-04-22 22:00:00 fbotti Exp $

class block_user_info extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_user_info');
    }

    function get_content() {
        global $CFG, $OUTPUT, $USER;
        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';

        if (isloggedin()) {
 	        $this->content->text.= $USER->firstname.' '.$USER->lastname;
 	        $this->content->text.= $OUTPUT->pix_url('pix/tape2','block');
 	        $this->content->text.= '<span style="background:url(\'http://localhost/moodle20/blocks/user_info/pix/tape2.png\') no-repeat scroll 0 0 transparent"></span>';
			$this->content->text.= $OUTPUT->user_picture($USER, array('size'=>100, 'class'=>'userinfoblock'));

        }

        $this->content->footer = '';
        return $this->content;
    }
}
?>

