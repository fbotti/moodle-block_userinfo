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
            $this->content->text.= '<div class="userinfoblock">';
            $this->content->text.= '<br /><span></span>';
            $this->content->text.= $OUTPUT->user_picture($USER, array('size' => 100, 'class' => 'userinfoblockimg'));
            $this->content->text.= "<br/><a href=\"$CFG->wwwroot/user/profile.php?id=$USER->id\">".fullname($USER,true)."</a>";
            $this->content->text.= '</div>';
            $this->content->text.= '<br />';
            $this->content->text.= '<a href="'.$CFG->wwwroot.'/user/editadvanced.php?id='.$USER->id.'">'
                        .'<img src="'.$OUTPUT->pix_url('i/edit').'" />&nbsp;Edit my profile</a><br />';
            $this->content->text.= '<a href="'.$CFG->wwwroot.'/message/index.php">'
                    .'<img src="'.$OUTPUT->pix_url('message','block_user_info').'" />&nbsp;Messages</a><br />';
            $this->content->text.= '<a href="'.$CFG->wwwroot.'/course/index.php">'
                    .'<img src="'.$OUTPUT->pix_url('i/course').'" />&nbsp;My courses</a><br /><br />';
            $this->content->text.= $USER->lastlogin;
        }

        $this->content->footer = '';
        return $this->content;
    }

}
?>

