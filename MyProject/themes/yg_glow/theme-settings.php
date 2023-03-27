<?php

/**
 * @file
 * Provides an additional config form for theme settings.
 */

use Drupal\Core\Form\FormStateInterface;

function yg_glow_form_system_theme_settings_alter(array &$form, FormStateInterface $form_state) {
  $form['visibility'] = array(
    '#type' => 'vertical_tabs',
    '#title' => t('YG Glow Settings'),
    '#weight' => -999,
  );
  $form['social']= array(
    '#type' => 'details',
    '#attributes' => array(),
    '#title' => t('Social Links'),
    '#weight' => -999,
    '#group' => 'visibility',
    '#open' => FALSE,
  );
#social links    
  $form['social']['social_links'] = array(
    '#type' => 'details',
    '#title' => t('Contact Info'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['social']['social_links']['social_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Social Section Title'),
    '#description' => t('Please enter social section title'),
    '#default_value' => theme_get_setting('social_title'),
    '#required' => TRUE,
  );
  $form['social']['social_links']['twitter_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter'),
    '#description' => t('Please enter your twitter url'),
    '#default_value' => theme_get_setting('twitter_url'),
  ); 
  $form['social']['social_links']['facebook_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook'),
    '#description' => t('Please enter your facebook url'),
    '#default_value' => theme_get_setting('facebook_url'),
  );
   $form['social']['social_links']['google_plus_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Google Plus'),
    '#description' => t('Please enter your instagram url'),
    '#default_value' => theme_get_setting('google_plus_url'),
  );
  $form['social']['social_links']['instagram_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Instagram'),
    '#description' => t('Please enter your instagram url'),
    '#default_value' => theme_get_setting('instagram_url'),
  );

#Footer
  $form['footer_about']= array(
    '#type' => 'details',
    '#attributes' => array(),
    '#title' => t('About Footer Section'),
    '#weight' => -998,
    '#group' => 'visibility',
    '#open' => FALSE,
  );
  $form['footer_about']['about'] = array(
    '#type' => 'details',
    '#title' => t('Footer'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['footer_about']['about']['about_title'] = array(
    '#type' => 'textfield',
    '#title' => t('About Title'),
    '#description' => t('Please enter footer about section title'),
    '#default_value' => theme_get_setting('about_title'),
    '#required' => TRUE,
  );
  $form['footer_about']['about']['about_desc'] = array(
    '#type' => 'textarea',
    '#title' => t('About Description'),
    '#description' => t('Please enter footer about section description'),
    '#default_value' => theme_get_setting('about_desc'),
  );

    
}
 
