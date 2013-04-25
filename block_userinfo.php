<?php //$Id: block_userinfo.php,v 0.5 2011-04-22 22:00:00 fbotti Exp $

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package    moodlecore
 * @subpackage block
 * @copyright  2013 Federico J. Botti - Entornos Educativos
 * @author     2013 Federico J. Botti <federico@entornos.com.ar>
 * @version    1.0
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_userinfo extends block_base {

    function init() {
        $this->title = get_string('pluginname','block_userinfo');
    }

    function get_content() {
        global $CFG, $OUTPUT, $USER, $COURSE;
        
        require_once($CFG->dirroot.'/message/lib.php');
        
        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';

        if (isloggedin()) {
            $this->title = $this->salute();
            $this->content->text.= '<div class="userinfoblock">';
            $this->content->text.= '<br /><span></span>';
            $this->content->text.= $OUTPUT->user_picture($USER, array('size' => 100, 'class' => 'userinfoblockimg'));
            $this->content->text.= "<br/><a href=\"$CFG->wwwroot/user/profile.php?id=$USER->id\">".fullname($USER,true)."</a>&nbsp;"
                    ."(<a href=\"$CFG->wwwroot/login/logout.php?sesskey=".sesskey()."\">".get_string('logout').'</a>)';
            $this->content->text.= '</div>';
            $this->content->text.= '<br />';
            $this->content->text.= '<a href="'.$CFG->wwwroot.'/user/edit.php?id='.$USER->id.'&course='.$COURSE->id.'">'
                        .'<img src="'.$OUTPUT->pix_url('i/edit').'" />&nbsp;'.get_string('editmyprofile','block_userinfo').'</a><br />';
            $this->content->text.= '<a href="'.$CFG->wwwroot.'/message/index.php">'
                    .'<img src="'.$OUTPUT->pix_url('message','block_userinfo').'" />&nbsp;'.get_string('messages','block_userinfo')
                    .'&nbsp;('.message_count_unread_messages($USER).')</a><br />';
            $this->content->text.= '<a href="'.$CFG->wwwroot.'/course/index.php">'
                    .'<img src="'.$OUTPUT->pix_url('i/course').'" />&nbsp;'.get_string('mycourses','block_userinfo').'</a><br /><br />';
            $this->content->text.= '<span class="lastaccess">'.get_string('lastaccess').': '
                    .date(get_string('strftimedate','block_userinfo'), $USER->lastlogin).'</span>';
        }

        $this->content->footer = '';
        return $this->content;
    }
    
    function salute(){
			$tmz = get_user_timezone_offset();
			if ($tmz == 99) {
				$ut = (date('G')*3600 + date('i')*60 + date('s'))/3600;
			} else {
				$ut = ((gmdate('G') + get_user_timezone_offset())*3600 + gmdate('i')*60 + gmdate('s'))/3600;
				If ($ut <= 0) { $ut = 24 + $ut; }
				If ($ut > 24) { $ut = $ut - 24; }
			}
			if ($ut < 12) {
				return get_string('morning', 'block_userinfo');
			} elseif (($ut >=12 ) and ($ut < 19 )) {
				return get_string('afternoon', 'block_userinfo');
			} else {
				return get_string('night', 'block_userinfo');
			}
    }
}
?>
