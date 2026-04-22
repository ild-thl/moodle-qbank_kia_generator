<?php
// This file is part of Moodle - http://moodle.org/
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
 * Question generation form
 *
 * @package    qbank_kia_generator
 * @author     Jan Rieger, ISy, TH Lübeck
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

use qbank_kia_generator\helper;

class generate_form extends moodleform {

    public function definition() {
       
        $mform = $this->_form;

        $mform->addElement('textarea', 'sourcetext', get_string('sourcetext', 'qbank_kia_generator'),'wrap="virtual" rows="20" cols="50"');
        $mform->setType('sourcetext', PARAM_TEXT);

        // ToDo add Elements for mods with content
        $courseid = isset($this->_customdata['courseid']) ? $this->_customdata['courseid'] : 0;
        $helper = new helper();
        $mods = $helper->get_mods_with_content($courseid);
        $checkboxes = [];
        foreach ($mods as $mod) {
            $checkboxes[] = $mform->createElement('checkbox', $mod->name.'_'.$mod->id, '', $mod->title);
        }
        $mform->addGroup($checkboxes, 'modgroup', get_string('modselection', 'qbank_kia_generator'), '<br>', false);
        $presets = $helper->get_presets(); // ['preset1' => 'Multiple-Choice Fragen (GIFT)']
        $mform->addElement('select', 'preset', get_string('preset', 'qbank_kia_generator'), $presets);
        $mform->addHelpButton('preset', 'presethelp', 'qbank_kia_generator');

        $mform->addElement('checkbox', 'editpreset', get_string('editpreset', 'qbank_kia_generator'));

        foreach ($presets as $preset => $presetname) {
            $i = preg_replace('/[^0-9]/', '', $preset);

            // Primer.
            $mform->addElement('textarea', 'presetprimer'.$i, get_string('presetprimer', 'qbank_kia_generator'),
                'wrap="virtual" rows="10" cols="50"');
            $mform->setType('presetprimer'.$i, PARAM_RAW);
            $mform->setDefault('presetprimer' . $i, get_config('qbank_kia_generator', 'presetprimer'.$i));
            //$mform->addHelpButton('presetprimer' . $i, 'presetprimerdesc', 'qbank_kia_generator');
            $mform->hideif('presetprimer'.$i, 'editpreset');
            $mform->hideif('presetprimer'.$i, 'preset', 'neq', $preset); // Show only if the preset is selected or if the edit preset checkbox is checked.
            
            // Instructions.
            $mform->addElement('textarea', 'presetinstructions'.$i, get_string('presetinstructions', 'qbank_kia_generator'),
            'wrap="virtual" rows="10" cols="50"');
            $mform->setType('presetinstructions'.$i, PARAM_RAW);
            $mform->setDefault('presetinstructions'.$i, get_config('qbank_kia_generator', 'presetinstructions'.$i));
            //$mform->addHelpButton('presetinstructions'.$i, 'presetinstructionsdesc', 'qbank_kia_generator');
            $mform->hideif('presetinstructions'.$i, 'editpreset');
            $mform->hideif('presetinstructions'.$i, 'preset', 'neq', $preset);
            
            // Example.
            $mform->addElement('textarea', 'presetexample'.$i, get_string('presetexample', 'qbank_kia_generator'),
            'wrap="virtual" rows="10" cols="50"');
            $mform->setType('presetexample'.$i, PARAM_RAW);
            $mform->setDefault('presetexample'.$i, get_config('qbank_kia_generator', 'presetexample'.$i));
            //$mform->addHelpButton('presetexample'.$i, 'presetexample', 'qbank_kia_generator');
            $mform->hideif('presetexample'.$i, 'editpreset');
            $mform->hideif('presetexample'.$i, 'preset', 'neq', $preset);
        }

        $mform->addElement('text', 'number_of_questions', get_string('numquestions', 'qbank_kia_generator'));
        $mform->setType('number_of_questions', PARAM_INTEGER);
        $mform->addHelpButton('number_of_questions', 'numquestions', 'qbank_kia_generator');
        $mform->setDefault('number_of_questions', 1);

        $mform->addElement('hidden', 'courseid', '1');
        $mform->setType('courseid', PARAM_INTEGER);

        // Add Dropdown with question category selection
        $categories = $helper->get_question_categories($courseid);
        if (empty($categories)) {
            // add new moodle question category
            $helper->create_default_question_categories($courseid);
            $categories = $helper->get_question_categories($courseid);
        }
        $mform->addElement('select', 'category', get_string('questioncategory', 'qbank_kia_generator'), $categories);

        $this->add_action_buttons(true, get_string('kia_generator:generatequestions', 'qbank_kia_generator'));
    }

    public function validation($data, $files) {
        $errors = [];
        // check if textarea or checkboxes are not empty
        $sourcetextnotok = strlen($data['sourcetext']) < 100 || strlen($data['sourcetext']) > 64000;
        $anycheckboxchecked = false;

        // Check if at least one checkbox is checked
        foreach ($data as $key => $value) {
            if (preg_match('/^mod_\w+_\d+$/', $key) && $value) {
                $anycheckboxchecked = true;
                break;
            }
        }

        if ($data['number_of_questions'] < 1 || $data['number_of_questions'] > 10) {
            $errors['number_of_questions'] = get_string('notanumber', 'qbank_kia_generator');
        }

        if ($sourcetextnotok && !$anycheckboxchecked) {
            $errors['modgroup'] = get_string('sourcetextorcheckboxes', 'qbank_kia_generator');
        }

        return $errors;
    }

}