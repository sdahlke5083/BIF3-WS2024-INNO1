<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Block compviz is defined here.
 *
 * @package     block_compviz
 * @copyright   2024 BIF-INNO-Group10
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// import display_data.php
require_once($CFG->dirroot . '/blocks/compviz/db/display_data.php');

class block_compviz extends block_base {

    //Initialisiert den Block & setzt Titel
    public function init() {
        $this->title = get_string('pluginname', 'block_compviz');
        //ruft Namen des Plugins ab
    }

    //Erstellt Inhalt des Blocks
    public function get_content() {

        //Existiert Inhalt vom Block schon?
        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        // Diagramm mit flexibler Platzierung (da eigene Aufteilung) rendern
        $this->content->text = $this->render_skills_chart();

        return $this->content;
    }

    //Generiert Diagramm mit den Skills
    private function render_skills_chart() {
        global $OUTPUT;
    
        $moodle_version = block_compviz_get_moodle_version_from_db();
        //$gradings = (array) block_compviz_get_current_user_grade_items();
        $gradings = block_compviz_get_current_user_grade_items_by_category(4); // 4 = ID der Kategorie "LEO's"

        $html = "DB-Data: <br/>";
        // Display Moodle version
        $html .= "Moodle version: ";
        $html .= $moodle_version;
        $html .= "<br/>";
        // Display block_compviz data	
        if($gradings == [] ){ // if is empty array
            $html .= "No data found";
            return $html;
        }

        $templatedata = array_values($gradings);
        //var_dump($templatedata);

		$totalProgress = 50; // Beispielwert für den Gesamtfortschritt (kann später dynamisch berechnet werden)

        $html .= '<div style="margin-bottom: 15px; font-size: 16px; font-weight: bold; text-align: center;">Skills Overview</div>';
        $html .= '<div style="display: flex; flex-direction: column; gap: 5px;">';

        // Horizontale Leiste für Gesamtfortschritt
        $html .= '<div style="margin-bottom: 20px;">';
        $html .= $this->render_horizontal_bar('Total', $totalProgress, false);
        $html .= '</div>';

        foreach ($templatedata as $leo) {
            $leo = (array) $leo;
            $html .= $this->render_collapsible_skill($leo["fullname"], $leo['finalgrade'], $leo['grademax'], $leo['grade_items']);
        }
        
        $html .= '</div>'; // Hauptcontainer

        return $html;
    }

    //Aufklappbare Skills/Sub-Skills
    private function render_collapsible_skill($label, $progress, $max, $subskills) {
        // Fortschrittsbalken mit dem Marker (Pfeil) innerhalb der Progressbar
        $html = '<details>';
        $html .= '<summary style="margin: 0; padding: 0; list-style: none;">' . $this->render_horizontal_bar($label, $progress, $max, true) . '</summary>';
        if (!empty($subskills) && is_array($subskills)) {
            $html .= '<div style="margin-left: 20px;">';
            foreach ($subskills as $subskill) {               
                    $subskill = (array) $subskill;
                    $html .= $this->render_horizontal_bar($subskill["itemname"], $subskill["finalgrade"], $subskill["grademax"] ,false);
            }
            $html .= '</div>';
        }
        $html .= '</details>';
    
        return $html;
    }
    
    //Horizontaler Fortschrittsbalken
    private function render_horizontal_bar($label, $progress, $max, $is_main_skill = false) {
        //Fortschrittswert horizontal
        if($max == 0) {
            $bar_width = 0 . '%'; // Wenn max 0 ist, setze die Breite auf 0%
        }else{
            $bar_width = $progress/$max * 100 . '%'; // Prozentualer Wert für die Breite des Balkens
        }
        $background_color = $this->get_progress_color($progress);
    
        // Fortschrittsbalken-Inhalt: Label und Pfeil (bei Hauptskills)
        $content = '<div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; position: relative;">
                        <span style="font-size: 12px;">' . $label . '</span>'; // Text mittig in Box
        //Dropdown-Pfeil nur bei den Hauptskills (später auch für die subskills)
        if ($is_main_skill) {
            $content .= '<span style="position: absolute; right: 10px; font-size: 12px; cursor: pointer;">▼</span>'; // Dropdown-Pfeil rechts
        }
        $content .= '</div>';
    
        return '<div style="margin-bottom: 10px; display: flex; align-items: center; border: 1px solid #ccc; border-radius: 5px; background: #f4f4f4; width: 100%; height: 35px; position: relative;">
                    <div style="width: ' . $bar_width . '; height: 100%; background-color: ' . $background_color . '; position: absolute; top: 0; left: 0; z-index: 0;"></div>
                    <div style="position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; width: 100%; color: #333; font-weight: normal; font-size: 12px;">
                        ' . $content . '
                    </div>
                </div>';
    }
    /*
    //vertikale Fortschrittsanzeige
    private function render_vertical_bar($label, $progress) {
        //Fortschrittswert vertikal
        $bar_height = $progress . '%';
        $background_color = $this->get_progress_color($progress);

        //Text steht über Leiste
        return '<div style="text-align: center;">
            <div style="font-size: 12px; color: #333; margin-bottom: 10px">' . $label . '</div>
            <div style="width: 40px; height: 200px; border: 1px solid #ccc; border-radius: 5px; background: #f4f4f4; position: relative;">
                <div style="height: ' . $bar_height . '; width: 100%; background-color: ' . $background_color . '; position: absolute; bottom: 0; display: flex; align-items: flex-end; justify-content: center; color: #333; font-weight: normal; font-size: 12px; padding-bottom: 8px;">
                    ' . $progress . '%
                </div>
            </div>
        </div>';
    }
    */

    /* Grünes Konzept
    private function get_progress_color($progress) {
        if ($progress < 20) {
            return '#EEFFBA'; 
        } elseif ($progress < 40) {
            return '#D6FA8C'; 
        } elseif($progress < 60) {
            return '#BEED53'; 
        }elseif($progress < 80){
			return '#A5D722'; 
		}else{
			return '#78AD00'; 
		}
    }
    */

    private function get_progress_color($progress) {
        if ($progress < 20) {
            return '#D8F3DC'; 
        } elseif ($progress < 40) {
            return '#b7e4c7'; 
        } elseif($progress < 60) {
            return '#74c69d'; 
        }elseif($progress < 80){
			return '#52b788'; 
		}else{
			return '#40916C'; 
		}
    }

    public function has_config() {
        return true;
    }

    public function applicable_formats() {
        return [
            'course-view' => true,
            'site-index' => false,
        ];
    }
}
