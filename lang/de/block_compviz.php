<?php
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
 * Strings for component 'block_compviz', language 'de'
 *
 * @package    block_compviz
 * @category   string
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Predefined / Basic required strings
$string['compviz:addinstance'] = 'Neuen CompViz-Block hinzufügen';
$string['compviz:myaddinstance'] = 'Neuen CompViz-Block zu "Meine Startseite" hinzufügen';
$string['compviz:show_graph'] = 'Bewertungsdiagramm anzeigen';
$string['pluginname'] = 'Kompetenz-Visualisierung';

// Block strings
$string['admin_settings_desc'] = 'Info:';
$string['admin_settings_desc_desc'] = 'Globale Einstellungen für den CompViz-Block.';
$string['enabled'] = 'Aktivieren';
$string['enabled_desc'] = 'Den Skills-Overview-Block auf der Kursseite aktivieren.';
$string['enabled_help'] = 'Den Skills-Overview-Block auf der Kursseite aktivieren.';
$string['no_leo'] = 'Keine Kategorien für Lernziele gefunden.';
$string['no_subskills'] = 'Keine sichtbaren Unterfähigkeiten für diese Kategorie gefunden.';
$string['skills_overview'] = 'Fähigkeitenübersicht';

// Settings form strings
$string['select_leo'] = 'Lernzielkategorie auswählen';
$string['select_leo_desc'] = 'Wählen Sie die Lernzielkategorie für den Skills-Overview-Block aus.';
$string['select_leo_help'] = 'Wählen Sie eine Bewertungs- bzw. Lernzielkategorie für den Skills-Overview-Block. Diese wird zur Anzeige der Fähigkeiten verwendet.';

// User settings form strings
$string['appearance'] = 'Darstellung';
$string['color_settings_desc'] = 'Darstellungseinstellungen bestimmen, wie Fortschrittsbalken und Diagramme in Ihrer Ansicht eingefärbt werden. Sie können Theme-Farben verwenden oder eine persönliche Palette mit dem Farbwähler erstellen.';
$string['settingsnotsaved'] = 'Benutzereinstellungen konnten nicht gespeichert werden.';
$string['settingssaved'] = 'Benutzereinstellungen gespeichert.';
$string['show_completed'] = 'Abgeschlossene Fähigkeiten anzeigen';
$string['show_completed_help'] = 'Wenn aktiviert, werden abgeschlossene Fähigkeiten in Ihrer Fähigkeitenübersicht angezeigt. Wenn deaktiviert, werden nur unvollständige oder in Bearbeitung befindliche Fähigkeiten angezeigt, damit Sie sich auf ausstehende Aufgaben konzentrieren können.';
$string['theme'] = 'Farbthema';
$string['theme_help'] = 'Wählen Sie ein gespeichertes Farbschema zur Darstellung der Fortschrittsbalken. Diese Option ist nur aktiv, wenn "Theme-Farben verwenden" in der Farbauswahl aktiviert ist.';
$string['usersettings'] = 'CompViz-Einstellungen';
$string['usersettings_desc'] = 'Konfigurieren Sie Ihre persönlichen CompViz-Einstellungen. Diese Einstellungen betreffen nur Ihr Konto und ändern nicht, wie andere Benutzer den Block sehen.';

// Privacy provider strings
$string['privacy:metadata:block_compviz'] = 'Der CompViz-Block speichert Benutzereinstellungen zum Aktivieren des Blocks und zum Anzeigen abgeschlossener Fähigkeiten.';
$string['privacy:metadata:block_compviz_enabled'] = 'Benutzereinstellung zum Aktivieren des Skills-Overview-Blocks.';
$string['privacy:metadata:block_compviz_show_completed'] = 'Benutzereinstellung zum Anzeigen abgeschlossener Fähigkeiten im Skills-Overview-Block.';

// Color / appearance strings (colorpicker)
$string['colormode'] = 'Farbmodus';
$string['colormode_help'] = 'Wählen Sie, ob der Block die Theme-Farben Ihrer Seite verwenden soll (empfohlen) oder ob Sie eigene Farbwerte verwenden möchten. Änderungen wirken nur in Ihrer persönlichen Ansicht.';
$string['custom_color_1'] = 'Fortschrittsfarbe (höchste)';
$string['custom_color_1_help'] = 'Höchste Leistungsfarbe (mindestens 80%). Wählen Sie mit dem Farbwähler.';
$string['custom_color_2'] = 'Fortschrittsfarbe (hoch)';
$string['custom_color_2_help'] = 'Zweithöchste Leistungsfarbe (mindestens 60%). Wählen Sie mit dem Farbwähler.';
$string['custom_color_3'] = 'Fortschrittsfarbe (mittel)';
$string['custom_color_3_help'] = 'Mittlere Leistungsfarbe (mindestens 40%). Wählen Sie mit dem Farbwähler.';
$string['custom_color_4'] = 'Fortschrittsfarbe (niedrig)';
$string['custom_color_4_help'] = 'Zweittiefste Leistungsfarbe (mindestens 20%). Wählen Sie mit dem Farbwähler.';
$string['custom_color_5'] = 'Fortschrittsfarbe (sehr niedrig)';
$string['custom_color_5_help'] = 'Niedrigste Leistungsfarbe (unter 20%). Wählen Sie mit dem Farbwähler.';
$string['custom_color_completed'] = 'Farbe für bestanden';
$string['custom_color_failed'] = 'Farbe für nicht bestanden';
$string['custom_color_help'] = 'Primäre Farbe, verwendet wenn benutzerdefinierte Farben aktiviert sind.';
$string['usecolorpicker'] = 'Benutzerdefinierte Farben verwenden';
$string['usecolorpicker_help'] = 'Wenn ausgewählt, erstellen Sie eine persönliche Farbpalette mit den Farbwählern unten.';
$string['usetheme'] = 'Theme-Farben verwenden';
$string['usetheme_help'] = 'Wenn ausgewählt, verwendet der CompViz-Block die Farbpalette Ihres Moodle-Themes für Diagramme und Balken. Theme-Farben werden von Ihrem Administrator verwaltet.';

// Completion labels for quiz prefix
$string['completion_completed'] = 'Abgeschlossen';
$string['completion_failed'] = 'Nicht bestanden';
$string['completion_notcompleted'] = 'Nicht abgeschlossen';
$string['completion_passed'] = 'Bestanden';