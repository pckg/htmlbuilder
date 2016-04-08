<?php namespace Pckg\Htmlbuilder\Snippet;

use Pckg\Htmlbuilder\Element\Button;
use Pckg\Htmlbuilder\Element\Button\Cancel;
use Pckg\Htmlbuilder\Element\Button\Submit;
use Pckg\Htmlbuilder\Element\ElementFactory;
use Pckg\Htmlbuilder\Element\Fieldset;
use Pckg\Htmlbuilder\Element\Group\CheckboxGroup;
use Pckg\Htmlbuilder\Element\Group\RadioGroup;
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
use Pckg\Htmlbuilder\Snippet\Buildable\Checkboxable;
use Pckg\Htmlbuilder\Snippet\Buildable\Radioable;

trait Buildable
{

    // use Checkboxable, Radioable;

    /**
     * @var ElementFactory
     */

    /**
     * @return Fieldset
     */
    public function addFieldset()
    {
        $element = $this->elementFactory->create(Fieldset::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Hidden
     */
    public function addHidden()
    {
        $element = $this->elementFactory->create(Hidden::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Text
     */
    public function addText()
    {
        $element = $this->elementFactory->create(Text::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Textarea
     */
    public function addTextarea()
    {
        $element = $this->elementFactory->create(Textarea::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Textarea
     */
    public function addEditor()
    {
        $element = $this->elementFactory->create(Textarea::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Email
     */
    public function addEmail()
    {
        $element = $this->elementFactory->create(Email::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Number
     */
    public function addNumber()
    {
        $element = $this->elementFactory->create(Number::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Int
     */
    public function addInteger()
    {
        $element = $this->elementFactory->create(Integer::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Decimal
     */
    public function addDecimal()
    {
        $element = $this->elementFactory->create(Decimal::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return File
     */
    public function addFile()
    {
        $element = $this->elementFactory->create(File::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Picture
     */
    public function addPicture()
    {
        $element = $this->elementFactory->create(Picture::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return CheckboxGroup
     */
    public function addCheckboxGroup()
    {
        $element = $this->elementFactory->create(CheckboxGroup::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return RadioGroup
     */
    public function addRadioGroup()
    {
        $element = $this->elementFactory->create(RadioGroup::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Date
     */
    public function addDate()
    {
        $element = $this->elementFactory->create(Date::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Time
     */
    public function addTime()
    {
        $element = $this->elementFactory->create(Time::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Datetime
     */
    public function addDatetime()
    {
        $element = $this->elementFactory->create(Datetime::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Password
     */
    public function addPassword()
    {
        $element = $this->elementFactory->create(Password::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Select
     */
    public function addSelect()
    {
        $element = $this->elementFactory->create(Select::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Button
     */
    public function addButton()
    {
        $element = $this->elementFactory->create(Button::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Submit
     */
    public function addSubmit()
    {
        $element = $this->elementFactory->create(Submit::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    /**
     * @return Cancel
     */
    public function addCancel()
    {
        $element = $this->elementFactory->create(Cancel::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

}
