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
 * Plugin administration pages are defined here.
 *
 * @package     qbank_kia_generator
 * @author      Jan Rieger, ISy, TH Lübeck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('qbank_kia_generator_settings', new lang_string('pluginname', 'qbank_kia_generator'));

    if ($ADMIN->fulltree) {
        $settings->add(new admin_setting_configexecutable(
            'qbank_kia_generator/pathtopdftoppm',
            get_string('pathtopdftoppm', 'qbank_kia_generator'),
            get_string('pathtopdftoppm_desc', 'qbank_kia_generator'),
            '/usr/bin/pdftoppm'
        ));

        // Presets
        $settings->add( new admin_setting_heading(
            'qbank_kia_generator/presets',
            get_string('presets', 'qbank_kia_generator'),
            get_string('presetsdesc', 'qbank_kia_generator')
        ));
        
        for ($i = 1; $i <= 10; $i++) {

            // Preset header.
            $settings->add( new admin_setting_heading(
                'qbank_kia_generator/preset' . $i,
                get_string('preset', 'qbank_kia_generator') . " $i",
                null
            ));

            // Preset name.
            $settings->add( new admin_setting_configtext(
                'qbank_kia_generator/presetname' . $i,
                get_string('presetname', 'qbank_kia_generator'),
                get_string('presetnamedesc', 'qbank_kia_generator'),
                get_string('presetnamedefault' . $i, 'qbank_kia_generator')
            ));

            // Preset format.
            $settings->add( new admin_setting_configselect(
                'qbank_kia_generator/presetformat' . $i,
                get_string('presetformat', 'qbank_kia_generator'),
                get_string('presetformatdesc', 'qbank_kia_generator'),
                get_string('presetformatdefault'.$i, 'qbank_kia_generator'),
                [
                    'GIFT' => 'GIFT',
                    'XML' => 'XML'
                ]
            ));

            // Preset primer.
            $settings->add( new admin_setting_configtextarea(
                'qbank_kia_generator/presetprimer' . $i,
                get_string('presetprimer', 'qbank_kia_generator'),
                get_string('presetprimerdesc', 'qbank_kia_generator'),
                get_string('presetprimerdefault' . $i, 'qbank_kia_generator'),
                PARAM_RAW, 4000
            ));

            // Preset instructions.
            $settings->add( new admin_setting_configtextarea(
                'qbank_kia_generator/presetinstructions' . $i,
                get_string('presetinstructions', 'qbank_kia_generator'),
                get_string('presetinstructionsdesc', 'qbank_kia_generator'),
                get_string('presetinstructionsdefault' . $i, 'qbank_kia_generator'),
                PARAM_RAW, 4000
            ));

            // Preset example.
            $settings->add( new admin_setting_configtextarea(
                'qbank_kia_generator/presetexample' . $i,
                get_string('presetexample', 'qbank_kia_generator'),
                get_string('presetexampledesc', 'qbank_kia_generator'),
                get_string('presetexampledefault' . $i, 'qbank_kia_generator'),
                PARAM_RAW, 4000
            ));

        }
    }
}
