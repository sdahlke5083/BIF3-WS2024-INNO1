# Competence Visualization #

TODO Describe the plugin shortly here.

TODO Provide more detailed description here.

## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/blocks/compviz

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## Learning Outcomes (LEOs) and Micro Learning Outcomes (µLEOs)

**Learning Outcomes (LEOs)** describe what a learner is expected to know, do, or understand after completing a course or module. They guide curriculum design and help ensure alignment between teaching, learning, and assessment.  
*Example: "Students will be able to apply basic statistical methods to analyze real-world data."*

**Micro Learning Outcomes (µLEOs)** are smaller, more focused learning goals that support the achievement of a broader LEO. They allow for targeted instruction and detailed tracking of learner progress.  
*Example: "Students can calculate mean, median, and mode from a dataset."*

### Translating LEOs and µLEOs into Moodle Using Grades

In Moodle, **µLEOs** can be represented as individual **grade items**, each tied to a specific activity, quiz question, or manual assessment. These items provide fine-grained insight into specific skills and knowledge areas.

**LEOs** can be organized as **grade categories** that group related µLEO grade items. This structure allows Moodle to automatically calculate aggregated grades for each LEO, offering a clear overview of learner achievement at both micro and macro levels.



## License ##

2024 BIF-INNO-Group10

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.
