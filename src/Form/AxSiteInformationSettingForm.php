<?php

namespace Drupal\ax_siteinfo\Form;

// Classes referenced in this class:
use Drupal\Core\Form\FormStateInterface;

// This is the form we are extending.
use Drupal\system\Form\SiteInformationForm;

/**
 * Configure site information settings for this site.
 */
class AxSiteInformationSettingForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Retrieve the system.site configuration.
    $site_config = $this->config('system.site');

    // Get the original form from the class we are extending.
    $form = parent::buildForm($form, $form_state);

    // Add a textfield to the site information section of the form for our.
    // Site API.
    $form['site_information']['site_api_key'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      // The default value is the new value we added to our configuration.
      '#default_value' => $site_config->get('siteapikey'),
      '#description' => $this->t('The site api key use for accessing the node'),
    ];
    // Update the actions button value from save configuration to
    // update configuration.
    $form['actions']['submit']['#value'] = $this->t('Update configuration');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get field value.
    $siteapikey = $form_state->getValue('site_api_key');
    // Now we need to save the new Site API Key to the
    // system.site.siteapikey configuration.
    $this->config('system.site')
      // The site_api_key is retrieved from the submitted form values
      // and saved 'Site API Key' element of the system.site configuration.
      ->set('siteapikey', $siteapikey)
      // Save the configuration.
      ->save();

    // Pass the remaining values off to the original form that we have extended,
    // so that they are also saved.
    parent::submitForm($form, $form_state);
    // Display message that information has been saved successfully.
    $message = "The Site API Key has been saved with $siteapikey";
    \Drupal::messenger()->addMessage($message);
  }

}
