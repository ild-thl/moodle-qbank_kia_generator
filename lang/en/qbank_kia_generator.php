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
 * Plugin strings are defined here.
 *
 * @package     qbank_kia_generator
 * @category    string
 * @author      Jan Rieger, ISy, TH Lübeck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['questioncategory'] = 'Question category';
$string['defaultmodel'] = 'Default model';
$string['defaultmodellabel'] = 'This AI Model will be used as default. It can be changed in the course.';
$string['defaultmodelnotavailable'] = 'The selected AI model is not available. Please select another model from the list of available models.';
$string['editpreset'] = 'Edit preset before submitting';
$string['emptypythonpathwarning'] = 'Warning: The Python path is not configured. Please set it in <a href="search.php?query=pathtopython">Site administration</a>.<br>Without this path, the KIA AI Question Generator cannot process content from PDFs.<br>Possible Python paths are:<br>Linux: /usr/bin/python3<br>Windows: C:\laragon\bin\python\python-3.13\python.exe';
$string['errorprocessingpdf'] = 'Error processing the PDF file. The Python package "PyMuPDF" may not be installed. Please install it using the command "pip install PyMuPDF".';
$string['kia_generator:generatequestions'] = 'Generate questions';

$string['mistral_api_key'] = 'Mistral API Key';
$string['mistral_api_key_desc'] = 'Mistral is required to extract content from PDF files. Log in to <a href="https://mistral.ai/">mistral.ai</a> and create an API key under "Try the API".';
$string['pluginname'] = 'KIA AI Question Generator';
$string['preset'] = 'Preset';
$string['presetname'] = 'Preset name';
$string['presetnamedesc'] = 'The name of the preset that will be displayed in the courses.';
$string['presetnamedefault1'] = 'Multiple choice (GIFT)';
$string['presetnamedefault2'] = 'True/False (GIFT)';
$string['presetnamedefault3'] = 'Shortanswer (GIFT)';
$string['presetnamedefault4'] = 'Matrix (XML)';
$string['presetnamedefault5'] = 'Cloze (XML)';
$string['presetnamedefault6'] = 'Ddwtos (XML)';
$string['presetnamedefault7'] = '';
$string['presetnamedefault8'] = '';
$string['presetnamedefault9'] = '';
$string['presetnamedefault10'] = '';
$string['presetformat'] = 'Preset format';
$string['presetformatdesc'] = 'Format in which the questions should be generated. This can be GIFT or XML, for example. GIFT is the standard format for Moodle questions and allows easy integration into the Moodle question bank.';
$string['presetformatdefault1'] = 'GIFT';
$string['presetformatdefault2'] = 'GIFT';
$string['presetformatdefault3'] = 'GIFT';
$string['presetformatdefault4'] = 'XML';
$string['presetformatdefault5'] = 'XML';
$string['presetformatdefault6'] = 'XML';
$string['presetformatdefault7'] = '';
$string['presetformatdefault8'] = '';
$string['presetformatdefault9'] = '';
$string['presetformatdefault10'] = '';
$string['presetprimer'] = 'Preset primer';
$string['presetprimerdesc'] = 'Initial information sent to the AI to set the context for question generation. This can be a brief description of the topic for which questions are to be generated.';
$string['presetprimerdefault1'] = 'You are a helpful teacher\'s assistant that creates multiple choice questions based on the topics given by the user.';
$string['presetprimerdefault2'] = 'You are a helpful teacher\'s assistant that creates truefalse questions based on the topics given by the user.';
$string['presetprimerdefault3'] = 'You are a helpful teacher\'s assistant that creates shortanswer questions based on the topics given by the user.';
$string['presetprimerdefault4'] = 'Erstelle Aussagen zu einem Text, den ich extra angebe, die entweder wahr oder falsch sind.';
$string['presetprimerdefault5'] = 'Erstelle eine Aussage zu einem Text, den ich extra angebe. Wir wollen eine Dropdown-Auswahlmöglichkeit erzeugen.';
$string['presetprimerdefault6'] = 'Erstelle einen Text zur Erklärung eines Inhaltes, den ich extra angebe.';
$string['presetprimerdefault7'] = '';
$string['presetprimerdefault8'] = '';
$string['presetprimerdefault9'] = '';
$string['presetprimerdefault10'] = '';
$string['presetinstructions'] = 'Preset instructions';
$string['presetinstructionsdesc'] = 'Instructions for the AI to generate questions. This can include specific requirements or formats for the questions.';
$string['presetinstructionsdefault1'] = 'Please write a multiple choice question in English language in GIFT format on a topic I will specify to you separately GIFT format use equal sign for right answer and tilde sign for wrong answer at the beginning of answers. For example: \'::Question title:: Question text { =right answer#feedback ~wrong answer#feedback ~wrong answer#feedback ~wrong answer#feedback }\' Please have a blank line between questions. Do not include the question title in the beginning of the question text.';
$string['presetinstructionsdefault2'] = 'Please write a true/false question in GIFT format on a topic I will specify to you separately. In GIFT format, use the character T for a true answer and the character F for a false answer inside the curly braces. For example: \'::Question title::Question text{T}\' or \'::Question title::Question text{F}\'. Please have a blank line between questions. Do not include the question title in the beginning of the question text. The following is an example of how your output should look like.';
$string['presetinstructionsdefault3'] = 'Please write a short answer question in GIFT format on a topic I will specify to you separately. In GIFT format, use the equal sign inside the curly braces to specify the correct answer(s). You can provide multiple correct answers by listing them with separate equal signs inside the curly braces. Answers are case-insensitive by default. For example: \'::Question title::Question text{=correct answer =another correct answer}\'. Please have a blank line between questions. Do not include the question title in the beginning of the question text. Please choose answers that are short and simple, to minimize the chance of errors while the user is entering the correct answer. The following is an example of how your output should look like.';
$string['presetinstructionsdefault4'] = 'Schreibe jede Aussage an die entsprechende Stelle <shorttext>Aussage 1,2,3 oder 4</shorttext> und ersetze das Wort Aussage 1,2,3 oder 4. Adaptiere die auf jede Aussage folgende Zeilen <weight-of-col>0</weight-of-col> und schreibe dort in die erste Zeile eine 1 und in die darauffolgende Spalte eine 0, bei einer wahren Aussage. Bei einer falschen Aussage vertauscht Du die 1 und 0. Für die richtige Antwort jeweils unter Feedback ein. Nutze folgendes Template und fülle dies aus:';
$string['presetinstructionsdefault5'] = 'Entferne dazu den wichtigen Teil der Aussage und schreibe den unwichtigen Teil an die Stelle STATEMENT. Ersetze in dem Template die Stellen FILL 1,2,3 mit zwei falschen Vervollständigungen der Aussage und einmal mit der richigen Aussage. Vor jede falsche Vervollständigung kommt eine Tilde "~" und vor die richtige Vervollständigung eine Tilde und ein Gleichheitszeichen "~=" Die Ersetzung soll hinter dem Wort "MULTICHOICE:" beginnen. Schreibe jeweils direkt hinter eine Vervollständigung an die Stelle FEEDBACK 1,2,3 in dem Template eine Aussage, warum die Ergänzung richtig oder falsch ist. Mache zwischen Vervollständigung und Feedback eine Raute "#".';
$string['presetinstructionsdefault6'] = 'Lasse dabei Schlüsselwoerter aus und ersetze diese durch aufsteigende Zahlen in doppelten eckigen Klammern "[[1]]". Schreibe diesen Text in folgendes Template an die Stelle TEXT. Schreibe die Schluesselwoerter in der richtigen Reihenfolge ihres Auftretens jeweils in ein dragbox xml-statement. Die Zahl der Group soll immer 1 sein. Füge am Ende noch drei weitere Schlüsselworter, welche nicht exakt in den Text passen, in gleicher Weise an. Keine Zahl darf doppelt auftreten.';
$string['presetinstructionsdefault7'] = '';
$string['presetinstructionsdefault8'] = '';
$string['presetinstructionsdefault9'] = '';
$string['presetinstructionsdefault10'] = '';
$string['presetexample'] = 'Preset example';
$string['presetexampledesc'] = 'An example of the output format of the questions generated by the AI. This helps to understand how the questions will look like.';
$string['presetexampledefault1'] = '::Indexicality and iconicity 1:: Imagine that you are standing on a lake shore. A wind rises, creating waves on the lake surface. According to C.S. Peirce, in what way the waves signify the wind? { =The relationship is both indexical and iconical.#Correct. There is a connection of spatio-temporal contiguity between the wind and the waves, which is a determining feature of indexicality. There is also a formal resemblance between wind direction and the direction of the waves, which is a determining feature of iconicity.  ~The relationship is indexical.#Almost correct. There is a connection of spatio-temporal contiguity between the wind and the waves, which, according to Peirce, is a determining feature of indexicality. However, there is additional signification taking place as well. ~There is no sign phenomena betweem the wind and the waves, they are two separate signs.#Incorrect. The movement of the waves is determined by the wind. ~The relationship between the wind and the waves is symbolic.#Incorrect. The movement of the waves is not arbitrary, which would be the case if the relationship was symbolic. }';
$string['presetexampledefault2'] = '::Wahre Aussage über Grant::Grant wurde in einem Grab in New York City bestattet.{T}';
$string['presetexampledefault3'] = '::Solar System 1::What is the name of the planet closest to the Sun?{=Mercury}

