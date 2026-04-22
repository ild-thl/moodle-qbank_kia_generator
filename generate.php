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
 * Generation form page
 *
 * @package    qbank_kia_generator
 * @author     Jan Rieger, ISy, TH Lübeck
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/classes/forms/generate.php');
require_once($CFG->libdir.'/navigationlib.php');

use qbank_kia_generator\handler;
use qbank_kia_generator\helper;

// We reuse this page both for the initial question text form as well as the edit questions page.
// During setup, we'll assume which is which based on whether the "id" parameter is set or not (id => generate questions, no id => edit questions)
// Once the page is set up, if no id parameter is set, we'll check to see if any form data was passed to determine if we actually ARE on the edit questions page or not.
// If not, we just redirect to the course.

// First, figure out the current course. If passed in the URL, use that; otherwise, grab the session value
// Also set the URL accordingly
$courseid = optional_param('courseid', 1, PARAM_INTEGER);
$url = null;
if ($courseid !== 1) {
  $url = new moodle_url($CFG->wwwroot . "/question/bank/kia_generator/generate.php", ['id' => $courseid]);
} else {
  $url = new moodle_url($CFG->wwwroot . "/question/bank/kia_generator/generate.php");
}

// Then get the course record from this value, check that the user has permission to do this, and add the relevant crumbs to the nav trail
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

require_login($course);
if (!has_capability('moodle/course:manageactivities', context_course::instance($course->id))) {
  throw new \moodle_exception("capability_error", "qbank_kia_generator", "", get_string('error_capability', 'qbank_kia_generator'));
}

$PAGE->navbar->add($course->shortname, new moodle_url('/course/view.php', ['id' => $course->id]));
if ($courseid !== 1) {
  $PAGE->navbar->add(get_string("pluginname", "qbank_kia_generator", $url));
} else {
  $PAGE->navbar->add(
    get_string("pluginname", "qbank_kia_generator"), 
    new moodle_url('/question/bank/kia_generator/generate.php', ['id' => $course->id])
  );
  $PAGE->navbar->add(get_string("editquestions", "qbank_kia_generator", $url));
}

// Set up page
$pagetitle = get_string('pluginname', 'qbank_kia_generator');
$PAGE->set_course($course);
$PAGE->set_url($url);
$PAGE->set_title($pagetitle);
$PAGE->set_pagelayout('standard');

$helper = new helper();

$mform = new generate_form(null, ['courseid' => $courseid]);
$fromform = $mform->get_data();

if ($mform->is_cancelled()) {

  redirect($CFG->wwwroot . "/course/view.php?id=" . $course->id);
  
} else if ($fromform) {
  // The form was submitted, so render the edit questions page with the result

  $PAGE->requires->strings_for_js(['confirmdelete_question', 'wait'], 'qbank_kia_generator');
  $PAGE->requires->js(new moodle_url('/question/bank/kia_generator/lib.js'));
  $PAGE->set_heading(get_string('editquestions', 'qbank_kia_generator'));
  echo $OUTPUT->header();
  // generate sourcetext from course mods if checked in form
  $mods = [];
  foreach ($fromform as $key => $value) {
    if (preg_match('/^mod_\w+_\d+$/', $key) && $value) {
        // activated checkbox
        $mod = explode('_', $key);
        $mods[$mod[0].'_'.$mod[1]][] = explode('_', $key)[2];
    }
  }

  $sourcetexts = array();
  if (count($mods) > 0) {
    $modtexts = $helper->get_sourcetexts($mods);
    $sourcetexts = array_merge($sourcetexts, $modtexts);
  }
  if ($fromform->sourcetext) {
    // If the user entered a source text, add it to the array
    $sourcetexts[] = $fromform->sourcetext;
  }
  
  $i = preg_replace('/[^0-9]/', '', $fromform->preset);
  $format = get_config('qbank_kia_generator', 'presetformat'.$i);
  $primer = $fromform->{'presetprimer'.$i};
  $instructions = $fromform->{'presetinstructions'.$i};
  $example = $fromform->{'presetexample'.$i};
  $handler = new handler($sourcetexts, \context_course::instance($course->id)->id);
  $questions = $handler->fetch_response($fromform->number_of_questions, $format, $primer, $instructions, $example);
  // call helper function to import the questions into the question bank
  // on success, redirect to question bank page 
  if ($helper->import_questions_from_string($questions, $fromform->category, $course, $format)) {
    // ToDo: add url parameters to filter by the correct category and show the last imported questions
    redirect(new moodle_url('/question/edit.php', ['courseid' => $course->id]));
  }
} else {
  
  // If the course id isn't set and data wasn't actually passed, redirect to course. Somebody went to this page directly, I guess
  if ($courseid === 1 && (!$fromform && !file_get_contents('php://input'))) {
    redirect(new moodle_url('/course/view.php', ['id' => $course->id]));
  }
  if (!has_capability('qbank/kia_generator:generatequestions', context_course::instance($course->id))) {
    throw new \moodle_exception("capability_error", "qbank_kia_generator", "", get_string('error_capability', 'qbank_kia_generator'));
  }

  $PAGE->set_heading($pagetitle);
  echo $OUTPUT->header();
  $mform->set_data(['courseid' => $courseid]);
  $mform->display();

}

echo $OUTPUT->footer();
