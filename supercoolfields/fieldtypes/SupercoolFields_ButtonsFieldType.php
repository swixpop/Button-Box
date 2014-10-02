<?php
namespace Craft;

/**
 * SupercoolFields by Supercool
 *
 * Modified from the original DropdownFieldType class
 *
 * @package   SupercoolFields
 * @author    Josh Angell
 * @copyright Copyright (c) 2014, Supercool Ltd
 * @link      http://www.supercooldesign.co.uk
 */
class SupercoolFields_ButtonsFieldType extends BaseOptionsFieldType
{
  // Public Methods
  // =========================================================================

  /**
   * @inheritDoc IComponentType::getName()
   *
   * @return string
   */
  public function getName()
  {
    return Craft::t('Buttons');
  }

 /**
  * @inheritDoc IFieldType::getInputHtml()
  *
  * @param string $name
  * @param mixed  $value
  *
  * @return string
  */
  public function getInputHtml($name, $value)
  {
    $options = $this->getTranslatedOptions();

    // If this is a new entry, look for a default option
    if ($this->isFresh())
    {
      $value = $this->getDefaultValue();
    }

    craft()->templates->includeCssResource('supercoolfields/buttons.css');
    craft()->templates->includeJsResource('supercoolfields/buttons.js');

    return craft()->templates->render('supercoolfields/buttons/field', array(
      'name'    => $name,
      'value'   => $value,
      'options' => $options
    ));
  }

  /**
   * @inheritDoc BaseElementFieldType::getSettingsHtml()
   *
   * @return string|null
   */
  public function getSettingsHtml()
  {
    $options = $this->getOptions();

    if (!$options)
    {
      // Give it a default row
      $options = array(array('label' => '', 'value' => ''));
    }

    return craft()->templates->renderMacro('_includes/forms', 'editableTableField', array(
      array(
        'label'        => $this->getOptionsSettingsLabel(),
        'instructions' => Craft::t('Define the available options.'),
        'id'           => 'options',
        'name'         => 'options',
        'addRowLabel'  => Craft::t('Add an option'),
        'cols'         => array(
          'label' => array(
            'heading'      => Craft::t('Option Label'),
            'type'         => 'singleline',
            'autopopulate' => 'value'
          ),
          'showLabel' => array(
            'heading'      => Craft::t('Show Label?'),
            'type'         => 'checkbox',
            'class'        => 'thin'
          ),
          'value' => array(
            'heading'      => Craft::t('Value'),
            'type'         => 'singleline',
            'class'        => 'code'
          ),
          'imagePath' => array(
            'heading'      => Craft::t('Image Path'),
            'type'         => 'singleline'
          ),
          'default' => array(
            'heading'      => Craft::t('Default?'),
            'type'         => 'checkbox',
            'class'        => 'thin'
          ),
        ),
        'rows' => $options
      )
    ));
  }

  // Protected Methods
  // =========================================================================

  /**
   * @inheritDoc BaseOptionsFieldType::getOptionsSettingsLabel()
   *
   * @return string
   */
  protected function getOptionsSettingsLabel()
  {
    return Craft::t('Button Options');
  }

  /**
   * @inheritDoc BaseSavableComponentType::defineSettings()
   *
   * @return array
   */
  protected function defineSettings()
  {
    return array(
      'options' => array(AttributeType::Mixed, 'default' => array())
    );
  }
}