::Solar System 2::Name a gas giant in our solar system.{=Jupiter =Saturn =Uranus =Neptune}';
$string['presetexampledefault4'] = '<?xml version="1.0" encoding="UTF-8"?>
    <quiz>
      <question type="matrix">
        <name>
          <text>Question name</text>
        </name>
        <questiontext format="html">
          <text><![CDATA[<p dir="ltr" style="text-align: left;">Taskdescription</p>]]></text>
        </questiontext>
        <generalfeedback format="html">
          <text></text>
        </generalfeedback>
        <defaultgrade>4</defaultgrade>
       <penalty>0</penalty>
        <hidden>0</hidden>
        <idnumber></idnumber>
        <use_dnd_ui>0</use_dnd_ui>
        <row>
            <shorttext>Aussage 1</shorttext>
            <feedback format="html">
          <text></text>
            </feedback>
        </row>
        <weights-of-row>
        <weight-of-col>0</weight-of-col>
        <weight-of-col>1</weight-of-col>
        </weights-of-row>
        <row>
            <shorttext>Aussage 2</shorttext>
            <feedback format="html">
          <text></text>
            </feedback>
        </row>
        <weights-of-row>
        <weight-of-col>1</weight-of-col>
        <weight-of-col>0</weight-of-col>
        </weights-of-row>
        <row>
            <shorttext>Aussage 3</shorttext>
            <feedback format="html">
          <text></text>
            </feedback>
        </row>
        <weights-of-row>
        <weight-of-col>1</weight-of-col>
        <weight-of-col>0</weight-of-col>
        </weights-of-row>
        <row>
            <shorttext>Aussage 4</shorttext>
            <feedback format="html">
          <text></text>
            </feedback>
        </row>
        <weights-of-row>
        <weight-of-col>0</weight-of-col>
        <weight-of-col>1</weight-of-col>
        </weights-of-row>
        <col>
            <shorttext>Wahr</shorttext>
            <description format="html">
          <text></text>
            </description>
        </col>
        <col>
            <shorttext>Falsch</shorttext>
            <description format="html">
          <text></text>
            </description>
        </col>
        <grademethod>all</grademethod>
        <shuffleanswers>1</shuffleanswers>
        <multiple>0</multiple>
        <renderer>matrix</renderer>
      </question>
    </quiz>';
