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
 * @copyright  2011 Federico J. Botti - Entornos Educativos
 * @author     2011 Federico J. Bott <federico@entornos.com.ar>
 * @version    0.5
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_userinfo extends block_base {

    function init() {
        $this->title = get_string('userinfo','block_userinfo');
        $this->version = 2011042500;
    }

    function get_content() {
        global $CFG, $USER, $COURSE;
              
        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';

        if (isloggedin()) {
            $this->title = $this->salute();
            $this->content->text.= '<div class="userinfoblock">';
            $this->content->text.= '<br />';
            $this->content->text.= print_user_picture($USER, $COURSE->id, $USER->picture, '100px', true, false);
            $this->content->text.= "<br/><a href=\"$CFG->wwwroot/user/view.php?id=$USER->id\">".fullname($USER,true)."</a>&nbsp;"
                    ."(<a href=\"$CFG->wwwroot/login/logout.php?sesskey=".sesskey()."\">".get_string('logout').'</a>)';
            $this->content->text.= '</div>';
            $this->content->text.= '<br />';
            $this->content->text.= '<a href="'.$CFG->wwwroot.'/user/editadvanced.php?id='.$USER->id.'">'
                        .'<img src="'.$CFG->pixpath.'/i/edit.gif" />&nbsp;'.get_string('editmyprofile','block_userinfo').'</a><br />';
            $this->content->text.= '<a href="'.$CFG->wwwroot.'/message/index.php">'
                    .'<img src="'.$CFG->wwwroot.'/blocks/userinfo/pix/message.gif" />&nbsp;'.get_string('messages','block_userinfo')
                    .'&nbsp;('.$this->message_count_unread_messages($USER).')</a><br />';
            $this->content->text.= '<a href="'.$CFG->wwwroot.'/course/index.php">'
                    .'<img src="'.$CFG->pixpath.'/i/course.gif" />&nbsp;'.get_string('mycourses','block_userinfo').'</a><br /><br />';
            //$format = get_string('strftimedate','block_userinfo');
            $format = 'l jS \of F Y h:i:s A';
            $this->content->text.= '<span class="lastaccess">'.get_string('lastaccess').': '
                    .date($format, $USER->lastlogin).'</span>';
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
    function message_count_unread_messages(){
        global $CFG, $USER;
        
        $users = get_records_sql("SELECT m.useridfrom as id, COUNT(m.useridfrom) as count,
                                         u.firstname, u.lastname, u.picture, u.imagealt, u.lastaccess
                                       FROM {$CFG->prefix}user u, 
                                            {$CFG->prefix}message m 
                                       WHERE m.useridto = '$USER->id' 
                                         AND u.id = m.useridfrom
                                    GROUP BY m.useridfrom, u.firstname,u.lastname,u.picture,u.lastaccess,u.imagealt");
        if (empty($users)) return 0;                                            
        return count($users);
    }
}
?>