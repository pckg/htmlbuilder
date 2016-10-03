<?php namespace Pckg\Htmlbuilder\Snippet;

use Pckg\Htmlbuilder\Element\Button;
use Pckg\Htmlbuilder\Element\Button\Cancel;
use Pckg\Htmlbuilder\Element\Button\Submit;
use Pckg\Htmlbuilder\Element\Div;
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
use Pckg\Htmlbuilder\Element\Editor;

/**
 * Class Buildable
 *
 * @package Pckg\Htmlbuilder\Snippet
 */
trait Buildable
{

    /**
     * @param $class
     * @param $name
     *
     * @return mixed
     */
    private function addElementByClassAndName($class, $name)
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
        return $this->addElementByClassAndName(Hidden::class, $name);
    }

    /**
     * @return Text
     */
    public function addText($name = null)
    {
        return $this->addElementByClassAndName(Text::class, $name);
    }

    /**
     * @return Textarea
     */
    public function addTextarea($name = null)
    {
        return $this->addElementByClassAndName(Textarea::class, $name);
    }

    /**
     * @return Textarea
     */
    public function addEditor($name = null)
    {
        return $this->addElementByClassAndName(Editor::class, $name);
    }

    /**
     * @return Email
     */
    public function addEmail($name = null)
    {
        return $this->addElementByClassAndName(Email::class, $name);
    }

    /**
     * @return Number
     */
    public function addNumber($name = null)
    {
        return $this->addElementByClassAndName(Number::class, $name);
    }

    /**
     * @return Int
     */
    public function addInteger($name = null)
    {
        return $this->addElementByClassAndName(Integer::class, $name);
    }

    /**
     * @return Decimal
     */
    public function addDecimal($name = null)
    {
        return $this->addElementByClassAndName(Decimal::class, $name);
    }

    /**
     * @return File
     */
    public function addFile($name = null)
    {
        return $this->addElementByClassAndName(File::class, $name);
    }

    /**
     * @return Picture
     */
    public function addPicture($name = null)
    {
        return $this->addElementByClassAndName(Picture::class, $name);
    }

    /**
     * @return CheckboxGroup
     */
    public function addCheckboxGroup($name = null)
    {
        return $this->addElementByClassAndName(CheckboxGroup::class, $name);
    }

    /**
     * @return RadioGroup
     */
    public function addRadioGroup($name = null)
    {
        return $this->addElementByClassAndName(RadioGroup::class, $name);
    }

    /**
     * @return Date
     */
    public function addDate($name = null)
    {
        return $this->addElementByClassAndName(Date::class, $name);
    }

    /**
     * @return Time
     */
    public function addTime($name = null)
    {
        return $this->addElementByClassAndName(Time::class, $name);
    }

    /**
     * @return Datetime
     */
    public function addDatetime($name = null)
    {
        return $this->addElementByClassAndName(Datetime::class, $name);
    }

    /**
     * @return Password
     */
    public function addPassword($name = null)
    {
        return $this->addElementByClassAndName(Password::class, $name);
    }

    /**
     * @return Select
     */
    public function addSelect($name = null)
    {
        return $this->addElementByClassAndName(Select::class, $name);
    }

    /**
     * @return Button
     */
    public function addButton($name = null)
    {
        return $this->addElementByClassAndName(Button::class, $name);
    }

    /**
     * @return Submit
     */
    public function addSubmit($name = 'submit')
    {
        return $this->addElementByClassAndName(Submit::class, $name);
    }

    /**
     * @return Cancel
     */
    public function addCancel($name = 'cancel')
    {
        return $this->addElementByClassAndName(Cancel::class, $name);
    }

    /**
     * @param null $name
     *
     * @return Checkbox
     */
    public function addCheckbox($name = null)
    {
        return $this->addElementByClassAndName(Checkbox::class, $name);
    }

    /**
     * @return Div
     */
    public function addDiv()
    {
        $element = $this->elementFactory->create(Div::class);

        $this->addChild($element);

        return $element;
    }

}
