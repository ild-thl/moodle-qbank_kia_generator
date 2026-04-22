# qbank_kia_generator

`qbank_kia_generator` is a Moodle **Question bank plugin (qbank)** for AI-assisted question generation in the question bank.

## Goal

The plugin allows teachers to automatically generate questions from selected course content and import them directly into a chosen question category.

## Technical Status

- Moodle version: **4.5**
- Plugin type: **qbank**
- AI integration: **Moodle-native AI API** (`core_ai\manager`)
- Provider: **`aiprovider_myai`**
- Dedicated action for this plugin: **`aiprovider_myai\aiactions\generate_question`**

The previous direct integration via `local_kia_connector` is no longer used.

## Features

- Select course content as input source:
  - Free text
  - Content from activities/resources (for example Label, Page, Resource, Folder)
- Use presets (format, primer, instructions, example)
- Generate questions in supported output formats (for example GIFT/XML)
- Import questions into a selected question bank category

## Requirements

- Installed and enabled plugin `aiprovider_myai`
- In `aiprovider_myai`, the `generate_question` action is configured with:
  - Model
  - Endpoint
  - System instruction
- Sufficient permissions in course/question contexts

## Installation

1. Deploy the plugin to `question/bank/kia_generator`.
2. Run Moodle upgrade (via web UI or CLI).
3. Verify that the `aiprovider_myai` dependency is satisfied.

## Configuration

- Plugin settings:
  - `Site administration > Plugins > Question bank plugins > KIA Generator`
- Prompt and output behavior can be managed through plugin presets.
- Model/endpoint-specific settings are managed centrally in the provider:
  - `Site administration > AI > AI providers > MyAI`

## Usage

1. Open the question generation entry point in the course (More > Generate KIA AI Questions).
2. Select sources (free text and/or activity content).
3. Select and optionally adjust a preset.
4. Set the number of questions and start generation.
5. After review, import the result into the selected question category.

## Notes

- Output quality strongly depends on source content and preset instructions.
- For strict output formats (GIFT/XML), presets should stay consistent and explicit.
