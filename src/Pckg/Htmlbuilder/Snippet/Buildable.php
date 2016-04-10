<?php namespace Pckg\Htmlbuilder\Snippet;

use Pckg\Htmlbuilder\Element\Button;
use Pckg\Htmlbuilder\Element\Button\Cancel;
use Pckg\Htmlbuilder\Element\Button\Submit;
use Pckg\Htmlbuilder\Element\ElementFactory;
use Pckg\Htmlbuilder\Element\Fieldset;
use Pckg\Htmlbuilder\Element\Group\CheckboxGroup;
use Pckg\Htmlbuilder\Element\Group\RadioGroup;
use Pckg\Htmlbuilder\Element\Input\Checkbox;
use Pckg\Htmlbuilder\Element\Input\Date;
use Pckg\Htmlbuilder\Element\Input\Datetime;
use Pckg\Htmlbuilder\Element\Input\Email;
use Pckg\Htmlbuilder\Element\Input\File;
use Pckg\Htmlbuilder\Element\Input\File\Picture;
use Pckg\Htmlbuilder\Element\Input\Hidden;
use Pckg\Htmlbuilder\Element\Input\Number;
use Pckg\Htmlbuilder\Element\Input\Number\Decimal;
use Pckg\Htmlbuilder\Element\Input\Number\Integer;
use Pckg\Htmlbuilder\Element\Input\Password;
use Pckg\Htmlbuilder\Element\Input\Text;
use Pckg\Htmlbuilder\Element\Input\Time;
use Pckg\Htmlbuilder\Element\Select;
use Pckg\Htmlbuilder\Element\Textarea;

/**
 * Class Buildable
 * @package Pckg\Htmlbuilder\Snippet
 */
trait Buildable
{

    /*use Checkboxable, Radioable {
        Checkboxable::addOptions as addCheckboxOptions;
        Checkboxable::addOption as addCheckboxOption;
        Radioable::addOptions as addRadioOptions;
        Radioable::addOption as addRadioOption;
    }*/

    /**
     * @param $class
     * @param $name
     * @return mixed
     */
    private function addByClassAndName($class, $name)
    {
        $element = $this->elementFactory->create($class, func_get_args());

        $this->addChild($element);

        if ($name) {
            $element->setName($name);
        }

        return $element;
    }

    /**
     * @var ElementFactory
     */

    /**
     * @return Fieldset
     */
    public function addFieldset($class = null)
    {
        $element = $this->elementFactory->create(Fieldset::class, func_get_args());

        $this->addChild($element);

        if ($class) {
            $element->addClass($class);
        }

        return $element;
    }

    /**
     * @return Hidden
     */
    public function addHidden($name = null)
    {
        return $this->addByClassAndName(Hidden::class, $name);
    }

    /**
     * @return Text
     */
    public function addText($name = null)
    {
        return $this->addByClassAndName(Text::class, $name);
    }

    /**
     * @return Textarea
     */
    public function addTextarea($name = null)
    {
        return $this->addByClassAndName(Textarea::class, $name);
    }

    /**
     * @return Textarea
     */
    public function addEditor($name = null)
    {
        return $this->addByClassAndName(Textarea::class, $name);
    }

    /**
     * @return Email
     */
    public function addEmail($name = null)
    {
        return $this->addByClassAndName(Email::class, $name);
    }

    /**
     * @return Number
     */
    public function addNumber($name = null)
    {
        return $this->addByClassAndName(Number::class, $name);
    }

    /**
     * @return Int
     */
    public function addInteger($name = null)
    {
        return $this->addByClassAndName(Integer::class, $name);
    }

    /**
     * @return Decimal
     */
    public function addDecimal($name = null)
    {
        return $this->addByClassAndName(Decimal::class, $name);
    }

    /**
     * @return File
     */
    public function addFile($name = null)
    {
        return $this->addByClassAndName(File::class, $name);
    }

    /**
     * @return Picture
     */
    public function addPicture($name = null)
    {
        return $this->addByClassAndName(Picture::class, $name);
    }

    /**
     * @return CheckboxGroup
     */
    public function addCheckboxGroup($name = null)
    {
        return $this->addByClassAndName(CheckboxGroup::class, $name);
    }

    /**
     * @return RadioGroup
     */
    public function addRadioGroup($name = null)
    {
        return $this->addByClassAndName(RadioGroup::class, $name);
    }

    /**
     * @return Date
     */
    public function addDate($name = null)
    {
        return $this->addByClassAndName(Date::class, $name);
    }

    /**
     * @return Time
     */
    public function addTime($name = null)
    {
        return $this->addByClassAndName(Time::class, $name);
    }

    /**
     * @return Datetime
     */
    public function addDatetime($name = null)
    {
        return $this->addByClassAndName(Datetime::class, $name);
    }

    /**
     * @return Password
     */
    public function addPassword($name = null)
    {
        return $this->addByClassAndName(Password::class, $name);
    }

    /**
     * @return Select
     */
    public function addSelect($name = null)
    {
        return $this->addByClassAndName(Select::class, $name);
    }

    /**
     * @return Button
     */
    public function addButton($name = null)
    {
        return $this->addByClassAndName(Button::class, $name);
    }

    /**
     * @return Submit
     */
    public function addSubmit($name = 'submit')
    {
        return $this->addByClassAndName(Submit::class, $name);
    }

    /**
     * @return Cancel
     */
    public function addCancel($name = 'cancel')
    {
        return $this->addByClassAndName(Cancel::class, $name);
    }

    /**
     * @param null $name
     * @return Checkbox
     */
    public function addCheckbox($name = null)
    {
        return $this->addByClassAndName(Checkbox::class, $name);
    }

}
