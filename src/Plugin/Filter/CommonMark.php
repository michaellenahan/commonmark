<?php

namespace Drupal\commonmark\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;
use League\CommonMark\CommonMarkConverter;

/**
 * Provides a filter to process CommonMark Markdown to HTML.
 *
 * @Filter(
 *   id = "commonmark",
 *   title = @Translation("CommonMark"),
 *   description = @Translation("Convert Markdown to HTML with CommonMark."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 *   settings = {
 *     "commonmark_help" = TRUE
 *   }
 * )
 */
class CommonMark extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['commonmark_help'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Display basic CommonMark help in long filter tips.'),
      '#default_value' => $this->settings['commonmark_help'],
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    // It is necessary to escape html input.
    // See: https://commonmark.thephpleague.com/security/
    $converter = new CommonMarkConverter(['html_input' => 'escape']);
    $processed_text = $converter->convertToHtml($text);
    return new FilterProcessResult($processed_text);
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $url_options = array('attributes' => array('target' => '_blank'));
    $url = Url::fromUri('http://commonmark.org/help/', $url_options);
    $text = $this->t('This site uses Markdown. Click here for help.');
    $link = Link::fromTextAndUrl($text, $url)->toString();
    return $link;
  }

}
