<?php

namespace Drupal\commonmark\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;

/**
 * Provides a filter to process CommonMark Markdown to HTML.
 * 
 * @Filter(
 *   id = "commonmark",
 *   title = @Translation("CommonMark"),
 *   description = @Translation("Convert Markdown to HTML with CommonMark."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 *   settings = {
 *     "allowed_tags" = "<a> <abbr> <address> <blockquote> <br> <cite> <code> <dd> <del> <div> <dl> <dt> <em> <h1> <h2> <h3> <h4> <h5> <h6> <hr> <img> <kbd> <li> <ol> <p> <pre> <small> <span> <strong> <sub> <sup> <table> <tbody> <td> <tfoot> <th> <thead> <tr> <ul>",
 *     "show_examples" = TRUE,
 *     "use_global_settings" = TRUE
 *   }
 * )
 */
class CommonMark extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['allowed_tags'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Allowed HTML tags'),
      '#default_value' => $this->settings['allowed_tags'],
      '#maxlength' => 2048,
      '#size' => 250,
      '#description' => $this->t('<p>A list of HTML tags that will be permitted to remain after CommonMark has converted the Markdown to HTML. JavaScript event attributes, JavaScript URLs, and CSS are always stripped.</p><p><strong>WARNING: Modifying this list will have a severe impact on the final output from CommonMark, use with caution.</strong></p>'),
    );
    $form['show_examples'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Show examples in the "long" filter tips.'),
      '#default_value' => $this->settings['show_examples'],
    );
    $form['use_global_settings'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Use global CommonMark settings.'),
      '#default_value' => $this->settings['use_global_settings'],
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $converter = new \League\CommonMark\CommonMarkConverter();
    $processed_text = $converter->convertToHtml($text);
    return new FilterProcessResult($processed_text);
  }
}