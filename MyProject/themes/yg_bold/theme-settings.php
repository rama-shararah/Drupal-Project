<?php

/**
 * @file
 * Provides an additional config form for theme settings.
 */

use Drupal\Core\Form\FormStateInterface;

function yg_bold_form_system_theme_settings_alter(array &$form, FormStateInterface $form_state) {
  $form['visibility'] = [
    '#type' => 'vertical_tabs',
    '#title' => t('YG Bold Settings'),
    '#weight' => -999,
  ];

  $form['social']= [
    '#type' => 'details',
    '#title' => t('Social Links'),
    '#weight' => -999,
    '#group' => 'visibility',
    '#open' => FALSE,
  ];
#social links    
  $form['social']['social_links'] = [
    '#type' => 'details',
    '#title' => t('Social Links'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];
  $form['social']['social_links']['social_title'] = [
    '#type' => 'textfield',
    '#title' => t('Social Section Title'),
    '#description' => t('Please enter social section title'),
    '#default_value' => theme_get_setting('social_title'),
    '#required' => TRUE,
  ];
  $form['social']['social_links']['twitter_url'] = [
    '#type' => 'textfield',
    '#title' => t('Twitter'),
    '#description' => t('Please enter your twitter url'),
    '#default_value' => theme_get_setting('twitter_url'),
  ]; 
  $form['social']['social_links']['facebook_url'] = [
    '#type' => 'textfield',
    '#title' => t('Facebook'),
    '#description' => t('Please enter your facebook url'),
    '#default_value' => theme_get_setting('facebook_url'),
  ];
   $form['social']['social_links']['google_plus_url'] = [
    '#type' => 'textfield',
    '#title' => t('Google Plus'),
    '#description' => t('Please enter your google url'),
    '#default_value' => theme_get_setting('google_plus_url'),
  ];
  $form['social']['social_links']['instagram_url'] = [
    '#type' => 'textfield',
    '#title' => t('Instagram'),
    '#description' => t('Please enter your instagram url'),
    '#default_value' => theme_get_setting('instagram_url'),
  ];

// About-us
  $form['about_us']= [
    '#type' => 'details',
    '#title' => t('About Us Footer'),
    '#weight' => -999,
    '#group' => 'visibility',
    '#open' => FALSE,
  ];
    $form['about_us']['about_us_title'] = [
    '#type' => 'textfield',
    '#title' => t('About Us Title'),
    '#description' => t('Please enter about us title'),
    '#default_value' => theme_get_setting('about_us_title'),
  ];
  $form['about_us']['about_desc'] = array(
    '#type' => 'textarea',
    '#title' => t('About Description'),
    '#description' => t('Please enter footer about section description'),
    '#default_value' => theme_get_setting('about_desc'),
  );
  $form['about_us']['social_links']['about_us_url'] = [
    '#type' => 'textfield',
    '#title' => t('About Us Url'),
    '#description' => t('Please enter your about us url'),
    '#default_value' => theme_get_setting('about_us_url'),
  ];
}
 