$string['presetexampledefault5'] = '<?xml version="1.0" encoding="UTF-8"?>
<quiz>
  <question type="cloze">
    <name>
      <text>TITLE</text>
    </name>
    <questiontext format="html">
      <text><!\[CDATA\[<p dir="ltr" style="text-align: left;">STATEMENT {1:MULTICHOICE: FILL 1#FEEDBACK 1\~FILL 2#FEEDBACK 2\~=FILL 3#FEEDBACK 3}<br /></p><p></p>\]\]></text>
    </questiontext>
    <generalfeedback format="html">
      <text></text>
    </generalfeedback>
    <penalty>0.3333333</penalty>
    <hidden>0</hidden>
    <idnumber></idnumber>
  </question>
</quiz>';
$string['presetexampledefault6'] = '<?xml version="1.0" encoding="UTF-8"?>
<quiz>
  <question type="ddwtos">
    <name>
      <text>TITLE</text>
    </name>
    <questiontext format="html">
      <text>TEXT</text>
    </questiontext>
    <generalfeedback format="html">
      <text></text> 
    </generalfeedback> 
    <defaultgrade>3</defaultgrade> 
    <penalty>1</penalty> 
    <hidden>0</hidden> 
    <idnumber></idnumber> 
    <shuffleanswers>1</shuffleanswers> 
    <correctfeedback format="html"> 
      <text>Die Antwort ist richtig.</text> 
    </correctfeedback> 
    <partiallycorrectfeedback format="html"> 
      <text>Die Antwort ist teilweise richtig.</text> 
    </partiallycorrectfeedback> 
    <incorrectfeedback format="html"> 
      <text>Die Antwort ist falsch.</text> 
    </incorrectfeedback> 
    <shownumcorrect/> 
    <dragbox> 
      <text>FILLTEXT</text> 
      <group>1</group> 
    </dragbox> 
  </question> 
</quiz>';
$string['presetexampledefault7'] = '';
$string['presetexampledefault8'] = '';
$string['presetexampledefault9'] = '';
$string['presetexampledefault10'] = '';
$string['presets']  = 'Presets';
$string['presetsdesc']  = 'Specify up to 10 presets, which can be selected in the courses.';
$string['presethelp_help'] = 'Presets are preconfigured settings that determine the question type and other parameters. Each preset includes instructions, examples, and formatting that are sent to the AI to create the desired questions. ';

$string['settings'] = 'KIA AI Question Generator Settings';
$string['title'] = 'Generate KIA AI questions';

$string['privacy:metadata'] = 'KIA AI Question Generator, by default, neither stores personal user data nor sends it to third parties. However, text submitted by teachers in order to generate questions is sent in its entirety to third parties, and is then subject to their privacy policy, e.g. OpenAI (https://openai.com/api/policies/privacy/), which may store messages in order to improve the API. Additionally, this text is then used to generate questions that may be saved to the site.';

$string['model'] = 'Model';
$string['modellabel'] = 'The model to use in order to generate questions';

$string['sourcetext'] = 'Source text';
$string['qtype'] = 'Question type';
$string['qtype_help'] = 'Question types are ordered by their complexity. More complex question types will reduce GPT\'s ability to follow instructions or generate coherent questions.';
$string['qtype_prompt_multichoice'] = 'Multiple choice';
$string['qtype_prompt_multichoice_descr'] = 'Example of the output JSON of a question of the type Multiple choice.';
$string['qtype_prompt_multichoice_default'] = '[{"question": "On what date did construction start?", "answers": {"A": "1882", "B": "1893", "C": "1926", "D": "1918"}, "correct": "A"}, {"question": "Who was the original architect of the basilica?", "answers": {"A": "Antoni Gaudi", "B": "Francsico de Goya", "C": "Francisco de Paula del Villar", "D": "Louis Sullivan"}, "correct": "C"}, {"question": "How much of the basilica was finished when Gaudi died?", "answers": {"A": "Over a third", "B": "Nearly all of it", "C": "Around half", "D": "Less than a quarter"}, "correct": "D"}]';
$string['qtype_prompt_shortanswer'] = 'Short answer';
$string['qtype_prompt_shortanswer_descr'] = 'Example of the output JSON of a question of the type Short answer.';
$string['qtype_prompt_shortanswer_default'] = '[{"question": "On what date did construction start?", "answers": {"A": "19 March 1882"}}, {"question": "Who was the original architect of the basilica?", "answers": {"A": "Francisco de Paula del Villar"}}, {"question": "How much of the project was completed when Gaudi died?", "answers": {"A": "Less than a quarter"}}]';
$string['qtype_prompt_truefalse'] = 'True/False';
$string['qtype_prompt_truefalse_descr'] = 'Example of the output JSON of a question of the type True/False.';
$string['qtype_prompt_truefalse_default'] = '[{"question": "Construction started on 19 March 1882", "answers": {"A": "True"}}, {"question": "The original architect was Antoni Gaudi", "answers": {"A": "False"}}, {"question": "Over half of the basilica was finished when Gaudi died.", "answers": {"A": "False"}}]';
$string['modselection'] = 'Choose activities as content';
$string['numquestions'] = 'Number of questions to generate';
$string['numquestions_help'] = 'GPT will be asked to generate this many questions, but it is just a request. Larger input text or more complex question types will limit GPT\'s ability to match the number asked for.';
$string['notanumber'] = 'Value must be a number that is between 1 and 10';
$string['sourcetextcharlength'] = 'Number of characters must be between 100 and 64,000';
$string['sourcetextorcheckboxes'] = 'Please either enter the source text or select one or more activities to use as content. Source texts should be between 100 and 64,000 characters long.';

$string['editquestions'] = 'Edit Questions';
$string['numbermismatch'] = "The number of questions generated by GPT doesn't match the number you requested. This could have different reasons (to long text, to many questions requested, question type to coplex. If this keeps happening, you may want to try using a different model.";
$string['markascorrect'] = "Mark as correct";
$string['addtoqbank'] = "Add to question bank";
$string['cancel'] = "Cancel";

$string['error_capability'] = 'Sorry, you don\'t have permission to generate questions in this course.';
$string['error_gpt_format'] = "GPT failed to return questions in the correct format. Sorry, there's nothing you can do about this except try generating the questions again. You can refresh this page to re-attempt question generation.";
$string['herestheresponse'] = "\n\nHere's the response received from GPT:\n\"";

$string['confirmdelete_question'] = 'Delete this question?';
$string['wait'] = 'Please wait...';
$string['pathtopdftoppm'] = 'Path to pdftoppm';
$string['pathtopdftoppm_desc'] = 'Absolute path to the pdftoppm executable used to render PDF pages into images (for example /usr/bin/pdftoppm).';
