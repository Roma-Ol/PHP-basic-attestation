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
    // Number of rows.
    $number_of_forms = $form_state->get('number_of_forms');
    $number_of_tags  = $form_state->get('number_of_tags');

    for ($y = 0; $y < $number_of_forms + 1; $y++) {
      $form['table'][$y] = [
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

      for ($i = 0; $i < $number_of_tags - 1; $i++) {
        $form['table'][$y][$i]['year'] = [
          '#type'     => 'number',
          '#value'    => $year - $i,
          '#disabled' => TRUE,
        ];
        for ($c = 1; $c <= 17; $c++) {
          $form['table'][$y][$i][$c] = [
            '#type' => 'number',
          ];
        }
      }
    }

    // Add a row button.
    $form['addRow'] = [
      '#type'   => 'submit',
      '#value'  => t('+ Row'),
      '#submit' => ['::addOneTag'],
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

    if (empty($number_of_tags)) {
      $number_of_tags = 1;
      $form_state->set('number_of_tags', $number_of_tags);
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
  public function addOneTag(array &$form, FormStateInterface $form_state) {
    $number_of_tags = $form_state->get('number_of_tags');
    $form_state->set('number_of_tags', $number_of_tags + 1);
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
