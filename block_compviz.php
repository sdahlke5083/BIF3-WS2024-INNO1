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


class block_compviz extends block_base {

    //Initialisiert den Block & setzt Titel
    public function init() {
        $this->title = get_string('pluginname', 'block_compviz');
        //ruft Namen des Plugins ab
    }

    //Erstellt Inhalt des Blocks
    public function get_content() {
        global $PAGE;

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
        $this->content->text = $this->block_compviz_render_skills_overview();
        $this->content->footer = '';
        $PAGE->requires->js_call_amd("block_compviz/skills_overview", "init");

        return $this->content;
    }

    // Generiert Diagramm mit Moustache Template
    private function block_compviz_render_skills_overview() {
        global $OUTPUT;

        $skills = $this->block_compviz_get_skills_data();
        $totalprogress = $this->block_compviz_get_total_progress($skills);
        $passingvalue = 75; // Example value

        $skillsData = [];
        foreach ($skills as $name => $skill) {
            $subSkillsData = [];
            foreach ($skill['Sub-Skills'] as $key => $subSkill) {
                $subSkillsData[] = [
                    'name' => $key,
                    'progress' => $subSkill,
                    'passingValue' => $passingvalue
                ];
            }
            $skillsData[] = [
                'id' => uniqid(),
                'name' => $name,
                'progress' => $skill['Fortschritt'],
                'passingValue' => $passingvalue,
                'subSkills' => $subSkillsData
            ];
        }

        $data = [
            'header' => get_string('skills_overview', 'block_compviz'),
            'totalProgress' => $totalprogress,
            'passingValue' => $passingvalue,
            'skills' => $skillsData
        ];

        return $OUTPUT->render_from_template('block_compviz/skills_overview', $data);
        
    }

    // Holt Daten der Skills
    private function block_compviz_get_skills_data() {
        //global $DB, $USER;

        $skills = [
            'Skill - Conflict Handling' => [
                'Fortschritt' => 100,
                'Sub-Skills' => [
                    'Merge Conflict' => 100,
                    'Rebasing' => 100
                ]
            ],
            'Skill - JavaScript' => [
                'Fortschritt' => 80,
                'Sub-Skills' => [
                    'ES6' => 85,
                    'Async Programming' => 75,
                ]
            ],
            'Skill - Python' => [
                'Fortschritt' => 60,
                'Sub-Skills' => [
                    'Data Structures' => 65,
                    'Web Development' => 55,
                ]
            ],
            'Skill - SQL' => [
                'Fortschritt' => 40,
                'Sub-Skills' => [
                    'Basic Queries' => 45,
                    'Joins' => 35,
                ]
            ],
            'Skill - PHP' => [
                'Fortschritt' => 50,
                'Sub-Skills' => [
                    'Syntax' => 55,
                    'Functions' => 45,
                ]
            ],
            'Skill - CSS' => [
                'Fortschritt' => 90,
                'Sub-Skills' => [
                    'Flexbox' => 95,
                    'Grid' => 85,
                ]
            ],
            'Skill - Java' => [
                'Fortschritt' => 70,
                'Sub-Skills' => [
                    'Basic Syntax' => 75,
                    'OOP' => 65,
                ]
            ],
            'Skill - C++' => [
                'Fortschritt' => 30,
                'Sub-Skills' => [
                    'Syntax' => 35,
                    'Memory Management' => 25,
                ]
            ],
            'Skill - Data Structures' => [
                'Fortschritt' => 20,
                'Sub-Skills' => [
                    'Arrays' => 15,
                    'Linked Lists' => 25,
                ]
            ],
            'Skill - Algorithms' => [
                'Fortschritt' => 75,
                'Sub-Skills' => [
                    'Sorting' => 80,
                    'Searching' => 70,
                ]
            ]
        ];

        return $skills;
    }

    // Berechnet Gesamtfortschritt
    private function block_compviz_get_total_progress($skills) {
        $totalprogress = 0;
        $count = 0;

        foreach ($skills as $skill) {
            $totalprogress += $skill['Fortschritt'];
            $count++;
        }

        return $totalprogress / $count;
    }

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
