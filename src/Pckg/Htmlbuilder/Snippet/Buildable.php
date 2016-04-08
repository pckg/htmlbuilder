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
use Pckg\Htmlbuilder\Element\Input\Number\Int;
use Pckg\Htmlbuilder\Element\Input\Password;
use Pckg\Htmlbuilder\Element\Input\Radio;
use Pckg\Htmlbuilder\Element\Input\Text;
use Pckg\Htmlbuilder\Element\Input\Time;
use Pckg\Htmlbuilder\Element\Select;
use Pckg\Htmlbuilder\Element\Textarea;

trait Buildable
{

    /**
     * @var ElementFactory
     */
    //public $elementFactory;

    /**
     * @$element = Fieldset
     */
    public function addFieldset()
    {
        $element = $this->elementFactory->create(Fieldset::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Hidden
     */
    public function addHidden()
    {
        $element = $this->elementFactory->create(Hidden::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Text
     */
    public function addText()
    {
        $element = $this->elementFactory->create(Text::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Textarea
     */
    public function addTextarea()
    {
        $element = $this->elementFactory->create(Textarea::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Textarea
     */
    public function addEditor()
    {
        $element = $this->elementFactory->create(Textarea::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Email
     */
    public function addEmail()
    {
        $element = $this->elementFactory->create(Email::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Number
     */
    public function addNumber()
    {
        $element = $this->elementFactory->create(Number::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Int
     */
    public function addInt()
    {
        $element = $this->elementFactory->create(Int::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Decimal
     */
    public function addDecimal()
    {
        $element = $this->elementFactory->create(Decimal::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = File
     */
    public function addFile()
    {
        $element = $this->elementFactory->create(File::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Picture
     */
    public function addPicture()
    {
        $element = $this->elementFactory->create(Picture::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Checkbox
     */
    public function addCheckbox()
    {
        $element = $this->elementFactory->create(Checkbox::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = CheckboxGroup
     */
    public function addCheckboxGroup()
    {
        $element = $this->elementFactory->create(CheckboxGroup::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Radio
     */
    public function addRadio()
    {
        $element = $this->elementFactory->create(Radio::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = RadioGroup
     */
    public function addRadioGroup()
    {
        $element = $this->elementFactory->create(RadioGroup::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Date
     */
    public function addDate()
    {
        $element = $this->elementFactory->create(Date::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Time
     */
    public function addTime()
    {
        $element = $this->elementFactory->create(Time::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Datetime
     */
    public function addDatetime()
    {
        $element = $this->elementFactory->create(Datetime::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Password
     */
    public function addPassword()
    {
        $element = $this->elementFactory->create(Password::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Select
     */
    public function addSelect()
    {
        $element = $this->elementFactory->create(Select::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Button
     */
    public function addButton()
    {
        $element = $this->elementFactory->create(Button::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Submit
     */
    public function addSubmit()
    {
        $element = $this->elementFactory->create(Submit::class);

        $this->addChild($element);

        return $element;
    }

    /**
     * @$element = Cancel
     */
    public function addCancel()
    {
        $element = $this->elementFactory->create(Cancel::class);

        $this->addChild($element);

        return $element;
    }

}