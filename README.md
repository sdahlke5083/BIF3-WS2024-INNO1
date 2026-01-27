# Competence Visualization (CompViz) #

The **Competence Visualization (CompViz)** block is a Moodle plugin that provides students and teachers with a visual overview of learning progress and competency development within a course. It translates Moodle's gradebook structure into an intuitive, color-coded display of Learning Outcomes (LEOs) and Micro Learning Outcomes (µLEOs).

[![Build, Package & Release on Tag](https://github.com/sdahlke5083/BIF3-WS2024-INNO1/actions/workflows/main.yml/badge.svg?branch=main)](https://github.com/sdahlke5083/BIF3-WS2024-INNO1/actions/workflows/main.yml)

## Project Information

**Current Version:** v0.0.3-alpha.5  
**Maturity:** ALPHA (under active development)  
**Development Team:** BIF-INNO-Group10 (Technikum Wien)  
**Semester:** WS2024 - SS2026 (INNO1, INNO2, INNO3)  
**Repository:** [GitHub](https://github.com/sdahlke5083/BIF3-WS2024-INNO1)

This project is part of a multi-semester innovation course where different student teams continue development. See the [Übergabeprotokol](Docs/Übergabeprotokol.md) for complete handover documentation.

## Key Features

- **Visual Progress Tracking**: Color-coded progress bars showing achievement levels from 0% to 100%
- **Personalized Appearance**: Users can choose from predefined color themes or create custom color palettes
- **Flexible Display**: Toggle visibility of completed competencies for a focused view
- **Multi-language Support**: Available in English and German
- **Responsive Design**: Adapts to various screen sizes and devices
- **Teacher Configuration**: Teachers can configure which grade category (LEO) to display per block instance
- **Privacy Compliant**: GDPR-ready with proper Privacy API implementation

## Learning Outcomes (LEOs) and Micro Learning Outcomes (µLEOs)

**Learning Outcomes (LEOs)** describe what a learner is expected to know, do, or understand after completing a course or module. They guide curriculum design and help ensure alignment between teaching, learning, and assessment.  
*Example: "Students will be able to apply basic statistical methods to analyze real-world data."*

**Micro Learning Outcomes (µLEOs)** are smaller, more focused learning goals that support the achievement of a broader LEO. They allow for targeted instruction and detailed tracking of learner progress.  
*Example: "Students can calculate mean, median, and mode from a dataset."*

### Translating LEOs and µLEOs into Moodle Using Grades

In Moodle, **µLEOs** can be represented as individual **grade items**, each tied to a specific activity, quiz question, or manual assessment. These items provide fine-grained insight into specific skills and knowledge areas.

**LEOs** can be organized as **grade categories** that group related µLEO grade items. This structure allows Moodle to automatically calculate aggregated grades for each LEO, offering a clear overview of learner achievement at both micro and macro levels.

## Documentation

### Installation
- **[Installation Guide (English)](Docs/Compviz_Install_EN.md)** - Complete installation instructions for administrators
- **[Installation Guide (Deutsch)](Docs/Compviz_Install_DE.md)** - Vollständige Installationsanleitung für Administratoren
  
**Requirements:**
- ![Moodle 4.1 or newer](https://img.shields.io/badge/Moodle-4.1%2B-blue?logo=moodle)
- ![PHP 8.0 or newer](https://img.shields.io/badge/PHP-8.0%2B-blue?logo=php)

### User Guides
- **[User Guide (English)](Docs/Compviz_UserGuide_EN.md)** - How to use CompViz as a student or teacher
- **User Guide (Deutsch)** - Not yet available

### Development & Handover
- **[Übergabeprotokol (Deutsch)](Docs/Übergabeprotokol.md)** - Comprehensive handover document for future development teams
  - Project goals and implemented features
  - Moodle plugin development basics
  - Advanced problems and solutions (Custom Colorpicker, Grunt/AMD, etc.)
  - GitHub Actions and release management
  - Critical guidance for future teams

**For Developers:** If you're continuing work on this plugin, please read the **Übergabeprotokol** thoroughly before starting. It contains essential information about architecture decisions, known issues, and best practices.

## License ##

Copyright 2024-2026 BIF-INNO-Group10  
Authors: Sebastian Dahlke, Mateo Rašo

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.

## Available Languages

- English: `lang/en/block_compviz.php`
- German: `lang/de/block_compviz.php`

## Contributing

This plugin is part of an educational project at Technikum Wien. If you're a future development team:

1. Read the **[Übergabeprotokol](Docs/Übergabeprotokol.md)** completely before starting
2. Follow the established tag naming convention for releases
3. Maintain Moodle coding standards (PHPDoc is mandatory!)
4. Document your changes and learnings in the Übergabeprotokol

For questions or issues, please use [GitHub Issues](https://github.com/sdahlke5083/BIF3-WS2024-INNO1/issues).

