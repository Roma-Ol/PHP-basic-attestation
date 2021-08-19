<?php

namespace Drupal\Form\table\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FormMain.
 *
 * Works on this specific class.
 */
class FormMail extends FormBase {

  /**
   * Return the ID.
   *
   * @returns string
   */
  public function getFormId() {
    return 'form_main';
  }

  /**
   * Building the form and setting the fields.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name']   = [
      '#type'        => 'textfield',
      '#title'       => t('Name:'),
      '#placeholder' => 'Name',
    ];
    $form['submit'] = [
      '#type'  => 'submit',
      '#name'  => 'submit',
      '#value' => $this->t('Submit'),
    ];
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
  }

}
