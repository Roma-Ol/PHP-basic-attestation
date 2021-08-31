<?php

namespace Drupal\romaroma\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a romaroma form.
 */
class FormMain extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'romaroma_form_main';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Current year.
    $year = date('Y');
    // Counters for forms and lines.
    $number_of_forms = $form_state->get('number_of_forms');
    $number_of_rows = $form_state->get('number_of_rows');

    for ($tables = 0; $tables < $number_of_forms; $tables++) {
      $form['table'][$tables] = [
        '#type'   => 'table',
        '#header' => [
          'Year',
          'Jan',
          'Feb',
          'Mar',
          'Q1',
          'Apr',
          'May',
          'Jun',
          'Q2',
          'Jul',
          'Aug',
          'Sep',
          'Q3',
          'Oct',
          'Nov',
          'Dec',
          'Q4',
          'YTD',
        ],
      ];

      for ($rows = 0; $rows < $number_of_rows; $rows++) {
        $form['table'][$tables][$rows]['year'] = [
          '#type'     => 'number',
          '#value'    => $year - $rows,
          '#disabled' => TRUE,
        ];
        for ($cells = 1; $cells <= 17; $cells++) {
          $form['table'][$tables][$rows][$cells] = [
            '#type' => 'number',
          ];
        }
      }
    }

    // Add a row button.
    $form['addRow'] = [
      '#type'   => 'submit',
      '#value'  => t('+ Row'),
      '#submit' => ['::addOneRow'],
    ];
    // Add form button.
    $form['addForm'] = [
      '#type'   => 'submit',
      '#value'  => t('+ Form'),
      '#submit' => ['::addOneForm'],
    ];
    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type'       => 'submit',
      '#value'      => $this->t('Send'),
      '#attributes' => ["onclick" => "javascript: this.disabled = true;"],
    ];

    if (empty($number_of_rows)) {
      $number_of_rows = 1;
      $form_state->set('number_of_rows', $number_of_rows);
    }

    if (empty($number_of_forms)) {
      $number_of_forms = 1;
      $form_state->set('$number_of_forms', $number_of_forms);
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Do validation.
  }

  /**
   * Increment number of rows.
   */
  public function addOneRow(array &$form, FormStateInterface $form_state) {
    $number_of_rows = $form_state->get('number_of_rows');
    $form_state->set('number_of_rows', $number_of_rows + 1);
    $form_state->setRebuild(TRUE);
  }

  /**
   * Increment number of tables.
   */
  public function addOneForm(array &$form, FormStateInterface $form_state) {
    $number_of_forms = $form_state->get('number_of_forms');
    $form_state->set('number_of_forms', $number_of_forms + 1);
    $form_state->setRebuild(TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('romaroma.form_main');
  }

}
