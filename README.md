# About HtmlBuilder #
![Build status](https://github.com/pckg/htmlbuilder/workflows/Pckg%20Htmlbuilder%20CI/badge.svg)
Build advanced forms in PHP with datasources, decorators, handlers and validators.

# Functionalities #
Htmlbuilder is built with simplicity in mind. Use validators to automatically validate data on client and server side and
notify user about errors. Datasources allows you to simply bind different kind of data to form, fieldset, field or
other element and let them do magic - they just know how to transfer values between datasource, PHP, HTML and JS.
With handlers you can quickly add functionalities to elements and organize your logic. Decorators are mostly used for
designing fields. If you use some kind of Twitter Bootstrap themes in your project then you'll be able to write
decorator logic only once and apply it on all your forms. Or you can simply use our precoded Bootstrap form and let it
"do it's thing". And finally, plugins. We prepared plugins for TWIG and Blade templating system so you can code core of
your form in PHP and then add classes, reorder elements or design fields.

## Form ##

### Form ###
    use Htmlbuilder\Form;
    
    class EmptyForm extends Form {
    
        public function run() {
            $this->addText('name');
        }
    
    }
    
... produces ...

    <form method="post">
        <fieldset>
            <input type="text" name="name" />
        </fieldset>
    </form>

### Bootstrap ###

    use Htmlbuilder\Form\Bootstrap as Form;
    
    class EmptyForm extends Form {
        
        public function run() {
            $this->addText('name')->setLabel('Name');
        }
    
    }
    
... produces ...

    <form method="post">
        <fieldset>
            <div class="form-group">
                <label class="col-lg-3" for="name">Name</label>
                <div class="col-lg-9">
                    <input type="text" name="name" value="" id="name" class="form-control">
                </div>
            </div>
        </fieldset>
    </form>

## Validators ##
All fields have already added validators (example, Htmlbuilder\Element\Input\Datetime has Htmlbuilder\Validator\Datetime
 validator).

### Required ###
    $field->require();
    
### Email ###
    $field->requireEmail();
    
### Text ###
    $field->requireMin();
    $field->requireMax();
    $field->requireBetween();
    
### Number ###
    $field->requireInteger();
    $field->requirePositive();
    $field->requireNegative();
    $field->requireEmpty();
    $field->requireFloat();
    $field->requireCurrency();
    $field->requireMin();
    $field->requireMax();
    $field->requireBetween();
    
### Date, Time and Datetime ###
    $field->requireDate();
    $field->requireTime();
    $field->requireDatetime();
    
    $field->requireMin();
    $field->requireMax();
    $field->requireBetween();
    $field->requireFuture();
    $field->requirePast();
    
### Regex ###
    $field->requireRegex();

## Datasources ##

### Array ###
    $element->fillWithArray(['name' => 'Bill Clinton']);

### Object ###
 Object datasource automatically fills element's value with existent and accessable getters, setters and public
 properties.
 
    $element->fillWithObject($user);

### Record (LFW/Database/Record) ###
 Does same as Object datasource, except it also provides some additional functionality.
 
    $element->fillWithRecord($rUser);

### Post / Request / Session / Cookie ###
 Similar to other datasources they provide automatic storing and fetching data from request variables.

    $element->fillWithPost($rUser);

## Handlers ##
Handlers are basically element's decorators, so you can simply add functionality to speciffic or groups of elements
by creating new one and adding it to the list of element's handlers. This is how we handled addText(), addNumber() and
getClosest().

### Basic ###
### Query ###

## Decorators ##
This really are decorators because they're executed in process of HTML generation. Basic elements are printed only with
element name (example: div) and attributes (example: class="bordered"). With decorators can you, for example, bind
form and it's values to AngularJS model, enable onSuccess and onError Javascript handlers. Or wrap input in Twitter
Bootstrap HTML, enable Crsf protection and advanced Javascript validation.

### AngularJS ###
### Bootstrap ###
### Csrf ###

## Plugins ##
Every web developer knows that you cannot build form by using only PHP. You simply cannot put every design change in
HTML to decorator, so we solved this problem by creating macros, snippets or whatever you call them for changing form in
templating engines. From now on you will be able to put all logic in PHP and change field position in HTML, some
attribute or add button directly in template engine.

### TWIG ###
    {{ form.open }}
    <p>Some HTML ...</p>
    {{ form.field.name }}
    <p>Some HTML ...</p>
    {{ form.fieldset.index }}
    <p>Some HTML ...</p>
    {{ form.buttonset }}
    <p>Some HTML ...</p>
    {{ form.close }}

### Blade ###

# Notes #
Please note that Htmlbuilder is not (yet) prepared for production use. We still need to write some functional and unit
tests, prepare examples, optimize and document code. =)